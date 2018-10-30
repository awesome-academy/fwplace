<?php

namespace App\Repositories;

use DB;
use App\Models\User;

class WorkspaceRepository extends EloquentRepository
{

    public function model()
    {
        return \App\Models\Workspace::class;
    }

    public function getWorkspaces()
    {
        return $this->model->latest()->get();
    }

    public function getOwnLocation()
    {
        return $this->model->with('locations')->paginate();
    }

    public function getArrayLocation($id)
    {
        return $this->model->findOrFail($id)->locations()->pluck('name', 'id')->toArray();
    }

    public function getListLocation($id)
    {
        return $this->model->findOrFail($id)->locations;
    }

    public function listWorkspaceArray()
    {
        return $this->model->pluck('name', 'id')->toArray();
    }

    public function getData($workspaceId, $filter)
    {
        $workspace = $this->model->findOrFail($workspaceId);
        if (!$workspace || !array_key_exists('start', $filter) || !array_key_exists('end', $filter)) {
            return null;
        }
        $allShift = $this->getAllShift($workspace, $filter);

        return $allShift;
    }

    public function getAllShift($workspace, $filter)
    {
        $fullTime = $this->getByShift(
            $workspace,
            $filter,
            __('Fulltime:'),
            config('site.shift.all'),
            config('site.calendar.fulltime-color')
        );
        $morning = $this->getByShift(
            $workspace,
            $filter,
            __('Morning:'),
            config('site.shift.morning')
        );
        $afternoon = $this->getByShift(
            $workspace,
            $filter,
            __('Afternoon:'),
            config('site.shift.afternoon'),
            config('site.calendar.afternoon-color')
        );
        $off = $this->getByShift(
            $workspace,
            $filter,
            __('Off:'),
            config('site.shift.off'),
            config('site.calendar.off-color')
        );

        return array_merge($morning, $afternoon, $fullTime, $off);
    }

    public function getByShift($workspace, $filter, $title, $shift, $color = null)
    {
        $color = $color ?? config('site.calendar.default-color');


        $shiftData = $workspace->workSchedules()
            ->select(DB::raw('COUNT(user_id) as total, date as start, shift, CONCAT("'
                    . $title
                    . '", COUNT(user_id)) as title, ' . $color . 'as className'))
            ->whereBetween('date', [$filter['start'], $filter['end']])
            ->where('shift', $shift);

        if (array_key_exists('program_id', $filter) && $filter['program_id']) {
            $getUserByProgram = User::where('program_id', $filter['program_id'])
                ->pluck('id');
            $shiftData = $shiftData->whereIn('user_id', $getUserByProgram);
        }
        
        $shiftData = $shiftData->groupBy('date', 'shift', 'workspace_id')
            ->get()->toArray();

        return $shiftData;
    }

    public function pluckWorkspace()
    {
        return $this->model->pluck('name', 'id');
    }

    public function getOneDate($workspaceId, $date, $filter = [])
    {
        $workspace = $this->model->findOrFail($workspaceId);
        if (!$workspace || !$date) {
            return null;
        }
        $dates = ['start' => $date, 'end' => $date];
        $off = $this->getByShift($workspace, $dates, __('Off'), config('site.shift.off'));
        $data = $this->getAllShift($workspace, $dates);

        return array_merge($data, $off);
    }
}
