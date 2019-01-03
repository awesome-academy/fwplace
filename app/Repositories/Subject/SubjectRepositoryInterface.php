<?php

namespace App\Repositories\Subject;

use App\Models\User;

interface SubjectRepositoryInterface
{
    public function getNameSubject();

    public function getUserSubject($userId);
}
