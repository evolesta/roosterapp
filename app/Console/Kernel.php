<?php

namespace App\Console;

use App\Jobs\DailyRegCheck;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // dagelijkse check of gebruikers zijn uitgeklokt
        $schedule->job(new DailyRegCheck())->dailyAt('19:00:00');
    }
}
