<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use App\Models\DaftarTask_Model;
use App\Models\DaftarWS_Model;
use App\Models\Karyawan_Model;
use App\Models\Kustomer_Model;
use App\Models\Monitoring_Model;
use App\Models\Projects_Model;
use App\Models\Projects_Teams_Model;
use App\Models\Team_Model;
use App\Models\DaftarLogin_Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Jobs\CheckExpiredWorksheetsJob;
use App\Models\Coordinators_Model;

use Illuminate\Support\Facades\Artisan;


class ProjectsController extends Controller
{
    // protected $breadcrumbService;

    // public function __construct(BreadcrumbService $breadcrumbService)
    // {
    //     $this->breadcrumbService = $breadcrumbService;
    // }

    public function index(Request $request)
    {
        $process = $this->setPageSession("Manage Projects", "m-projects");
        if ($process) {
            $authUserType = auth()->user()->type;
            $project = [];

            if ($authUserType === 'Client') {
                $authIDClient = auth()->user()->id_client;
                $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor' => function ($query) {
                    $query->orderBy('order'); // Sort by the new order column in tb_monitoring
                }])
                    ->where('id_client', $authIDClient)
                    ->where('show_to_client', 1)
                    ->withoutTrashed()
                    ->orderBy('order')
                    ->get()
                    ->values();
            } else {
                // $project = Projects_Model::with(['karyawan', 'client', 'team', 'worksheet', 'monitor'])
                $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor' => function ($query) {
                    $query->orderBy('order'); // Sort by the new order column in tb_monitoring
                }])
                    ->withoutTrashed()
                    ->orderBy('order')
                    ->get();
            }

            // dd($project->toarray());

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



    public function add_project(Request $request)
    {
        // dd($request->toArray());
        $validator = Validator::make(
            $request->all(),
            [
                'project-id' => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('tb_projects', 'id_project')->ignore($request->input('project-id'), 'id_project')->whereNull('deleted_at')
                ],
                'project-name'  => 'sometimes|required',
                'start-deadline' => [
                    'required',
                    'string',
                    'regex:/^\d{4}-\d{2}-\d{2} to \d{4}-\d{2}-\d{2}$/', // Check format
                    function ($attribute, $value, $fail) {
                        $dates = explode(" to ", $value);
                        if (count($dates) !== 2) {
                            return $fail('The ' . $attribute . ' must contain two valid dates.');
                        }

                        // Validate the dates
                        $startDate = $dates[0];
                        $endDate = $dates[1];

                        if (!strtotime($startDate) || !strtotime($endDate)) {
                            return $fail('The dates must be valid dates.');
                        }

                        if ($startDate > $endDate) {
                            return $fail('The start date must be before the end date.');
                        }
                    },
                ],
                'co-select2-assign' => 'required|array|min:1', // Ensure at least one item in the array
                'engteam-select2-assign' => 'required|array|min:1', // Ensure at least one item in the array

            ],
            [
                'project-id' => 'The project-id field is required.',
                'project-name' => 'The project-name field is required.',
                'start-deadline.regex' => 'The start-deadline must be in the format YYYY-MM-DD to YYYY-MM-DD.',
                'co-select2-assign.required' => 'At least one coordinator must be assigned.',
                'co-select2-assign.min' => 'At least one coordinator must be assigned.',
                'engteam-select2-assign.required' => 'At least one engineering team must be assigned.',
                'engteam-select2-assign.min' => 'At least one engineering team must be assigned.',
            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the project already exists (including soft-deleted)
        $existingProject = Projects_Model::withTrashed()->where('id_project', $request->input('project-id'))->first();
        if ($existingProject) {
            // If the project is soft-deleted, restore it then edit it
            if ($existingProject->trashed()) {
                $doRestore = $this->restore_and_edit($existingProject, $request);
                if ($doRestore) {
                    Session::flash('success', ['Project restored successfully!']);
                } else {
                    Session::flash('n_errors', ['Project restore failed!']);
                }
                return redirect()->back();
            } else {
                // If the project exists and is not deleted, return an error
                $toast_message = ['The project-id has already been taken.'];
                Session::flash('n_errors', $toast_message);
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        // Create a new project
        $prj = new Projects_Model();
        $prj->id_project = $request->input('project-id');
        $prj->na_project = $request->input('project-name');
        $prj->status_project = 'OPEN';
        $prj->show_to_client = 0;
        $prj->id_client = $request->input('client-id');
        $dateRange = $request->input('start-deadline');
        $dates = explode(" to ", $dateRange);
        $prj->start_project = $dates[0];
        $prj->deadline_project = $dates[1];

        $lastOrderNo = DB::table('tb_projects')->max('order');
        $newOrderNo = $lastOrderNo ? $lastOrderNo + 1 : 1;
        $prj->order = $newOrderNo;


        $prj->save();

        if ($request->has('co-select2-assign')) {
            $coordinatorIds = $request->input('co-select2-assign');
            foreach ($coordinatorIds as $id_kar) {
                $coordinator = Coordinators_Model::withTrashed()
                    ->where('id_project', $request->input('project-id'))
                    ->where('id_karyawan', $id_kar)
                    ->first();

                if ($coordinator) {
                    if ($coordinator->trashed()) {
                        $coordinator->restore();
                    }
                } else {
                    $coordinator = new Coordinators_Model();
                    $coordinator->id_project = $request->input('project-id');
                    $coordinator->id_karyawan = $id_kar;
                    $coordinator->save();
                }
            }
        }
        if ($request->has('engteam-select2-assign')) {
            $teamIds = $request->input('engteam-select2-assign');
            foreach ($teamIds as $id_team) {
                $team = Projects_Teams_Model::withTrashed()
                    ->where('id_project', $request->input('project-id'))
                    ->where('id_team', $id_team)
                    ->first();

                if ($team) {
                    if ($team->trashed()) {
                        $team->restore();
                    }
                } else {
                    $team = new Projects_Teams_Model();
                    $team->id_team = $id_team;
                    $team->id_project = $request->input('project-id');
                    $team->save();
                }
            }
        }

        Session::flash('success', ['Project added successfully!']);
        return redirect()->back();
    }


    public function restore_and_edit($existingProject, $request)
    {
        $existingProject->restore();

        $prj = Projects_Model::find($request->input('project-id'));
        if ($prj) {
            $prj->id_project = $request->input('project-id');
            $prj->na_project = $request->input('project-name');
            $prj->id_client = $request->input('client-id');
            $dateRange = $request->input('start-deadline');
            $dates = explode(" to ", $dateRange);
            $prj->start_project = $dates[0];
            $prj->deadline_project = $dates[1];
            $prj->save();


            // Update coordinators
            if ($request->has('co-select2-assign')) {
                $coordinatorInput = $request->input('co-select2-assign', []);
                if (!is_array($coordinatorInput)) {
                    $coordinatorInput = [$coordinatorInput];
                }

                // Get existing coordinators for the project, including soft-deleted ones
                $existingCoordinators = Coordinators_Model::withTrashed()
                    ->where('id_project', $prj->id_project)
                    ->get();
                // Restore or delete coordinators that are not in the new input
                foreach ($existingCoordinators as $coordinator) {
                    if (in_array($coordinator->id_karyawan, $coordinatorInput)) {
                        if ($coordinator->trashed()) {
                            $coordinator->restore();
                        }
                    } else {
                        $coordinator->delete(); // This will soft delete it
                    }
                }
                // Add or update new coordinators
                foreach ($coordinatorInput as $id_kar) {
                    Coordinators_Model::updateOrCreate(
                        ['id_project' => $prj->id_project, 'id_karyawan' => $id_kar],
                        ['id_project' => $prj->id_project, 'id_karyawan' => $id_kar]
                    );
                }
            }

            // Update teams
            if ($request->has('engteam-select2-assign')) {
                $teamInput = $request->input('engteam-select2-assign', []);
                if (!is_array($teamInput)) {
                    $teamInput = [$teamInput];
                }
                // Get existing teams for the project, including soft-deleted ones
                $existingTeams = Projects_Teams_Model::withTrashed()
                    ->where('id_project', $prj->id_project)
                    ->get();
                // Restore or delete teams that are not in the new input
                foreach ($existingTeams as $team) {
                    if (in_array($team->id_team, $teamInput)) {
                        // If the team is soft-deleted, restore it
                        if ($team->trashed()) {
                            $team->restore();
                        }
                    } else {
                        // If the team is not in the new input, delete it
                        $team->delete(); // This will soft delete it
                    }
                }
                // Add or update new teams
                foreach ($teamInput as $id_team) {
                    Projects_Teams_Model::updateOrCreate(
                        ['id_project' => $prj->id_project, 'id_team' => $id_team],
                        ['id_project' => $prj->id_project, 'id_team' => $id_team]
                    );
                }
            }

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            // Session::flash('success', ['Project updated successfully!']);
            return true;
        } else {
            return false;
        }
    }


    // // public function get_project(Request $request)
    // // {
    // //     $authTypeUser = auth()->user()->type;
    // //     $prjID = $request->input('prjID');
    // //     $prjName = $request->input('prjName');
    // //     $clientID = $request->input('clientID');

    // //     // $daftarProjects = Projects_Model::where('id_project', $prjID)->first();

    // //     $project = Projects_Model::with(['teams.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
    // //         ->withoutTrashed()
    // //         ->get()
    // //         ->sortBy('created_at')
    // //         ->where('id_project', $prjID)->first();

    // //     // Assuming $prjID is defined and you want to find a specific project from the previously loaded collection
    // //     // $project = $daftarProjects->where('id_project', $prjID)->first();

    // //     // dd($daftarProjects->toarray());
    // //     if ($project) {
    // //         if ($project->id_client) {
    // //             $project->load('client');
    // //         }
    // //         $ourClients = $project->client;
    // //         $clientList = [];
    // //         if ($ourClients) {
    // //             $clientList = Kustomer_Model::all()->map(function ($o_client) use ($ourClients) {
    // //                 $selected = ($o_client->id_client == $ourClients->id_client);
    // //                 return [
    // //                     'value' => $o_client->id_client,
    // //                     'text' => $o_client->na_client,
    // //                     'selected' => $selected,
    // //                 ];
    // //             });
    // //         } else {
    // //             $clientList = Kustomer_Model::withoutTrashed()->get()->map(function ($o_client) {
    // //                 return [
    // //                     'value' => $o_client->id_client,
    // //                     'text' => $o_client->na_client,
    // //                     'selected' => false,
    // //                 ];
    // //             });
    // //         }

    // //         $ourTeams = $project->team;
    // //         $teamList = [];
    // //         if ($ourTeams) {
    // //             $teamList = Team_Model::all()->map(function ($o_team) use ($ourTeams) {
    // //                 $selected = ($o_team->id_team == $ourTeams->id_team);
    // //                 return [
    // //                     'value' => $o_team->id_team,
    // //                     'text' => $o_team->na_team,
    // //                     'selected' => $selected,
    // //                 ];
    // //             });
    // //         } else {
    // //             $teamList = Team_Model::withoutTrashed()->get()->map(function ($o_team) {
    // //                 return [
    // //                     'value' => $o_team->id_team,
    // //                     'text' => $o_team->na_team,
    // //                     'selected' => false,
    // //                 ];
    // //             });
    // //         }

    // //         $Coords = $project->karyawan;
    // //         $coordList = [];
    // //         if ($Coords) {
    // //             $coordList = Karyawan_Model::whereHas('daftar_login', function ($query) {
    // //                 $query->where('type', 3); // Assuming 3 corresponds to 'Supervisor'
    // //             })->get()->map(function ($o_coord) use ($Coords) {
    // //                 $selected = ($o_coord->id_karyawan == $Coords->id_karyawan);
    // //                 return [
    // //                     'value' => $o_coord->id_karyawan,
    // //                     'text' => $o_coord->na_karyawan,
    // //                     'selected' => $selected,
    // //                 ];
    // //             });
    // //         } else {
    // //             $coordList = Karyawan_Model::whereHas('daftar_login', function ($query) {
    // //                 $query->where('type', 3); // Assuming 3 corresponds to 'Supervisor'
    // //             })->withoutTrashed()->get()->map(function ($o_coord) {
    // //                 return [
    // //                     'value' => $o_coord->id_karyawan,
    // //                     'text' => $o_coord->na_karyawan,
    // //                     'selected' => false,
    // //                 ];
    // //             });
    // //         }

    // //         // Return queried data as a JSON response
    // //         return response()->json([
    // //             'authtypeuser' => $authTypeUser,
    // //             'id_project' => $prjID,
    // //             'na_project' => $project->na_project,
    // //             'id_client' => $clientID,
    // //             'clientList' => $clientList,
    // //             'id_karyawan' => $project->id_karyawan,
    // //             'coList' => $coordList,
    // //             'na_karyawan' => $project->karyawan->na_karyawan,
    // //             'teamList' => $teamList,
    // //             'start_deadline' => Carbon::parse($project->start_project)->format('Y-m-d') . ' to ' . Carbon::parse($project->deadline_project)->format('Y-m-d'),
    // //         ]);
    // //     } else {
    // //         // Handle the case when the Jabatan_Model with the given projectID is not found
    // //         return response()->json(['error' => 'Project_Model not found'], 404);
    // //     }
    // // }



    // public function get_project(Request $request)
    // {
    //     $authTypeUser  = auth()->user()->type;
    //     $prjID = $request->input('prjID');
    //     $prjName = $request->input('prjName');
    //     $clientID = $request->input('clientID');

    //     $project = Projects_Model::with(['teams.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
    //         ->withoutTrashed()
    //         ->where('id_project', $prjID)
    //         ->first();

    //     if ($project) {
    //         // Load client if it exists
    //         if ($project->id_client) {
    //             $project->load('client');
    //         }
    //         $ourClients = $project->client;
    //         $clientList = [];
    //         if ($ourClients) {
    //             $clientList = Kustomer_Model::all()->map(function ($o_client) use ($ourClients) {
    //                 $selected = ($o_client->id_client == $ourClients->id_client);
    //                 return [
    //                     'value' => $o_client->id_client,
    //                     'text' => $o_client->na_client,
    //                     'selected' => $selected,
    //                 ];
    //             });
    //         } else {
    //             $clientList = Kustomer_Model::withoutTrashed()->get()->map(function ($o_client) {
    //                 return [
    //                     'value' => $o_client->id_client,
    //                     'text' => $o_client->na_client,
    //                     'selected' => false,
    //                 ];
    //             });
    //         }

    //         // Build team list from the project teams
    //         $teamList = [];
    //         foreach ($project->teams as $team) {
    //             $teamList[] = [
    //                 'value' => $team->id_team,
    //                 'text' => $team->na_team,
    //                 'selected' => true, // Assuming the team is part of the project
    //             ];
    //         }

    //         // Build coordinator list from the project coordinators
    //         $coordList = [];
    //         foreach ($project->coordinators as $coordinator) {
    //             $coordList[] = [
    //                 'value' => $coordinator->karyawan->id_karyawan,
    //                 'text' => $coordinator->karyawan->na_karyawan,
    //                 'selected' => true, // Assuming the coordinator is part of the project
    //             ];
    //         }

    //         // Return queried data as a JSON response
    //         return response()->json([
    //             'authtypeuser' => $authTypeUser,
    //             'id_project' => $prjID,
    //             'na_project' => $project->na_project,
    //             'id_client' => $clientID,
    //             'clientList' => $clientList,
    //             'id_karyawan' => $project->id_karyawan,
    //             'coList' => $coordList,
    //             'na_karyawan' => $project->karyawan->na_karyawan ?? null, // Handle case where karyawan might not exist
    //             'teamList' => $teamList,
    //             'start_deadline' => Carbon::parse($project->start_project)->format('Y-m-d') . ' to ' . Carbon::parse($project->deadline_project)->format('Y-m-d'),
    //         ]);
    //     } else {
    //         // Handle the case when the project with the given projectID is not found
    //         return response()->json(['error' => 'Project_Model not found'], 404);
    //     }
    // }



    public function get_project(Request $request)
    {
        $authTypeUser     = auth()->user()->type;
        $prjID = $request->input('prjID');
        $prjName = $request->input('prjName');
        $clientID = $request->input('clientID');

        // $project = Projects_Model::with(['teams.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
        $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
            ->withoutTrashed()
            ->where('id_project', $prjID)
            ->first();

        if ($project) {
            // Load client if it exists
            if ($project->id_client) {
                $project->load('client');
            }
            $ourClients = $project->client;
            $clientList = [];
            if ($ourClients) {
                $clientList = Kustomer_Model::all()->map(function ($o_client) use ($ourClients) {
                    $selected = ($o_client->id_client == $ourClients->id_client);
                    return [
                        'value' => $o_client->id_client,
                        'text' => $o_client->na_client,
                        'selected' => $selected,
                    ];
                });
            } else {
                $clientList = Kustomer_Model::withoutTrashed()->get()->map(function ($o_client) {
                    return [
                        'value' => $o_client->id_client,
                        'text' => $o_client->na_client,
                        'selected' => false,
                    ];
                });
            }

            // Build team list from the project teams
            $teamList = Team_Model::all()->map(function ($o_team) use ($project) {
                // Check if the current team exists in the project's prjteams
                $selected = $project->prjteams->contains(function ($prjteam) use ($o_team) {
                    return isset($prjteam['team']) && $prjteam['team']['id_team'] == $o_team->id_team;
                });

                return [
                    'value' => $o_team->id_team,
                    'text' => $o_team->na_team,
                    'selected' => $selected,
                ];
            });

            // Build coordinator list from Karyawan_Model
            $coordList = Karyawan_Model::whereHas('daftar_login', function ($query) {
                $query->where('type', 3); // Assuming 3 corresponds to 'Supervisor'
            })->get()->map(function ($o_coord) use ($project) {
                // Check if the coordinator is part of the project
                $selected = $project->coordinators->contains('karyawan.id_karyawan', $o_coord->id_karyawan);
                return [
                    'value' => $o_coord->id_karyawan,
                    'text' => $o_coord->na_karyawan,
                    'selected' => $selected,
                ];
            });

            // Return queried data as a JSON response
            return response()->json([
                'authtypeuser' => $authTypeUser,
                'id_project' => $prjID,
                'na_project' => $project->na_project,
                'id_client' => $clientID,
                'clientList' => $clientList,
                'id_karyawan' => $project->id_karyawan,
                'coList' => $coordList, // This will now support multiple selections
                'na_karyawan' => $project->karyawan->na_karyawan ?? null, // Handle case where karyawan might not exist
                'teamList' => $teamList, // This will now support multiple selections
                'start_deadline' => Carbon::parse($project->start_project)->format('Y-m-d') . ' to ' . Carbon::parse($project->deadline_project)->format('Y-m-d'),
            ]);
        } else {
            // Handle the case when the project with the given projectID is not found
            return response()->json(['error' => 'Project_Model not found'], 404);
        }
    }



    public function edit_project(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'edit-project-id'  => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('tb_projects', 'id_project')->ignore($request->input('edit-project-id'), 'id_project')
                ],
                'edit-start-deadline' => [
                    'required',
                    'string',
                    'regex:/^\d{4}-\d{2}-\d{2} to \d{4}-\d{2}-\d{2}$/', // Check format
                    function ($attribute, $value, $fail) {
                        $dates = explode(" to ", $value);
                        if (count($dates) !== 2) {
                            return $fail('The ' . $attribute . ' must contain two valid dates.');
                        }

                        // Validate the dates
                        $startDate = $dates[0];
                        $endDate = $dates[1];

                        if (!strtotime($startDate) || !strtotime($endDate)) {
                            return $fail('The dates must be valid dates.');
                        }

                        if ($startDate > $endDate) {
                            return $fail('The start date must be before the end date.');
                        }
                    },
                ],
                'bsvalidationcheckbox1' => 'required',
                'edit-co-select2-assign' => 'required|array|min:1', // Ensure at least one coordinator is selected
                'edit-engteam-select2-assign' => 'required|array|min:1', // Ensure at least one engineering team is selected

            ],
            [
                'edit-project-id.required'  => 'The project-id field is required.',
                'bsvalidationcheckbox1.required' => 'The saving agreement field is required.',
                'edit-start-deadline.regex' => 'The start-deadline must be in the format YYYY-MM-DD to YYYY-MM-DD.',
                'edit-co-select2-assign.required' => 'At least one coordinator must be assigned.',
                'edit-co-select2-assign.min' => 'At least one coordinator must be assigned.',
                'edit-engteam-select2-assign.required' => 'At least one engineering team must be assigned.',
                'edit-engteam-select2-assign.min' => 'At least one engineering team must be assigned.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $prj = Projects_Model::find($request->input('e-project-id'));
        if ($prj) {
            $prj->id_project = $request->input('edit-project-id');
            $prj->na_project = $request->input('edit-project-name');
            $prj->id_client = $request->input('edit-client-id');
            // $prj->id_karyawan = $request->input('edit-co-id');
            // $prj->id_team = $request->input('edit-team-id');

            $dateRange = $request->input('edit-start-deadline');
            $dates = explode(" to ", $dateRange);
            $prj->start_project = $dates[0];
            $prj->deadline_project = $dates[1];

            $prj->save();


            // // Update coordinators
            // if ($request->has('edit-co-select2-assign')) {
            //     Coordinators_Model::where('id_project', $prj->id_project)->delete();
            //     $coordinatorInput = $request->input('edit-co-select2-assign', []);
            //     // dd($coordinatorInput);
            //     if (!is_array($coordinatorInput)) {
            //         $coordinatorInput = [$coordinatorInput];
            //     }
            //     if (!empty($coordinatorInput)) {
            //         foreach ($coordinatorInput as $id_kar) {
            //             $cos = new Coordinators_Model();
            //             $cos->id_project = $prj->id_project;
            //             $cos->id_karyawan = $id_kar;
            //             $cos->save();
            //         }
            //     }
            // }

            // // Update teams
            // if ($request->has('edit-engteam-select2-assign')) {
            //     Projects_Teams_Model::where('id_project', $prj->id_project)->delete();
            //     $teamInput = $request->input('edit-engteam-select2-assign', []);
            //     // dd($teamInput->toArray());
            //     if (!is_array($teamInput)) {
            //         $teamInput = [$teamInput];
            //     }
            //     if (!empty($teamInput)) {
            //         foreach ($teamInput as $id_team) {
            //             $prjteam = new Projects_Teams_Model();
            //             $prjteam->id_team = $id_team;
            //             $prjteam->id_project = $prj->id_project;
            //             $prjteam->save();
            //         }
            //     }
            // }


            // Update coordinators
            if ($request->has('edit-co-select2-assign')) {
                $coordinatorInput = $request->input('edit-co-select2-assign', []);
                if (!is_array($coordinatorInput)) {
                    $coordinatorInput = [$coordinatorInput];
                }

                // Get existing coordinators for the project, including soft-deleted ones
                $existingCoordinators = Coordinators_Model::withTrashed()
                    ->where('id_project', $prj->id_project)
                    ->get();

                // Restore or delete coordinators that are not in the new input
                foreach ($existingCoordinators as $coordinator) {
                    if (in_array($coordinator->id_karyawan, $coordinatorInput)) {
                        // If the coordinator is soft-deleted, restore it
                        if ($coordinator->trashed()) {
                            $coordinator->restore();
                        }
                    } else {
                        // If the coordinator is not in the new input, delete it
                        $coordinator->delete(); // This will soft delete it
                    }
                }

                // Add or update new coordinators
                foreach ($coordinatorInput as $id_kar) {
                    Coordinators_Model::updateOrCreate(
                        ['id_project' => $prj->id_project, 'id_karyawan' => $id_kar],
                        ['id_project' => $prj->id_project, 'id_karyawan' => $id_kar]
                    );
                }
            }

            // Update teams
            if ($request->has('edit-engteam-select2-assign')) {
                $teamInput = $request->input('edit-engteam-select2-assign', []);
                if (!is_array($teamInput)) {
                    $teamInput = [$teamInput];
                }

                // Get existing teams for the project, including soft-deleted ones
                $existingTeams = Projects_Teams_Model::withTrashed()
                    ->where('id_project', $prj->id_project)
                    ->get();

                // Restore or delete teams that are not in the new input
                foreach ($existingTeams as $team) {
                    if (in_array($team->id_team, $teamInput)) {
                        // If the team is soft-deleted, restore it
                        if ($team->trashed()) {
                            $team->restore();
                        }
                    } else {
                        // If the team is not in the new input, delete it
                        $team->delete(); // This will soft delete it
                    }
                }

                // Add or update new teams
                foreach ($teamInput as $id_team) {
                    Projects_Teams_Model::updateOrCreate(
                        ['id_project' => $prj->id_project, 'id_team' => $id_team],
                        ['id_project' => $prj->id_project, 'id_team' => $id_team]
                    );
                }
            }


            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Project updated successfully!']);
            return Redirect::back();
        } else {
            Session::flash('errors', ['Err[404]: Project update failed!']);
        }

        return redirect()->back();
    }



    // public function delete_project(Request $request)
    // {
    //     $projectID = $request->input('project_id');
    //     $project = Projects_Model::with('client', 'team', 'monitor', 'worksheet', 'task')->where('id_project', $projectID)->first();
    //     if ($project) {
    //         $project->delete();
    //         Session::flash('success', ['Project deletion successful!']);
    //     } else {
    //         Session::flash('errors', ['Err[404]: Project deletion failed!']);
    //     }
    //     return redirect()->back();
    // }

    public function delete_project(Request $request)
    {
        $projectID = $request->input('del-project_id');
        $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
            ->withoutTrashed()
            ->find($projectID);

        // Check if the project exists
        if (!$project) {
            Session::flash('n_errors', ['Err[404]: Project not found for deletion!']);
            return redirect()->back();
        }


        // Note: exclude softdeleted
        // Check project progress for the specific project
        $isProjectOngoing = $this->checkProjectProgress([$project]) > 0;
        if ($isProjectOngoing) {
            Session::flash('n_errors', ['Err[409]: Project deletion failed! Project is ongoing.']);
            return redirect()->back();
        }

        // Check if there are related monitors, worksheets, or tasks
        if ($project->monitor()->withoutTrashed()->exists()) {
            Session::flash('n_errors', ['Err[409]: Project deletion failed! Related monitors exist!']);
            return redirect()->back();
        }
        if ($project->worksheet()->withoutTrashed()->exists()) {
            Session::flash('n_errors', ['Err[409]: Project deletion failed! Related worksheets exist!']);
            return redirect()->back();
        }
        if ($project->task()->withoutTrashed()->exists()) {
            Session::flash('n_errors', ['Err[409]: Project deletion failed! Related tasks exist!']);
            return redirect()->back();
        }

        // If no related monitors, worksheets, or tasks, proceed with deletion
        $project->delete();
        Session::flash('success', ['Project deletion successful!']);
        return redirect()->back();
    }


    public function checkProjectProgress($projects)
    {
        $totalActual = 0;
        foreach ($projects as $project) {

            $currentDateTime = \Carbon\Carbon::now();
            $expiredAt = \Carbon\Carbon::parse($project->deadline_project);
            $isExpired = $expiredAt < $currentDateTime;
            $ongoing = $project->prjstatus_beta() == 'ONGOING' ? true : false;
            if ($project->monitor->isNotEmpty()) {
                foreach ($project->monitor as $mon) {
                    $total = 0;
                    //  THIS IS ORIGINALLY TOTAL PROGRESS THAT NEEDED !
                    $qty = $mon['qty'];
                    // Get all tasks associated with the project
                    $relatedTasks = $project->task; // This gets all tasks related to the project
                    $totalProgress = 0;

                    // Iterate over each task and sum the progress
                    foreach ($relatedTasks as $task) {
                        $totalProgress += $task->sumProgressByMonitoring(
                            $mon['id_monitoring'],
                        );
                    }

                    // Assuming you want to calculate based on the average progress
                    $up =
                        $relatedTasks->count() > 0
                        ? $totalProgress / $relatedTasks->count()
                        : 0; // Average progress
                    $total = ($qty * $up) / 100; // Calculate total percentage
                    $totalActual += $total; // Accumulate to totalActual if needed
                }
            }
        }

        return $totalActual;
    }



    public function reset_project(Request $request)
    {
        Projects_Model::query()->delete();
        DB::statement('ALTER TABLE tb_projects AUTO_INCREMENT = 1');

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All project data reset successfully!']);
        return redirect()->back();
    }


    public function get_prjmondws(Request $request)
    {
        if (!Auth::check() && in_array($request->route()->getName(), [
            'm.projects.getprjmondws',
            'm.ws',
            'm.projects.modprj.sh2cl',
        ])) {
            return redirect()->route('login.page');
        }

        $process = $this->setPageSession("Manage Projects", "m-projects");
        if ($process) {
            $projectId = $request->input('projectID');
            if (!$projectId) {
                return Session::flash('n_errors', ['Project ID is required!']);
            }

            try {
                // // $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
                // //     ->findOrFail($projectId);
                // $project = Projects_Model::with(['client', 'pcoordinator', 'team.karyawans', 'monitor', 'task', 'worksheet'])
                //     ->where('id_project', $projectId)
                //     ->first();
                // $project = Projects_Model::with(['teams' , 'coordinators', 'client', 'worksheet', 'monitor'])
                // $project = Projects_Model::with(['client', 'pcoordinator', 'team.karyawans', 'monitor', 'task', 'worksheet'])
                // $project = Projects_Model::with(['coordinators', 'teams.karyawans', 'client', 'monitor', 'task', 'worksheet'])
                // $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
                //     ->where('id_project', $projectId)
                //     ->withoutTrashed()
                //     ->get()
                //     ->sortBy('created_at')
                //     // ->sortByDesc('created_at')
                //     ->first();


                // $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor' => function($query) {
                //     $query->orderBy('order'); // Sort by the new order column in tb_monitoring
                // }])
                // ->where('id_project', $projectId)
                // ->withoutTrashed()
                // ->first();

                $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet' => function ($query) {
                    $query->orderBy('working_date_ws', 'asc')->orderBy('id_ws', 'asc');   // Sort by working_date_ws and then by id_ws
                }])
                    ->where('id_project', $projectId)
                    ->withoutTrashed()
                    ->first();

                if ($project) {
                    $project->setRelation('monitor', $project->monitor()->orderBy('order')->get());
                }

                try {
                    $project->load('worksheet');
                    $ws_status = $project->worksheet->map(function ($worksheet) {
                        return $worksheet->checkAllWSStatus();
                    })->contains('OPEN') ? 'OPEN' : 'CLOSED';
                } catch (\Throwable $th) {
                    Session::flash('n_errors', ['Projects not available or deleted!']);
                    return redirect()->back();
                }

                // $user = auth()->user();
                // $authenticatedUserEmployee = Karyawan_Model::with(['daftar_login.karyawan', 'daftar_login_4get.karyawan', 'jabatan.karyawan'])
                //     ->findOrFail($user->id_karyawan);


                // $user = auth()->user();
                // $authenticated_user_data = Karyawan_Model::with(['daftar_login.karyawan', 'daftar_login_4get.karyawan' => function ($query) {
                //     $query->orderBy('created_at', 'desc')->withoutTrashed()->take(1);
                // }, 'jabatan.karyawan'])
                //     ->find($user->id_karyawan);

                // if ($authenticated_user_data == null) {
                //     $authenticated_user_data = Kustomer_Model::with(
                //         [
                //             'daftar_login_4get.client' => function ($query) {
                //                 $query->orderBy('created_at', 'desc')->withoutTrashed()->take(1);
                //             }
                //         ]
                //     )->find($user->id_client);
                // }


                $user = auth()->user();
                $authenticated_user_data = $this->get_user_auth_data();
                // dd($authenticated_user_data->toArray());

                $loadDataDailyWS = [];
                if ($loadDataDailyWS) {
                    $loadDataDailyWS = DaftarWS_Model::where('id_project', $project->monitor[0]['id_project'])->get();
                }
                // dd($loadDataDailyWS);
                // $clientData = DaftarWS_Model::with('project', 'monitoring')->where('id_project', $project->monitor[0]['id_project'])->first()->getClientData();

                // $isProjectOpen = $project->status_project == 'OPEN' ? true : false;
                $modalData = [
                    'modal_add_moni' => '#add_moniModal',
                    'modal_edit_moni' => '#edit_moniModal',
                    'modal_delete_moni' => '#delete_moniModal',
                    'modal_reset_moni' => '#reset_moniModal',
                    'modal_moni_print' => '#export_moniModal',
                    'modal_add_ws' => '#add_wsModal',
                    'modal_edit_ws' => '#edit_wsModal',
                    'modal_delete_ws' => '#delete_wsModal',
                    'modal_reset_ws' => '#reset_wsModal',
                    'modal_lock' => '#lock_wsModal',
                    'modal_unlock' => '#unlock_wsModal',
                    'modal_lock_prj' => '#lock_prjModal',
                    'modal_unlock_prj' => '#unlock_prjModal'
                ];


                $data = [
                    'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                    'currentRouteName' => Route::currentRouteName(),
                    'project' => $project,
                    'authenticated_user_data' => $authenticated_user_data,
                    'loadDataDailyWS' => $loadDataDailyWS,
                    'wsStatus' => $ws_status,
                    'modalData' => $modalData,
                    // 'clientData' => $clientData,
                ];

                // $this->dispatchJob('direct');
                return view('pages.userpanels.pm_mondws', $data);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return Session::flash('n_errors', ['Err[404]: Project not found!']);
            }
        }
    }




    public function get_prj_4lockunlock(Request $request)
    {
        $projectID = $request->input('projectID');
        $daftarProject = Projects_Model::where('id_project', $projectID)->first();
        // dd($daftarProject->toarray());  //http://100.100.100.58/m-prj/m-monitoring-worksheet/prj/getlockunlock?projectID=PRJ-24-0001
        if ($daftarProject) {
            return response()->json([    // Return queried data as a JSON response
                'project_id'    => $daftarProject->id_project,
                'project_co'    => $daftarProject->id_karyawan
            ]);
        } else {    // Handle the case when the Jabatan_Model with the given jabatanID is not found
            return response()->json(['error' => 'Project for locking wasn\'t found!'], 404);
        }
    }




    public function lock_prj(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lock-prj_id' => 'required'
            ],
            [
                'lock-prj_id.required' => 'The project_id field is not filled by system!'
            ]
        );

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $prj = Projects_Model::find($request->input('lock-prj_id'));
        $currentActualProgress = $this->countProgress($prj);
        // dd($currentActualProgress);
        if ($prj) {
            $authTypeUser = auth()->user()->type;
            // if (auth()->user()->type == 'Superuser' || $currentActualProgress == 100) {
            if ($authTypeUser == 'Superuser' || $authTypeUser = 'Supervisor') {
                $this->closeProject($prj);
                Session::flash('success', ['Project locked successfully!']);
                return redirect()->back();
            } else {
                Session::flash('n_errors', ["Can't lock the project because the actual project progress is still at {$currentActualProgress}%!"]);
                return redirect()->back();
            }
        } else {
            Session::flash('n_errors', ['Err[404]: Failed to lock project, project not found!']);
            return redirect()->back();
        }
    }

    private function closeProject($prj)
    {
        $prj->status_project = 'CLOSED';
        $prj->closed_at_project = Carbon::now();
        $prj->save();

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);
    }


    public function unlock_prj(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'unlock-prj_id' => 'required'
            ],
            [
                'unlock-prj_id.required' => 'The project_id field is not filled by system!'
            ]
        );
        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $prj = Projects_Model::find($request->input('unlock-prj_id'));
        $currentActualProgress = $this->countProgress($prj);
        if ($prj) {
            if (auth()->user()->type == 'Superuser' || auth()->user()->type == 'Supervisor' || $currentActualProgress == 100) {
                $this->openProject($prj);
                Session::flash('success', ['Project unlock successfully!']);
                return redirect()->back();
            } else {
                Session::flash('n_errors', ["Can't unlock the project because you have no authority!"]);
                return redirect()->back();
            }
        } else {
            Session::flash('n_errors', ['Err[404]: Failed to unlock project!']);
            return redirect()->back();
        }
    }


    private function openProject($prj)
    {
        $prj->status_project = 'OPEN';
        $prj->closed_at_project = null;
        $prj->save();

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);
    }




    public function countProgress($prj)
    {
        $totalActual = 0;
        foreach ($prj->monitor as $mon) {
            $qty = $mon['qty'];
            // Find related tasks where expired_ws is null
            $relatedTasks = collect($prj->task)->filter(function ($task) use (
                $mon,
                $prj,
            ) {
                $worksheet = collect($prj->worksheet)->firstWhere(
                    'id_ws',
                    $task['id_ws'],
                );
                return $task['id_monitoring'] === $mon['id_monitoring'] &&
                    ($worksheet['expired_at_ws'] ?? null) === null;
            });

            // Calculate total progress
            $totalProgress = $relatedTasks->sum('progress_current_task');
            $up =
                $relatedTasks->count() > 0
                ? $totalProgress / $relatedTasks->count()
                : 0;
            $total = ($qty * $up) / 100;
            $totalActual += $total;
        }

        return $totalActual;
    }



    public function up_show_toclient(Request $request)
    {
        $request->validate([
            'projectID' => 'required',
            'show_to_client' => 'required|boolean',
        ]);

        $project = Projects_Model::where('id_project', $request->input('projectID'))
            ->whereNull('deleted_at')
            ->firstOrFail();

        $project->show_to_client = $request->show_to_client;
        $project->save();

        $message['success_json'][] = $project->id_project . ' has been successfully updated to ' .
            ($project->show_to_client ? '*show to client.' : '*not show to client.');
        return response()->json(['message' => $message], 200);
    }



    public function get_project_4add(Request $request)
    {
        if ($request) {
            $clientList = Kustomer_Model::withoutTrashed()->get()->map(function ($client) {
                return [
                    'value' => $client->id_client,
                    'text' => $client->na_client,
                    'selected' => false,
                ];
            });
            $teamList = Team_Model::withoutTrashed()->get()->map(function ($team) {
                return [
                    'value' => $team->id_team,
                    'text' => $team->na_team,
                    'selected' => false,
                ];
            });

            $coordList = Karyawan_Model::whereHas('daftar_login', function ($query) {
                $query->where('type', 3)->withoutTrashed(); // Assuming 3 corresponds to 'Supervisor'
            })->get()->map(function ($coord) {
                return [
                    'value' => $coord->id_karyawan,
                    'text' => $coord->na_karyawan,
                    'selected' => false,
                ];
            });

            return response()->json([    // Return queried data as a JSON response
                'client_list' => $clientList,
                'team_list' => $teamList,
                'co_list' =>  $coordList
            ]);
        } else {    // Handle the case when the Jabatan_Model with the given jabatanID is not found
            return response()->json(['error' => '[Err: 404] request wasn\'t found!'], 404);
        }
    }
}
