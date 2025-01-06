<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckExpiredWorksheetsJob;
use Illuminate\Support\Facades\Log;

class RunEvery30Seconds extends Command
{
    protected $signature = 'run:every-30-seconds';
    protected $description = 'Run a job every 30 seconds indefinitely';

    public function handle()
    {
        // Run the job twice with a 30-second interval
        for ($i = 0; $i < 2; $i++) {
            // Dispatch the job
            CheckExpiredWorksheetsJob::dispatch();

            // Log the action (optional)
            Log::info('CheckExpiredWorksheetsJob dispatched.');

            // Wait for 30 seconds before the next iteration
            sleep(30);
        }

        $this->info('Job executed twice, once every 30 seconds.');
    }
}
