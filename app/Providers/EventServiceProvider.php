<?php

namespace App\Providers;

use App\Models\RequirementYearApplication;
use App\Observers\RequirementYearApplicationObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\RequirementRepairApplication;
use App\Observers\RequirementRepairApplicationObserver;
use App\Models\RequirementEmergencyApplication;
use App\Observers\RequirementEmergencyApplicationObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        RequirementYearApplication::observe(RequirementYearApplicationObserver::class);
        RequirementRepairApplication::observe(RequirementRepairApplicationObserver::class);
        RequirementEmergencyApplication::observe(RequirementEmergencyApplicationObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
