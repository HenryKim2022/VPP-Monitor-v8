<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DaftarLogin_Model;
use App\Models\DaftarTask_Model;
use App\Models\Karyawan_Model;
use App\Models\DaftarWS_Model;
use App\Models\Monitoring_Model;
use App\Models\Projects_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Jobs\CheckExpiredWorksheetsJob;



class WorksheetController extends Controller
{
    //
    public function index(Request $request)
    {
        // dd(DaftarTask_Model::with('monitor')->withoutTrashed()->get());
        // dd(DaftarTask_Model::withoutTrashed()->get());

        $projectID = $request->input('projectID');
        $wsID = $request->input('wsID');
        $wsDate = Carbon::parse($request->input('wsDate'));

        $process = $this->setPageSession("Manage Daily Worksheet", "m-worksheet");
        if ($process) {
            // $loadDataWS = DaftarWS_Model::with([
            //     'project',
            //     'project.client',
            //     'monitoring',
            //     // 'task' => function ($query) use ($wsDate) {
            //     //     $query->whereDate('created_at', $wsDate)
            //     //     ->with('monitor');
            //     // }
            //     // ,
            //     'task' => function ($query) use ($projectID) {
            //         $query->where('id_project', $projectID);
            //     }
            //     // ,
            //     // 'task.monitor' => function ($query) use ($projectID) {
            //     //     $query->where('id_project', $projectID);
            //     // }
            // ])->where('id_ws', $wsID)
            //     ->whereDate('working_date_ws', $wsDate)
            //     ->first();

            // dd($loadDataWS->toArray());


            $loadDataWS = DaftarWS_Model::with([
                'project',
                'project.client',
                // 'task' => function ($query) use ($wsDate) {
                //     $query->whereDate('created_at', $wsDate)
                //     ->with('monitor');
                // }
                // ,
                'task' => function ($query) use ($projectID) {
                    $query->where('id_project', $projectID)
                        ->orderBy('start_time_task', 'asc');
                }
                // ,
                // 'task.monitor' => function ($query) use ($projectID) {
                //     $query->where('id_project', $projectID);
                // }
            ])->where('id_ws', $wsID)
                ->whereDate('working_date_ws', $wsDate)
                ->first();
            // Get monitoring records for the tasks of the worksheet
            $loadDataWS->task->flatMap(function ($task) {
                return $task->monitor; // Assuming monitor returns a single Monitoring_Model instance
            });

            // // Dump the result
            // dd($loadDataWS->toArray());




            // $loadRelatedDailyWS = DaftarWS_Model::with('karyawan', 'project', 'monitoring')->where('id_project', $projectID)->first();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();

            $modalData = ['modal_edit' => '#edit_taskModal', 'modal_delete' => '#delete_taskModal', 'modal_reset' => '#reset_taskModal'];
            if ($loadDataWS->status_ws === 'OPEN') {
                $modalData['modal_add'] = '#add_taskModal';
                $modalData['modal_lock'] = '#lock_wsModal';
            } else {
                $modalData['modal_print'] = '#export_taskModal';
                $modalData['modal_unlock'] = '#unlock_wsModal';
            }

            $projectId = $request->input('projectID');
            // $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
            $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
                ->where('id_project', $projectId)
                ->first();


            $taskCategoryList = Monitoring_Model::where('id_project', $projectID)->withoutTrashed()->orderBy('order')->get();
            // foreach ($taskCategoryList as $category) {
            //     $total = 0; // Initialize total for this category
            //     $qty = $category->qty;
            //     $relatedTasks = $project->task; // This gets all tasks related to the project
            //     $totalProgress = 0;
            //     foreach ($relatedTasks as $task) {
            //         $totalProgress += $task->sumProgressByMonitoring($category->id_monitoring);
            //     }

            //     $up = $relatedTasks->count() > 0 ? $totalProgress / $relatedTasks->count() : 0; // Average progress
            //     $total = ($qty * $up) / 100; // Calculate total percentage
            //     // $total = $qty - $total;
            //     $category->current_progress = number_format($total, 1); // Store formatted total
            // }

            // Calculate current progress for each task category
            foreach ($taskCategoryList as $category) {
                $totalProgress = 0; // Initialize total progress for the category
                $totalQuantity = $category->qty; // Assuming qty is the total quantity for the category

                try {
                    // Iterate over each monitor
                    foreach ($project->monitor as $monitor) {
                        // Check if the monitor has tasks
                        if (!empty($monitor->tasks)) {
                            foreach ($monitor->tasks as $task) {
                                // Check if progress_current_task is not empty
                                if (!empty($task->progress_current_task)) {
                                    // Check if task is not soft-deleted and meets worksheet conditions
                                    if (
                                        empty($task->deleted_at) &&
                                        isset($task->worksheet) &&
                                        // is_null($task->worksheet->expired_at_ws) &&
                                        // $task->worksheet->status_ws === 'CLOSED' &&
                                        $task->id_monitoring === $category->id_monitoring
                                    ) { // Ensure task belongs to the current category
                                        $totalProgress += $task->progress_current_task; // Sum progress for saved tasks
                                    }
                                }
                            }
                        }
                    }
                    // $progressPercentage = $totalQuantity > 0 ? ($totalProgress / $totalQuantity) * 100 : 0; // Avoid division by zero
                    $progressPercentage = $totalProgress; // Avoid division by zero
                    // Calculate remaining progress as a percentage of 100%
                    $remainingProgress = (100 - $progressPercentage);

                    // Store formatted remaining progress for the category
                    $category->current_progress = number_format($remainingProgress, 1);
                } catch (\Throwable $th) {
                    Session::flash('n_errors', ['Monitors not available or deleted!']);
                    return redirect()->back();
                }
            }


            // $this->dispatchJob('direct');
            $data = [
                'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
                'currentRouteName' => Route::currentRouteName(),
                // 'loadDaftarWorksheetFromDB' => $loadDaftarWorksheetFromDB,
                'modalData' => $modalData,
                'loadDataWS' => $loadDataWS,
                // 'loadRelatedDailyWS' => $loadRelatedDailyWS,
                'employee_list' => Karyawan_Model::withoutTrashed()->get(),
                // 'taskCategoryList' => Monitoring_Model::where('id_project', $projectID)->withoutTrashed()->get(),
                'taskCategoryList' => $taskCategoryList,
                'project' => $project,
                'authenticated_user_data' => $authenticated_user_data,
            ];
            return $this->setReturnView('pages/userpanels/pm_daftartaskws', $data);
        }
    }


