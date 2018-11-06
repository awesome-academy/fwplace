<?php

namespace App\Repositories;

use App\Models\Program;

class ProgramRepository extends EloquentRepository implements ProgramInterface
{
    public function model()
    {
        return Program::class;
    }

    public function listProgramArray()
    {
        return $this->model->pluck('name', 'id')->toArray();
    }

    public function pluckProgram()
    {
        return $this->model->pluck('name', 'id');
    }

    public function listProgram()
    {
        return $this->model->pluck('name', 'id')->toArray();
    }
}
