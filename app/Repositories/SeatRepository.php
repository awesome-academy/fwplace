<?php

namespace App\Repositories;

class SeatRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\Seat::class;
    }

    public function getArraySeatByLocationId($locationId)
    {
        return $this->model
            ->where('location_id', $locationId)
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getSeatByLocationId($locationId)
    {
        return $this->model->where('location_id', $locationId)->get();
    }
}
