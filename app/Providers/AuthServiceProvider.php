<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\Schedule;
use App\Policies\LeaveRequestPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\SchedulePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Notification::class => NotificationPolicy::class,
        Schedule::class => SchedulePolicy::class,
        LeaveRequest::class => LeaveRequestPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
