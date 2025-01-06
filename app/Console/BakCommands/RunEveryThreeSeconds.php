<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckExpiredWorksheetsJob;
use Illuminate\Support\Facades\Log;

class RunEveryThreeSeconds extends Command
{
    protected $signature = 'run:every-three-seconds';
    protected $description = 'Run a job every 2 seconds';

    public function handle()
    {
        // Run the job every 2 seconds for a total of 60 seconds (20 times)
        for ($i = 0; $i < 3600; $i++) {
            // Dispatch the job
            CheckExpiredWorksheetsJob::dispatch();

            // Log the action (optional)
            Log::info('CheckExpiredWorksheetsJob dispatched.');

            // Wait for 3 seconds
            sleep(seconds: 3);
        }

        $this->info('Job executed every 2 seconds for 1 minute.');
    }
}
