<?php

namespace App\Http\Controllers\UserPanels\Navigate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Jobs\CheckExpiredWorksheetsJob;


use App\Models\DaftarWS_Model;
use App\Models\Kustomer_Model;
use App\Models\Projects_Model;
use App\Models\Team_Model;
use App\Models\DaftarLogin_Model;


class UserPanelController extends Controller
{
    //
    // public function index(Request $request)
    // {
    //      $process = $this->setPageSession("Dashboard", "dashboard");
    //      if ($process) {
    //          $data = [
    //             'currentRouteName' => Route::currentRouteName(),
    //             'quote' => $this->getQuote(),
    //             'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
    //          ];
    //          return $this->setReturnView('pages/userpanels/p_dashboard', $data);
    //      }
    // }

    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Projects", "m-projects");
        if ($process) {
            $authUserType = auth()->user()->type;
            $project = [];
            if ($authUserType === 'Client') {
                $authIDClient = auth()->user()->id_client;
                $project = Projects_Model::where('id_client', $authIDClient)
                    ->where('show_to_client', 1)
                    ->withoutTrashed()
                    ->get()
                    ->sortBy('created_at');
            } else {
                // $project = Projects_Model::with(['karyawan', 'client', 'team', 'worksheet', 'monitor'])->withoutTrashed()->get();
                // $project = Projects_Model::with(['teams.karyawans' , 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
                $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
                ->withoutTrashed()
                ->get()
                ->sortBy('created_at');
            }


            $user = auth()->user();
            // $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'daftar_login_4get.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);
            $authenticated_user_data = $this->get_user_auth_data();

            $modalData = [
                'modal_add' => '#add_projectModal',
                'modal_edit' => '#editprojectModal',
                'modal_delete' => '#delete_projectModal',
                'modal_reset' => '#reset_projectModal',
            ];

            $co_auth = $authenticated_user_data ? [$authenticated_user_data->id_karyawan, $authenticated_user_data->na_karyawan] : null;

            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                'project' => $project,
                'modalData' => $modalData,
                'client_list' => Kustomer_Model::withoutTrashed()->get(),
                'team_list' => Team_Model::withoutTrashed()->get(),
                'co_auth' =>  $co_auth,
                'co_list' => DaftarLogin_Model::with('karyawan')->withoutTrashed()->where('type', 3)->get(),
                'worksheet_list' => DaftarWS_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/pm_daftarproject', $data);
        }
    }
}
