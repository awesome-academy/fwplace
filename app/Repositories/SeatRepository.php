<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\LocationRepository;

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
}
