<?php

// namespace App\Rules;

// use Closure;
// use Illuminate\Contracts\Validation\ValidationRule;
// use Illuminate\Support\Facades\Http;

// class ReCaptcha implements ValidationRule
// {
//     /**
//      * Run the validation rule.
//      *
//      * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
//      */
//     public function validate(string $attribute, mixed $value, Closure $fail): void
//     {
//         $response = Http::get("https://www.google.com/recaptcha/api/siteverify",[
//             'secret' => env('GOOGLE_RECAPTCHA_SECRET_PROD'),
//             'response' => $value
//         ]);

//         if (!($response->json()["success"] ?? false)) {
//               $fail('The google recaptcha is required.');
//         }
//     }
// }



namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;

class ReCaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Determine if the request is local based on the IP address
        $clientIp = Request::ip();
        $isLocal = in_array($clientIp, ['127.0.0.1', '::1']) || // Add common localhost IPs
                   $this->isIpInRange($clientIp, config('recaptcha.local_ip_ranges', [])); //Use config for flexibility

        // Use the appropriate reCAPTCHA secret key based on whether the request is local
        $secretKey = $isLocal ? env('GOOGLE_RECAPTCHA_SECRET_LOCAL') : env('GOOGLE_RECAPTCHA_SECRET_PROD');


        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $value,
        ]);

        if (! $response->successful() || ! ($response->json('success') ?? false)) {
            $fail('The reCAPTCHA response is invalid.');
        }
    }


    /**
     * Helper function to check if an IP address is within a range of IP addresses.
     *
     * @param string $ip The IP address to check.
     * @param array $ipRanges An array of IP address ranges (e.g., [['192.168.1.0', '192.168.1.255']]).
     * @return bool True if the IP address is within any of the ranges, false otherwise.
     */
    private function isIpInRange(string $ip, array $ipRanges): bool
    {
        $ipInt = ip2long($ip);
        foreach ($ipRanges as $range) {
            $startInt = ip2long($range[0]);
            $endInt = ip2long($range[1]);
            if ($ipInt >= $startInt && $ipInt <= $endInt) {
                return true;
            }
        }
        return false;
    }
}
