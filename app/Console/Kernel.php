<?php

namespace App\Console;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $treatment_activate = config('Settings.treatment.activate');
        if ($treatment_activate) {
            // exec Report schedule
            //$schedule->command('report:exec')->cron('* * * * *');
            $schedule->command('report:exec')->everyMinute();
        }

        /*$schedule->call(function () {
            $dt = Carbon::now();

            $times = 3;
            $wait_secs=60/$times;

            do {
                Artisan::call('treatment:dispatch');
                sleep($wait_secs);

            } while($times-- > 0);

        })->everyMinute();*/

        $schedule->command('job:watch')->everyMinute();
        $schedule->command('jobbatch:watch')->everyMinute();
        $schedule->command('treatmentarchive:deleteexpired')->everyMinute();
        $schedule->command('collectedreportfile:watch')->everyMinute();

        $schedule->command('treatment:dispatch')->everyMinute();
        $schedule->command('reportfile:import')->everyMinute();
        $schedule->command('reportfile:merge')->everyMinute();
        /*$schedule->call(function () {
            $dt = Carbon::now();

            $times = 2;
            $wait_secs=60/$times;

            do {
                Artisan::call('reportfile:import');
                sleep($wait_secs);

            } while($times-- > 0);

        })->everyMinute();*/
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
