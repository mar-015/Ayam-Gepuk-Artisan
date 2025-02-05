<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendShiftReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-shift-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to staff about their upcoming shifts';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $tomorrow = now()->addDay()->format('Y-m-d');
        
        $schedules = Schedule::whereDate('date', $tomorrow)->get();
        
        foreach ($schedules as $schedule) {
            $notificationService->sendShiftReminder($schedule);
            $this->info("Sent reminder to {$schedule->user->name} for tomorrow's {$schedule->shift_type} shift.");
        }

        return Command::SUCCESS;
    }
}
