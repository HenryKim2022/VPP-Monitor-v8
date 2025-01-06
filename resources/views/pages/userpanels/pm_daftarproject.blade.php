@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = 'DD MMM YYYY';
    $cust_time_format = 'hh:mm:ss A';
    $reset_btn = false;
    // $authenticated_user_data = Session::get('authenticated_user_data');
    // dd($authenticated_user_data);
@endphp

@extends('layouts.userpanels.v_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
    {{-- @if (auth()->user()->type == 'Superuser' || auth()->user()->type == 'Supervisor')
        <h1>HI MIN :)</h1>
    @endif

    @if (auth()->user()->type == 'Engineer')
        <h1>HI WAN :)</h1>
    @endif --}}

    {{-- {{ dd($authenticated_user_data) }} --}}


    <!-- BEGIN: PhpLogicsBundle --> @include('v_res.php_logics.date_time_converter') <!-- END: PhpLogicsBundle -->
    @php
        $authUserId = null;
        $authUserType = auth()->user()->type;

        if ($authenticated_user_data) {
            $authUserId = $authenticated_user_data->id_karyawan
                ? $authenticated_user_data->id_karyawan
                : ($authenticated_user_data->id_client
                    ? $authenticated_user_data->id_client
                    : null);
        }
    @endphp






    <div class="row match-height">
        <!-- QRCodeCheck-out Card -->
        <div class="col-lg-4 col-md-6 col-12">
        </div>
        <!--/ QRCodeCheck-out Card -->


        {{-- <!--  Check $data as array -->
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <pre style="color: white">{{ print_r($project->toArray(), true) }}</pre>
                     <!--  <pre>{{ print_r($project[0]['prjteams']->toArray(), true) }}</pre> -->

                    <br>
                </div>
            </div>
        </div> --}}



        <!-- TableAbsen Card -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card card-developer-meetup">

                <div class="card-body p-1">

                    <div class="row match-height KOP-1">
                        <!-- Left Card 1st -->
                        <div class="col-xl-12 col-md-12 col-12 d-flex align-items-center logo_eng_text px-0">
                            <div class="card mb-0 w-100">
                                <div class="card-body pt-0">
                                    <!-- Column 3: Engineer Text -->
                                    {{-- <div class="col text-end col-xl-3 col-md-6 col-12 d-flex align-items-top"> --}}
                                    <span class="btn btn-primary auth-role-eng-text">
                                        <a class="mt-0 mb-0 cursor-default text-end">
                                            @if ($authUserType === 'Client')
                                                CLI
                                            @else
                                                SPV/ ENG
                                            @endif
                                        </a>
                                    </span>
                                    {{-- </div> --}}
                                    <div class="row w-100 justify-content-between">
                                        <!-- Column 1: Brand Logo -->
                                        <div
                                            class="col text-start brand-logo col-xl-2 col-md-2 col-sm-1 d-flex align-items-center">
                                            <span class="brand-logo">
                                                <img src="{{ asset('public/assets/logo/dws_header_vplogo.svg') }}"
                                                    class="img-fluid max-width-sm max-width-md max-width-lg" alt="VPLogo">
                                            </span>
                                        </div>

                                        <!-- Column 2: Project Title -->
                                        <div
                                            class="col text-center col-xl-8 col-md-5 col-12 pl-3 d-flex align-items-center justify-content-center">
                                            <span>
                                                <strong>
                                                    <h3 class="mt-0 mb-0 underline-text pt-2 h3-dark">PROJECT LISTS</h3>
                                                </strong>
                                                <i class="fas"></i>
                                            </span>
                                        </div>

                                        <!-- Column 3: Engineer Text -->
                                        <div class="col text-end col-xl-2 col-md-2 col-12 d-flex align-items-top">
                                            <span class="btn auth-role-eng-text">
                                                {{-- <a class="mt-0 mb-0 cursor-default text-end">ENGINEER</a> --}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--/ Right Card 2nd -->
                    </div>



                    <div class="row match-height mb-0 px-1 DIVI-1">
                        <div class="divider-container">
                            <div class="divider"></div> <!-- Divider line -->
                            <div class="button-wrapper">
                                <div class="nav-item"></div>
                                <div class="nav-item">
                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                        @if ($modalData['modal_add'])
                                            <button {{-- onclick="openModal('{{ $modalData['modal_add'] }}')" --}}
                                                class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white add-new-record"
                                                style="width: fit-content; height: 3rem; padding: 0.5rem;">
                                                <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                <div class="nav-item"></div>
                            </div>
                        </div>
                    </div>


                    <div class="TABLE-1 overflow-x-scroll dis-overflow-y-hidden">
                        {{-- @dd(auth()->user()->toArray()) --}}
                        <table id="daftarProjectTable" class="table table-fixed table-striped">
                            <thead>
                                <tr>
                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                        <th class="cell-fit">Act</th>
                                    @endif
                                    <th class="cell-fit text-nowrap">Project-No</th>
                                    <th class="text-nowrap">Project Name</th>
                                    <th class="">Customer</th>
                                    <th class="cell-fit text-nowrap">Project Co</th>
                                    <th class="">Team</th>
                                    <th class="">Status</th>
                                    <th class="">Timeline</th>
                                    {{-- <th class="">Deadline</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{dd($project->toArray());}} --}}


                                @foreach ($project as $project)
                                    @php
                                        // Team Check based-on id_karyawan
                                        $auth_emp_id = auth()->user()->id_karyawan;
                                        $prj_cos = [];
                                        $team_emps = [];
                                    @endphp


                                    @php
                                        $totalActual = 0;
                                        $ongoing = $project->prjstatus_beta() == 'ONGOING' ? true : false;

                                        $currentDateTime = \Carbon\Carbon::now();
                                        $expiredAt = \Carbon\Carbon::parse($project->deadline_project);
                                        $expiredAt = $expiredAt->copy()->addDay();
                                        $isExpired = $expiredAt < $currentDateTime;
                                    @endphp

                                    @php
                                        $team_emps = [];
                                        // dd($project['prjteams']->toArray());
                                        foreach ($project['prjteams'] as $prj_team) {
                                            if (isset($prj_team['team']['karyawans'])) {
                                                foreach ($prj_team['team']['karyawans'] as $karyawan) {
                                                    $team_emps[] = (int) $karyawan['id_karyawan'];
                                                }
                                            }
                                        }
                                        // Check if the authenticated employee ID is in the team_emps array
                                        $isEmployeeInTeam = in_array($auth_emp_id, $team_emps);
                                    @endphp



                                    @php
                                        // dd($project['coordinators']->toarray());
                                        foreach ($project['coordinators'] as $co) {
                                            if (isset($co['karyawan'])) {
                                                $prj_cos[] = (int) $co['karyawan']['id_karyawan'];
                                            }
                                        }
                                        $isCoInPrj = in_array($auth_emp_id, $prj_cos);
                                    @endphp

                                    @if ($project->monitor->isNotEmpty())
                                        {{-- @foreach ($project->monitor as $monitor)
                                            @php
                                                $total = 0; // Initialize total for this monitoring entry
                                            @endphp
                                            @if ($monitor->qty)
                                                @php
                                                    $qty = $monitor->qty;
                                                    // Find the tasks related to the current monitor where the associated worksheet's expired_ws is null
                                                    $relatedTasks = collect($project->task)->filter(function (
                                                        $task,
                                                    ) use ($monitor, $project) {
                                                        // Find the related worksheet for the task
                                                        $worksheet = collect($project->worksheet)->firstWhere(
                                                            'id_ws',
                                                            $task['id_ws'],
                                                        );
                                                        // Check if the task's worksheet expired_ws is null
                                                        return $task['id_monitoring'] === $monitor->id_monitoring &&
                                                            ($worksheet['expired_at_ws'] ?? null) === null; // Match tasks by id_monitoring and check expired_ws
                                                    });

                                                    // Calculate the total progress from related tasks
                                                    $totalProgress = 0;
                                                    foreach ($relatedTasks as $task) {
                                                        $totalProgress += $task['progress_current_task']; // Sum up the progress of related tasks
                                                    }

                                                    // Calculate average progress
                                                    $up =
                                                        $relatedTasks->count() > 0
                                                            ? $totalProgress / $relatedTasks->count()
                                                            : 0; // Average progress
                                                    $total = ($qty * $up) / 100; // Calculate total percentage
                                                    $totalActual += $total; // Accumulate to totalActual
                                                @endphp
                                            @else
                                                @php
                                                    $total = 0; // No quantity, total remains 0
                                                @endphp
                                            @endif
                                        @endforeach --}}


                                        @foreach ($project->monitor as $mon)
                                            @php
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
                                                // $tbodyTotalActual += $total;
                                            @endphp
                                        @endforeach
                                    @endif

                                    @php
                                        // $isCondFullfilled = $ongoing && $isExpired && $totalActual < 100 ? true : false;
                                        $isCondFullfilled = $isExpired ? true : false;
                                    @endphp



                                    <tr class="{{ $isCondFullfilled ? 'expired' : '' }}"
                                        project_id_value="{{ $project->id_project }}">

                                        @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                            <td class="cell-fit text-center align-middle">
                                                <input type="hidden" class="project-id" name="{{ $project->id_project }}"
                                                    id="{{ $project->id_project }}" value="{{ $project->id_project }}">
                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                    <button class="btn btn-icon navbar-toggler p-0" type="button"
                                                        id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                                    </button>
                                                    <!-- dropdown menu -->
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="tableActionDropdown">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            @php
                                                                $border1Ref = '';
                                                                $meRef = 'me-3';
                                                                if (
                                                                    (!count($project->coordinators) > 0 &&
                                                                        !count($project->prjteams) > 0) ||
                                                                    !count($project->coordinators) > 0 ||
                                                                    !count($project->prjteams) > 0
                                                                ) {
                                                                    $meRef = '';
                                                                }
                                                                if (
                                                                    $authUserType === 'Superuser' ||
                                                                    $authUserType === 'Supervisor'
                                                                ) {
                                                                    $border1Ref =
                                                                        'border-right: 2px solid #7367f0 !important';
                                                                }
                                                            @endphp

                                                            <div class="{{ $meRef }} w-100"
                                                                style="{{ $border1Ref }}">
                                                                {{-- @if ($isCoInPrj || $isEmployeeInTeam) --}}
                                                                @if (count($project->coordinators) > 0 && count($project->prjteams) > 0)
                                                                    <a class="open-project-mw dropdown-item d-flex align-items-center"
                                                                        project_id_value="{{ $project->id_project }}"
                                                                        client_id_value="{{ $project->client !== null ? $project->client->id_client : 0 }}"
                                                                        href="{{ route('m.projects.getprjmondws') . '?projectID=' . $project->id_project }}">
                                                                        <i data-feather="navigation" class="mr-1"
                                                                            style="color: #288cc7;"></i>
                                                                        Navigate
                                                                    </a>
                                                                @endif
                                                                {{-- @endif --}}
                                                                {{-- @if ($authUserType === 'Superuser' || auth()->user()->id_karyawan == $project->karyawan->id_karyawan) --}}
                                                                @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                                    <a class="edit-record dropdown-item d-flex align-items-center"
                                                                        project_id_value="{{ $project->id_project }}"
                                                                        karyawan_id_value="{{ $project->karyawan !== null ? $project->karyawan->id_karyawan : 0 }}"
                                                                        client_id_value="{{ $project->client !== null ? $project->client->id_client : 0 }}">
                                                                        <i data-feather="edit" class="mr-1"
                                                                            style="color: #28c76f;"></i>
                                                                        Edit
                                                                    </a>
                                                                    <a class="delete-record dropdown-item d-flex align-items-center"
                                                                        project_id_value="{{ $project->id_project }}"
                                                                        onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                                        <i data-feather="trash" class="mr-1"
                                                                            style="color: #ea5455;"></i>
                                                                        Delete
                                                                    </a>
                                                                @endif
                                                                @if ($authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                                    <div class="text-center align-middle">
                                                                        @if (!count($project->coordinators) > 0 && !count($project->prjteams) > 0)
                                                                            Fill Project Co<br>&<br>Team!
                                                                        @else
                                                                            @if (!count($project->coordinators) > 0)
                                                                                Fill Project Co!
                                                                            @elseif (!count($project->prjteams) > 0)
                                                                                Fill Project Team!
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                @endif

                                                            </div>
                                                            <!-- Separator Line -->
                                                            {{-- @if ($authUserType === 'Superuser' || auth()->user()->id_karyawan == $project->karyawan->id_karyawan) --}}
                                                            @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                                <div class="text-center">
                                                                    <div class="dropdown-header">Show to Client?</div>
                                                                    <div class="d-flex justify-content-center">
                                                                        <div class="custom-control custom-radio me-2">
                                                                            <input type="radio"
                                                                                id="show_to_client_yes_{{ $project->id_project }}"
                                                                                name="show_to_client_{{ $project->id_project }}"
                                                                                value="1" class="custom-control-input"
                                                                                {{ $project->show_to_client ? 'checked' : '' }}>
                                                                            <label class="custom-control-label"
                                                                                for="show_to_client_yes_{{ $project->id_project }}">Yes</label>
                                                                        </div>
                                                                        <div class="custom-control custom-radio">
                                                                            <input type="radio"
                                                                                id="show_to_client_no_{{ $project->id_project }}"
                                                                                name="show_to_client_{{ $project->id_project }}"
                                                                                value="0"
                                                                                class="custom-control-input"
                                                                                {{ !$project->show_to_client ? 'checked' : '' }}>
                                                                            <label class="custom-control-label"
                                                                                for="show_to_client_no_{{ $project->id_project }}">No</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!--/ dropdown menu -->
                                                </div>
                                            </td>
                                        @endif

                                        <td class="text-center align-middle font-weight-bolder">
                                            @if (count($project->coordinators) > 0 && count($project->prjteams) > 0)
                                                @if ($project->id_project)
                                                    <div data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom" data-original-title="Click to navigate!"
                                                        class="pull-up">
                                                        <a class="open-project-mw {{ $isCondFullfilled ? 'text-white' : '' }}"
                                                            project_id_value="{{ $project->id_project }}"
                                                            href="{{ route('m.projects.getprjmondws') . '?projectID=' . $project->id_project }}">
                                                            {{ $project->id_project ?: '-' }}
                                                        </a>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            @else
                                                @if ($authUserType != 'Client')
                                                    @if ($project->id_project)
                                                        <div data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="{{ !count($project->coordinators) > 0 && !count($project->prjteams) > 0 ? 'Fill Project Co & Team!' : (!count($project->coordinators) > 0 ? 'Fill Project Co!' : (!count($project->prjteams) > 0 ? 'Fill Project Team!' : 'Click to navigate!')) }}"
                                                            class="pull-up">
                                                            <a class="open-project-mw {{ $isCondFullfilled ? 'text-white' : '' }}"
                                                                project_id_value="{{ $project->id_project }}">
                                                                {{ $project->id_project ?: '-' }}
                                                            </a>
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    @if ($project->id_project)
                                                        <div data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="{{ !count($project->coordinators) > 0 && !count($project->prjteams) > 0 ? 'Pending...' : (!count($project->coordinators) > 0 ? 'Pending...' : (!count($project->prjteams) > 0 ? 'Pending...' : 'Click to navigate!')) }}"
                                                            class="pull-up">
                                                            <a class="open-project-mw {{ $isCondFullfilled ? 'text-white' : '' }}"
                                                                project_id_value="{{ $project->id_project }}">
                                                                {{ $project->id_project ?: '-' }}
                                                            </a>
                                                        </div>
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            @endif
                                            {{--
                                                <br>
                                            @if ($isEmployeeInTeam)
                                                <p>You are ({{ $auth_emp_id }}) part of the team for this project.</p>
                                            @else
                                                <p>You are ({{ $auth_emp_id }}) not part of the team for this project.</p>
                                            @endif
                                            <br>
                                            @if ($isCoInPrj)
                                                <p>You are ({{ $auth_emp_id }}) Coordinator of the team for this project.
                                                </p>
                                            @else
                                                <p>You are ({{ $auth_emp_id }}) not Coordinator of the team for this
                                                    project.</p>
                                            @endif --}}

                                        </td>
                                        <td class="txt-wrap {{ $isCondFullfilled ? 'text-white' : '' }}">
                                            {{ $project->na_project ?: '-' }}</td>
                                        <td class="txt-wrap {{ $isCondFullfilled ? 'text-white' : '' }}">
                                            {{ $project->client !== null ? $project->client->na_client : '-' }}</td>
                                        <td class="{{ $isCondFullfilled ? 'text-white' : '' }} text-center align-middle">
                                            @php
                                                $coordinatorNames = [];
                                                foreach ($project->coordinators as $index => $co) {
                                                    $coordinatorNames[] =
                                                        $co->karyawan !== null ? $co->karyawan->na_karyawan : '-';
                                                }
                                                if (empty($coordinatorNames)) {
                                                    $coordinatorNames = ['-'];
                                                }
                                            @endphp
                                            {{ implode(', ', $coordinatorNames) }}
                                        </td>
                                        <td
                                            class="cell-fit text-center align-middle {{ $isCondFullfilled ? 'text-white' : '' }}">
                                            @php
                                                $teamName = [];
                                                $teamInfo = '';
                                                if (!empty($project['prjteams']) && $project['prjteams']) {
                                                    foreach ($project['prjteams'] as $prjteam) {
                                                        $teamInfo .=
                                                            "<span class='bg-primary rounded' style='padding: 0.01rem;'>" .
                                                            $prjteam['team']['na_team'] .
                                                            '</span>:<br>';
                                                        $karyawansArray = $prjteam['team']['karyawans']->toArray();
                                                        $teamInfo .= implode(
                                                            ', ',
                                                            array_column($karyawansArray, 'na_karyawan'),
                                                        );
                                                        $teamInfo .= '<br>';
                                                        $teamName[] = $prjteam['team']['na_team'];
                                                    }
                                                } else {
                                                    $teamInfo = 'No team information available';
                                                }
                                            @endphp
                                            @if ($teamName)
                                                <div data-toggle="tooltip" data-placement="left" data-html="true"
                                                    class="pull-up" data-original-title="{!! '<div class=\'text-left\'>' . $teamInfo . '</div>' !!}">
                                                    {{ implode(', ', $teamName) }}
                                                </div>
                                            @else
                                                <div>
                                                    -
                                                </div>
                                            @endif

                                        </td>
                                        <td
                                            class="cell-fit text-center align-middle {{ $isCondFullfilled ? 'text-white' : '' }}">
                                            @php
                                                $isProjectLocked = false;
                                                if ($project->closed_at_project !== null) {
                                                    $isProjectLocked = true;
                                                }
                                            @endphp
                                            @if ($project->monitor->isNotEmpty())
                                                @if ($project->prjstatus_beta() == 'FINISH' || $totalActual == 100)
                                                    <span class="bg-success text-white rounded small"
                                                        style="padding: 0.5rem">
                                                        <i
                                                            class="fas {{ $isProjectLocked == true ? 'fa-lock ' : 'fa-check-circle ' }}me-1 fa-md"></i>
                                                        {{ number_format($totalActual, 0) }}%
                                                    </span>
                                                @elseif ($project->prjstatus_beta() == 'FINISH' || $totalActual > 100)
                                                    <span class="bg-danger text-white rounded small"
                                                        style="padding: 0.5rem">
                                                        <i
                                                            class="far {{ $isProjectLocked == true ? 'fa-lock ' : 'fa-engine-warning ' }}me-1 fa-md"></i>
                                                        {{ number_format($totalActual, 0) }}%
                                                    </span>
                                                @else
                                                    <span class="bg-warning text-white rounded small"
                                                        style="padding: 0.5rem">
                                                        <i
                                                            class="fas {{ $isProjectLocked == true ? 'fa-lock ' : 'fa-hourglass-half ' }}me-1 fa-md"></i>
                                                        {{ number_format($totalActual, 0) }}%
                                                    </span>
                                                @endif
                                            @else
                                                @if ($project->prjstatus_beta() != 'FINISH' || $totalActual == 0)
                                                    <span class="bg-warning text-white rounded small"
                                                        style="padding: 0.5rem">
                                                        <i
                                                            class="fas {{ $isProjectLocked == true ? 'fa-lock ' : 'fa-hourglass-half ' }}me-1 fa-md"></i>
                                                        0%
                                                    </span>
                                                @endif
                                            @endif
                                        </td>



                                        <td
                                            class="cell-fit txt-wrap text-center align-middle {{ $isCondFullfilled ? 'text-white' : '' }}">
                                            @php
                                                $startDate = convertDateOnly($project->start_project);
                                                $endDate = convertDateOnly($project->deadline_project);
                                            @endphp
                                            {{ $startDate . ' s/d ' . $endDate }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
        <!--/ TableAbsen Card -->



    </div>






    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
        <!-- BEGIN: AddPrjModal--> @include('v_res.m_modals.userpanels.m_daftarproject.v_add_prjModal') <!-- END: AddPrjModal-->
        <!-- BEGIN: EditPrjModal--> @include('v_res.m_modals.userpanels.m_daftarproject.v_edit_prjModal') <!-- END: EditPrjModal-->
        <!-- BEGIN: DelPrjModal--> @include('v_res.m_modals.userpanels.m_daftarproject.v_del_prjModal') <!-- END: DelPrjModal-->
        @if ($reset_btn)
            <!-- BEGIN: ResetPrjModal--> @include('v_res.m_modals.userpanels.m_daftarproject.v_reset_prjModal') <!-- END: ResetPrjModal-->
        @endif
    @endif
@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

    <script>
        $(document).ready(function() {
            var lengthMenu = [10, 50, 100, 500, 1000, 2000, 3000]; // Length menu options

            var $table = $('#daftarProjectTable').DataTable({
                lengthMenu: lengthMenu,
                pageLength: 100,
                responsive: false,
                ordering: true,
                searching: true,
                language: {
                    lengthMenu: 'Display _MENU_ records per page',
                    info: 'Showing page _PAGE_ of _PAGES_',
                    search: 'Search',
                    // paginate: {
                    //     first: 'First',
                    //     last: 'Last',
                    //     next: '&rarr;',
                    //     previous: '&larr;'
                    // }
                },
                scrollCollapse: true,
                dom: '<"card-header border-bottom p-1"<"head-label"><"d-flex justify-content-between align-items-center"<"dt-search-field"f>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                columnDefs: [{ // Set the initial column visibility
                    targets: [], // Specify the columns to hide
                    visible: false // Set visibility to false
                }],
                initComplete: function() {
                    // // $(this.api().column([0]).header()).addClass('cell-fit text-center align-middle');
                    // // $(this.api().column([5]).header()).addClass('cell-fit text-center align-middle');
                    // // $(this.api().column([6]).header()).addClass('cell-fit text-center align-middle');
                    // // $(this.api().column([7]).header()).addClass('cell-fit text-center align-middle');
                    // // $(this.api().column([8]).header()).addClass('cell-fit text-center align-middle');

                    // $('#daftarProjectTable th:contains("No")').css('width', '3% !important');
                    // $('#daftarProjectTable th:contains("Project-No")').css('width', '2% !important');
                    // $('#daftarProjectTable th:contains("Project Name")').css('width', '2% !important');
                    // $('#daftarProjectTable th:contains("Customer")').css('width', '5% !important');
                    // $('#daftarProjectTable th:contains("Project CO")').css('width', '5% !important');
                    // $('#daftarProjectTable th:contains("Team")').css('width', '5% !important');
                    // $('#daftarProjectTable th:contains("Status")').css('width', '2% !important');

                    var api = this.api();
                    var columnHeaders = [{
                            header: "Act",
                            width: "25px"
                        },
                        {
                            header: "Project-No",
                            width: "120px"
                        },
                        {
                            header: "Project Name",
                            width: "200px"
                        },
                        {
                            header: "Customer",
                            width: "150px"
                        },
                        {
                            header: "Project Co",
                            width: "150px"
                        },
                        {
                            header: "Team",
                            width: "68px"
                        },
                        {
                            header: "Status",
                            width: "58px"
                        },
                        {
                            header: "Start",
                            width: "100px"
                        },
                        {
                            header: "Timeline",
                            width: "100px"
                        }
                    ];

                    columnHeaders.forEach(function(col) {
                        var index = api.columns().indexes().filter(function(i) {
                            return $(api.column(i).header()).text().trim() === col
                                .header;
                        })[0];

                        if (index !== undefined) {
                            $(api.column(index).header()).css('width', col.width).addClass(
                                'cell-fit text-center align-middle');
                            // Apply the .txt-wrap class to the cells in this column
                            api.column(index).nodes().each(function(cell) {
                                $(cell).addClass('txt-wrap');
                            });
                        }
                    });

                    var pageInfo = this.api().page.info();
                    $('#lengthMenu').val(pageInfo.length); // Updated ID
                },
                drawCallback: function() {
                    var pageInfo = this.api().page.info();
                    $('#lengthMenu').val(pageInfo.length); // Updated ID
                },
            });


            // Create a dropdown button with nested actions
            var dropdownButton = `
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle mx-0 px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-table fa-xs"></i>
                    </button>
                    <div class="dropdown-menu p-1" style="z-index: 1052; max-height: 300px; overflow-y: auto; overflow-x: auto;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="dropdown-item">
                                <label for="lengthMenu" class="my-0">Records per page:</label>
                                <select class="select2 form-control form-select-sm" id="lengthMenu" name="lengthMenu" aria-label="Select page length">
                                    ${lengthMenu.map(function(length) {
                                        return `<option value="${length}">${length}</option>`;
                                    }).join('')}
                                </select>
                            </div>
                            <div class="dropdown-item colvis-container">
                                <label>Column Visibility:</label>
                                <div class="colvis-options my-0"></div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-item d-flex justify-content-center align-content-center">Project Lists</span>
                    </div>
                </div>
            `;

            // Wrap the dropdown button and search field in a scrollable container
            $('.head-label').prepend(`
                <div class="dropdown-search-container">
                    ${dropdownButton}
                    <div class="dt-search-field"></div>
                </div>
            `);

            // Handle length change
            $('.dropdown-item select').on('change', function() {
                var newLength = $(this).val();
                $table.page.len(newLength).draw(); // Set new page length and redraw
            });

            // Generate dynamic column visibility options
            var columnCount = $table.columns().count();
            for (var i = 0; i < columnCount; i++) {
                var column = $table.column(i);
                var columnVisible = column.visible();
                var checkbox = `
                    <label>
                        <input type="checkbox" class="colvis-checkbox" data-column="${i}" ${columnVisible ? 'checked' : ''}> ${column.header().textContent}
                    </label><br>
                `;
                $('.colvis-options').append(checkbox);
            }

            // Handle column visibility toggle
            $('.colvis-options').on('change', '.colvis-checkbox', function() {
                var column = $(this).data('column');
                var isVisible = $(this).is(':checked');
                $table.column(column).visible(isVisible); // Toggle column visibility
            });

            // Prevent dropdown from closing when interacting with select field or column visibility options
            $(document).on('click', '.dropdown-item select, .dropdown-item a, .colvis-checkbox', function(event) {
                event.stopPropagation(); // Prevent the dropdown from closing
            });

            $table.draw();

        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                $('.open-project-mw').on('click', function() {
                    var projectID = $(this).attr('project_id_value');
                    console.log("Navigate to Project-ID: " + projectID);
                });
            }, 200);
        });
    </script>


    @if ($authUserType != 'Client')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalId = 'edit_projectModal';
                const modalSelector = document.getElementById(modalId);
                const modalToShow = new bootstrap.Modal(modalSelector);
                const targetedModalForm = document.querySelector('#' + modalId + ' #edit_projectModalFORM');

                $(document).on('click', '.edit-record', function(event) {
                    var prjID = $(this).attr('project_id_value');
                    var prjName = $(this).attr('project_id_value');
                    var clientID = $(this).attr('client_id_value');
                    var prjCO = $(this).attr('karyawan_id_value');

                    // setTimeout(() => {
                    //     $.ajax({
                    //         url: '{{ route('m.projects.getprj') }}',
                    //         method: 'POST',
                    //         headers: {
                    //             'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                    //         },
                    //         data: {
                    //             prjID: prjID,
                    //             prjName: prjName,
                    //             clientID: clientID,
                    //             prjCO: prjCO
                    //         },
                    //         success: function(response) {
                    //             console.log(response);
                    //             $('#e-client-id').val(response.id_client);
                    //             $('#e-project-id').val(response.id_project);
                    //             $('#edit-project-id').val(response.id_project);
                    //             $('#edit-project-name').val(response.na_project);
                    //             // setCoId(response);
                    //             setClientList(response);
                    //             setTeamList(response);
                    //             setCoordinatorList(
                    //                 response); // New function to set coordinators
                    //             // setEngineerTeamList(response); // New function to set engineer teams
                    //             setStartDeadline(response);


                    //             document.body.style.overflowY = 'hidden';
                    //             modalToShow.show();
                    //         },
                    //         error: function(error) {
                    //             console.log("Err [JS]:\n");
                    //             console.log(error);
                    //         }
                    //     });
                    // }); // <-- Closing parenthesis for setTimeout

                    setTimeout(() => {
                        makeRequest('{{ route('m.projects.getprj') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    prjID: prjID,
                                    prjName: prjName,
                                    clientID: clientID,
                                    prjCO: prjCO
                                })
                            })
                            .then(response => {
                                console.log(response);
                                $('#e-client-id').val(response.id_client);
                                $('#e-project-id').val(response.id_project);
                                $('#edit-project-id').val(response.id_project);
                                $('#edit-project-name').val(response.na_project);
                                // setCoId(response);
                                setClientList(response);
                                setTeamList(response);
                                setCoordinatorList(response); // New function to set coordinators
                                // setEngineerTeamList(response); // New function to set engineer teams
                                setStartDeadline(response);

                                // document.body.style.overflowY = 'hidden';
                                modalToShow.show();
                            })
                            .catch(error => {
                                console.log("Err [JS]:\n");
                                console.log(error);
                            });
                    }); // <-- Closing parenthesis for setTimeout
                });

                function setTeamList(response) {
                    var teamSelect = $('#' + modalId + ' #edit-engteam-select2-assign');
                    teamSelect.empty(); // Clear existing options
                    teamSelect.append($('<option>', {
                        value: "",
                        text: "Select Team"
                    }));
                    $.each(response.teamList, function(index, teamOption) {
                        var option = $('<option>', {
                            value: teamOption.value,
                            text: `${teamOption.text}`
                        });
                        if (teamOption.selected) {
                            option.attr('selected',
                                'selected'); // Select the option if it is marked as selected
                        }
                        teamSelect.append(option);
                    });
                    initializeSelect2(teamSelect, "Select Team");
                }

                function setCoordinatorList(response) {
                    var coSelect = $('#' + modalId + ' #edit-co-select2-assign');
                    coSelect.empty(); // Clear existing options
                    coSelect.append($('<option>', {
                        value: "",
                        text: "Select Co"
                    }));
                    $.each(response.coList, function(index, coOption) {
                        var option = $('<option>', {
                            value: coOption.value,
                            text: `${coOption.text}`
                        });
                        if (coOption.selected) {
                            option.attr('selected',
                                'selected'); // Select the option if it is marked as selected
                        }
                        coSelect.append(option);
                    });
                    initializeSelect2(coSelect, "Assign Co");
                }

                function setClientList(response) {
                    var clientSelect = $('#' + modalId + ' #edit-client-id');
                    clientSelect.empty(); // Clear existing options
                    clientSelect.append($('<option>', {
                        value: "",
                        text: "Select Customer"
                    }));
                    $.each(response.clientList, function(index, clientOption) {
                        var option = $('<option>', {
                            value: clientOption.value,
                            text: `${clientOption.text}`
                        });
                        if (clientOption.selected) {
                            option.attr('selected', 'selected'); // Select the option
                        }
                        clientSelect.append(option);
                    });
                }


                function initializeSelect2(selectElement, placeholder) {
                    selectElement.select2({
                        placeholder: placeholder,
                        allowClear: false,
                        closeOnSelect: true
                    }).on("select2:unselect", function(e) {
                        // Handle unselect event
                        console.log("Unselected:", e.params.data);
                        // Optionally, you can perform additional actions here
                    }).on("select2:select", function(e) {
                        // Handle select event
                        console.log("Selected:", e.params.data);
                    });
                    // .on("select2:open", function() {
                    //     // Handle open event
                    //     console.log("Select2 opened");
                    // }).on("select2:close", function() {
                    //     // Handle close event
                    //     console.log("Select2 closed");
                    // });
                }

                function setStartDeadline(response) {
                    var startDeadlineDate = $('#' + modalId + ' #edit-start-deadline');
                    startDeadlineDate.val(response.start_deadline);
                }


                const saveRecordBtn = document.querySelector('#' + modalId + ' #confirmSave');
                if (saveRecordBtn) {
                    saveRecordBtn.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent the default button behavior
                        targetedModalForm.submit(); // Submit the form if validation passes
                    });
                }
            });
        </script>



        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                whichModal = "delete_projectModal";
                const modalSelector = document.querySelector('#' + whichModal);
                const modalToShow = new bootstrap.Modal(modalSelector);

                setTimeout(() => {
                    $('.delete-record').on('click', function() {
                        var projectID = $(this).attr('project_id_value');
                        $('#' + whichModal + ' #project_id').val(projectID);
                        //document.body.style.overflowY = 'hidden';
                        modalToShow.show();
                    });
                }, 200);

            });
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                whichDelModal = "delete_projectModal";
                const modalDelSelector3 = document.querySelector('#' + whichDelModal);

                if (modalDelSelector3) {
                    const modalToShow3 = new bootstrap.Modal(modalDelSelector3);

                    setTimeout(() => {
                        $('table .dropdown-menu').on('click', '.delete-record', function(event) {
                            console.log("CLICKED");
                            // var projectID = $(this).attr('project_id_value');
                            var projectID = $(this).closest('tr').attr('project_id_value');
                            // var projectID = $(this).closest('tr').find('.project-id').val();


                            $('#' + whichDelModal + ' #del-project_id').val(projectID);
                            modalToShow3.show();
                        });
                    }, 800);

                }
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('input[name^="show_to_client_"]').change(function() {
                    const projectID = $(this).attr('name').split('_')[3]; // Extracting the project ID
                    const showToClientValue = $(this).val(); // Get the value of the selected radio button

                    // $.ajax({
                    //     url: '{{ route('m.projects.modprj.sh2cl') }}',
                    //     method: 'POST',
                    //     data: {
                    //         projectID: projectID,
                    //         show_to_client: showToClientValue,
                    //         _token: '{{ csrf_token() }}'
                    //     },
                    //     success: function(response) {
                    //         if (response != null && response.message) {
                    //             jsonToastReceiver(response
                    //                 .message); // Pass response.message instead of response
                    //         }
                    //         // Handle success response
                    //         console.log('Update successful:', response);
                    //     },
                    //     error: function(xhr, status, error) {
                    //         if (xhr.responseJSON != null && xhr.responseJSON.message) {
                    //             jsonToastReceiver(xhr.responseJSON
                    //                 .message); // Pass response.message instead of response
                    //         }
                    //         // Handle error response
                    //         console.error('Update failed:', error);
                    //     }
                    // });

                    makeRequest('{{ route('m.projects.modprj.sh2cl') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                projectID: projectID,
                                show_to_client: showToClientValue,
                                _token: '{{ csrf_token() }}' // This can be omitted if CSRF token is managed globally
                            })
                        })
                        .then(response => {
                            if (response != null && response.message) {
                                jsonToastReceiver(response
                                    .message); // Pass response.message instead of response
                            }
                            // Handle success response
                            console.log('Update successful:', response);
                        })
                        .catch(error => {
                            if (error.responseJSON != null && error.responseJSON.message) {
                                jsonToastReceiver(error.responseJSON
                                    .message); // Pass response.message instead of response
                            }
                            // Handle error response
                            console.error('Update failed:', error);
                        });
                });
            });
        </script>

        {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#engteam-select2-assign').select2({
            placeholder: "Assign Team",
            allowClear: false,
            closeOnSelect: true
        });
        $('#co-select2-assign').select2({
            placeholder: "Assign Co",
            allowClear: false,
            closeOnSelect: true
        });
    });
