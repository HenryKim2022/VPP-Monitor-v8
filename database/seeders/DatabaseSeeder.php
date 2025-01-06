<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(tb_SettingsSeeder::class);
        $this->call(tb_ClientSeeder::class);
        $this->call(tb_ProjectsSeeder::class);
        $this->call(tb_TeamsSeeder::class);
        $this->call(tb_ProjectsTeamsSeeder::class);
        $this->call(tb_KaryawanSeeder::class);
        $this->call(tb_CosSeeder::class);
        $this->call(tb_MonitoringSeeder::class);
        $this->call(tb_WorksheetSeeder::class);
        $this->call(tb_TaskSeeder::class);
        $this->call(tb_JabatanSeeder::class);
        $this->call(tb_DaftarLoginSeeder::class);
    }
}
