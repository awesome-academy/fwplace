<?php

namespace App\Repositories;

use App\Models\SpecialDay;
use App\Repositories\EloquentRepository;

class SpecialDayRepository extends EloquentRepository
{
    public function model()
    {
        return SpecialDay::class;
    }
}
