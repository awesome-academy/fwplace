<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository extends EloquentRepository
{
    public function model()
    {
        return Permission::class;
    }
}
