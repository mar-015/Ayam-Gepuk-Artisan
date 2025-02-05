<?php

namespace App\Policies;

use App\Models\LeaveRequest;
use App\Models\User;

class LeaveRequestPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, LeaveRequest $leaveRequest)
    {
        return $user->id === $leaveRequest->user_id || $user->isManager();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, LeaveRequest $leaveRequest)
    {
        return $user->id === $leaveRequest->user_id && $leaveRequest->status === 'pending';
    }

    public function delete(User $user, LeaveRequest $leaveRequest)
    {
        return $user->id === $leaveRequest->user_id && $leaveRequest->status === 'pending';
    }

    public function approve(User $user, LeaveRequest $leaveRequest)
    {
        return $user->isManager() && $leaveRequest->status === 'pending';
    }

    public function reject(User $user, LeaveRequest $leaveRequest)
    {
        return $user->isManager() && $leaveRequest->status === 'pending';
    }
}
