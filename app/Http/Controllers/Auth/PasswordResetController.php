<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DaftarLogin_Model;
use App\Models\PasswordResetToken_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetEmail;

class PasswordResetController extends Controller
{
    //

    public function index()
    {
        Session::forget(['success', 'n_errors']);
        $process = $this->setPageSession("Reset", "reset");
        if ($process) {
            // dd($this->genSysSettings());
            $data = [
                'site_name' => env(key: 'APP_NAME'),
            ];

            return $this->setReturnView('pages/auths/p_reset', $data);
        }
    }




    public function doSend(Request $request)
    {

        if ($request->isMethod('get')) {
            // $data = [
            //     'site_name' => env(key: 'APP_NAME'),
            // ];
            // return $this->setReturnView('pages/auths/p_reset', $data);
            return redirect()->route('reset.page');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'user-email' => 'required|email', // Simplified validation rule
            ],
            [
                'user-email.required' => 'The email field is required.',
                'user-email.email' => 'The email must be a valid email address.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $userEmail = $request->input('user-email');
        $user = DaftarLogin_Model::where('email', $userEmail)
            ->whereNull('deleted_at')
            ->first();
        if (!$user) {
            Session::flash('n_errors', ['Email not registered!']);
            $data = ['site_name' => env(key: 'APP_NAME'),];
            return $this->setReturnView('pages/auths/p_reset', $data);
        }

        $token = Str::random(60);
        PasswordResetToken_Model::create([
            'user_id' => $user->user_id,
            'token' => $token,
        ]);
        $url = route('reset.form', ['token' => $token, 'email' => $userEmail]);

        $data = [
            'site_name' => env('APP_NAME'),
            'site_owner' => env('APP_OWNER'),
        ];

        try {
            Mail::to($userEmail)->send(new PasswordResetEmail($url));

            Session::flash('success', ['A password reset link has been sent to your email address. Please check your spam or inbox!']);
            return $this->setReturnView('pages/auths/p_reset_done_send', $data);
        } catch (\Symfony\Component\Mailer\Exception\TransportException $e) {
            Session::flash('n_errors', ['Error: Unable to connect to the email server. Please check env email configuration!']);
            return redirect()->route('login.page');
        } catch (\Exception $e) {
            Session::flash('n_errors', ['Error: An unexpected error occurred. Please try again later!']);
            return redirect()->route('reset.page');
        }


    }



    public function showReset($token)
    {
        $process = $this->setPageSession("Reset", "reset");
        if ($process) {
            // Validate the token
            $passwordResetToken = PasswordResetToken_Model::where('token', $token)->first();
            if (!$passwordResetToken) {
                Session::flash('n_errors', ['Err: [001] Invalid or expired token!']);
                return redirect()->route('reset.page'); // Redirect to the reset page
            }

            $user = DaftarLogin_Model::find($passwordResetToken->user_id); // Get the user by ID
            $data = [
                'site_name' => env('APP_NAME'),
                'site_owner' => env('APP_OWNER'),
                'token' => $token,
                'email' => $user->email, // Pass the email to the view
            ];

            return $this->setReturnView('pages/auths/p_reset_form', $data);
        }
    }


    public function doReset(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token'  => [
                    'required',
                    'string'
                ],
                'email'  => [
                    'required',
                    'email'
                ],
                'reset-password-new' => 'required|min:6',
                'reset-password-confirm'  => 'required|same:reset-password-new',
            ],
            [
                'token.required' => 'The reset token is required!',
                'email.required' => 'The email is required!',
                'email.email' => 'The email must be a valid email address.',
                'reset-password-new.required' => 'The password field is required.',
                'reset-password-confirm.required' => 'The confirm password field is required.',
                'reset-password-confirm.same' => 'The confirmation password does not match.',
            ]

        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('reset-password-new');
        $password_confirmation = $request->input('reset-password-confirm');

        $user = DaftarLogin_Model::where('email', $email)->first();
        if (!$user) {
            Session::flash('n_errors', ['Email or user not registered!']);
            return redirect()->back();
        }

        $passwordResetToken = PasswordResetToken_Model::where('user_id', $user->user_id)->where('token', $token)->first();
        // dd($passwordResetToken);

        if (!$passwordResetToken) {
            Session::flash('n_errors', ['Err: [002] Invalid token!']);
            return redirect()->back();
        }


        $user->password = Hash::make($password);
        $user->save();
        $passwordResetToken->delete();

        Session::flash('success', ['Password reset successfully!']);
        return redirect()->route('login.page');
    }
}
