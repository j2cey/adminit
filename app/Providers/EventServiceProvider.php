<?php

namespace App\Providers;

use App\Events\JobProcessedEvent;
use App\Events\LaunchTreatmentEvent;
use App\Observers\TreatmentObserver;
use App\Events\TreatmentCreatedEvent;
use App\Observers\DynamicRowObserver;
use App\Listeners\JobProcessedListener;
use App\Models\DynamicValue\DynamicRow;
use App\Events\DynamicValueCreatedEvent;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SetInnerValueListener;
use App\Listeners\LaunchTreatmentListener;
use App\Models\Treatments\Treatment;
use App\Listeners\TreatmentCreatedListener;
use App\Observers\TreatmentServiceObserver;
use App\Listeners\InitFormattedValueListener;
use App\Models\Treatments\TreatmentService;
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

        //TreatmentStartingEvent::class => [ TreatmentStartingListener::class, ],
        //TreatmentEndingEvent::class => [ TreatmentEndingListener::class, ],

        JobProcessedEvent::class => [ JobProcessedListener::class, ],
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
