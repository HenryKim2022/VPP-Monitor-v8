<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunQueueWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-queue-work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // Execute the queue:work command
        $this->call('queue:work', [
            '--sleep' => 3,
            '--tries' => 3,
        ]);
    }
}