    public function add_ws(Request $request)
    {
        // dd(Carbon::parse($request->input('ws-working_date')));
        $validator = Validator::make(
            $request->all(),
            [
                'ws-working_date'   => ['required', 'date'],
                'ws-arrival_time'   => 'required',
                // 'ws-finish_time'    => 'required|after_or_equal:ws-arrival_time',
                // 'ws-finish_time'    => 'required',
                'ws-id_karyawan'    => 'required',
                'ws-id_project'     => 'required'
            ],
            [
                'ws-working_date.required'  => 'The working_date field is required.',
                'ws-working_date.date'      => 'The working_date must be a valid date.',
                'ws-arrival_time.required'  => 'The arrival_time field is required.',
                // 'ws-finish_time.required'   => 'The finish_time must be equal or not lower than arrival_time!',
                // 'ws-finish_time.required'   => 'The finish_time field is required!',
                'ws-id_karyawan.required'   => 'The id_karyawan field is not filled by system!',
                'ws-id_project.required'    => 'The id_project field is not filled by system!',
            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the worksheet already exists
        $existingWorksheets = DaftarWS_Model::where('working_date_ws', $request->input('ws-working_date'))
            ->where('id_karyawan', $request->input('ws-id_karyawan'))
            ->where('id_project', $request->input('ws-id_project'))
            ->get();

        // dd( $existingWorksheets->toArray());

        if ($existingWorksheets->isNotEmpty()) {
            $hasOpenStatus = false;
            foreach ($existingWorksheets as $worksheet) {
                $empName = $worksheet->karyawan->na_karyawan ?? null;
                if ($worksheet->status_ws === 'OPEN') {
                    if ($worksheet->expired_at_ws) {
                        if (now()->isBefore($worksheet->expired_at_ws)) {
                            // If there's an OPEN status and it is not expired, show message and return
                            Session::flash('n_errors', ['The worksheet for employee named *' . $empName . ' already exists and still UNLOCKED!']);
                            return redirect()->back();
                        } else {
                            // If expired, allow to insert duplicate data & set the old to locked
                            // how to do lock at the old data which expired here?
                            // If expired, lock the old data
                            // Reset progress for related tasks
                            $worksheet->status_ws = 'LOCKED'; // Change the status to LOCKED
                            $worksheet->save(); // Save the changes to the database

                            foreach ($worksheet->task as $task) {
                                $task->progress_current_task = 0;
                                $task->save();
                            }
                            $hasOpenStatus = true;
                        }
                    } else {
                        Session::flash('n_errors', ['The worksheet for employee *' . $empName . ' already exists and still UNLOCKED!']);
                        return redirect()->back();
                    }
                } elseif ($worksheet->status_ws === 'LOCKED') {
                    // If the existing worksheet is LOCKED and expired, allow insertion of a new worksheet
                    if (now()->isAfter($worksheet->expired_at_ws)) {
                        $hasOpenStatus = true; // Allow to insert duplicate
                    }
                }
            }

            // If there are OPEN worksheets but they are expired, insert duplicate
            if ($hasOpenStatus) {
                $this->insertDuplicateWorksheet($request);
                Session::flash('success', ['Duplicated worksheet added successfully!']);
                return redirect()->back();
            }
        } else {
            // If no existing worksheet, insert the new data
            $this->insertNewWorksheet($request);
            Session::flash('success', ['New worksheet added successfully!']);
            return redirect()->back();
        }

        // Handle case for CLOSED status
        foreach ($existingWorksheets as $worksheet) {
            if ($worksheet->status_ws === 'CLOSED') {
                // if (now()->isAfter($worksheet->expired_at_ws)) {
                if ($worksheet->expired_at_ws === null || now()->isAfter($worksheet->expired_at_ws)) {
                    // If expired, insert the duplicate data
                    $this->insertDuplicateWorksheet($request);
                    Session::flash('success', ['Duplicated worksheet added successfully!']);
                    return redirect()->back();
                }
            }
        }

        // If we reach here, it means no action was taken
        Session::flash('n_errors', ['Failed to insert duplicate worksheet.']);
        return redirect()->back();
    }

    private function insertDuplicateWorksheet($request)
    {
        $worksheet = new DaftarWS_Model();
        $worksheet->working_date_ws = Carbon::parse($request->input('ws-working_date'));
        $worksheet->arrival_time_ws = $request->input('ws-arrival_time');
        // $worksheet->finish_time_ws = $request->input('ws-finish_time');
        $worksheet->finish_time_ws = null;
        $worksheet->status_ws = "OPEN";
        $worksheet->expired_at_ws = Carbon::tomorrow()->setTime(12, 1);
        $worksheet->id_karyawan = $request->input('ws-id_karyawan');
        $worksheet->id_project = $request->input('ws-id_project');
        $worksheet->save();
    }

    private function insertNewWorksheet($request)
    {
        $worksheet = new DaftarWS_Model();
        $worksheet->working_date_ws = Carbon::parse($request->input('ws-working_date'));
        $worksheet->arrival_time_ws = $request->input('ws-arrival_time');
        // $worksheet->finish_time_ws = $request->input('ws-finish_time');
        $worksheet->finish_time_ws = null;
        $worksheet->status_ws = "OPEN";
        $worksheet->expired_at_ws = Carbon::tomorrow()->setTime(12, 1);
        $worksheet->id_karyawan = $request->input('ws-id_karyawan');
        $worksheet->id_project = $request->input('ws-id_project');
        $worksheet->save();
    }


    public function get_ws(Request $request)
    {
        $wsID = $request->input('wsID');
        $projectID = $request->input('projectID');
        $karyawanID = $request->input('karyawanID');
        // dd($wsID);
        $daftarWorksheet = DaftarWS_Model::where('id_ws', $wsID)->first();
        // dd($daftarWorksheet->toArray());
        // dd(Carbon::parse($daftarWorksheet->working_date_ws)->isoFormat("Y-MM-DD"));
        if ($daftarWorksheet) {
            return response()->json([    // Return queried data as a JSON response
                'id_ws'         => $daftarWorksheet->id_ws,
                'work_date'     => Carbon::parse($daftarWorksheet->working_date_ws)->isoFormat("Y-MM-DD"),
                'arrival_time'  => $daftarWorksheet->arrival_time_ws,
                'finish_time'   => $daftarWorksheet->finish_time_ws,
                'id_karyawan'   => $daftarWorksheet->id_karyawan,
                'id_project'    => $daftarWorksheet->id_project,
                'authUserType'  => auth()->user()->type
            ]);
        } else {    // Handle the case when the Jabatan_Model with the given jabatanID is not found
            return response()->json(['error' => 'Worksheet_Model not found'], 404);
        }
    }





    public function edit_ws(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'edit-ws_id'  => 'required',
                'edit-ws_working_date'   => ['required', 'date'],
                'edit-ws_arrival_time'  => 'required',
                // 'edit-ws_finish_time'  => 'required|after_or_equal:edit-ws_arrival_time',
                // 'edit-ws_finish_time'  => 'required',
                'edit-ws_finish_time'  => 'nullable',
                'edit-ws_project_id'  => 'required',
                'edit-ws_id_karyawan'  => 'required',
                'bsvalidationcheckbox1'  => 'required',
            ],
            [
                'edit-ws_id.required'  => 'The ws_id field is required.',
                'edit-ws_working_date.required'  => 'The working_date field is required.',
                'edit-ws_arrival_time.required'  => 'The arrival_time field is required.',
                // 'edit-ws_finish_time.required'   => 'The finish_time must be equal or not lower than arrival_time!',
                // 'edit-ws_finish_time.required'   => 'The finish_time field is required!',
                'edit-ws_finish_time.required'   => 'The finish_time field is required if provided!',
                'edit-ws_project_id.required' => 'The id_project field is not filled by system!',
                'edit-ws_id_karyawan.required' => 'The id_karyawan field is not filled by system!',
                'bsvalidationcheckbox1.required'  => 'The saving agreement field is required.',
            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve the worksheet to check its expiration
        $ws = DaftarWS_Model::find($request->input('edit-ws_id'));

        if ($ws) {
            // Check if the current date and time is greater than the expired_at_ws
            if (now()->isAfter($ws->expired_at_ws)) {
                Session::flash('n_errors', ['Error: The worksheet has expired and cannot be edited. Please add new worksheet, then donot forget to lock your worksheet!']);
                return redirect()->back();
            }

            // Check if the working_date related to id_karyawan already exists and exclude soft-deleted records
            $existingWorksheet = DaftarWS_Model::where('working_date_ws', $request->input('edit-ws_working_date'))
                ->where('id_karyawan', $request->input('edit-ws_id_karyawan'))
                ->where('id_project', $request->input('edit-ws_project_id'))
                ->whereNull('deleted_at') // Exclude soft-deleted records
                ->exists();
            if ($existingWorksheet) {
                $readExistingWorksheet = DaftarWS_Model::where('working_date_ws', $request->input('edit-ws_working_date'))
                    ->where('id_karyawan', $request->input('edit-ws_id_karyawan'))
                    ->where('id_project', $request->input('edit-ws_project_id'))
                    ->whereNull('deleted_at') // Exclude soft-deleted records
                    ->first(); // Use first() to get the actual record
                if (
                    $readExistingWorksheet->arrival_time_ws == $request->input('edit-ws_arrival_time') &&
                    $readExistingWorksheet->finish_time_ws == $request->input('edit-ws_finish_time')
                ) {
                    $work_date = Carbon::parse($request->input('edit-ws_working_date'))->isoFormat("ddd, DD MMM YYYY");
                    Session::flash('n_errors', ['The worksheet data for this employee already exists at ' . $work_date . '.']);
                    return redirect()->back();
                }
            }

            // Proceed to update the worksheet
            $ws->working_date_ws = $request->input('edit-ws_working_date');
            $ws->arrival_time_ws = $request->input('edit-ws_arrival_time');
            $ws->finish_time_ws = $request->input('edit-ws_finish_time');
            $ws->id_project = $request->input('edit-ws_project_id');
            $ws->id_karyawan = $request->input('edit-ws_id_karyawan');
            $ws->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Worksheet updated successfully!']);
            return Redirect::back();
        } else {
            Session::flash('errors', ['Err[404]: Worksheet update failed!']);
        }
    }




    // public function edit_ws(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'edit-ws_id'  => 'required',
    //             'edit-ws_working_date'   => ['required', 'date'],
    //             'edit-ws_arrival_time'  => 'required',
    //             'edit-ws_finish_time'  => 'required|after_or_equal:edit-ws_arrival_time',
    //             'edit-ws_project_id'  => 'required',
    //             'edit-ws_id_karyawan'  => 'required',
    //             'bsvalidationcheckbox1'  => 'required',
    //         ],
    //         [
    //             'edit-ws_id.required'  => 'The ws_id field is required.',
    //             'edit-ws_working_date.required'  => 'The working_date field is required.',
    //             'edit-ws_arrival_time.required'  => 'The arrival_time field is required.',
    //             'edit-ws_finish_time.required'   => 'The finish_time must be equal or not lower than arrival_time!',
    //             'edit-ws_project_id.required' => 'The id_project field is not filled by system!',
    //             'edit-ws_id_karyawan.required' => 'The id_karyawan field is not filled by system!',
    //             'bsvalidationcheckbox1.required'  => 'The saving agreement field is required.',
    //         ]
    //     );
    //     if ($validator->fails()) {
    //         $toast_message = $validator->errors()->all();
    //         Session::flash('errors', $toast_message);
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }


    //     // Add funct to check *compare current date time with  DaftarWS_Model -> expired_at_ws is it expired or not, if *NOT expired* continue to saving edited data, if expired show error
    //     // Check if the working_date related to id_karyawan already exists and exclude soft-deleted records
    //     $existingWorksheet = DaftarWS_Model::where('working_date_ws', $request->input('edit-ws_working_date'))
    //         ->where('id_karyawan', $request->input('edit-ws_id_karyawan'))
    //         ->where('id_project', $request->input('edit-ws_project_id'))
    //         ->whereNull('deleted_at') // Exclude soft-deleted records
    //         ->exists();

    //     if ($existingWorksheet) {
    //         $work_date = Carbon::parse($request->input('edit-ws_working_date'))->isoFormat("ddd, DD MMM YYYY");
    //         Session::flash('n_errors', ['The worksheet data for this employee already exists at ' . $work_date . '.']);
    //         return redirect()->back();
    //     }



    //     $ws = DaftarWS_Model::find($request->input('edit-ws_id'));
    //     if ($ws) {
    //         $ws->working_date_ws = $request->input('edit-ws_working_date');
    //         $ws->arrival_time_ws = $request->input('edit-ws_arrival_time');
    //         $ws->finish_time_ws = $request->input('edit-ws_finish_time');
    //         $ws->id_project = $request->input('edit-ws_project_id');
    //         $ws->id_karyawan = $request->input('edit-ws_id_karyawan');
    //         $ws->save();

    //         $user = auth()->user();
    //         $authenticated_user_data = $this->get_user_auth_data();
    //         Session::put('authenticated_user_data', $authenticated_user_data);

    //         Session::flash('success', ['Worksheet updated successfully!']);
    //         return Redirect::back();
    //     } else {
    //         Session::flash('errors', ['Err[404]: Worksheet update failed!']);
    //     }
    // }


    // public function lock_ws(Request $request)
    // {
    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'lock-ws_id'            => 'required'
    //         ],
    //         [
    //             'lock-ws_id.required'   => 'The ws_id field is not filled by system!'
    //         ]
    //     );
    //     if ($validator->fails()) {
    //         $toast_message = $validator->errors()->all();
    //         Session::flash('errors', $toast_message);
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $ws = DaftarWS_Model::find($request->input('lock-ws_id'));
    //     if ($ws) {
    //         if (auth()->user()->type == 'Superuser') {
    //             $ws->status_ws = 'CLOSED';
    //             $ws->expired_at_ws = null;
    //             $ws->save();

    //             $user = auth()->user();
    //             $authenticated_user_data = $this->get_user_auth_data();
    //             Session::put('authenticated_user_data', $authenticated_user_data);

    //             Session::flash('success', ['Worksheet locked successfully!']);
    //         } else {
    //             // check is theres tasks (DaftarTask_Model) related with worksheet (DaftarWS_Model) by id_ws ?

    //             // Check if there are related tasks
    //             $relatedTasks = DaftarTask_Model::where('id_ws', $ws->id)->get();
    //             dd($relatedTasks);
    //             if ($relatedTasks->isNotEmpty()) {
    //                 // If no related tasks, allow locking
    //                 $ws->status_ws = 'CLOSED';
    //                 $ws->expired_at_ws = null;
    //                 $ws->save();

    //                 Session::flash('success', ['Worksheet locked successfully!']);
    //             } else {
    //                 // If there are no related tasks, prevent locking
    //                 Session::flash('n_errors', ['Can\'t lock the worksheet because there\'s no tasks in this worksheet!']);
    //             }
    //         }


    //         return Redirect::back();
    //     } else {
    //         Session::flash('n_errors', ['Err[404]: Failed to lock worksheet!']);
    //     }
    // }



    public function get_ws_4lockunlock(Request $request)
    {
        $wsID = $request->input('wsID');
        $daftarWorksheet = DaftarWS_Model::where('id_ws', $wsID)->first();
        if ($daftarWorksheet) {
            return response()->json([    // Return queried data as a JSON response
                'wsID'         => $daftarWorksheet->id_ws,
                'workingDate'  => $daftarWorksheet->working_date_ws(),
                'namaKaryawan' => $daftarWorksheet->karyawan->na_karyawan,
                'projectID'    => $daftarWorksheet->id_project
            ]);
        } else {    // Handle the case when the Jabatan_Model with the given jabatanID is not found
            return response()->json(['error' => 'Worksheet for locking not found'], 404);
        }
    }



    public function lock_ws(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'lock-ws_id' => 'required',
                'lock-project_id' => 'required',
                'lock-ws_finish_time'  => 'required',
            ],
            [
                'lock-ws_id.required' => 'The ws_id field is not filled by system!',
                'lock-project_id.required' => 'The project_id field is not filled by system!',
                'lock-ws_finish_time.required'   => 'The finish_time field is required!',
            ]
        );

        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $ws = DaftarWS_Model::with('task')
            ->withoutTrashed() // Exclude soft-deleted records
            ->find($request->input('lock-ws_id'));

