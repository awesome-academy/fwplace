<?php

namespace App\Repositories;

use App\Repositories\EloquentRepository;

class BatchRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\Batch::class;
    }

    public function listBatchesArray()
    {
        $array = [];
        $results = $this->model->all();
        foreach ($results as $result) {
            $array[$result->id] =
                $result->batch . '-' . $result->workspace->name . '-' .
                $result->program->name . '-' . $result->position->name;
        }

        return $array;
    }

    public function getAll()
    {
        $batches = $this->model->with(['program', 'position', 'workspace', 'subjects'])->orderBy('id', 'DESC')->get();

        return $batches;
    }

    public function lastestBatch($data)
    {
        $this->makeModel();

        return $this->model->where('position_id', $data['position_id'])
                ->where('workspace_id', $data['workspace_id'])
                ->where('program_id', $data['program_id'])
                ->first();
    }
}
