<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\DaftarSysSettings_Model;
use App\Models\Karyawan_Model;
use App\Models\Kustomer_Model;
use App\Models\DaftarLogin_Model;

use App\Services\BreadcrumbService;
use App\Jobs\AutoCloseExpiredWorksheetsJob;
use App\Jobs\ManualCloseExpiredWorksheetsJob;
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade directly




abstract class Controller
{
    protected $pageData;
    protected $breadcrumbService;

    public function __construct(BreadcrumbService $breadcrumbService)
    {
        // $this->middleware('Client')->except('logout');
        $this->pageData = [
            'page_title' => 'What Public See',
            'page_url' => base_url('login-url'),
            'custom_date_format' => "ddd, DD MMM YYYY, h:mm:ss A",

        ];
        Session::put('page', $this->pageData);
        $this->breadcrumbService = $breadcrumbService;
        // Dispatch the job to check for expired worksheets
        // CheckExpiredWorksheetsJob::dispatch();
        // $this->runQueueWorkerv1();
        // $this->dispatchJob();
    }


    ///////////////////////////// JOB DB CHECK VER.1 - NOT USED ////////////////////////////
    public function runQueueWorkerv1()
    {
        // NOTE:
        // Run this cmd, at terminal 1x times if using this way (background process)
        // php artisan queue:work --sleep=3 --tries=9999999999

        // This will run the queue worker command
        Artisan::call('queue:work', [
            '--sleep' => 3,
            '--tries' => 9999999999,
        ]);

        return response()->json(['message' => 'Queue worker started.']);
    }


    ///////////////////////////// JOB DB CHECK VER.3 - MANUAL USED ////////////////////////////
    public function dispatchJob($mode = 'undirect')
    {
        // NOTE CRONJOB (hourly):
        // Sample Command:
        ////// * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
        // Command Applied at Webhosting:
        ////// /usr/local/bin/ea-php82 /home/itir9421/public_html/vppm.iti-if.my.id/artisan schedule:run >> /home/itir9421/cron.log 2>&1

        try {
            if ($mode == 'undirect') {
                AutoCloseExpiredWorksheetsJob::dispatch();   // Dispatch to queue schedule
            } else if ($mode == 'direct') {
                $job = new AutoCloseExpiredWorksheetsJob();
                $job->handle();
            } else {
                // Dispatch the job to run immediately
                ManualCloseExpiredWorksheetsJob::dispatch();
                Log::info('Job dispatched successfully.');
            }

            return response()->json(['message' => 'Job dispatched.']);
        } catch (\Exception $e) {
            Log::error('Failed to dispatch job: ' . $e->getMessage());
            return response()->json(['message' => 'Job dispatched.']);
        }
    }

    public function getBreadcrumb($routeName)
    {
        return $this->breadcrumbService->generate($routeName);
    }


    public function getQuote()
    {
        $quote = trim(strip_tags(Inspiring::quote()));
        $quote = htmlspecialchars_decode($quote, ENT_QUOTES);
        $lastHyphenPos = strrpos($quote, '—');
        if ($lastHyphenPos !== false) {
            $text = trim(substr($quote, 0, $lastHyphenPos));
            $author = trim(substr(utf8_decode($quote), $lastHyphenPos - 2));
        } else {
            $text = $quote;
            $author = '';
        }
        return [
            'text' => $text,
            'author' => $author
        ];
        // Note (in the view):<div><p><strong>{{ $quote['text'] }}</strong><span style="color: gray;"> {{ '  —' . $quote['author'] }}</span></p></div>
    }


    ///////////////////////////// GET USER AUTH DATA ////////////////////////////
    public function get_user_auth_data()
    {
        $user = auth()->user();
        $authUserType = $user->type; // Use the user object directly
        $authenticated_user_data = null;


        $test = [
            '$test dd output:' => $user->toArray(),
        ];

        // dd($test);

        if ($authUserType != "Client") {
            $authenticated_user_data = DaftarLogin_Model::with([
                'karyawan.jabatan' => function ($query) use ($user) {
                    $query->where('id_karyawan', $user->id_karyawan)
                          ->orderBy('created_at', 'desc')
                          ->withTrashed() // Include soft-deleted records
                          ->take(1);
                },
                'client' => []
            ])->where('id_karyawan', $user->id_karyawan)->withTrashed()->first();
        } else {
            $authenticated_user_data = DaftarLogin_Model::with([
                'karyawan.jabatan' => [],
                'client' => function ($query) use ($user) {
                    $query->where('id_client', $user->id_client)
                          ->orderBy('created_at', 'desc')
                          ->withTrashed() // Include soft-deleted records
                          ->take(1);
                }
            ])->where('id_client', $user->id_client)->withTrashed()->first();
        }


        // dd($authenticated_user_data->toArray()); // Pretty print the data as an array

        return $authenticated_user_data;
    }










    ///////////////////////////// GEN SETTINGS ////////////////////////////
    public function genSysSettings()
    {
        $settings = DaftarSysSettings_Model::withoutTrashed()->get();
        return json_encode($settings, JSON_UNESCAPED_UNICODE);
    }

    public function getSpecificSetting($na_sett)
    {
        return DaftarSysSettings_Model::withoutTrashed()
            ->where('na_sett', $na_sett)
            ->first(); // Use first() to get a single object
    }
    // $phoneSetting = $this->getSpecificSetting('site_owner_phone_number');





    ///////////////////////////// PAGE SETTER ////////////////////////////
    public function setPageSession($pageTitle, $pageUrl)
    {
        $pageData = Session::get('page');
        $pageData['page_title'] = $pageTitle;
        $pageData['page_url'] = $pageUrl;

        // Store the updated array back in the session
        Session::put('page', $pageData);
        return true;
    }


    public function setReturnView($viewurl, $loadDatasFromDB = [])
    {
        $pageData = Session::get('page');
        $mergedData = array_merge($loadDatasFromDB, ['pageData' => $pageData]);
        return view($viewurl, $mergedData);
    }
}
