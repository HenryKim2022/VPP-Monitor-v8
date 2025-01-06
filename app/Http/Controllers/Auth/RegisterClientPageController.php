<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DaftarLogin_Model;
use App\Models\Kustomer_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class RegisterClientPageController extends Controller
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
            return $this->setReturnView('pages/auths/p_register_client', $data);
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
            return $this->setReturnView('pages/auths/p_register_client', $data);
        }
    }

    public function doRegister(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'register-id-client'     => 'required|string',
                'register-name-client'   => 'required|string',
                'register-username' => 'required|string|unique:tb_daftar_login,username',
                'register-email'    => 'required|email|unique:tb_daftar_login,email',
                'register-password' => 'required|min:6',
                'register-confirm-password'  => 'required|same:register-password',
                'register-privacy-policy'    => 'required|accepted',
            ],
            [
                // 'register-id-client.required' => 'The id field is required.',
                'register-name-client.required' => 'The name field is required.',
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


        $client = Kustomer_Model::create([
            // 'id_karyawan' => $request->input('register-id-karyawan'),
            'na_client' => $request->input('register-name-client'),
        ]);

        $id_client = $client->id_client;
        DaftarLogin_Model::create([
            'username' => $request->input('register-username'),
            'email' => $request->input('register-email'),
            'password' => Hash::make($request->input('register-password')),
            'type' => "1",
            'id_client' => $id_client
        ]);
        Session::flash('success', ['Registration successful!']);
        return redirect()->route('login.page');
    }
}
