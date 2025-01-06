<?php

// namespace App\Console;

// use Illuminate\Console\Scheduling\Schedule;
// use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// use Illuminate\Support\Facades\Log;

// class Kernel extends ConsoleKernel
// {
//     /////// NOTE
//     //// Everytime updating this, must do
//     ////    php artisan config:clear
//     ////    php artisan cache:clear
//     ////    php artisan route:clear

//     protected function schedule(Schedule $schedule)
//     {
//         Log::info('Scheduler is running'); // Add this line for debugging

//         // Schedule the command to run immediately
//         // $schedule->command('app:database-weekly-backup')->everyMinute(); // For testing purposes

//         // Schedule the command to run weekly on Friday at 12:00 AM
//         $schedule->command('app:database-weekly-backup')->weeklyOn(5, '00:00');

//         // Schedule the command to auto-close expired worksheets every minute
//         $schedule->command('app:auto-close-expired-worksheets')->everyMinute();

//         $schedule->call(function () {
//             Log::info('Test command executed.');
//         })->everyMinute();

//     }

//     protected function commands()
//     {
//         $this->load(__DIR__ . '/Commands');
//     }
// }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;


// use Illuminate\Support\Facades\Artisan;

use App\Jobs\AutoCloseExpiredWorksheetsJob; // Correctly import the job class

class Kernel extends ConsoleKernel
{
    /////// NOTE
    //// Everytime updating this, must do
    ////    php artisan config:clear
    ////    php artisan cache:clear
    ////    php artisan route:clear

    protected function schedule(Schedule $schedule)
    {
        //         Log::info('Scheduler is running'); // This log should appear in cron.log
        //         // Schedule the command to run weekly on Friday at 12:00 AM
        //         // $schedule->call(function () {
        //         //     Artisan::call('app:database-weekly-backup');
        //         //     Log::info('Database weekly backup command executed for weekly schedule.');
        //         // })->weeklyOn(5, '00:00');

        //         // // Schedule the command to auto-close expired worksheets every minute
        //         // $schedule->call(function () {
        //         //     Artisan::call('app:auto-close-expired-worksheets');
        //         //     Log::info('Auto Close Expired Worksheets command executed.');
        //         // })->everyMinute();

        //             // Dispatch the job to the queue every minute
        //         $schedule->job(new AutoCloseExpiredWorksheetsJob)->everyMinute();

        //         // Schedule the command to run weekly on Friday at 12:00 AM
        //         $schedule->job(new AutoCloseExpiredWorksheetsJob)->weeklyOn(5, '00:00');


        // // Example of scheduling a job to auto-close expired worksheets
        //         Schedule::job(new AutoCloseExpiredWorksheetsJob)->everyMinute();




        //         // Schedule a test command to log execution
        //         $schedule->call(function () {
        //             Log::info('Test command executed.');
        //         })->everyMinute();




        Log::info('Scheduler is running'); // Log to indicate the scheduler is running

        // // Schedule the command to run hourly
        // $schedule->command('jobs:fetch-update')->hourly();

        // Dispatch the job to auto-close expired worksheets every 5 minutes
        $schedule->job(AutoCloseExpiredWorksheetsJob::class)->everyMinute();

        // Schedule a test command to log execution every minute
        $schedule->call(function () {
            Log::info('Scheduled task executed at ' . now()); // Log for testing purposes
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands'); // This loads all commands from the Commands directory
    }
}
