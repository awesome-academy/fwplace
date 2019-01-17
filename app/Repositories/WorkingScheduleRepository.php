<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ScheduleSeat;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WorkingScheduleRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\WorkSchedule::class;
    }

    public function getUserSchedule($id)
    {
        $this->makeModel();

        return $this->model->where('user_id', $id)->pluck('shift', 'date');
    }
    
    public function getLocation($id)
    {
        $this->makeModel();

        return $this->model->where('user_id', $id)->pluck('location_id', 'date');
    }

    public function getByMonth($request)
    {
        $this->makeModel();

        $users = User::with([
            'workspace',
            'position',
            'program',
        ])
        ->where(function ($query) use ($request) {
            if ($request->has('workspace') && $request->workspace !== null) {
                $query->where('workspace_id', $request->workspace);
            }
            if ($request->has('program') && $request->program !== null) {
                $query->where('program_id', $request->program);
            }
            if ($request->has('position') && $request->position !== null) {
                $query->where('position_id', $request->position);
            }
        })
        ->get();

        $firstDay = Date(Date('Y') . '-' . Date('m') . '-' . '01');
        $lastDay = Date(Date('Y') . '-' . Date('m') . '-' . Date('t'));

        $schedules = $this->model->whereBetween('date', [$firstDay, $lastDay])->get();
        $data = collect();
        foreach ($schedules as $schedule) {
            $day = \DateTime::createFromFormat('d-m-Y', $schedule->date)->format('j');
            $temp = collect();
            $temp->put($day, $schedule);
            if (isset($data[$schedule->user_id])) {
                $data[$schedule->user_id]->put($day, $schedule);
            } else {
                $data->put($schedule->user_id, $temp);
            }
        }

        foreach ($users as $user) {
            if (isset($data[$user->id])) {
                $user->schedules = $data[$user->id];
            }
        }

        return $users;
    }

    public function updateSchedules($data)
    {
        DB::beginTransaction();
        try {
            foreach ($data['shift'] as $key => $value) {
                Auth::user()->workSchedules()->updateOrCreate(
                    [
                        'date' => $key,
                    ],
                    [
                        'location_id' => $data['location'][$key],
                        'shift' => $value,
                    ]
                );
            }

            $schedule = DB::table('work_schedules')
                ->select('work_schedules.id')
                ->join('schedule_seat', 'schedule_seat.work_schedule_id', 'work_schedules.id')
                ->join('seats', 'schedule_seat.seat_id', 'seats.id')
                ->where('seats.location_id', '!=', DB::raw('work_schedules.location_id'))
                ->get()
                ->pluck('id');
            
            $scheduleSeats = ScheduleSeat::whereIn('work_schedule_id', $schedule)->delete();

            DB::commit();

            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollback();
            
            return $exception;
        }
    }
}
