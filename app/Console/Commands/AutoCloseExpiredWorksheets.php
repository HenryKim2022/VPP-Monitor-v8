<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DaftarWS_Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/////////// MAKING/ CONFIG NOTE:
//// Make console command:
////    php artisan make:command AutoCloseExpiredWorksheets
//// Config app/console/kernel.php:
////    protected function schedule(Schedule $schedule)
////    {
////         $schedule->command('app:auto-close-expired-worksheets')->everyMinute();
////    }


/////////// USAGE NOTE:
//// Manual test (1 schedule):
///////// php artisan app:auto-close-expired-worksheets
//// Manual test (AIO schedule):
///////// php artisan schedule:run
//// Auto test webhosting:
////////

/////////// CRONJOB COMMAND (Webhosting):
////    * * * * * /usr/local/bin/php /home/itir9421/public_html/vppm.iti-if.my.id/artisan schedule:run >> /home/itir9421/cron.log 2>&1
//// OR this one:
////    * *	* *	* /usr/local/bin/ea-php82 /home/itir9421/public_html/vppm.iti-if.my.id/artisan schedule:run >> /home/itir9421/cron.log 2>&1


class AutoCloseExpiredWorksheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-close-expired-worksheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Close Expired Worksheets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $now = Carbon::now();

        // Find worksheets that are expired
        $expiredWorksheets = DaftarWS_Model::with('task')->where('status_ws', 'OPEN')
            ->whereNotNull('expired_at_ws')
            ->where('expired_at_ws', '<', $now)
            ->get();
        foreach ($expiredWorksheets as $worksheet) {
            $workDate = $worksheet->working_date_ws;
            $prjID = $worksheet->id_project;
            if ($worksheet->status_ws == 'OPEN'){
                // Update the status to LOCKED or any other status you prefer
                $worksheet->status_ws = 'LOCKED';
                $worksheet->closed_at_ws = Carbon::now()->format('Y-m-d H:i:s');
                $worksheet->save();

                // Reset progress for related tasks
                foreach ($worksheet->task as $task) {
                    $task->progress_current_task = 0;
                    $task->save();
                }

                // Optionally log or notify about the locked worksheets
                Log::info("Worksheet ProjectID: {$prjID} WSID:{$worksheet->id_ws} WorkDate:{$workDate} has been locked due to expiration.");
                $this->info("Worksheet ProjectID: {$prjID} WSID:{$worksheet->id_ws} WorkDate:{$workDate} has been locked due to expiration.");
            }else{
                $worksheet->closed_at_ws = Carbon::now()->format('Y-m-d H:i:s');
                $worksheet->save();

                // Reset progress for related tasks
                foreach ($worksheet->task as $task) {
                    $task->progress_current_task = 0;
                    $task->save();
                }

                // Optionally log or notify about the locked worksheets
                Log::info("Worksheet ProjectID: {$prjID} WSID:{$worksheet->id_ws} WorkDate:{$workDate} has been locked due to expiration.");
                $this->info("Worksheet ProjectID: {$prjID} WSID:{$worksheet->id_ws} WorkDate:{$workDate} has been locked due to expiration.");

            }
        }

    }
}
