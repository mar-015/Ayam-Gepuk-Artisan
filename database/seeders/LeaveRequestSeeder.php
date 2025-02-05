<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::where('role', 'staff')->first();

        // Create a pending leave request
        LeaveRequest::create([
            'user_id' => $staff->id,
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(3),
            'type' => 'vacation',
            'reason' => 'Family vacation',
            'status' => 'pending'
        ]);

        // Create an approved leave request
        LeaveRequest::create([
            'user_id' => $staff->id,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(8),
            'type' => 'personal',
            'reason' => 'Personal matters',
            'status' => 'approved',
            'admin_remarks' => 'Approved by manager'
        ]);

        // Create a rejected leave request
        LeaveRequest::create([
            'user_id' => $staff->id,
            'start_date' => now()->addDays(14),
            'end_date' => now()->addDays(15),
            'type' => 'sick',
            'reason' => 'Medical appointment',
            'status' => 'rejected',
            'admin_remarks' => 'Insufficient staff coverage'
        ]);
    }
}
