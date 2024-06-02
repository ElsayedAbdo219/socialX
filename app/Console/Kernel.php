<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
<<<<<<< HEAD
=======
        $schedule->command('telescope:prune --hours=48')->daily();
        $schedule->command('queue:work --daemon --tries=3')
            ->cron('* * * * *')->withoutOverlapping(5);
        $schedule->command('queue:restart')->cron('*/5 * * * *');
>>>>>>> 8e8dff787b35a54fd7a7ff9e3accd62cda6d8720
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
