<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan_Model;
use App\Models\Karyawan_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Jobs\CheckExpiredWorksheetsJob;



class OfficeRoleController extends Controller
{
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage OfficeRole", "m-role");
        if ($process) {
            $loadDaftarJabatanFromDB = [];
            $loadDaftarJabatanFromDB = Jabatan_Model::with(['karyawan'])->withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'daftar_login_4get.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);

            // $user = auth()->user();
            // $authenticated_user_data = $this->get_user_auth_data();

            $modalData = [
                'modal_add' => '#add_roleModal',
                'modal_edit' => '#edit_roleModal',
                'modal_delete' => '#delete_roleModal',
                'modal_reset' => '#reset_roleModal',
            ];

            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                // 'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                // 'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                // 'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                // 'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                // 'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                // 'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'loadDaftarJabatanFromDB' => $loadDaftarJabatanFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/pm_daftarjabatan', $data);
        }
    }


    public function get_role(Request $request)
    {
        $jabatanID = $request->input('jabatanID');
        $karyawanID = $request->input('karyawanID');

        $daftarJabatan = Jabatan_Model::where('id_jabatan', $jabatanID)->first();
        if ($daftarJabatan) {
            if ($daftarJabatan->id_karyawan) {
                $daftarJabatan->load('karyawan');
            }
            $karyawan = $daftarJabatan->karyawan;
            $employeeList = [];
            if ($karyawan) {
                $employeeList = Karyawan_Model::all()->map(function ($user) use ($karyawan) {
                    $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                    return [
                        'value' => $user->id_karyawan,
                        'text' => $user->na_karyawan,
                        'selected' => $selected,
                    ];
                });
            } else {
                $employeeList = Karyawan_Model::withoutTrashed()->get()->map(function ($user) {
                    return [
                        'value' => $user->id_karyawan,
                        'text' => $user->na_karyawan,
                        'selected' => false,
                    ];
                });
            }

            // Return queried data as a JSON response
            return response()->json([
                'id_jabatan' => $jabatanID,
                'na_jabatan' => $daftarJabatan->na_jabatan,
                'id_karyawan' => $karyawanID,
                'employeeList' => $employeeList,
            ]);
        } else {
            // Handle the case when the Jabatan_Model with the given jabatanID is not found
            return response()->json(['error' => 'Jabatan_Model not found'], 404);
        }
    }




    public function add_role(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role-name'  => 'required',
            ],
            [
                'role-name' => 'The role-name field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $id_karyawan = $request->input('role-karyawan-id');
        if ($id_karyawan || !$id_karyawan) {          // IF Check-in
            $roles = new Jabatan_Model();
            $roles->na_jabatan = $request->input('role-name');
            $roles->id_karyawan = $id_karyawan == null ? null : $id_karyawan;
            $roles->save();

            $authenticated_user_data = Jabatan_Model::find($roles->user_id);      // Re-auth after saving
            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Role added successfully!']);
        }
        return redirect()->back();
    }



    public function edit_role(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role_name'  => 'required',
                'bsvalidationcheckbox1'  => 'required',
            ],
            [
                'role_name' => 'The role field is required.',
                'bsvalidationcheckbox1'  => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jab = Jabatan_Model::find($request->input('jabatan_id'));
        if ($jab) {
            $jab->na_jabatan = $request->input('role_name');
            $id_karyawan = $request->input('edit-role-karyawan-id');
            $jab->id_karyawan = $id_karyawan;
            $jab->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Role updated successfully!']);
            return Redirect::back();
        } else {
            Session::flash('errors', ['Err[404]: Role update failed!']);
        }
    }




    public function delete_role(Request $request)
    {
        $jabatanID = $request->input('jabatan_id');
        $jabatan = Jabatan_Model::with('karyawan')->where('id_jabatan', $jabatanID)->first();
        if ($jabatan) {
            $jabatan->delete();

            $authenticated_user_data = Jabatan_Model::find($jabatan->id_jabatan);      // Re-auth after saving
            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Role deletion successful!']);
        } else {
            Session::flash('errors', ['Err[404]: Role deletion failed!']);
        }
        return redirect()->back();
    }

    public function reset_role(Request $request)
    {
        Jabatan_Model::query()->delete();
        DB::statement('ALTER TABLE tb_jabatan AUTO_INCREMENT = 1');

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All role data reset successfully!']);
        return redirect()->back();
    }
}
