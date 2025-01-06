<?php

namespace App\Services;

use App\Jobs\CheckExpiredWorksheetsJob;
use Illuminate\Support\Facades\Log;

class QueueWorkerService
{
    public function runQueueWorker()
    {
        // Dispatch the CheckExpiredWorksheetsJob
        $this->dispatchCheckExpiredWorksheetsJob();

        // Optionally, you can also implement other job processing logic here
        // For example, monitoring the queue, handling retries, etc.

        return "Queue worker is running and jobs are being dispatched.";
    }

    protected function dispatchCheckExpiredWorksheetsJob()
    {
        try {
            // Dispatch the job to the queue
            CheckExpiredWorksheetsJob::dispatch();

            Log::info("CheckExpiredWorksheetsJob has been dispatched.");
        } catch (\Exception $e) {
            // Log::error("Failed to dispatch CheckExpiredWorksheetsJob: " . $e->getMessage());
            Log::error("Failed to dispatch CheckExpiredWorksheetsJob: " . $e->getMessage());
        }
    }

    // You can add more methods to handle other job-related functionalities
}
