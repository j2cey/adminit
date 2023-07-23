<?php

namespace App\Providers;

use App\Events\DynamicValueCreated;
use App\Listeners\InitFormattedValue;
use Illuminate\Auth\Events\Registered;
use App\Events\ReportFileImportedEvent;
use App\Events\ReportFileNotifiedEvent;
use App\Events\ReportFileFormattedEvent;
use App\Events\ReportFileDownloadedEvent;
use App\Listeners\ReportFileImportedListener;
use App\Listeners\ReportFileNotifiedListener;
use App\Listeners\ReportFileFormattedListener;
use App\Listeners\ReportFileDownloadedListener;
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
        ReportFileDownloadedEvent::class => [ ReportFileDownloadedListener::class, ],
        ReportFileImportedEvent::class => [ ReportFileImportedListener::class, ],
        ReportFileFormattedEvent::class => [ ReportFileFormattedListener::class, ],
        ReportFileNotifiedEvent::class => [ ReportFileNotifiedListener::class, ],
        DynamicValueCreated::class => [ InitFormattedValue::class, ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
