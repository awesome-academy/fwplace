<?php

namespace App\Repositories;

use DB;
use Carbon\CarbonPeriod;
use App\Models\User;

class LocationRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\Location::class;
    }

    public function listLocation($filter)
    {
        if (is_array($filter)) {
            $model = $this->model->with('workspace');
            if ($filter['workspace_id']) {
                $model->where('workspace_id', $filter['workspace_id']);
            }
            if ($filter['name']) {
                $model->where('name', 'like', '%' . $filter['name'] . '%');
            }

            return $model->latest()->paginate(config('database.paginate'));
        }

        return $this->model
            ->with('workspace')
            ->latest()
            ->paginate(config('database.paginate'));
    }

    public function getByWorkspace($workspaceId)
    {
        return $this->model
            ->where('workspace_id', $workspaceId)
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getData($locationId, $filter)
    {
        $location = $this->model->findOrFail($locationId);
        if (!array_key_exists('start', $filter) || !array_key_exists('end', $filter)) {
            return null;
        }
        $allShift = $this->getAllShift($location, $filter);

        return $allShift;
    }

    public function getAllShift($location, $filter)
    {
        $totalSeat = $location->total_seat;
        $fullTimeSeat = $this->getByShift($location, $filter, config('site.shift.all'))
            ->pluck('total', 'start')
            ->toArray();
        $morning = $this->getByShift($location, $filter, config('site.shift.morning'))
            ->pluck('total', 'start')
            ->toArray();
        $afternoon = $this->getByShift($location, $filter, config('site.shift.afternoon'))
            ->pluck('total', 'start')
            ->toArray();

        $morningData = $this->analystic(
            $fullTimeSeat,
            $morning,
            array_merge($filter, ['shift' => config('site.shift.morning')]),
            __('1. Morning:'),
            config('site.analystic.default-color'),
            $totalSeat,
            $location
        );
        $afternoonData = $this->analystic(
            $fullTimeSeat,
            $afternoon,
            array_merge($filter, ['shift' => config('site.shift.afternoon')]),
            __('2. Afternoon:'),
            config('site.analystic.afternoon-color'),
            $totalSeat,
            $location
        );

        return array_merge($morningData, $afternoonData);
    }

    public function getDatesOfFilter($filter)
    {
        if (!is_array($filter) || !array_key_exists('start', $filter) || !array_key_exists('end', $filter)) {
            return null;
        }
        $dates = CarbonPeriod::create($filter['start'], $filter['end'])->toArray();
        $arrayDates = [];
        foreach ($dates as $date) {
            if (!$date->isWeekend()) {
                $arrayDates[] = $date->format('Y-m-d');
            }
        }

        return $arrayDates;
    }

    public function analystic(
        $fullTimeSeat,
        $shiftData,
        $filter,
        $title,
        $className,
        $totalSeat,
        $location
    ) {
        if (!is_array($fullTimeSeat) && !$shiftData) {
            return;
        }
        $dates = $this->getDatesOfFilter($filter);
        $data = [];
        foreach ($dates as $date) {
            if (array_key_exists($date, $shiftData)) {
                $count = $shiftData[$date];
            } else {
                $count = 0;
            }
            if (array_key_exists($date, $fullTimeSeat)) {
                $count += $fullTimeSeat[$date];
            }
            $count = $totalSeat - $count;
            if ($count < 0) {
                $count = __('lacking') . ' ' . $count * -1;
            } elseif ($count >= 0) {
                $count = __('over') . ' ' . $count;
            }
            $data[] = [
                'start' => $date,
                'title' => $title . ' ' . $count,
                'className' => $className,
                'url' => route(
                    'calendar.location.detail_location',
                    [
                        'id' => $location->id,
                        'date' => $date,
                    ]
                ) . '?shift=' . $filter['shift'],
                'description' => __('Click to view detail'),
            ];
        }

        return $data;
    }

    public function getByShift($location, $filter, $shift)
    {
        $shiftData = $location->workSchedules()
            ->select(DB::raw('COUNT(user_id) as total, date as start, shift'))
            ->whereBetween('date', [$filter['start'], $filter['end']])
            ->where('shift', $shift);

        if (array_key_exists('program_id', $filter) && $filter['program_id']) {
            $getUserByProGram = User::where('program_id', $filter['program_id'])->pluck('id');
            $shiftData = $shiftData->whereIn('user_id', $getUserByProGram);
        }
        $shiftData = $shiftData->groupBy('date', 'shift')->get();

        return $shiftData;
    }

    public function getLocationDetail($filter)
    {
        if (!is_array($filter) || !array_key_exists('location_id', $filter) || !array_key_exists('date', $filter)) {
            return null;
        }
        $location = $this->model->findOrFail($filter['location_id']);
        $listUserId = $location->workSchedules()
            ->where('date', $filter['date']);
        if (array_key_exists('shift', $filter) && $filter['shift'] != 0) {
            $listUserId = $listUserId->whereIn(
                'shift',
                [
                    $filter['shift'],
                    config('site.shift.all'),
                ]
            );
        }
        $listUserId = $listUserId->pluck('user_id');
        $users = User::whereIn('id', $listUserId);
        if (array_key_exists('program_id', $filter) && $filter['program_id']) {
            $users = $users->where('program_id', $filter['program_id']);
        }
        $data = $users->orderBy('program_id')->get();

        return $data;
    }

    public function setDataForCalenDar($location, $filter)
    {
        $data = $this->getTotalUsersInDay($location, $filter);
        $dates = $this->getDatesOfFilter($filter);
        $totalData = [];
        foreach ($dates as $key => $date) {
            if (array_key_exists($date, $data)) {
                $totalData[] = [
                    'start' => $date,
                    'title' => trans_choice(':count employee | :count employees', $data[$date]),
                    'className' => config('site.analystic.fulltime-color'),
                    'url' => route(
                        'calendar.location.detail_location',
                        [
                            'id' => $location->id,
                            'date' => $date,
                        ]
                    ),
                    'description' => __('Click to view detail'),
                ];
            } else {
                $totalData[] = [
                    'start' => $date,
                    'title' => __('No employee'),
                    'className' => '',
                    'url' => route(
                        'calendar.location.detail_location',
                        [
                            'id' => $location->id,
                            'date' => $date,
                        ]
                    ),
                    'description' => __('Click to view detail'),
                ];
            }
        }

        return $totalData;
    }

    public function getTotalUsersInDay($location, $filter)
    {
        $data = $location->workSchedules()
            ->select(DB::raw('COUNT(user_id) as total, date as start'))
            ->whereBetween('date', [$filter['start'], $filter['end']]);

        if (array_key_exists('program_id', $filter) && $filter['program_id']) {
            $getUserByProGram = User::where('program_id', $filter['program_id'])->pluck('id');
            $data = $data->whereIn('user_id', $getUserByProGram);
        }
        $data = $data->groupBy('date')->pluck('total', 'start')->toArray();

        return $data;
    }

    public function getLocationIdByWorkspace($workspaceId)
    {
        return $this->model
            ->where('workspace_id', $workspaceId)
            ->get()
            ->pluck('id');
    }
}
