<?php

namespace App\Repositories;

use App\Models\DesignDiagram;

class DesignDiagramRepository extends EloquentRepository
{
    public function model()
    {
        return DesignDiagram::class;
    }

    public function getListDiagram()
    {
        return $this->model->where('status', 1)->get();
    }
}
