<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class RecaptchaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        config([
            'recaptcha.local_ip_ranges' => [
                ['100.100.100.0', '100.100.100.200'],
                ['192.168.1.0', '192.168.1.254'],
            ],
        ]);

        // Get the client's IP address
        $clientIp = Request::ip();

        // Check if the client's IP is within any of the specified ranges
        $isLocal = in_array($clientIp, ['127.0.0.1', '::1']) ||
                   $this->isIpInRange($clientIp, config('recaptcha.local_ip_ranges', []));


        // Determine the reCAPTCHA key based on whether the request is local or not
        $recaptchaKey = $isLocal
            ? env('GOOGLE_RECAPTCHA_KEY_LOCAL')
            : env('GOOGLE_RECAPTCHA_KEY_PROD');

        // Share the reCAPTCHA key and isLocal variable with all views
        View::share('recaptchaKey', $recaptchaKey);
        View::share('isLocal', $isLocal);
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
