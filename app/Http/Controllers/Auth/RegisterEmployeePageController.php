<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DaftarLogin_Model;
use App\Models\Karyawan_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class RegisterEmployeePageController extends Controller
{
    //
    public function index()
    {
        $process = $this->setPageSession("Register", "signup");
        if ($process) {
            $data = [
                'site_name' => env(key: 'APP_NAME'),
                'quote' => $this->getQuote(),
            ];
            return $this->setReturnView('pages/auths/p_register_emp', $data);
        }
    }

    public function showRegister()
    {
        $process = $this->setPageSession("Register", "signup");
        if ($process) {
            $data = [
                'site_name' => env(key: 'APP_NAME'),
                'quote' => $this->getQuote(),
            ];
            return $this->setReturnView('pages/auths/p_register_emp', $data);
        }
    }

    public function doRegister(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'register-id-karyawan'     => 'required|string',
                'register-name-karyawan'   => 'required|string',
                'register-username' => 'required|string|unique:tb_daftar_login,username',
                'register-email'    => 'required|email|unique:tb_daftar_login,email',
                'register-password' => 'required|min:6',
                'register-confirm-password'  => 'required|same:register-password',
                'register-privacy-policy'    => 'required|accepted',
            ],
            [
                // 'register-id-karyawan.required' => 'The id field is required.',
                'register-name-karyawan.required' => 'The name field is required.',
                'register-username.required' => 'The username field is required.',
                'register-email.required' => 'The email field is required.',
                'register-password.required' => 'The password field is required.',
                'register-confirm-password.required' => 'The confirm password field is required.',
                'register-privacy-policy.required' => 'You must accept the terms and conditions.',
                'register-email.email' => 'The email must be a valid email address.',
                'register-confirm-password.min' => 'The password must be at least :min characters.',
                'register-confirm-password.same' => 'The confirm password must match the password.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $karyawan = Karyawan_Model::create([
            // 'id_karyawan' => $request->input('register-id-karyawan'),
            'na_karyawan' => $request->input('register-name-karyawan'),
        ]);

        // Note:
        // After creating new data at Karyawan_Model, get the id_karyawan of newly created data id_karyawan attibute
        // then pass the id_karyawan into $id_karyawan variable


        $id_karyawan = $karyawan->id_karyawan;
        DaftarLogin_Model::create([
            'username' => $request->input('register-username'),
            'email' => $request->input('register-email'),
            'password' => Hash::make($request->input('register-password')),
            'type' => "4",
            'id_karyawan' => $id_karyawan,
            'id_client' => null,
        ]);
        Session::flash('success', ['Registration successful!']);
        return redirect()->route('login.page');
    }

}
