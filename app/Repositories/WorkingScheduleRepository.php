<?php

namespace App\Repositories;

use App\Models\User;

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
}
