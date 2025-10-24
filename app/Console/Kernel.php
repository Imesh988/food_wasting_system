<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    public function __construct(\Illuminate\Contracts\Foundation\Application $app, \Illuminate\Contracts\Events\Dispatcher $events)
    {

        parent::__construct($app, $events);

        date_default_timezone_set('Asia/Colombo');
    }

    protected function schedule(Schedule $schedule): void
    {
        // Run command every 5 minutes
        $schedule->command('food:check-expiry')->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
