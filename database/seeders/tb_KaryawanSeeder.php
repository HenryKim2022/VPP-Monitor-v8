<?php

namespace Database\Seeders;

use App\Models\Karyawan_Model;
use Illuminate\Database\Seeder;

class tb_KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawanList = [
            ////////////////////////////////////////////////// SUPERADMIN ///////////////////////////////////////////////////////
            [
                'na_karyawan' => 'Hendri',
                'tlah_karyawan' => 'Toboali',
                'tglah_karyawan' => '1998-10-26',
                'agama_karyawan' => 'Buddha',
                'alamat_karyawan' => 'JL. Jend Sudirman',
                'notelp_karyawan' => '+6282281190072',
                'foto_karyawan' => '669f4ffdd2ff6.jpg',
                'id_team' => null
            ],
            [
                'na_karyawan' => 'Firman',
                'tlah_karyawan' => null,
                'tglah_karyawan' => null,
                'agama_karyawan' => 'Islam',
                'alamat_karyawan' => null,
                'notelp_karyawan' => null,
                'foto_karyawan' => null,
                'id_team' => null
            ],
            [
                'na_karyawan' => 'Zachra',
                'tlah_karyawan' => null,
                'tglah_karyawan' => null,
                'agama_karyawan' => 'Islam',
                'alamat_karyawan' => null,
                'notelp_karyawan' => null,
                'foto_karyawan' => null,
                'id_team' => 5
            ],
            ////////////////////////////////////////////////// PK or SPV ///////////////////////////////////////////////////////
            [
                'na_karyawan' => 'Latief',
                'tlah_karyawan' => null,
                'tglah_karyawan' => null,
                'agama_karyawan' => 'Islam',
                'alamat_karyawan' => null,
                'notelp_karyawan' => null,
                'foto_karyawan' => null,
                'id_team' => 5
            ],
            [
                'na_karyawan' => 'Sarman',
                'tlah_karyawan' => null,
                'tglah_karyawan' => null,
                'agama_karyawan' => 'Islam',
                'alamat_karyawan' => null,
                'notelp_karyawan' => null,
                'foto_karyawan' => null,
                'id_team' => 5
            ],
            [
                'na_karyawan' => 'Khoiri',
                'tlah_karyawan' => null,
                'tglah_karyawan' => null,
                'agama_karyawan' => 'Islam',
                'alamat_karyawan' => null,
                'notelp_karyawan' => null,
                'foto_karyawan' => null,
                'id_team' => 5
            ],
            [
                'na_karyawan' => 'Juanda',
                'tlah_karyawan' => null,
                'tglah_karyawan' => null,
                'agama_karyawan' => null,
                'alamat_karyawan' => null,
                'notelp_karyawan' => null,
                'foto_karyawan' => null,
                'id_team' => 5
            ],
            ////////////////////////////////////////////////// ENGINEER ///////////////////////////////////////////////////////
            ['na_karyawan' => 'Simson', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 5], // TEAM OTHER
            ['na_karyawan' => 'Rudi', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 1], // TEAM A
            ['na_karyawan' => 'Rio', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 1], // TEAM A
            ['na_karyawan' => 'Reza', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 4], // TEAM D
            ['na_karyawan' => 'Nick', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 2], // TEAM B
            ['na_karyawan' => 'Ilham', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 3], // TEAM OTHER
            ['na_karyawan' => 'Joni', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 2], // TEAM B
            ['na_karyawan' => 'Harindra', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 2], // TEAM B
            ['na_karyawan' => 'Edi', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 2], // TEAM B
            ['na_karyawan' => 'Arjuna', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 1], // TEAM A
            ['na_karyawan' => 'Arie', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 3], // TEAM C
            ['na_karyawan' => 'Andreas', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 2], // TEAM B
            ['na_karyawan' => 'Aditya', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 1], // TEAM A
            ['na_karyawan' => 'Dimas', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 1], // TEAM A
            ['na_karyawan' => 'Didi', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 3], // TEAM C
            ['na_karyawan' => 'Denny', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 3], // TEAM OTHER
            ['na_karyawan' => 'Sumarwan', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 3], // TEAM C
            ['na_karyawan' => 'Irpan', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 3], // TEAM C
            ['na_karyawan' => 'Dhany', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 5], // TEAM OTHER
            ['na_karyawan' => 'Adrian', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 4], // TEAM D
            ['na_karyawan' => 'Dedek', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 4], // TEAM D
            ['na_karyawan' => 'Hudi', 'tlah_karyawan' => null, 'tglah_karyawan' => null, 'agama_karyawan' => null, 'alamat_karyawan' => null, 'notelp_karyawan' => null, 'foto_karyawan' => null, 'id_team' => 5], // TEAM OTHER


        ]; // Example karyawan values

        foreach ($karyawanList as $karyawan) {
            Karyawan_Model::create($karyawan);
        }
    }
}
