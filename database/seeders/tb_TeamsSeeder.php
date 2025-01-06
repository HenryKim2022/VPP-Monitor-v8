<?php

namespace Database\Seeders;

use App\Models\Team_Model;
use Illuminate\Database\Seeder;

class tb_TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamList = [
            ['Team A'],
            ['Team B'],
            ['Team C'],
            ['Team D'],
            ['Team Other']
        ];
        foreach ($teamList as $team) {
            $model = new Team_Model();
            $model->na_team = $team[0];
            $model->save();
        }
    }
}
