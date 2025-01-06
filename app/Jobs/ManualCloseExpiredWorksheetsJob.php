<?php

    namespace App\Jobs;

    use App\Models\DaftarWS_Model;
    use Carbon\Carbon;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Support\Facades\Log;

    class ManualCloseExpiredWorksheetsJob
    {
        use Dispatchable;

        public function handle()
        {
            try {
                $now = Carbon::now();

                // Find worksheets that are expired
                $expiredWorksheets = DaftarWS_Model::with('task')->where('status_ws', 'OPEN')
                    ->whereNotNull('expired_at_ws')
                    ->where('expired_at_ws', '<', $now)
                    ->get();

                Log::info('Expired worksheets found: ' . $expiredWorksheets->count());

                foreach ($expiredWorksheets as $worksheet) {
                    $workDate = $worksheet->working_date_ws;
                    $prjID = $worksheet->id_project;

                    // Update the status to LOCKED or any other status you prefer
                    $worksheet->status_ws = 'LOCKED';
                    $worksheet->closed_at_ws = Carbon::now()->format('Y-m-d H:i:s');
                    $worksheet->save();

                    // Reset progress for related tasks
                    foreach ($worksheet->task as $task) {
                        $task->progress_current_task = 0;
                        $task->save();
                    }

                    // Log the action
                    Log::info("Worksheet ProjectID: {$prjID} WSID:{$worksheet->id_ws} WorkDate:{$workDate} has been locked due to expiration.");
                }
            } catch (\Exception $e) {
                Log::error('Error in AutoCloseExpiredWorksheetsJob: ' . $e->getMessage());
            }
        }
    }
