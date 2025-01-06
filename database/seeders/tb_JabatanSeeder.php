<?php

namespace Database\Seeders;

use App\Models\Jabatan_Model;
use Illuminate\Database\Seeder;

class tb_JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanList = [
            ['IT Developer', 1],
            ['IT Engineer', 2],
            ['General Manager', 26],
            ['Engineer Manager', 8],
        ];
        foreach ($jabatanList as $jabatan) {
            $model = new Jabatan_Model();
            $model->na_jabatan = $jabatan[0];
            $model->id_karyawan = $jabatan[1];
            $model->save();
        }

    }
}
