<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;

class BatchRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\Batch::class;
    }
}
