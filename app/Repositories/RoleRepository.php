<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends EloquentRepository
{
    public function model()
    {
        return Role::class;
    }

    public function pluckRole()
    {
        return $this->model->pluck('display_name', 'id');
    }

    public function getIdTrainee()
    {
        return $this->model->select('id')->where('name', 'like', 'trainee')->first();
    }
}
