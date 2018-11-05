<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends EloquentRepository
{
    public function model()
    {
        return Role::class;
    }
}
