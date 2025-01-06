<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DaftarLogin_Model;
use App\Models\Karyawan_Model;
use App\Models\Kustomer_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Rules\ReCaptcha;


class LoginPageController extends Controller
{
    //
    public function index()
    {
        $process = $this->setPageSession("Login", "login");
        if ($process) {
            $data = [
                'site_name' => env('APP_NAME'),
                'quote' => $this->getQuote(),
                'genSysSettings' => $this->genSysSettings(),
                'company_phone_number' => $this->getSpecificSetting('site_owner_phone_number'),
            ];

            // Decode the genSysSettings JSON into a collection
            $settingsCollection = collect(json_decode($data['genSysSettings'], true));
            // Filter to get entire objects where na_sett is either 'client_reg_menu' or 'employee_reg_menu'
            $filteredSettings = $settingsCollection
                ->whereIn('na_sett', ['client_reg_menu', 'employee_reg_menu'])
                ->values();
            $data['filtered_settings'] = $filteredSettings;


            return $this->setReturnView('pages/auths/p_login', $data);
        }
    }

    public function showLogin()
    {
        $process = $this->setPageSession("Login", "login");
        if ($process) {
            // dd($this->genSysSettings());
            $data = [
                'site_name' => env(key: 'APP_NAME'),
                'quote' => $this->getQuote(),
                'genSysSettings' => $this->genSysSettings(),
                'company_phone_number' => $this->getSpecificSetting('site_owner_phone_number'),
            ];

            // Decode the genSysSettings JSON into a collection
            $settingsCollection = collect(json_decode($data['genSysSettings'], true));
            // Filter to get entire objects where na_sett is either 'client_reg_menu' or 'employee_reg_menu'
            $filteredSettings = $settingsCollection
                ->whereIn('na_sett', ['client_reg_menu', 'employee_reg_menu'])
                ->values();
            $data['filtered_settings'] = $filteredSettings;

            return $this->setReturnView('pages/auths/p_login', $data);
        }
    }


    public function doLogin(Request $request)
    {
        $authUserType = auth()->user()->type ?? null;

        // Define an array of allowed local addresses and IP ranges
        $disableCapthaOnBaseUrl = [
            // 'localhost',
            // '127.0.0.1',
            // '::1',
            // 'http://localhost',
            // 'https://localhost',
            'ip_ranges' => [ // Define multiple IP ranges here
                ['100.100.100.0', '100.100.100.254'],
                ['192.168.1.0', '192.168.1.254'],
            ],
        ];
        // Get the client's IP address
        $clientIp = request()->ip();
        // Function to convert IP address to an integer
        function ipToInt($ip)
        {
            return sprintf('%u', ip2long($ip));
        }
        // Check if the client's IP is within any of the specified ranges
        $isInRange = false;
        if (isset($disableCapthaOnBaseUrl['ip_ranges'])) {
            foreach ($disableCapthaOnBaseUrl['ip_ranges'] as $range) {
                $ipRangeStart = $range[0];
                $ipRangeEnd = $range[1];
                if (ipToInt($clientIp) >= ipToInt($ipRangeStart) && ipToInt($clientIp) <= ipToInt($ipRangeEnd)) {
                    $isInRange = true;
                    break; // Exit the loop if the IP is found in any range
                }
            }
        }
        // Check if the current request's IP is in the allowed local addresses or in the defined ranges
        $isLocal = $isInRange;
        // Set up the validation rules
        $rules = [];
        if (!$isLocal) {
            $rules['g-recaptcha-response'] = ['required', new ReCaptcha]; // reCAPTCHA validation here
        }
        // Validate the request
        $validator = Validator::make($request->all(), $rules);


        $validator->after(function ($validator) use ($request) {
            $usernameEmail = $request->input('username-email');
            $password = $request->input('login-password');
            $user = DaftarLogin_Model::where(function ($query) use ($usernameEmail) {
                $query->where('username', $usernameEmail)
                    ->orWhere('email', $usernameEmail);
            })->first();

            if ($usernameEmail && $password) {
                if (!$user) {
                    $validator->errors()->add('username-email', 'The username or email is not registered.');
                } elseif (!Hash::check($password, $user->password)) {
                    $validator->errors()->add('login-password', 'The password is incorrect.');
                }
            } else if ($usernameEmail) {
                $validator->errors()->add('password-email', 'The password is required.');
            } else if ($password) {
                $validator->errors()->add('username-email', 'The username or email is required.');
            } else {
                $validator->errors()->add('username-email', 'The username or email is required.');
                $validator->errors()->add('password-email', 'The password is required.');
            }
        });

        $validator->validate();

        // Get Field Value
        $credentials = $request->only('username-email', 'login-password');
        $usernameEmail = $credentials['username-email'];
        $password = $credentials['login-password'];
        $rememberMe = $request->boolean('remember-me');

        // Attempt Authentication
        $authenticated = Auth::attempt(['username' => $usernameEmail, 'password' => $password, 'deleted_at' => null], $rememberMe)
            || Auth::attempt(['email' => $usernameEmail, 'password' => $password, 'deleted_at' => null], $rememberMe);

        if ($authenticated) {
            // Authentication successful
            $request->session()->regenerate();
            // Session::flash('success', ['Welcome back :)']);

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();

            // Access the image URL using the getImageAttribute method
            $imageUrl = $authenticated_user_data->image ?? null; // This will call the getImageAttribute method
            // Optionally store the image URL in the session
            Session::put('user_image', $imageUrl);

            if ($rememberMe) {  // Set the remember token and its expiration
                $token = Str::random(60); // Generate a random token
                $user->setRememberToken($token); // Set the token and expiration to 8 days
                Session::put('authenticated_user_data', $authenticated_user_data);
                Session::save();
                config([
                    'session.lifetime' => 11520, // 8 days in minutes (8 days * 24 hours)
                    'session.expire_on_close' => false,
                ]);
            } else {
                Session::put('authenticated_user_data', $authenticated_user_data);
            }

            return redirect()->route('userPanels.projects'); // Redirect to admin dashboard
            // if ($authUserType === 'Superuser') {
            //     return redirect()->route('userPanels.projects'); // Redirect to admin dashboard
            // } elseif ($authUserType === "Supervisor" || $authUserType === 'Engineer' || $authUserType === 'Client') {
            //     return redirect()->route('userPanels.projects'); // Redirect to karyawan dashboard
            // } else {
            //     // Session::flash('n_errors', ['Ups sorry, Illegal access is\'nt allowed!']);
            //     return redirect()->route('login.page'); // Redirect to login page
            // }
        } else {
            // Authentication failed
            Session::flash('n_errors', ['Invalid credentials!']);
            return redirect()->back();
        }
    }




    public function doLogoutUPanel(Request $request)
    {
        $process = $this->setPageSession("Login Page", "login");
        if ($process) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            Session::forget('authenticated_user_data');

            Session::flash('success', ['Logged Out :)']);
            return Redirect::to('/login');
        }
    }
}
