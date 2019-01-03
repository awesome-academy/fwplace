<?php

namespace App\Repositories\Reviews;

use App\Repositories\EloquentRepository;
use App\Repositories\Reviews\ReviewRepositoryInterface;

class ReviewEloquentRepository extends EloquentRepository implements ReviewRepositoryInterface
{
    public function model()
    {
        return \App\Models\Review::class;
    }
}
