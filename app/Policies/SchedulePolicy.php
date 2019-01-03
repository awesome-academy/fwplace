<?php

namespace App\Policies;

use App\User;
use App\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Schedule $schedule)
    {
        return $user->id === $schedule->user_id;
    }
}
