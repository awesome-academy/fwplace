<?php

namespace App\Policies;

use App\User;
use App\Report;
use App\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Subject $subject)
    {
        return $user->canCreateReport() && !$user->subjects->contains($subject->id);
    }

    public function update(User $user, Report $report)
    {
        return $user->id === $report->user_id;
    }
}
