<?php

namespace Database\Seeders;

use App\Models\DaftarLogin_Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tb_DaftarLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $loginList = [
            // Username,    email,                  pass,       type,   id_kar, id_cli
            ///////////////////////////////// EMPLOYEE ////////////////////////////////
            // ######## SUPERADMIN
            ['admin',       'admin@mail.com',       '123456',   2,      1,      null],
            ['firman',      null,                   '123456',   2,      2,      null],
            // ######## SUPERVISOR or PK
            ['zachra',      null,                   '123456',   3,      3,      null],
            ['lathif',      null,                   '123456',   3,      4,      null],
            ['sarman',      null,                   '123456',   3,      5,      null],
            ['khoiri',      null,                   '123456',   3,      6,      null],
            ['juanda',      null,                   '123456',   3,      7,      null],
            // ######## ENGINEER
            ['simson',      null,                   '123456',   4,      8,      null],
            ['rudi',        null,                   '123456',   4,      9,      null],
            ['rio',         null,                   '123456',   4,      10,     null],
            ['reza',        null,                   '123456',   4,      11,     null],
            ['nick',        null,                   '123456',   4,      12,     null],
            ['ilham',       null,                   '123456',   4,      13,     null],
            ['joni',        null,                   '123456',   4,      14,     null],
            ['harindra',    null,                   '123456',   4,      15,     null],
            ['edi',         null,                   '123456',   4,      16,     null],
            ['arjuna',      null,                   '123456',   4,      17,     null],
            ['arie',        null,                   '123456',   4,      18,     null],
            ['andreas',     null,                   '123456',   4,      19,     null],
            ['aditya',      null,                   '123456',   4,      20,     null],
            ['dimas',       null,                   '123456',   4,      21,     null],
            ['didi',        null,                   '123456',   4,      22,     null],
            ['denny',       null,                   '123456',   4,      23,     null],
            ['sumarwan',    null,                   '123456',   4,      24,     null],
            ['irpan',       null,                   '123456',   4,      25,     null],
            ['dhany',       null,                   '123456',   4,      26,     null],
            ['adrian',      null,                   '123456',   4,      27,     null],
            ['dedek',       null,                   '123456',   4,      28,     null],
            ['hudi',        null,                   '123456',   3,      29,     null],
            ////////////////////////////////// CLIENT /////////////////////////////////
            // ['client1',     'client1@mail.com',     '123456',   1,      null,   1],
        ];

        foreach ($loginList as $index => $login) {
            $username = $login[0];
            $email = $login[1];
            $password = $login[2];
            $userType = $login[3];
            $idKaryawan = $login[4];
            $idClient = $login[5];

            $existingUser = DaftarLogin_Model::where('username', $username)->first();
            if ($existingUser) {
                $existingUser->update([
                    'email' => $email,
                    'password' => bcrypt($password),
                    'type' => $userType,
                    'id_karyawan' => $idKaryawan,
                    'id_client' => $idClient,
                ]);
            } else {
                DaftarLogin_Model::create([
                    'username' => $username,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'type' => $userType,
                    'id_karyawan' => $idKaryawan,
                    'id_client' => $idClient,
                ]);
            }
        }
    }
}
