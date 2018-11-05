<?php

namespace App\Repositories;

class WorkingScheduleRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\WorkSchedule::class;
    }

    public function getUserSchedule($id)
    {
        return $this->model->where('user_id', $id)->whereMonth('date', date('m'))->pluck('shift', 'date');
    }

    public function getLocation($id)
    {
        return $this->model->where('user_id', $id)->pluck('location_id', 'date');
    }
}
