<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckExpiredWorksheetsJob;

class CheckExpiredWorksheets extends Command
{
    protected $signature = 'worksheets:check-expired';
    protected $description = 'Check and close expired worksheets';

    public function handle()
    {
        // Dispatch the job to check expired worksheets
        CheckExpiredWorksheetsJob::dispatch();

        $this->info('Expired worksheets check job dispatched successfully.');
    }
}
