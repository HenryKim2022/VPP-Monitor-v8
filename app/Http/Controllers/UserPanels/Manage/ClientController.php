<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kustomer_Model;
use App\Models\DaftarLogin_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Jobs\CheckExpiredWorksheetsJob;


class ClientController extends Controller
{
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Client", "m-cli");
        if ($process) {
            $clients = [];
            $clients = Kustomer_Model::withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();

            $modalData = [
                'modal_add' => '#add_kustomerModal',
                'modal_edit' => '#edit_kustomerModal',
                'modal_delete' => '#delete_kustomerModal',
                'modal_reset' => '#reset_kustomerModal',
            ];

            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                // 'site_name' => TheApp_Model::where('na_setting', 'CompanyName')->withoutTrashed()->first(),
                // 'site_year' => TheApp_Model::where('na_setting', 'SiteCopyrightYear')->withoutTrashed()->first(),
                // 'aboutus_data' => TheApp_Model::where('na_setting', 'AboutUSText')->withoutTrashed()->first(),
                // 'company_addr' => TheApp_Model::where('na_setting', 'CompanyAddress')->withoutTrashed()->first(),
                // 'company_phone' => TheApp_Model::where('na_setting', 'CompanyPhone')->withoutTrashed()->first(),
                // 'company_email' => TheApp_Model::where('na_setting', 'CompanyEmail')->withoutTrashed()->first(),
                'clients' => $clients,
                'modalData' => $modalData,
                'client_list' => Kustomer_Model::withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/pm_daftarkustomer', $data);
        }
    }


    public function add_client(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'cli-name'  => [
                    'required',
                    'string'
                ],
                'avatar-upload'  => [
                    'sometimes',
                    'required',
                    'image',
                    'max:5120'
                ],
            ],
            [
                'emp-name.required'  => 'The name field is required.',
                'emp-addr.required'  => 'The address field is required.',
                'emp-telp.required'  => 'The no.telp field is required.',
                'avatar-upload.max' => 'The avatar must be a maximum of 5MB in size.',

            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kustomer_name = $request->input('cli-name');
        if ($kustomer_name) {          // IF Check-in
            $client = new Kustomer_Model();
            $client->na_client = $request->input('cli-name');
            $client->alamat_client = $request->input('cli-addr');
            $client->notelp_client = $request->input('cli-telp');

            if ($request->hasFile('avatar-upload')) {
                $file = $request->file('avatar-upload');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatar/uploads'), $filename);
                $client->foto_client = $filename;
            }
            $client->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Client added successfully!']);
        }
        return redirect()->back();
    }



    public function get_client(Request $request)
    {
        $clientID = $request->input('clientID');
        $daftarClient = Kustomer_Model::where('id_client', $clientID)->first();

        if ($daftarClient) {
            // Return queried data as a JSON response
            return response()->json([
                'id_client' => $daftarClient->id_client,
                'na_client' => $daftarClient->na_client,
                'addr_client' => $daftarClient->alamat_client,
                'telp_client' => $daftarClient->notelp_client,
                'ava_client' => $daftarClient->foto_client ? $daftarClient->foto_client . '?v=' . time() : $daftarClient->foto_client,
            ]);
        } else {
            // Handle the case when the user with the given user_id is not found
            return response()->json(['error' => '[Err: 404] Client not found!'], 404);
        }
    }


    public function edit_client(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'edit_cli_id' => 'sometimes|required',
                'edit-cli-name' => 'sometimes|required',
                'edit-cli-addr' => 'sometimes|required',
                'edit-cli-telp' => 'sometimes|required',
                'bsvalidationcheckbox1' => 'required',
            ],
            [
                'edit_cli_id.required' => 'The hidden employee-id field is required.',
                'edit-cli-name.required' => 'The employee name field is required.',
                'edit-cli-addr.required' => 'The address field is required.',
                'edit-cli-telp.required' => 'The no.telp field is required.',
                'bsvalidationcheckbox1.required' => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $edit_cli_name = $request->input('edit-cli-name');
        $edit_cli_addr = $request->input('edit-cli-addr');
        $edit_cli_telp = $request->input('edit-cli-telp');
        $edit_cli_avatar = $request->input('edit-avatar-upload');

        $clientID = $request->input('edit_cli_id');
        $daftarClient = Kustomer_Model::where('id_client', $clientID)->first();
        if ($daftarClient) {
            // dd($request->hasFile('edit-avatar-upload'));
            if ($request->hasFile('edit-avatar-upload')) {
                $daftarClient->na_client = $edit_cli_name;
                $daftarClient->alamat_client = $edit_cli_addr;
                $daftarClient->notelp_client = $edit_cli_telp;

                $file = $request->file('edit-avatar-upload');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('avatar/uploads'), $filename);
                $daftarClient->foto_client = $filename;
                $daftarClient->save();

                $user = auth()->user();
                $authenticated_user_data = $this->get_user_auth_data();
                Session::put('authenticated_user_data', $authenticated_user_data);

                Session::flash('success', ['Client update successfully!']);
            } else {    // Handle case where no logo file is provided
                $daftarClient->na_client = $edit_cli_name;
                $daftarClient->alamat_client = $edit_cli_addr;
                $daftarClient->notelp_client = $edit_cli_telp;
                $daftarClient->save();
                Session::flash('success', ['Client update successfully!']);
            }
        } else {
            Session::flash('errors', ['Err[404]: Client update failed!']);
        }

        return redirect()->back();
    }




    public function delete_client(Request $request)
    {
        $clientID = $request->input('del_client_id');
        $client = Kustomer_Model::where('id_client', $clientID)->whereNull('deleted_at')->first();

        $hasLogin = DaftarLogin_Model::where('id_client', $clientID)->whereNull('deleted_at')->exists();
        if ($hasLogin) {
            Session::flash('n_errors', ['Err[400]: Client cannot be deleted because they have an active login!']);
        } elseif ($client) {
            $client->delete();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);
            Session::flash('success', ['Client deletion successful!']);
        } else {
            Session::flash('n_errors', ['Err[404]: Client deletion failed!']);
        }

        return redirect()->back();
    }



    public function reset_client(Request $request)
    {
        $user = auth()->user();
        $clientID = $user->id_client;
        // Soft delete all karyawan records except the one with the given karyawanID
        Kustomer_Model::where('id_client', '!=', $clientID)->delete();

        // Reset the auto-increment value of the table
        DB::statement('ALTER TABLE tb_client AUTO_INCREMENT = 1');
        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All client data (excluding me) reset successfully!']);
        return redirect()->back();
    }
}
