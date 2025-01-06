<?php

use App\Jobs\AutoCloseExpiredWorksheetsJob;
use App\Jobs\ManualCloseExpiredWorksheetsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

//////////// NOTE:
///// 1. Check if's the schedule registered
// php artisan schedule:list
//
///// 2. Do test if's the job working fine manually #1
//  php artisan tinker
// 	    dispatch(new \App\Jobs\AutoCloseExpiredWorksheetsJob());
///// 3. Do test if's the job working fine manually #2
// php artisan queue:work
//




Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



// // Example of scheduling a job to auto-close expired worksheets
// // Schedule::job(new \App\Jobs\AutoCloseExpiredWorksheetsJob)->everyMinute();
// Schedule::job(new AutoCloseExpiredWorksheetsJob)->everyMinute()->withoutOverlapping();
Schedule::job(new AutoCloseExpiredWorksheetsJob)->hourly()->withoutOverlapping();


// // Example of scheduling a logging task to run every minute
// Schedule::call(function () {
//     Log::info('Scheduled task executed at ' . now());
// })->everyMinute();
// Log::info(message: 'Laravel Scheduler Active: All corresponding schdule has been scheduled.');
