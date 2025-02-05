<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\Schedule;
use App\Models\LeaveRequest;

class NotificationService
{
    public function notifyScheduleChange(Schedule $schedule)
    {
        $this->createNotification(
            $schedule->user_id,
            'schedule_change',
            'Your schedule has been updated.',
            [
                'schedule_id' => $schedule->id,
                'date' => $schedule->date->format('Y-m-d'),
                'shift_type' => $schedule->shift_type,
            ]
        );
    }

    public function notifyLeaveRequestUpdate(LeaveRequest $leaveRequest)
    {
        $status = ucfirst($leaveRequest->status);
        $message = "Your leave request has been {$leaveRequest->status}.";
        if ($leaveRequest->admin_remarks) {
            $message .= " Remarks: {$leaveRequest->admin_remarks}";
        }

        $this->createNotification(
            $leaveRequest->user_id,
            'leave_request_update',
            $message,
            [
                'leave_request_id' => $leaveRequest->id,
                'status' => $leaveRequest->status,
            ]
        );
    }

    public function sendShiftReminder(Schedule $schedule)
    {
        $this->createNotification(
            $schedule->user_id,
            'shift_reminder',
            "Reminder: You have a {$schedule->shift_type} shift tomorrow.",
            [
                'schedule_id' => $schedule->id,
                'date' => $schedule->date->format('Y-m-d'),
                'shift_type' => $schedule->shift_type,
                'shift_start' => $schedule->shift_start,
            ]
        );
    }

    public function notifyLowAttendance(User $user)
    {
        $managers = User::whereIn('role', ['admin', 'manager'])->get();
        
        foreach ($managers as $manager) {
            $this->createNotification(
                $manager->id,
                'attendance_alert',
                "Low attendance alert for {$user->name}.",
                [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ]
            );
        }
    }

    private function createNotification(int $userId, string $type, string $message, array $data = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
