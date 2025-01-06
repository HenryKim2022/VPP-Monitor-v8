<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use App\Jobs\AutoCloseExpiredWorksheetsJob; // Import the job class

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands'); // Load all commands from the Commands directory
    }
}
