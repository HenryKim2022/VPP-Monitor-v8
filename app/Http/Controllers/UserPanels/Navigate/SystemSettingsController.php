<?php

namespace App\Http\Controllers\UserPanels\Navigate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Jobs\CheckExpiredWorksheetsJob;
use App\Models\DaftarSysSettings_Model;
use Illuminate\Http\JsonResponse;


class SystemSettingsController extends Controller
{
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage System Settings", "m-sys");
        if ($process) {
            $authenticated_user_data = $this->get_user_auth_data();

            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                'genSysSettings' => $this->genSysSettings(),
                'authenticated_user_data' => $authenticated_user_data,
            ];

             // Decode the genSysSettings JSON into a collection
             $settingsCollection = collect(json_decode($data['genSysSettings'], true));
             // Filter to get entire objects where na_sett is either 'client_reg_menu' or 'employee_reg_menu'
             $filteredSettings = $settingsCollection
                 ->whereIn('na_sett', ['client_reg_menu', 'employee_reg_menu'])
                 ->values();
             $data['filtered_settings'] = $filteredSettings;

            return $this->setReturnView('pages/userpanels/pm_daftarsettings', $data);
        }
    }


    public function sh_reg_val_sett(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'setting_name' => 'required|string|in:client_reg_menu,employee_reg_menu',
            'setting_value' => 'required|boolean',
        ]);

        // Find the setting by name, ensuring it is not soft-deleted
        $setting = DaftarSysSettings_Model::where('na_sett', $validated['setting_name'])
            ->whereNull('deleted_at')
            ->firstOrFail();

        $setting->val_sett = $validated['setting_value'];
        $setting->save();

        $message = [
            'success_json' => [
                $setting->lbl_sett . ' Menu has been successfully updated to ' .
                ($setting->val_sett ? '*show to public.' : '*not show to public.')
            ]
        ];

        return response()->json(['message' => $message], 200);
    }



}
