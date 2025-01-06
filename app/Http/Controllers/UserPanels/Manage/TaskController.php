<?php

namespace App\Http\Controllers\UserPanels\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
use Illuminate\Support\Facades\Log;
use App\Jobs\CheckExpiredWorksheetsJob;
use Barryvdh\DomPDF\Facade\Pdf;

use Exception;


class TaskController extends Controller
{
    //
    public function add_task(Request $request)
    {
        // dd($request->input('ws-arrival_time' . ' != ' .'ws-finish_time'));
        // dd($request->toArray());
        $arrivalTime = Carbon::createFromFormat('H:i:s', $request->input('ws-arrival_time'));
        // dd($request->input('ws-arrival_time'));
        // $finishTime = Carbon::createFromFormat('H:i:s', $request->input('ws-finish_time'));
        $workTime = Carbon::createFromFormat('H:i:s', $request->input('task-work_time'));

        $check = [
            'arrivalTime' => $arrivalTime->toArray(),
            // 'finishTime' => $finishTime->toArray(),
            'workTime' => $workTime->toArray()
        ];
        // dd($check);

        $validator = Validator::make(
            $request->all(),
            [
                // 'ws-finish_time'                => 'required',
                'ws-arrival_time'               => 'required',
                'task-work_time' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $arrivalTime = Carbon::createFromFormat('H:i:s', $request->input('ws-arrival_time'));
                        // $finishTime = Carbon::createFromFormat('H:i:s', $request->input('ws-finish_time'));
                        $workTime = Carbon::createFromFormat('H:i:s', $value);

                        // Set the date part of workTime to match arrivalTime and finishTime
                        $workTime->setDate($arrivalTime->year, $arrivalTime->month, $arrivalTime->day);

                        // Add a tolerance of 12 hours only to the finish time
                        // $finishTimeWithTolerance = $finishTime->copy()->addHours(12);
                        $workTimeTimeWithTolerance = $workTime->copy()->addHours(12);

                        // // Compare the timestamps of workTime, arrivalTime, and finishTime with tolerance
                        // // if ($workTime->timestamp < $arrivalTime->timestamp || $workTime->timestamp > $finishTimeWithTolerance->timestamp) {
                        // if ($workTimeTimeWithTolerance->timestamp < $arrivalTime->timestamp) {
                        //     // $fail('The work time must be between arrival time and finish time (tolerance +12h).');
                        //     $fail('The work time must be above arrival time!');
                        // }
                    },
                ],
                'task-id_monitoring'            => 'required',
                'task-description'              => 'required|min:20',
                'task-current-progress'         => 'required',
                'ws-id_ws'                      => 'required',
                'ws-id_project'                 => 'required'
            ],
            [
                // 'ws-finish_time.required'       => 'The finish_time field is not filled by system!',
                'ws-arrival_time.required'      => 'The arrival_time field is not filled by system!',
                'task-work_time.required'       => 'The work_time field is required.',
                'task-id_monitoring.required'   => 'The task field is required.',
                'task-description.required'     => 'The description field is required.',
                'task-description.min'          => 'The description must be at least 20 characters.',
                'task-current-progress.required' => 'The current_progress field is required.',
                'ws-id_ws.required'             => 'The id_worksheet field is not filled by system!',
                'ws-id_project.required'        => 'The id_project field is not filled by system!'
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
        $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
            ->findOrFail($request->input('ws-id_project'));


        // Assuming this code is within a method and $request is available
        $id_monitoring = $request->input('task-id_monitoring');
        $currentProgress = $request->input('task-current-progress');
        if ($this->checkSavedProgressValue($id_monitoring, $currentProgress) > 100 || $this->checkUnsavedProgressValue($id_monitoring, $currentProgress) > 100) {
            $errorMessage = 'Err[400]: Sorry, you can\'t add a task with an exceeded progress number!';
            Session::flash('n_errors', [$errorMessage]);
            return redirect()->back();
        }

        // Check worksheet expiry
        $isWorksheetExpired = DaftarWS_Model::where('id_ws', $request->input('ws-id_ws'))
            ->where('id_project', $request->input('ws-id_project'))
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereNotNull('expired_at_ws') // Check for non-null expired_at_ws
            ->where('expired_at_ws', '<', Carbon::now()) // Compare expired_at_ws with current datetime
            ->exists(); // Use exists() to determine if such a record exists

        // Check worksheet ws_status
        $isWorksheetLocked = DaftarWS_Model::where('id_ws', $request->input('ws-id_ws'))
            ->where('id_project', $request->input('ws-id_project'))
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->where('status_ws', "CLOSED") // Corrected comparison
            ->exists(); // Use exists() to determine if such a record exists

        if ($isWorksheetExpired) {
            $errorMessage = 'Err[400]: Sorry, you can\'t add the task, because the worksheet is expired!';
            Session::flash('n_errors', [$errorMessage]);
            return redirect()->back();
        }
        if ($isWorksheetLocked) {
            $errorMessage = 'Err[400]: Sorry, you can\'t add the task, because the worksheet is locked!';
            Session::flash('n_errors', [$errorMessage]);
            return redirect()->back();
        }


        $task = new DaftarTask_Model();
        $task->start_time_task = Carbon::createFromFormat('H:i:s', $request->input('task-work_time'))->toTimeString();
        $task->descb_task = $request->input('task-description');
        // $task->progress_actual_task = $request->input('task-actual-progress');
        $task->progress_current_task = $request->input('task-current-progress');
        $task->id_ws = $request->input('ws-id_ws');
        $task->id_project = $request->input('ws-id_project');
        $task->id_monitoring = $request->input('task-id_monitoring');
        $task->save();

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['Task added successfully!']);
        return redirect()->back();
    }


    // public function get_task(Request $request)
    // {
    //     $taskID = $request->input('taskID');
    //     $projectID = $request->input('projectID');

    //     // Fetch the task based on ID and project ID
    //     $daftarTask = DaftarTask_Model::where('id_task', $taskID)
    //         ->where('id_project', $projectID)
    //         ->first();

    //     if ($daftarTask) {
    //         // Get the id_monitoring from the fetched task
    //         $id_monitoring = $daftarTask->id_monitoring;

    //         // Fetch all categories for the project
    //         $taskCategoryList = Monitoring_Model::where('id_project', $projectID)->withoutTrashed()->get();

    //         // Filter taskCategoryList based on the id_monitoring of the fetched task
    //         $filteredTaskCategoryList = $taskCategoryList->filter(function ($category) use ($id_monitoring) {
    //             return $category->id_monitoring == $id_monitoring; // Assuming id_monitoring links categories to tasks
    //         });

    //         // Prepare taskList with current progress
    //         $taskList = $filteredTaskCategoryList->map(function ($category) use ($daftarTask) {
    //             $selected = ($daftarTask && $category->id_monitoring == $daftarTask->id_monitoring);
    //             return [
    //                 'value' => $category->id_monitoring,
    //                 'text' => $category->category,
    //                 'selected' => $selected,
    //                 'current_progress' => $category->qty, // Assuming qty is the progress indicator
    //             ];
    //         });

    //         // Return queried data as a JSON response
    //         return response()->json([
    //             'id_task'               => $taskID,
    //             'task_worktime'         => $daftarTask->start_time_task,
    //             'task_description'      => $daftarTask->descb_task,
    //             'task_description_charcount' => strlen($daftarTask->descb_task),
    //             'task_currentprogress'  => $daftarTask->progress_current_task,
    //             'id_ws'                 => $daftarTask->id_ws,
    //             'id_project'            => $daftarTask->id_project,
    //             'taskList'              => $taskList,
    //         ]);
    //     } else {
    //         // Handle the case when the DaftarTask_Model with the given taskID is not found
    //         return response()->json(['error' => 'DaftarTask_Model not found'], 404);
    //     }
    // }


    public function get_task(Request $request)
    {
        $taskID = $request->input('taskID');
        $projectID = $request->input('projectID');

        // Fetch the task based on ID and project ID
        $daftarTask = DaftarTask_Model::where('id_task', $taskID)
            ->where('id_project', $projectID)
            ->first();

        if ($daftarTask) {
            // Get the id_monitoring from the fetched task
            $id_monitoring = $daftarTask->id_monitoring;

            // Fetch all categories for the project
            $taskCategoryList = Monitoring_Model::where('id_project', $projectID)->withoutTrashed()->orderBy('order')->get();

            // Initialize progress for each category
            foreach ($taskCategoryList as $category) {
                $totalProgress = 0; // Initialize total progress for the category
                $totalQuantity = $category->qty; // Assuming qty is the total quantity for the category

                // Fetch the project with related monitors
                $project = Projects_Model::with(['monitor'])->where('id_project', $projectID)->first();

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
                                    $task->id_monitoring === $category->id_monitoring
                                ) { // Ensure task belongs to the current category
                                    $totalProgress += $task->progress_current_task; // Sum progress for saved tasks
                                }
                            }
                        }
                    }
                }

                // Calculate remaining progress as a percentage of 100%
                $progressPercentage = $totalProgress; // Avoid division by zero
                $remainingProgress = (100 - $progressPercentage);

                // Store formatted remaining progress for the category
                $category->current_progress = number_format($remainingProgress, 1);
            }

            // // Filter taskCategoryList based on the id_monitoring of the fetched task
            // $filteredTaskCategoryList = $taskCategoryList->filter(function ($category) use ($id_monitoring) {
            //     return $category->id_monitoring == $id_monitoring; // Assuming id_monitoring links categories to tasks
            // });

            // // Prepare taskList with current progress
            // $taskList = $filteredTaskCategoryList->map(function ($category) use ($daftarTask) {
            //     $selected = ($daftarTask && $category->id_monitoring == $daftarTask->id_monitoring);
            //     $currentProgress = ($category->current_progress == 0 || $category->current_progress == 0.0 ? 0 : $category->current_progress);
            //     return [
            //         'value' => $category->id_monitoring,
            //         'text' => '(' . $currentProgress . '% left) ' . $category->category,
            //         'selected' => $selected,
            //         'current_progress' => $category->qty, // Assuming qty is the progress indicator
            //     ];
            // });

            // Prepare taskList with current progress without filtering by id_monitoring
            $taskList = $taskCategoryList->map(function ($category) use ($daftarTask) {
                $selected = ($daftarTask && $category->id_monitoring == $daftarTask->id_monitoring);
                $currentProgress = ($category->current_progress == 0 || $category->current_progress == 0.0 ? 0 : $category->current_progress);
                return [
                    'value' => $category->id_monitoring,
                    'text' => '(' . $currentProgress . '% left) ' . $category->category,
                    'selected' => $selected,
                    'current_progress' => $category->qty, // Assuming qty is the progress indicator
                ];
            });


            // Return queried data as a JSON response
            return response()->json([
                'id_task'               => $taskID,
                'task_worktime'         => $daftarTask->start_time_task,
                'task_description'      => $daftarTask->descb_task,
                'task_description_charcount' => strlen($daftarTask->descb_task),
                'task_currentprogress'  => $daftarTask->progress_current_task,
                'id_ws'                 => $daftarTask->id_ws,
                'id_project'            => $daftarTask->id_project,
                'taskList'              => $taskList,
                'arrivalTime'           => $daftarTask->worksheet->arrival_time_ws,
                'finishTime'            => $daftarTask->worksheet->finish_time_ws,

            ]);
        } else {
            // Handle the case when the DaftarTask_Model with the given taskID is not found
            return response()->json(['error' => 'DaftarTask_Model not found'], 404);
        }
    }



    public function edit_task(Request $request)
    {
        // dd($request->input('edit-ws_arrival_time'));
        $validator = Validator::make(
            $request->all(),
            [
                'edit-task_id'                  => 'sometimes|required',
                // 'edit-ws_finish_time'           => 'required',
                'edit-ws_arrival_time'          => 'required',
                'edit-task_work_time' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        $arrivalTime = Carbon::createFromFormat('H:i:s', $request->input('edit-ws_arrival_time'));
                        // $finishTime = Carbon::createFromFormat('H:i:s', $request->input('edit-ws_finish_time'));
                        $workTime = Carbon::createFromFormat('H:i:s', $value);

                        // Set the date part of workTime to match arrivalTime and finishTime
                        $workTime->setDate($arrivalTime->year, $arrivalTime->month, $arrivalTime->day);

                        // Add a tolerance of 12 hours only to the finish time
                        // $finishTimeWithTolerance = $finishTime->copy()->addHours(12);
                        $workTimeTimeWithTolerance = $workTime->copy()->addHours(12);

                        // // Compare the timestamps of workTime, arrivalTime, and finishTime with tolerance
                        // // if ($workTime->timestamp < $arrivalTime->timestamp || $workTime->timestamp > $finishTimeWithTolerance->timestamp) {
                        // if ($workTimeTimeWithTolerance->timestamp < $arrivalTime->timestamp) {
                        //     // $fail('The work time must be between work time and arrival time (tolerance +12h).');
                        //     $fail('The work time must be above arrival time!');
                        // }
                    },
                ],
                'edit-task_id_monitoring'       => 'sometimes|required',
                'edit-task_description'         => 'sometimes|required|min:20',
                'edit-task_current_progress'    => 'sometimes|required',
                'edit-ws_id_ws'                 => 'sometimes|required',
                'edit-ws_id_project'            => 'sometimes|required',
                'bsvalidationcheckbox1'         => 'required',
            ],
            [
                'edit-task_id.required'                 => 'The task-id field is not filled by system!.',
                // 'edit-ws_finish_time.required'          => 'The finish_time field is not filled by system!',
                'edit-ws_arrival_time.required'         => 'The arrival_time field is not filled by system!',
                'edit-task_work_time.required'          => 'The work_time field is required.',
                'edit-task_id_monitoring.required'      => 'The monitoring-id field is required.',
                'edit-task_description.required'        => 'The description field is required.',
                'edit-task_description.min'             => 'The description must be at least 20 characters.',
                'edit-task_current_progress.required'   => 'The current-progress field is required.',
                'edit-ws_id_ws.required'                => 'The worksheet-id field is not filled by system!.',
                'edit-ws_id_project.required'           => 'The project-id field is not filled by system!.',
                'bsvalidationcheckbox1.required'        => 'The saving agreement field is required.',
            ]
        );
        if ($validator->fails()) {
            $toast_message = $validator->errors()->all();
            Session::flash('errors', $toast_message);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Check worksheet expiry
        $isWorksheetExpired = DaftarWS_Model::where('id_ws', $request->input('ws-id_ws'))
            ->where('id_project', $request->input('ws-id_project'))
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereNotNull('expired_at_ws') // Check for non-null expired_at_ws
            ->where('expired_at_ws', '<', Carbon::now()) // Compare expired_at_ws with current datetime
            ->exists(); // Use exists() to determine if such a record exists

        // Check worksheet ws_status
        $isWorksheetLocked = DaftarWS_Model::where('id_ws', $request->input('ws-id_ws'))
            ->where('id_project', $request->input('ws-id_project'))
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->where('status_ws', "CLOSED") // Corrected comparison
            ->exists(); // Use exists() to determine if such a record exists

        if ($isWorksheetExpired) {
            $errorMessage = 'Err[400]: Sorry, you can\'t edit the task, because the worksheet is expired!';
            Session::flash('n_errors', [$errorMessage]);
            return redirect()->back();
        }
        if ($isWorksheetLocked) {
            $errorMessage = 'Err[400]: Sorry, you can\'t edit the task, because the worksheet is locked!';
            Session::flash('n_errors', [$errorMessage]);
            return redirect()->back();
        }

        $taskID = $request->input('edit-task_id');
        $daftarTask = DaftarTask_Model::where('id_task', $taskID)->first();
        if ($daftarTask) {
            // Retrieve the old progress before updating
            $oldProgress = $daftarTask->progress_current_task;
            // $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
            $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
                ->findOrFail($request->input('edit-ws_id_project'));

            // Assuming this code is within a method and $request is available
            $id_monitoring = $request->input('edit-task_id_monitoring');

            // dd($id_monitoring);

            $currentProgress = $request->input('edit-task_current_progress');

            // Step 1: Query to sum progress_current_task
            $totalProgress = DaftarTask_Model::where('id_monitoring', $id_monitoring)
                ->whereNull('deleted_at') // Exclude soft-deleted records
                ->whereHas('worksheet', function ($query) {
                    $query->whereNull('expired_at_ws'); // Only include if expired_at_ws is null
                })
                ->sum('progress_current_task'); // Sum the progress of the filtered tasks

            // Step 2: Add the current task's progress to the total
            $totalProgress += $currentProgress;

            // Step 3: Check if the total progress exceeds 100
            if ($totalProgress > 100) {
                $errorMessage = 'Err[400]: Sorry, you can\'t add a task with an exceeded progress number!';
                Session::flash('n_errors', [$errorMessage]);
                return redirect()->back();
            }

            $daftarTask->start_time_task = Carbon::createFromFormat('H:i:s', $request->input('edit-task_work_time'))->toTimeString();
            $daftarTask->descb_task = $request->input('edit-task_description');
            $daftarTask->progress_current_task = $request->input('edit-task_current_progress');
            $daftarTask->id_ws = $request->input('edit-ws_id_ws');
            $daftarTask->id_project = $request->input('edit-ws_id_project');
            $daftarTask->id_monitoring = $request->input('edit-task_id_monitoring');
            $daftarTask->save();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ['Task update successfully!']);
        } else {
            Session::flash('errors', ['Err[404]: Task update failed!']);
        }

        return redirect()->back();
    }


    public function checkSavedProgressValue($id_monitoring, $currentProgress)
    {
        // ///////// ILLUSTRATE LOCKED WS
        // Step 1: Query to sum progress_current_task
        $totalProgress = DaftarTask_Model::where('id_monitoring', $id_monitoring)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereHas('worksheet', function ($query) {
                $query->whereNull('expired_at_ws') // Only include if expired_at_ws is null
                    ->where('status_ws', 'CLOSED');
            })
            ->sum('progress_current_task'); // Sum the progress of the filtered tasks

        // Step 2: Add the current task's progress to the total
        $totalProgress += $currentProgress;
        return $totalProgress;
    }


    public function checkUnsavedProgressValue($id_monitoring, $currentProgress)
    {
        // ///////// ILLUSTRATE NOT LOCKED WS
        // Step 4: Query to sum progress_current_task
        $totalProgress = DaftarTask_Model::where('id_monitoring', $id_monitoring)
            ->whereNull('deleted_at') // Exclude soft-deleted records
            ->whereHas('worksheet', function ($query) {
                $query->whereNotNull('expired_at_ws') // Only include if expired_at_ws is null
                    ->where('status_ws', 'OPEN');
            })
            ->sum('progress_current_task'); // Sum the progress of the filtered tasks

        // Step 5: Add the current task's progress to the total
        $totalProgress += $currentProgress;
        return $totalProgress;
    }



    public function delete_task(Request $request)
    {
        $taskID = $request->input('del_task_id');
        $task = DaftarTask_Model::with('monitor', 'project')->where('id_task', $taskID)->first();

        if ($task) {
            $taskCategory = $task->monitor->category; // Store the monitor->category before deleting the task
            $taskTime = $task->start_time_task; // Store the monitor->category before deleting the task

            $task->delete();

            $user = auth()->user();
            $authenticated_user_data = $this->get_user_auth_data();
            Session::put('authenticated_user_data', $authenticated_user_data);

            Session::flash('success', ["Task deletion with work-time *$taskTime for task *$taskCategory was successful!"]);
        } else {
            $errorMessage = 'Err[404]: Task deletion was failed!';
            // if ($task && $task->monitor->category) {
            // $errorMessage = 'Err[404]: Task deletion with work-time *' . $task->start_time_task . 'for task *' . $task->monitor->category . ' was failed!';
            // }
            Session::flash('n_errors', [$errorMessage]);
        }

        return redirect()->back();
    }


    public function reset_task(Request $request)
    {
        DaftarTask_Model::query()->delete();
        DB::statement('ALTER TABLE tb_task AUTO_INCREMENT = 1');

        $user = auth()->user();
        $authenticated_user_data = $this->get_user_auth_data();
        Session::put('authenticated_user_data', $authenticated_user_data);

        Session::flash('success', ['All task data reset successfully!']);
        return redirect()->back();
    }


    // public function reset_task(Request $request)
    // {
    //     $taskWorkTime = $request->input('task-work_time');
    //     dd($taskWorkTime);
    //     if ($taskWorkTime) {
    //         DaftarTask_Model::where('start_time_task', $taskWorkTime)->delete();
    //         DB::statement('ALTER TABLE tb_task AUTO_INCREMENT = 1');

    //         $user = auth()->user();
    //         $authenticated_user_data = $this->get_user_auth_data();
    //         Session::put('authenticated_user_data', $authenticated_user_data);

    //         Session::flash('success', ['All task data reset successfully!']);
    //     }
    //     return redirect()->back();
    // }

    // public function print_task(Request $request)
    // {

    //     $projectID = $request->input('print-prj_id');
    //     $wsID = $request->input('print-ws_id');
    //     $wsDate = Carbon::parse($request->input('print-ws_date'));

    //     $process = $this->setPageSession("Print Daily Worksheet", "m-worksheet");
    //     if ($process) {
    //         // $loadData
    //         $loadDataWS = DaftarWS_Model::with([
    //             'project',
    //             'project.client',
    //             'task' => function ($query) use ($projectID) {
    //                 $query->where('id_project', $projectID);
    //             }
    //         ])->where('id_ws', $wsID)
    //             ->whereDate('working_date_ws', $wsDate)
    //             ->first();

    //         // Get monitoring records for the tasks of the worksheet
    //         $loadDataWS->task->flatMap(function ($task) {
    //             return $task->monitor; // Assuming monitor returns a single Monitoring_Model instance
    //         });

    //         // // Dump the result
    //         // dd($loadDataWS->toArray());




    //         // $loadRelatedDailyWS = DaftarWS_Model::with('karyawan', 'project', 'monitoring')->where('id_project', $projectID)->first();

    //         $user = auth()->user();
    //         $authenticated_user_data = $this->get_user_auth_data();

    //         $modalData = ['modal_edit' => '#edit_taskModal', 'modal_delete' => '#delete_taskModal', 'modal_reset' => '#reset_taskModal'];
    //         if ($loadDataWS->status_ws === 'OPEN') {
    //             $modalData['modal_add'] = '#add_taskModal';
    //         }


    //         $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
    //         $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
    //             ->where('id_project', $projectID)
    //             ->first();



    //         $data = [
    //             'breadcrumbs' => $this->getBreadcrumb($request->route()->getName()),
    //             'currentRouteName' => Route::currentRouteName(),
    //             // 'loadDaftarWorksheetFromDB' => $loadDaftarWorksheetFromDB,
    //             'modalData' => $modalData,
    //             'loadDataWS' => $loadDataWS,
    //             // 'loadRelatedDailyWS' => $loadRelatedDailyWS,
    //             'employee_list' => Karyawan_Model::withoutTrashed()->get(),
    //             'taskCategoryList' => Monitoring_Model::where('id_project', $projectID)->withoutTrashed()->get(),
    //             'prjmondws' => $project,
    //             'authenticated_user_data' => $authenticated_user_data,
    //         ];
    //         return $this->setReturnView('pages/userpanels/pm_daftartaskws', $data);
    //     }



    //     // $relatedView = 'pages/userpanels/pm_printtaskws';
    //     // return $this->generatePDF($request, $relatedView);
    // }


    public function print_task(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->back();
        } elseif ($request->isMethod('post')) {
            return $this->export_task($request, 'print');
        }
    }

    public function save_task(Request $request)
    {
        return $this->export_task($request, 'pdf');
    }


    // Modify the print_task method to use DOMPDF
    public function export_task($request, $ref)
    {
        $projectID = $request->input('print-prj_id');
        $wsID = $request->input('print-ws_id');
        $wsDate = Carbon::parse($request->input('print-ws_date'));
        $printAct = $request->input('print-act');

        // Load worksheet with necessary relationships
        $loadDataWS = DaftarWS_Model::with([
            'project',
            'project.client',
            'karyawan',
            'task' => function ($query) use ($projectID) {
                $query->where('id_project', $projectID);
            }
        ])
            ->where('id_ws', $wsID)
            ->whereDate('working_date_ws', $wsDate)
            ->first();
        // Get monitoring records for the tasks of the worksheet
        $loadDataWS->task->flatMap(function ($task) {
            return $task->monitor;
        });


        if (!$loadDataWS) {
            return back()->with('n_error', 'Worksheet not found');
        }

        if ($printAct == 'dom') {
            if ($ref == 'print') {
                return $this->returnDOMPDF_ver2($loadDataWS, $wsID, $projectID, $ref, $request);
            } else if ($ref == 'pdf') {
                return $this->returnDOMPDF_ver2($loadDataWS, $wsID, $projectID, $ref, $request);
            } else {
                return $this->returnDOMPDF_ver2($loadDataWS, $wsID, $projectID, 'view', $request);
            }
        } else {
            return $this->returnNormalView($loadDataWS, $projectID, 'pure');
        }
    }



    function cmToMm($cm)
    {
        return $cm * 10; // 1 cm = 10 mm
    }

    private function returnDOMPDF_ver2($worksheet, $wsID, $projectID, $mode = 'print', $request)
    {
        // $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
        $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
            ->where('id_project', $projectID)
            ->first();

        if (!$project) {
            abort(404, 'Project not found.'); // Or handle the error differently
        }

        // $margin_top = $this->cmToMm(1.5);
        // $margin_right = $this->cmToMm(1.5);
        // $margin_bottom = $this->cmToMm(1.5);
        // $margin_left = $this->cmToMm(1.5);
        // // $baseHeight = 223; // <---- Default 272; 228; 185; 223; for actual print
        $margin_top = $this->cmToMm($request->input('task-print-mt'));
        $margin_right = $this->cmToMm($request->input('task-print-mr'));
        $margin_bottom = $this->cmToMm($request->input('task-print-mb'));
        $margin_left = $this->cmToMm($request->input('task-print-ml'));

        $eachtaskChunk = $request->input('task-print-ep');
        $tbody_height = $request->input('task-print-tbh');
        // dd($tbody_height);

        // Get the tasks from the worksheet
        $tasks = $worksheet->task; // Assuming $worksheet->task contains the tasks
        // Split tasks into chunks of nx
        $taskChunks = array_chunk($tasks->toArray(), $eachtaskChunk); // Convert to array if it's a collection
        if ($mode == 'print' || $mode == 'pdf') {
            // Render the view as a string (HTML)
            $html = view('pages.userpanels.pm_printtaskws_dompdfview_v2', [
                'project' => $project,
                'title' => $worksheet->project->id_project . " - Daily Worksheet",
                'loadDataWS' => $worksheet,
                'taskChunks' => $taskChunks, // Pass the chunks of tasks to the view
                'eachtaskChunk' => $eachtaskChunk,
                'margin_top' => $margin_top,
                'margin_right' => $margin_right,
                'margin_bottom' => $margin_bottom,
                'margin_left' => $margin_left,
                'baseHeight' => $tbody_height
            ])->render();

            // Generate PDF from the HTML string
            $pdf = PDF::loadHTML($html);
            // Optional: Configure PDF settings
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isJavascriptEnabled' => false,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
                'margin_top' => $margin_top,
                'margin_right' => $margin_right,
                'margin_bottom' => $margin_bottom,
                'margin_left' => $margin_left,
                'dpi' => 60,
                'isFontSubsettingEnabled' => true,
                'debugPng' => false,
                'debugKeepTemp' => false,
                'debugFontSize' => 0,
                'debugKeepTemp' => false,
                'debugKern' => false,
                'debugFontDir' => false,
                'debugCss' => false,
            ]);

            $workingDateTime = Carbon::parse($worksheet->working_date_ws)->format('d.m.Y H.i.s');
            $filename = "{$project->id_project} - Daily Worksheet({$wsID}) - {$workingDateTime}";
            if ($mode == 'print') {
                return $pdf->stream("{$filename}.pdf");   // Return the PDF for streaming
            } else {
                return $pdf->download("{$filename}.pdf"); // Return the PDF for download
            }
        } else {
            return view('pages.userpanels.pm_printtaskws_dompdfview_v2', [
                'project' => $project,
                'title' => "Daily Worksheet - " . $worksheet->project->id_project,
                'loadDataWS' => $worksheet,
                'taskChunks' => $taskChunks, // Pass the chunks of tasks to the view
                'eachtaskChunk' => $eachtaskChunk,
                'margin_top' => $margin_top,
                'margin_right' => $margin_right,
                'margin_bottom' => $margin_bottom,
                'margin_left' => $margin_left,
                'baseHeight' => $tbody_height
            ]);
        }
    }




    private function returnNormalView($worksheet, $projectID, $pure = false)
    {
        // $project = Projects_Model::with(['client', 'pcoordinator', 'team', 'monitor', 'task', 'worksheet'])
        $project = Projects_Model::with(['prjteams.team.karyawans', 'coordinators.karyawan', 'client', 'worksheet', 'monitor'])
            ->where('id_project', $projectID)
            ->first();
        // Return a view instead of generating a PDF
        if ($pure) {
            return view('pages.userpanels.pm_printtaskws_pureview', [
                'project' => $project,
                'margin_top' => '1cm',
                'margin_left' => '5cm',
                'margin_bottom' => '1cm',
                'margin_right' => '1cm',
                'title' => "Daily Worksheet - " . $worksheet->project->id_project,
                'loadDataWS' => $worksheet
            ]);
        } else {
            return view('pages.userpanels.pm_printtaskws', [
                'project' => $project,
                'title' => "Daily Worksheet - " . $worksheet->project->id_project,
                'loadDataWS' => $worksheet
            ]);
        }
    }
}