</script> --}}




        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalId = 'add_projectModal';
                const modalSelector = document.getElementById(modalId);
                const modalToShow = new bootstrap.Modal(modalSelector);
                const targetedModalForm = document.querySelector('#' + modalId + ' #add_projectModalFORM');

                $(document).on('click', '.add-new-record', function(event) {
                    setTimeout(() => {
                        $.ajax({
                            url: '{{ route('m.projects.getprj4add') }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                            },
                            data: {
                                act: 'addData'
                            },
                            success: function(response) {
                                console.log(response);
                                setClientList(response);
                                setTeamList(response);
                                setCoordinatorList(response);

                                // document.body.style.overflowY = 'hidden';
                                modalToShow.show();
                            },
                            error: function(error) {
                                console.log("Err [JS]:\n");
                                console.log(error);
                            }
                        });
                    }); // <-- Closing parenthesis for setTimeout
                });


                function setTeamList(response) {
                    var teamSelect = $('#' + modalId + ' #engteam-select2-assign');
                    teamSelect.empty(); // Clear existing options
                    teamSelect.append($('<option>', {
                        value: "",
                        text: "Select Team"
                    }));
                    $.each(response.team_list, function(index, teamOption) {
                        var option = $('<option>', {
                            // value: teamOption.value,
                            value: teamOption.value,
                            text: teamOption.text
                        });
                        if (teamOption.selected) {
                            option.attr('selected',
                                'selected'); // Select the option if it is marked as selected
                        }
                        teamSelect.append(option);
                    });
                    initializeSelect2_add(teamSelect, "Select Team");
                }

                function setCoordinatorList(response) {
                    var coSelect = $('#' + modalId + ' #co-select2-assign');
                    coSelect.empty(); // Clear existing options
                    coSelect.append($('<option>', {
                        value: "",
                        text: "Select Co"
                    }));
                    $.each(response.co_list, function(index, coOption) {
                        var option = $('<option>', {
                            value: coOption.value,
                            text: coOption.text
                        });
                        if (coOption.selected) {
                            option.attr('selected',
                                'selected'); // Select the option if it is marked as selected
                        }
                        coSelect.append(option);
                    });
                    initializeSelect2_add(coSelect, "Assign Co");
                }

                function setClientList(response) {
                    var clientSelect = $('#' + modalId + ' #client-id');
                    clientSelect.empty(); // Clear existing options
                    clientSelect.append($('<option>', {
                        value: "",
                        text: "Select Customer"
                    }));
                    $.each(response.client_list, function(index, clientOption) {
                        var option = $('<option>', {
                            value: clientOption.value,
                            text: clientOption.text
                        });
                        if (clientOption.selected) {
                            option.attr('selected',
                                'selected'); // Select the option if it is marked as selected
                        }
                        clientSelect.append(option);
                    });
                    initializeSelect2_add(clientSelect, "Select Customer");
                }

                function initializeSelect2_add(selectElement, placeholder) {
                    selectElement.select2({
                        placeholder: placeholder,
                        allowClear: false,
                        closeOnSelect: true
                    }).on("select2:unselect", function(e) {
                        // Handle unselect event
                        console.log("Unselected:", e.params.data);
                        // Optionally, you can perform additional actions here
                    }).on("select2:select", function(e) {
                        // Handle select event
                        console.log("Selected:", e.params.data);
                    });
                    // .on("select2:open", function() {
                    //     // Handle open event
                    //     console.log("Select2 opened");
                    // }).on("select2:close", function() {
                    //     // Handle close event
                    //     console.log("Select2 closed");
                    // });
                }


                const saveRecordBtn = document.querySelector('#' + modalId + ' #confirmSave');
                if (saveRecordBtn) {
                    saveRecordBtn.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent the default button behavior
                        targetedModalForm.submit(); // Submit the form if validation passes
                    });
                }
            });
        </script>
    @endif
@endsection
