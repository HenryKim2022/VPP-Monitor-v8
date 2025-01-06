<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DatabaseWeeklyBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database-weekly-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a weekly backup of the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the application name from the config and convert it to lowercase
        $appName = strtolower(config('app.name'));

        // Get database credentials from the .env file
        $dbHost = config('database.connections.mysql.host');
        $dbUsername = config('database.connections.mysql.username');
        $dbPassword = config('database.connections.mysql.password');
        $dbName = config('database.connections.mysql.database');

        // Create a filename for the backup
        $filename = "weekly-{$appName}-db-backup-" . now()->format('Y-m-d-H-i-s') . ".sql";
        $backupPath = storage_path("backups/{$filename}");

        // Ensure the backups directory exists
        if (!File::exists(storage_path('backups'))) {
            File::makeDirectory(storage_path('backups'), 0755, true);
        }

        // Construct the mysqldump command
        $command = "mysqldump -h {$dbHost} -u {$dbUsername} -p'{$dbPassword}' {$dbName} > {$backupPath}";

        // Execute the command
        exec($command, $output, $return_var);

        // Check the result of the command
        if ($return_var === 0) {
            Log::info('Weekly database backup created: ' . $filename);
        } else {
            Log::error('Weekly database backup failed: ' . implode("\n", $output));
        }
    }
}
