<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Schedule $schedule)
    {
        return $user->id === $schedule->user_id || $user->isAdmin() || $user->isManager();
    }

    public function create(User $user)
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function update(User $user, Schedule $schedule)
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function delete(User $user, Schedule $schedule)
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function viewMySchedule(User $user)
    {
        return true;
    }
}