        if ($ws != null) {
            if (auth()->user()->type == 'Superuser') {
                // Allow superuser to lock the worksheet
                $ws->finish_time_ws = $request->input('lock-ws_finish_time');
                $ws->status_ws = 'CLOSED';
                $ws->expired_at_ws = null;
                $ws->closed_at_ws = Carbon::now();
                $ws->save();

                $user = auth()->user();
                $authenticated_user_data = $this->get_user_auth_data();
                Session::put('authenticated_user_data', $authenticated_user_data);

                Session::flash('success', ['Worksheet locked successfully!']);
            } else {

                if ($ws->task->isNotEmpty()) {
                    // There are tasks related to this ws
                    $ws->finish_time_ws = $request->input('lock-ws_finish_time');
                    $ws->status_ws = 'CLOSED';
                    $ws->expired_at_ws = null;
                    $ws->closed_at_ws = Carbon::now();
                    $ws->save();

                    Session::flash('success', ['Worksheet locked successfully!']);
                } else {
                    // No tasks found
                    Session::flash('n_errors', ['Can\'t lock the worksheet because there are no related tasks!']);
                }
            }

            return Redirect::back();
        } else {
            Session::flash('n_errors', ['Err[404]: Failed to lock worksheet!']);
        }
    }



    public function unlock_ws(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'unlock-ws_id'            => 'required'
            ],
            [
                'unlock-ws_id.required'   => 'The ws_id field is not filled by system!'
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ws = DaftarWS_Model::find($request->input('unlock-ws_id'));
        if ($ws) {
            $ws->finish_time_ws = null;
            $ws->status_ws = 'OPEN';
            $ws->expired_at_ws = Carbon::tomorrow()->setTime(12, 1);
            $ws->closed_at_ws = null;
            $ws->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Worksheet unlock successfully!']);
            return Redirect::back();
        } else {
            Session::flash('errors', ['Err[404]: Failed to unlock worksheet!']);
        }
    }






    public function edit_mark_ws(Request $request)
    {
        // Initialize the message array
        $message = [];

        try {
            // Validate the incoming request
            $request->validate([
                'id_ws' => 'required|integer|exists:tb_worksheet,id_ws',
                'remarkText' => [
                    'required',
                    'string',
                    'max:951',
                    'regex:/^((?:.*\n?){0,9})$/', // Max 9 lines
                ],
            ], [
                'remarkText.required' => 'The remark text field is required.',
                'remarkText.max' => 'The remark text may not be greater than 951 characters.',
                'remarkText.regex' => 'The remark text field format is invalid. It must not exceed 9 lines.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capture validation errors
            $message['err_json'] = $e->validator->errors()->all();
            return response()->json(['message' => $message], 422); // Return 422 Unprocessable Entity
        }

        // Get the worksheet ID from the request
        $wsID = $request->input('id_ws');
        $worksheet = DaftarWS_Model::find($wsID);
        if (!$worksheet) {
            $message['err_json'][] = 'Worksheet not found';
            return response()->json(['message' => $message], 404);
        }

        // Check if the remark text is different from the existing remark
        $newRemark = $request->input('remarkText');
        if ($newRemark === $worksheet->remark_ws) {
            // $message['info_json'][] = 'No changes detected in the remark text.';
            return response()->json(['message' => $message], 200); // Return 200 OK with info message
        }

        $work_date = Carbon::parse($worksheet->working_date_ws)->isoFormat("DD-MMM-YYYY");
        $worksheet->remark_ws = $request->input('remarkText');
        $worksheet->save(); // Don't forget to save the changes

        // Prepare success message
        $message['success_json'][] = $worksheet->id_project . ' worksheet remarks for ' . '*' . $work_date . ' is updated!';

        return response()->json(['message' => $message], 200);
    }


    public function delete_ws(Request $request)
    {
        $wsID = $request->input('del_ws_id');
        $worksheet = DaftarWS_Model::with('karyawan', 'project')->where('id_ws', $wsID)->first();

        if ($worksheet) {
            // Check if id_ws is used in DaftarTask_Model
            $isUsedInDaftarTask = DaftarTask_Model::where('id_ws', $wsID)->whereNull('deleted_at')->exists();

            if ($isUsedInDaftarTask) {
                Session::flash('n_errors', ['Error: This worksheet cannot be deleted because it is still referenced in one or more tasks.']);
                return redirect()->back();
            }

            // Store the working_date_ws before deleting the worksheet
            $worksheetDate = $worksheet->working_date_ws;
            $worksheet->delete();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Success: Worksheet deletion with date *' . $worksheetDate . '* was successful!']);
        } else {
            $errorMessage = 'Error: Worksheet deletion failed!';

            if ($worksheet && $worksheet->working_date_ws) {
                $errorMessage = 'Error: Worksheet deletion with date *' . $worksheet->working_date_ws . '* failed!';
            }

            Session::flash('n_errors', [$errorMessage]);
        }

        return redirect()->back();
    }

    public function reset_ws(Request $request)
    {
        DaftarWS_Model::query()->delete();
        DB::statement('ALTER TABLE tb_worksheet AUTO_INCREMENT = 1');

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All worksheet data reset successfully!']);
        return redirect()->back();
    }
}
