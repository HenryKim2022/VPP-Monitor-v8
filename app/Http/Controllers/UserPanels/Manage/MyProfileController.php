<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TheApp_Model;
use App\Models\Karyawan_Model;
use App\Models\Absen_Model;
use App\Models\DaftarLogin_Model;
use App\Models\Kustomer_Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Jobs\CheckExpiredWorksheetsJob;
use Illuminate\Support\Facades\Log;


class MyProfileController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("MyProfile", "my-profile");
        if ($process) {
            $idKaryawan = $this->getCurrentUserID();

            // $user = auth()->user();
            // $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'jabatan.karyawan')->find($user->idKaryawan);
            // if (!$authenticated_user_data){
            //     $authenticated_user_data = Session::get('authenticated_user_data');
            // }
            // // dd($authenticated_user_data->toArray());

            // $user = auth()->user();
            // $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'daftar_login_4get.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            if (!$authenticated_user_data) {
                if ($authenticated_user_data == null) {
                    return redirect()->back(); // Redirect to the previous page or handle the case when authenticated_user_data is not available
                }
            }


            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                'loadDataKaryawanFromDB' => DaftarLogin_Model::with(['karyawan'])->where('id_karyawan', $idKaryawan)->get(),
                // 'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                // 'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                // 'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                // 'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                // 'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                // 'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'authenticated_user_data' => $authenticated_user_data,
                'loadDataUserFromDB' => $this->profile_load_accdata($idKaryawan),
            ];
            Session::put('loadDataUserFromDB', $this->profile_load_accdata($idKaryawan));

            return $this->setReturnView('pages/userpanels/pm_myprofile', $data);
        }
    }

    public function profile_load_accdata($idKaryawan)
    {
        // dd(DaftarLogin_Model::with(['karyawan'])->where('id_karyawan', $idKaryawan)->get());
        return DaftarLogin_Model::with(['karyawan'])->where('id_karyawan', $idKaryawan)->get();
    }


    public function getCurrentUserID()
    {
        $user = auth()->user();
        $idUser = null;
        if ($user) {
            if ($user->id_karyawan) {
                $karyawan = Karyawan_Model::where('id_karyawan', $user->id_karyawan)->first();
                if ($karyawan) {
                    $idUser = $karyawan->id_karyawan;;
                }
            } else {
                $client = Kustomer_Model::where('id_client', $user->id_client)->first();
                if ($client) {
                    $idUser = $client->id_client;;
                }
            }
        }
        return $idUser;
    }

    public function profile_load_biodata(Request $request)
    {
        $process = $this->setPageSession("My Profile", "my-profile/load-biodata");
        if ($process) {
            $idKaryawan = $this->getCurrentUserID();
            $data = [
                'loadDataKaryawanFromDB' => DaftarLogin_Model::with(['karyawan'])->where('id_karyawan', $idKaryawan)->get(),
            ];
            return $this->setReturnView('pages/userpanels/p_dashboard', $data);
        }
    }


    public function profile_edit_avatar(Request $request)
    {
        $authUserType = auth()->user()->type;

        // Validation rules
        $rules = [
            'foto_karyawan' => 'nullable|image|max:5120', // 5MB in kilobytes (5 * 1024)
            'foto_client' => 'nullable|image|max:5120',   // 5MB in kilobytes (5 * 1024)
        ];
        $messages = [
            'foto_karyawan.image' => 'The foto_karyawan must be a valid image file.',
            'foto_karyawan.max' => 'The foto_karyawan must not exceed 5MB in size.',
            'foto_client.image' => 'The foto_client must be a valid image file.',
            'foto_client.max' => 'The foto_client must not exceed 5MB in size.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 422);
            $toast_message = $validator->errors()->all();
            Session::flash('n_errors', $toast_message);
        } else {
            $userModel = $authUserType != 'Client' ? Karyawan_Model::class : Kustomer_Model::class;
            $userIdField = $authUserType != 'Client' ? 'id_karyawan' : 'id_client';
            $fileField = $authUserType != 'Client' ? 'foto_karyawan' : 'foto_client';

            $user = $userModel::where($userIdField, $request->input($userIdField))->first();

            if ($user) {
                if ($request->hasFile($fileField)) {
                    $file = $request->file($fileField);
                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('avatar/uploads'), $filename);
                    $user->{$fileField} = $filename;
                    $user->save();

                    $authenticated_user_data = $this->get_user_auth_data();
                    Session::put('authenticated_user_data', $authenticated_user_data);
                    Session::flash('success', ['User  image updated successfully']);
                } else {
                    Session::flash('n_errors', ['User  image update failed']);
                }
            } else {
                Session::flash('n_errors', ['Err[404]: User not found']);
            }
        }


        return response()->json(['reload' => true]);
    }



    public function profile_edit_biodata(Request $request)
    {
        // dd($request->ToArray());
        // dd($request->input('birth-date'));
        $authUserType = auth()->user()->type;
        $validator = Validator::make(
            $request->all(),
            [
                'account-name'  => 'sometimes|required|min:3',
                'birth-loc'  => 'sometimes|required',
                // 'birth-date'  => 'sometimes|required',
                // 'religion'  => 'sometimes|required',
                'address'  => 'sometimes|required',
                'notelp'  => 'sometimes|required',
            ],
            [
                'account-name.required' => 'The account-name field is required.',
                // 'birth-loc.required' => 'The birth-loc field is required.',
                'birth-date.required' => 'The birth-date field is required.',
                // 'religion.required' => 'The religion field is required.',
                'address.required'  => 'The address field is required.',
                'notelp.required' => 'The notelp field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($authUserType != 'Client') {
            $karyawan = Karyawan_Model::where('id_karyawan', $request->input('id_karyawan'))->first();
            if ($karyawan) {
                $karyawan->na_karyawan = $request->input('account-name');
                $karyawan->tlah_karyawan = $request->input('birth-loc');
                $karyawan->tglah_karyawan = $request->input('birth-date');
                $karyawan->agama_karyawan = $request->input('religion');
                $karyawan->alamat_karyawan = $request->input('address');
                $karyawan->notelp_karyawan = $request->input('notelp');
                $karyawan->save();

                // Retrieve the updated authenticated user data
                $updatedUser  = $this->get_user_auth_data(); // Call your method to get the updated user data
                // Update the session with the new user data
                Session::put('authenticated_user_data', $updatedUser);

                Session::flash('success', ['Your account data was updated!']);
            } else {
                Session::flash('n_errors', ['Err[404]: Failed to update user account!']);
            }
        } else {
            $client = Kustomer_Model::where('id_client', $request->input('id_client'))->first();
            if ($client) {
                $client->na_client = $request->input('account-name');
                $client->alamat_client = $request->input('address');
                $client->notelp_client = $request->input('notelp');
                $client->save();

                // Retrieve the updated authenticated user data
                $updatedUser  = $this->get_user_auth_data(); // Call your method to get the updated user data
                // Update the session with the new user data
                Session::put('authenticated_user_data', $updatedUser);

                Session::flash('success', ['Your account data was updated!']);
            } else {
                Session::flash('n_errors', ['Err[404]: Failed to update user account!']);
            }
        }


        return redirect()->back();
    }

    public function profile_edit_accdata(Request $request)
    {
        $userId = $request->input('user_id'); // Get the user ID from the request

        $validator = Validator::make(
            $request->all(),
            [
                'username'  => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('tb_daftar_login', 'username')->ignore($userId, 'user_id')
                ],
                'email'     => [
                    'sometimes', // Make it optional
                    'nullable',  // Allow null values
                    'email',
                    Rule::unique('tb_daftar_login', 'email')->ignore($userId, 'user_id') // Ignore the current user's email
                ],
                'new-password'          => 'nullable|min:6', // Optional, only require min length if provided
                'confirm-new-password'  => 'nullable|same:new-password', // Optional, only required if new-password is present
            ],
            [
                'username.required'  => 'The username field is required.',
                'email.email'        => 'The email must be a valid email address.',
                'email.unique'       => 'The email has already been taken.', // Custom message for email uniqueness
                'new-password.min'    => 'The new-password field must be at least 6 characters.', // Custom message for min length
                'confirm-new-password.same' => 'The password confirmation does not match.',
            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $daftarLogin = DaftarLogin_Model::find($userId);
        if ($daftarLogin) {
            $daftarLogin->username = $request->input('username');

            // Only update email if it's provided
            if ($request->has('email') && $request->input('email') !== null) {
                $daftarLogin->email = $request->input('email');
            }

            // Update password if provided
            if ($request->filled('new-password')) {
                $daftarLogin->password = bcrypt($request->input('new-password'));
            }

            $daftarLogin->type = $request->input('type');
            $daftarLogin->save();

            // Refresh the authenticated user data
            $authenticated_user_data = $this->get_user_auth_data(); // Get updated user data
            Session::put('authenticated_user_data', $authenticated_user_data); // Update session

            Session::flash('success', ['Your account data was updated!']);
        } else {
            Session::flash('n_errors', ['Err[404]: Failed to update user account!']);
        }

        return redirect()->back();
    }
}
