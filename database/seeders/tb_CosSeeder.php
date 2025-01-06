<?php

namespace Database\Seeders;

use App\Models\Coordinators_Model;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class tb_CosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $CoordinatorList = [
            // ['PRJ-24-0001', 4],
            // ['PRJ-24-0001', 5]
        ];
        foreach ($CoordinatorList as $coo) {
            $model = new Coordinators_Model();
            $model->id_project = $coo[0];
            $model->id_karyawan = $coo[1];
            $model->save();
        }
    }
}
