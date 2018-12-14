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

    public function getDesignWithoutDiagram($id)
    {
        return $this->model
            ->where('workspace_id', $id)
            ->where('status', config('database.diagram_status.without_diagram'))
            ->first();
    }
}
