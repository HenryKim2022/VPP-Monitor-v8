<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DaftarSysSettings_Model;
use Illuminate\Support\Facades\Session;

class CheckRegistrationSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check the registration settings
        $clientRegSetting = DaftarSysSettings_Model::where('na_sett', 'client_reg_menu')->first();
        $employeeRegSetting = DaftarSysSettings_Model::where('na_sett', 'employee_reg_menu')->first();

        // Determine if registration is enabled
        $isClientRegEnabled = $clientRegSetting && $clientRegSetting->val_sett;
        $isEmployeeRegEnabled = $employeeRegSetting && $employeeRegSetting->val_sett;

        // Logic to determine which registration route to allow
        if ($request->is('register-client') && !$isClientRegEnabled) {
            $toast_message = ['Client registration is currently disabled!'];
            Session::flash('n_errors', $toast_message);
            return redirect()->route('login.page'); // Use redirect() to return a Response
        }

        if ($request->is('register-emp') && !$isEmployeeRegEnabled) {
            $toast_message = ['Employee registration is currently disabled!'];
            Session::flash('n_errors', $toast_message);
            return redirect()->route('login.page'); // Use redirect() to return a Response
        }

        return $next($request);
    }
}
