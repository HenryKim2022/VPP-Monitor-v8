<?php

namespace Database\Seeders;

use App\Models\DaftarSysSettings_Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tb_SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // php artisan migrate:refresh --seed
        $SettingsList = [
            ['client_reg_menu', 'Client Account', 'Create an client account', 1, 'register.client.page'],
            ['employee_reg_menu', 'Employee Account', 'Create an employee account', 0, 'register.emp.page'],
            ['site_owner_email', 'Company Email', 'info@vertechperdana.com', null, null],
            ['site_owner_phone_number', 'Company Phone Number', '+62 21 29 66666 2', null, null],
        ];

        foreach ($SettingsList as $setting) {
            $model = new DaftarSysSettings_Model();
            $model->na_sett = $setting[0];
            $model->lbl_sett = $setting[1];
            $model->tooltip_text_sett = $setting[2];
            $model->val_sett = $setting[3];
            $model->url_sett = $setting[4];
            $model->save();
        }
    }
}
