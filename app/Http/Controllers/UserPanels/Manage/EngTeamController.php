<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team_Model;
use App\Models\Karyawan_Model;
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
use App\Models\Projects_Model;
use Illuminate\Support\Facades\Log;


class EngTeamController extends Controller
{
    //
    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Teams", "m-teams");
        if ($process) {
            $loadDaftarTeamFromDB = [];
            $loadDaftarTeamFromDB = Team_Model::withoutTrashed()->get();

            $user = auth()->user();
            $authenticated_user_data = Karyawan_Model::with('daftar_login.karyawan', 'daftar_login_4get.karyawan', 'jabatan.karyawan')->find($user->id_karyawan);

            $modalData = [
                'modal_add' => '#add_teamModal',
                'modal_edit' => '#edit_teamModal',
                'modal_delete' => '#delete_teamModal',
                'modal_reset' => '#reset_teamModal',
            ];

            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                'loadDaftarTeamFromDB' => $loadDaftarTeamFromDB,
                'modalData' => $modalData,
                'employee_list' => Karyawan_Model::with(['team'])->withoutTrashed()->get(),
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/pm_daftarteam', $data);
        }
    }


    public function getTeamsByAjax(Request $request)
    {
        $employees = Karyawan_Model::with(['team'])->withoutTrashed()->get();

        $modalData = [
            'modal_add' => '#add_teamModal',
            'modal_edit' => '#edit_teamModal',
            'modal_delete' => '#delete_teamModal',
            'modal_reset' => '#reset_teamModal',
        ];

        return response()->json([
            'employees' => $employees,
            'modalData' => $modalData,
        ]);
    }


    public function detectDBChangesByAjax()
    {
        try {
            // Fetch the maximum updated_at timestamp
            $lastUpdated = DB::table('tb_karyawan')->max('updated_at');

            // // Log the value retrieved from the database
            // Log::info('Last updated timestamp retrieved:', ['last_updated' => $lastUpdated]);

            // Check if lastUpdated is null and handle it accordingly
            if ($lastUpdated === null) {
                return response()->json(['last_updated' => null]);
            }

            // Convert to ISO 8601 format
            $lastUpdated = \Carbon\Carbon::parse($lastUpdated)->toIso8601String();

            return response()->json(['last_updated' => $lastUpdated]);
        } catch (\Exception $e) {
            // Handle any exceptions
            // Log::error('Error fetching last updated timestamp:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch last updated timestamp'], 500);
        }
    }


    public function add_team(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'team-name'  => 'required',
            ],
            [
                'team-name' => 'The team name field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // $id_karyawan = $request->input('team-karyawan-id');
        // if ($id_karyawan) {          // IF Check-in
        $teams = new Team_Model();
        $teams->na_team = $request->input('team-name');
        // $teams->id_karyawan = $id_karyawan;
        $teams->save();

        $authenticated_user_data = Team_Model::find($teams->user_id);      // Re-auth after saving
        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['Team added successfully!']);
        // }
        return redirect()->back();
    }


    public function get_team(Request $request)
    {
        $timID = $request->input('timID');
        $karyawanID = $request->input('karyawanID');

        $daftarTim = Team_Model::where('id_team', $timID)->first();
        if ($daftarTim) {
            if ($daftarTim->id_karyawan) {
                $daftarTim->load('karyawan');
            }
            $karyawan = $daftarTim->karyawan;
            $employeeList = [];
            if ($karyawan) {
                $employeeList = Karyawan_Model::all()->map(function ($user) use ($karyawan) {
                    $selected = ($user->id_karyawan == $karyawan->id_karyawan);
                    return [
                        'value' => $user->id_karyawan,
                        'text' => $user->na_karyawan,
                        'selected' => $selected,
                    ];
                });
            } else {
                $employeeList = Karyawan_Model::withoutTrashed()->get()->map(function ($user) {
                    return [
                        'value' => $user->id_karyawan,
                        'text' => $user->na_karyawan,
                        'selected' => false,
                    ];
                });
            }

            // Return queried data as a JSON response
            return response()->json([
                'id_team' => $timID,
                'na_team' => $daftarTim->na_team,
                'id_karyawan' => $karyawanID,
                'employeeList' => $employeeList,
            ]);
        } else {
            // Handle the case when the Team_Model with the given timID is not found
            return response()->json(['error' => 'Team_Model not found'], 404);
        }
    }


    public function edit_team(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'team_name'  => 'required',
                'bsvalidationcheckbox1'  => 'required',
            ],
            [
                'team_name' => 'The team name field is required.',
                'bsvalidationcheckbox1'  => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tim = Team_Model::find($request->input('team_id'));
        if ($tim) {
            $tim->na_team = $request->input('team_name');
            $tim->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Team updated successfully!']);
            return Redirect::back();
        } else {
            Session::flash('n_errors', ['Err[404]: Team update failed!']);
        }
    }




    public function delete_team(Request $request)
    {
        $timID = $request->input('del-team_id');
        $tim = Team_Model::with('karyawans')->where('id_team', $timID)->first();
        $hasProject = Projects_Model::where('id_team', $timID)->whereNull('deleted_at')->exists();
        if ($hasProject) {
            Session::flash('n_errors', ['Err[400]: Team cannot be deleted because they have an active team in projects!']);
        } elseif ($tim) {
            $tim->delete();

            $authenticated_user_data = Team_Model::find($tim->id_team);      // Re-auth after saving
            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Team deletion successful!']);
        } else {
            Session::flash('n_errors', ['Err[404]: Team deletion failed!']);
        }
        return redirect()->back();
    }

    public function reset_team(Request $request)
    {
        Team_Model::query()->delete();
        DB::statement('ALTER TABLE tb_team AUTO_INCREMENT = 1');

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All team data reset successfully!']);
        return redirect()->back();
    }



    // public function load_select_opt(Request $request)
    // {
    //     $employees = Karyawan_Model::with(['team'])->withoutTrashed()->get();
    //     return response()->json($employees);
    // }


    public function un_assign_4rom_team(Request $request)
    {
        return $this->updateEmployeeTeam($request, null, 'un-assigned');
    }

    public function assign_into_team(Request $request)
    {
        return $this->updateEmployeeTeam($request, $request->team_id, 'assigned');
    }


    private function updateEmployeeTeam(Request $request, $teamId, $action)
    {
        $message = [
            'err_json' => [],
            'success_json' => [],
        ];

        try {
            $request->validate([
                'employee_id' => 'required|exists:tb_karyawan,id_karyawan',
                'team_id' => $action === 'assigned' ? 'required|exists:tb_team,id_team' : 'nullable',
            ]);

            $employee = Karyawan_Model::find($request->employee_id);
            if (!$employee) {
                $message['err_json'][] = 'Employee not found';
                return response()->json(['message' => $message], 404);
            }

            if ($action === 'un-assigned') {
                $previousTeam = Team_Model::find($request->team_id);
                if (!$previousTeam) {
                    $message['err_json'][] = 'Team not found';
                    return response()->json(['message' => $message], 404);
                }
                $employee->id_team = null;
                $message['success_json'][] = "*" . $employee->na_karyawan . ' un-assigned from ' . '*' . $previousTeam->na_team;
            } else {
                $team = Team_Model::find($teamId);
                if (!$team) {
                    $message['err_json'][] = 'Team not found';
                    return response()->json(['message' => $message], 404);
                }
                $employee->id_team = $teamId;
                $message['success_json'][] = "*" . $employee->na_karyawan . ' assigned into ' . '*' . $team->na_team;
            }

            $employee->save();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            $message['err_json'][] = 'An error occurred: ' . $e->getMessage();
            return response()->json(['message' => $message], 500);
        }
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////

    public function detect_db_team_ch_byajax()
    {
        try {
            // Fetch the maximum updated_at timestamp
            $lastUpdated = DB::table('tb_team')->max('updated_at');
            // Log::info('Last updated timestamp retrieved:', ['last_updated' => $lastUpdated]);

            // Check if lastUpdated is null and handle it accordingly
            if ($lastUpdated === null) {
                return response()->json(['last_updated' => null]);
            }
            // Convert to ISO 8601 format
            $lastUpdated = \Carbon\Carbon::parse($lastUpdated)->toIso8601String();
            return response()->json(['last_updated' => $lastUpdated]);
        } catch (\Exception $e) {       // Handle any exceptions
            // Log::error('Error fetching last updated timestamp:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch last updated timestamp'], 500);
        }
    }

    public function detect_db_kar_relteam_ch_byajax()
    {
        try {
            // Fetch the maximum updated_at timestamp
            $lastUpdated = DB::table('tb_karyawan')->max('updated_at');
            // Log::info('Last updated timestamp retrieved:', ['last_updated' => $lastUpdated]);

            // Check if lastUpdated is null and handle it accordingly
            if ($lastUpdated === null) {
                return response()->json(['last_updated' => null]);
            }
            // Convert to ISO 8601 format
            $lastUpdated = \Carbon\Carbon::parse($lastUpdated)->toIso8601String();
            return response()->json(['last_updated' => $lastUpdated]);
        } catch (\Exception $e) {
            // Handle any exceptions
            // Log::error('Error fetching last updated timestamp:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch last updated timestamp'], 500);
        }
    }


    public function load_employee_lists_byajax()
    {
        $employees = Karyawan_Model::with(['team'])->withoutTrashed()->get();
        return response()->json(['employeelists' => $employees]);
    }
    public function load_teams_lists_byajax()
    {
        $teams = Team_Model::with('karyawans')->withoutTrashed()->get();
        return response()->json(['teamlists' => $teams]);
    }

    public function load_employee_lists_opt_byajax(Request $request)
    {
        $employees = Karyawan_Model::with(['team'])->withoutTrashed()->get();
        return response()->json(['employees' => $employees]);
    }


    public function detect_db_team_assigment_ch_byajax(Request $request, $modelType)
    {
        try {
            // Example of filtering based on a condition (if needed)
            $query = Karyawan_Model::query();

            // Add any filters based on request parameters if necessary
            if ($request->has('filter_key')) {
                $query->where('filter_column', $request->input('filter_key'));
            }

            // Fetch the latest updated_at timestamp from the database
            $latestUpdate = $query->orderBy('updated_at', 'desc')->first();

            if ($latestUpdate) {
                $employees = Karyawan_Model::with(['team'])->withoutTrashed()->get();
                $teams = Team_Model::with('karyawans')->withoutTrashed()->get();

                return response()->json([
                    'last_updated' => $latestUpdate->updated_at->toIso8601String(), // Format as needed
                    'updated' => true,
                    'employeelists' => $employees,
                    'teamlists' => $teams

                ]);
            }

            return response()->json([
                'last_updated' => null,
                'updated' => false
            ]);
        } catch (\Exception $e) {
            // Log::error('Error fetching last updated timestamp:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch last updated timestamp'], 500);
        }
    }
}
