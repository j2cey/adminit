<?php

namespace App\Providers;

use App\Events\LaunchTreatmentEvent;
use App\Observers\TreatmentObserver;
use App\Models\Treatments\Treatment;
use App\Events\TreatmentCreatedEvent;
use App\Observers\DynamicRowObserver;
use Illuminate\Auth\Events\Registered;
use App\Models\DynamicValue\DynamicRow;
use App\Events\DynamicValueCreatedEvent;
use App\Listeners\SetInnerValueListener;
use App\Listeners\LaunchTreatmentListener;
use App\Models\Treatments\TreatmentService;
use App\Listeners\TreatmentCreatedListener;
use App\Observers\TreatmentServiceObserver;
use App\Listeners\InitFormattedValueListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        DynamicValueCreatedEvent::class => [
            SetInnerValueListener::class,
            InitFormattedValueListener::class,
        ],

        LaunchTreatmentEvent::class => [ LaunchTreatmentListener::class, ],

        TreatmentCreatedEvent::class => [ TreatmentCreatedListener::class, ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Treatment::observe(TreatmentObserver::class);
        DynamicRow::observe(DynamicRowObserver::class);
        TreatmentService::observe(TreatmentServiceObserver::class);
    }
}
