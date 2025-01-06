<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan_Model;
use App\Models\DaftarLogin_Model;
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


class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Employee", "m-emp");
        if ($process) {
            $loadDaftarKaryawanFromDB = [];
            $loadDaftarKaryawanFromDB = Karyawan_Model::withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();

            $modalData = [
                'modal_add' => '#add_karyawanModal',
                'modal_edit' => '#edit_karyawanModal',
                'modal_delete' => '#delete_karyawanModal',
                'modal_reset' => '#reset_karyawanModal',
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
                'loadDaftarKaryawanFromDB' => $loadDaftarKaryawanFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/pm_daftarkaryawan', $data);
        }
    }


    public function add_emp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'emp-name'  => [
                    'required',
                    'string'
                ],
                // 'emp-religion'  => [
                //     'sometimes',
                //     'required',
                //     'string'
                // ],
                // 'emp-addr'  => [
                //     'sometimes',
                //     'required',
                //     'string'
                // ],
                // 'emp-telp'  => [
                //     'sometimes',
                //     // 'required',
                //     'string',
                //     Rule::unique('tb_karyawan', 'notelp_karyawan')->ignore($request->input('emp-telp'), 'notelp_karyawan')
                // ],
                'avatar-upload'  => [
                    'sometimes',
                    'required',
                    'image',
                    'max:5120'
                ],
                // 'emp-bday-place'  => [
                //     'sometimes',
                //     'required',
                //     'string'
                // ],
                'emp-birth-date'  => [
                    'sometimes',
                    'required',
                    'date'
                ],
            ],
            [
                'emp-name'  => 'The name field is required.',
                'emp-religion'  => 'The religion field is required.',
                'emp-addr'  => 'The address field is required.',
                'emp-telp'  => 'The no.telp field is required.',
                'emp-bday-place'  => 'The birth-place field is required.',
                'emp-birth-date'  => 'The birth-date field is required.',
                'avatar-upload.max' => 'The avatar must be a maximum of 5MB in size.',

            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $karyawan_name = $request->input('emp-name');
        if ($karyawan_name) {          // IF Check-in
            $karyawan = new Karyawan_Model();
            $karyawan->na_karyawan = $request->input('emp-name');
            $karyawan->alamat_karyawan = $request->input('emp-addr');
            $karyawan->notelp_karyawan = $request->input('emp-telp');
            $karyawan->tlah_karyawan = $request->input('emp-bday-place');
            $karyawan->tglah_karyawan = $request->input('emp-birth-date');
            $karyawan->agama_karyawan = $request->input('emp-religion');

            if ($request->hasFile('avatar-upload')) {
                $file = $request->file('avatar-upload');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatar/uploads'), $filename);
                $karyawan->foto_karyawan = $filename;
            }
            $karyawan->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Employee added successfully!']);
        }
        return redirect()->back();
    }



    public function get_emp(Request $request)
    {
        $karyawanID = $request->input('karyawanID');
        $daftarKaryawan = Karyawan_Model::where('id_karyawan', $karyawanID)->first();

        if ($daftarKaryawan) {
            // Return queried data as a JSON response
            return response()->json([
                'id_karyawan' => $daftarKaryawan->id_karyawan,
                'na_karyawan' => $daftarKaryawan->na_karyawan,
                'reli_karyawan' => $daftarKaryawan->agama_karyawan,
                'addr_karyawan' => $daftarKaryawan->alamat_karyawan,
                'telp_karyawan' => $daftarKaryawan->notelp_karyawan,
                'ava_karyawan' => $daftarKaryawan->foto_karyawan ? $daftarKaryawan->foto_karyawan . '?v=' . time() : $daftarKaryawan->foto_karyawan,
                'bplace_karyawan' => $daftarKaryawan->tlah_karyawan,
                'bdate_karyawan' => $daftarKaryawan->tglah_karyawan,
                // 'employeeList' => $employeeList,
            ]);
        } else {
            // Handle the case when the user with the given user_id is not found
            return response()->json(['error' => '[Err: 404] Employee not found'], 404);
        }
    }


    public function edit_emp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'edit_karyawan_id' => 'sometimes|required',
                'edit-emp-name' => 'sometimes|required',
                // 'edit-emp-religion' => 'sometimes|required',
                // 'edit-emp-addr' => 'sometimes|required',
                // 'edit-emp-telp' => 'sometimes|required',
                // 'edit-emp-bday-place' => 'sometimes|required',
                // 'edit-emp-birth-date' => 'sometimes|date|required',
                'bsvalidationcheckbox1' => 'required',
            ],
            [
                'edit_karyawan_id' => 'The employee-id field is not filled by system.',
                'edit-emp-name' => 'The employee name field is required.',
                'edit-emp-religion' => 'The religion field is required.',
                'edit-emp-addr' => 'The address field is required.',
                'edit-emp-telp' => 'The no.telp field is required.',
                'edit-emp-bday-place' => 'The birth-place field is required.',
                'edit-emp-birth-date' => 'The birth-date field is required.',
                'edit-emp-birth-date.date' => 'The birth-date field must be a valid date.',
                'bsvalidationcheckbox1.required' => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $edit_emp_name = $request->input('edit-emp-name');
        $edit_emp_religion = $request->input('edit-emp-religion');
        $edit_emp_addr = $request->input('edit-emp-addr');
        $edit_emp_telp = $request->input('edit-emp-telp');
        $edit_emp_avatar = $request->input('edit-avatar-upload');
        $edit_emp_bday_place = $request->input('edit-emp-bday-place');
        $edit_emp_birth_date = $request->input('edit-emp-birth-date');

        $karyawanID = $request->input('edit_karyawan_id');
        $daftarKaryawan = Karyawan_Model::where('id_karyawan', $karyawanID)->first();
        if ($daftarKaryawan) {
            // dd($request->hasFile('edit-avatar-upload'));
            if ($request->hasFile('edit-avatar-upload')) {
                $daftarKaryawan->na_karyawan = $edit_emp_name;
                $daftarKaryawan->tlah_karyawan = $edit_emp_bday_place;
                $daftarKaryawan->tglah_karyawan = $edit_emp_birth_date;
                $daftarKaryawan->agama_karyawan = $edit_emp_religion;
                $daftarKaryawan->alamat_karyawan = $edit_emp_addr;
                $daftarKaryawan->notelp_karyawan = $edit_emp_telp;

                $file = $request->file('edit-avatar-upload');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatar/uploads'), $filename);
                $daftarKaryawan->foto_karyawan = $filename;
                $daftarKaryawan->save();

                $user = auth()->user();
                $authenticated_user_data = $this->get_user_auth_data();
                Session::put('authenticated_user_data', $authenticated_user_data);

                Session::flash('success', ['Employee update successfully!']);
            } else {    // Handle case where no logo file is provided
                $daftarKaryawan->na_karyawan = $edit_emp_name;
                $daftarKaryawan->tlah_karyawan = $edit_emp_bday_place;
                $daftarKaryawan->tglah_karyawan = $edit_emp_birth_date;
                $daftarKaryawan->agama_karyawan = $edit_emp_religion;
                $daftarKaryawan->alamat_karyawan = $edit_emp_addr;
                $daftarKaryawan->notelp_karyawan = $edit_emp_telp;
                $daftarKaryawan->save();
                Session::flash('success', ['Employee update successfully!']);
            }
        } else {
            Session::flash('errors', ['Err[404]: Employee update failed!']);
        }

        return redirect()->back();
    }




    public function delete_emp(Request $request)
    {
        $karyawanID = $request->input('del_karyawan_id');

        $authenticated_user_data = Session::get('authenticated_user_data');
        $current_user_rel_karyawan = $authenticated_user_data->id_karyawan;
        $is_current_user = ($karyawanID == $current_user_rel_karyawan);
        if ($is_current_user) {
            Session::flash('n_errors', ["Err[500]: You're not allowed to delete your own data while u're active!"]);
        } else {
            $karyawan = Karyawan_Model::where('id_karyawan', $karyawanID)->whereNull('deleted_at')->first();

            $hasLogin = DaftarLogin_Model::where('id_karyawan', $karyawanID)->whereNull('deleted_at')->exists();
            if ($hasLogin) {
                Session::flash('n_errors', ['Err[400]: Employee cannot be deleted because they have an active login!']);
            } elseif ($karyawan) {
                $karyawan->delete();

                $user = auth()->user();
                $authenticated_user_data = $this->get_user_auth_data();
                Session::put('authenticated_user_data', $authenticated_user_data);
                Session::flash('success', ['Employee deletion successful!']);
            } else {
                Session::flash('n_errors', ['Err[404]: Employee deletion failed!']);
            }
        }

        return redirect()->back();
    }



    public function reset_emp(Request $request)
    {
        $user = auth()->user();
        $karyawanID = $user->id_karyawan;
        // Soft delete all karyawan records except the one with the given karyawanID
        Karyawan_Model::where('id_karyawan', '!=', $karyawanID)->delete();

        // Reset the auto-increment value of the table
        DB::statement('ALTER TABLE tb_karyawan AUTO_INCREMENT = 1');
        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All employee data (excluding me) reset successfully!']);
        return redirect()->back();
    }
}
