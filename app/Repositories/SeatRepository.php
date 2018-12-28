<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\LocationRepository;
use App\Models\WorkSchedule;
use App\Models\ScheduleSeat;
use Illuminate\Support\Carbon;

class SeatRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\Seat::class;
    }

    public function deleteSeat($id)
    {
        DB::beginTransaction();
        
        try {
            $seat = $this->model->findOrFail($id);

            $count = $this->model->where('location_id', $seat->location_id)->count();

            $this->model->destroy($seat->id);

            if ($count <= 1) {
                $locationRepository = new LocationRepository();
                $locationRepository->delete($seat->location_id);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return $e;
        }
    }

    public function getAvailableSeats($schedule, $id, $shift = null)
    {
        $this->makeModel();

        return $this->model->whereNotIn('id', function ($query) use ($schedule, $id) {
            $query->from(DB::raw('work_schedules, schedule_seat'))
                ->select('seat_id')
                ->where(DB::raw('`work_schedules`.`id`'), DB::raw('schedule_seat.work_schedule_id'))
                ->where('date', Carbon::parse($schedule->date)->format('Y-m-d'))
                ->where(function ($query) use ($schedule) {
                    $query->where('work_schedules.shift', config('site.shift.all'));
                    if (func_num_args() === 2) {
                        $query->orWhere('work_schedules.shift', $shift);
                    } else {
                        $query->orWhere('work_schedules.shift', $schedule->shift);
                    }
                })
                ->where(function ($query) {
                    if (!empty($schedule->seat_id)) {
                        $query->where('seat_id', $schedule->seat_id);
                    }
                })
                ->where('work_schedules.location_id', $id)
                ->whereNotNull('seat_id')
                ->where('user_id', '!=', $schedule->user_id);
        })
        ->where('seats.location_id', $id)
        ->where(function ($query) {
            $query->where('seats.usable', '=', config('site.disable_seat'))
                ->orWhere('seats.usable');
        })
        ->orderBy('name')
        ->get()
        ->pluck('name', 'id');
    }

    public function getSaveData($requestData, $shift)
    {
        $saveData = [];
        if (isset($requestData[$shift])) {
            $data = $requestData[$shift];
            foreach ($data as $key => $value) {
                $saveData = array_merge($saveData, [
                    [
                        'work_schedule_id' => $key,
                        'seat_id' => $value,
                        'shift' => config('site.shift.' . $shift),
                    ],
                ]);
            }
        }

        return $saveData;
    }

    public function registerSeats($requestData)
    {
        DB::beginTransaction();

        try {
            $saveData = [];
            $saveData = array_merge($saveData, $this->getSaveData($requestData, 'morning'));
            $saveData = array_merge($saveData, $this->getSaveData($requestData, 'afternoon'));

            foreach ($saveData as $data) {
                ScheduleSeat::updateOrCreate(
                    [
                        'work_schedule_id' => $data['work_schedule_id'],
                        'shift' => $data['shift'],
                    ],
                    [
                        'seat_id' => $data['seat_id'],
                    ]
                );
            }
            DB::commit();

            return redirect()->back();
        } catch (\Exception $exeption) {
            DB::rollBack();

            return $exeption;
        }
    }
}
