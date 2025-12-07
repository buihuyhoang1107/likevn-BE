<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class ConsoleKernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Add scheduled tasks here if needed
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}

