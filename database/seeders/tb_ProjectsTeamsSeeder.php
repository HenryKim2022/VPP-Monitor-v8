<?php

namespace Database\Seeders;

use App\Models\Projects_Teams_Model;
use App\Models\Team_Model;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class tb_ProjectsTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prjteamList = [
            // [1, 'PRJ-24-0001'],
            // [2, 'PRJ-24-0001'],
            // [1, null],
            // [1, null],
            // [1, null]
        ];
        foreach ($prjteamList as $prjteam) {
            $model = new Projects_Teams_Model();
            $model->id_team = $prjteam[0];
            $model->id_project = $prjteam[1];
            $model->save();
        }
    }
}
