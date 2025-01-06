<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckExpiredWorksheetsJob;
use Illuminate\Support\Facades\Log;

class RunEveryHour extends Command
{
    protected $signature = 'run:every-hour';
    protected $description = 'Run a job every hour';
    // NOTE:
    // Sample Command:
    ////// * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
    // Command Applied at Webhosting:
    ////// /usr/local/bin/ea-php82 /home/itir9421/public_html/vppm.iti-if.my.id/artisan schedule:run >> /home/itir9421/cron.log 2>&1

    // public function handle()
    // {
    //     // Dispatch the job
    //     CheckExpiredWorksheetsJob::dispatch();

    //     // Log the action (optional)
    //     Log::info('CheckExpiredWorksheetsJob dispatched.');


    //     $this->info('Job executed once every hour.');
    // }


    public function handle()
    {
        // Run the job twice with a 30-second interval
        for ($i = 0; $i < 3600; $i++) {
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
