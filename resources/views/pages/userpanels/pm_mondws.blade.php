@php
    $page = Session::get('page', []);
    $page_title = $page['page_title'] ?? 'Default Title'; // Provide a default title if not set
    $cust_date_format = 'ddd, DD MMM YYYY';
    $cust_time_format = 'hh:mm:ss A';
    $authenticated_user_data = Session::get('authenticated_user_data', []);
    $reset_btn = false;

@endphp


@extends('layouts.userpanels.v_main')

@section('header_page_cssjs')
    <style>
        .media .mr-25.p-1.rounded {
            background-color: #30334e;
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        .dark-layout .media.mr-25.p-1.rounded {
            background-color: #ffffff;
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        .light-layout .media.mr-25.p-1.rounded {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }
    </style>

    <style>
        /* Custom CSS for setting max-width on the image */
        @media (max-width: 924) {
            .max-width-lg {
                max-width: 24%;
            }
        }

        @media (max-width: 800px) {
            .max-width-sm {
                max-width: 12%;
            }
        }

        @media (max-width: 768px) {
            .max-width-md {
                max-width: 12%;
            }
        }
    </style>
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
        $authUserId = $authenticated_user_data->id_karyawan ?? null;
        $authUserType = auth()->user()->type ?? null;
        $authUserTeam = $authenticated_user_data->id_team ?? null;
        $coUserId = $project->id_karyawan ?? null;
        $engPrjTeam = $project->id_team ?? null;

        // echo 'engPrjTeam: ' . $engPrjTeam . ' ------ ';
        // echo 'authUserTeam: ' . $authUserTeam . '<br>';
        // echo 'authUserId: ' . $authUserId . ' ------ ';

    @endphp


    @php
        // Team Check based-on id_karyawan
        $auth_emp_id = auth()->user()->id_karyawan;
        $prj_cos = [];
        // dd($project['coordinators']->toarray());
        foreach ($project['coordinators'] as $co) {
            if (isset($co['karyawan'])) {
                $prj_cos[] = (int) $co['karyawan']['id_karyawan'];
            }
        }
        $isCoInPrj = in_array($auth_emp_id, $prj_cos);
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
        $isProjectOpen = $project->status_project == 'OPEN' ? true : false;
        $totalActual = 0;
    @endphp




    <div class="row match-height">
        {{-- <!-- QRCodeCheck-out Card -->
        <div class="col-lg-4 col-md-6 col-12">
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
            @endif
        </div>
        <!--/ QRCodeCheck-out Card --> --}}

        <!-- TableAbsen Card -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card card-developer-meetup">
                <div class="card-body p-1">
                    {{-- <div class="card-title d-flex align-items-center">
                        <ul class="nav navbar-nav d-xl-none mr-1">
                            <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                                        data-feather="menu"></i></a></li>
                        </ul>
                        <div class="d-flex flex-row justify-content-between gap-2">
                            @if (isset($modalData['modal_add_moni']))
                                @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                    <div class="nav-item disableBodyScroll"
                                        onclick="event.preventDefault(); openModal('{{ $modalData['modal_add_moni'] }}')">
                                        <a class="dropdown-item d-flex align-items-center border rounded border-success add-new-record"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add New Record!">
                                            <span><i class="ficon text-success" data-feather="plus-circle"></i></span>
                                            <span class="d-none d-lg-block ml-1 font-small">Add Record</span>
                                        </a>
                                    </div>
                                @endif
                            @endif
                            @if ($reset_btn)
                                @if (auth()->user()->type === 'Superuser')
                                    @if (isset($modalData['modal_reset_moni']))
                                        @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                            <div class="nav-item ml-1 disableBodyScroll"
                                                onclick="event.preventDefault(); openModal('{{ $modalData['modal_reset_moni'] }}')">
                                                <a class="dropdown-item d-flex align-items-center border rounded border-warning reset-all-record"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Reset all Records!">
                                                    <span><i class="ficon text-warning"
                                                            data-feather="refresh-cw"></i></span>
                                                    <span class="d-none d-lg-block ml-1">Reset Records</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            @endif

                        </div>

                    </div> --}}





                    {{-- <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex gap-3">
                        </div>

                        <div class="overflow-x-scroll overflow-y-scroll">
                            <button class="btn btn-primary auth-role-text">
                                <a class="mt-0 mb-0 pr-xl-0 pr-md-0 pr-sm-0 pr-0 cursor-default text-end"></i>SUPERVISOR</a>
                            </button>
                        </div>
                    </div>
                    --}}



                    <!-- Tab menu -->
                    <ul class="nav nav-tabs d-flex justify-content-center align-items-middle" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="pm-pill-general" data-toggle="pill" href="#pm-vertical-general"
                                role="tab" aria-controls="pm-vertical-general" aria-selected="false">
                                <i class="fas fa-monitor-heart-rate fa-1x"></i> Monitoring
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="pm-pill-ws" data-toggle="pill" href="#pm-vertical-ws"
                                role="tab" aria-controls="pm-vertical-ws" aria-selected="true">
                                <i class="fas fa-users-cog fa-1x"></i> Worksheets
                            </a>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content">
                        <!-- General Progress Monitoring List Content -->
                        <div role="tabpanel" class="tab-pane fade" id="pm-vertical-general"
                            aria-labelledby="pm-pill-general" aria-expanded="false">

                            <div class="row match-height">

                                <!-- FLOATING BUTTTON: SIMPLE -->
                                <!-- Floating Button -->
                                <div class="left-floating-container">
                                    <div class="d-flex flex-row justify-content-between align-items-center">

                                        @if ($authUserType == 'Superuser' || $authUserType == 'Supervisor')
                                            <div class="d-flex gap-3">
                                                <div class="nav-item">
                                                    <button onclick="modReorder()"
                                                        class="btn btn-primary px-1 dropdown-item d-flex align-items-center border monitoring-task-reorder-btn"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reorder!">
                                                        <!-- default class btn-secondary, active btn-warning  -->
                                                        <span><i class="fal fa-folder fa-xs text-white"
                                                                style="display: inline; height: 13px; width: 12px;"></i></span>
                                                        <!-- icon default  -->
                                                        <span><i class="fal fa-folders fa-xs"
                                                                style="display: none; height: 13px; width: 12px;"></i></span>
                                                        <!-- icon active  -->
                                                    </button>
                                                </div>

                                            </div>
                                        @endif
                                        <!-- OTHER ITEM EXAMPLE -->
                                        {{--
                                            <button class="btn bg-primary btn-icon auth-role-lock-text {{ $blinkClass }}" type="button">
                                            <i class="fas fa-engine-warning fa-xs"></i>
                                            </button>
                                        --}}
                                    </div>
                                </div>




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
                                                        SPV
                                                    @endif
                                                </a>
                                            </span>
                                            {{-- </div> --}}
                                            <div class="row w-100 justify-content-between">
                                                <!-- Column 1: Brand Logo -->
                                                <div
                                                    class="col text-start brand-logo col-xl-2 col-md-2 col-12 d-flex align-items-center">
                                                    <span class="brand-logo">
                                                        <img src="{{ asset('public/assets/logo/dws_header_vplogo.svg') }}"
                                                            class="img-fluid max-width-sm max-width-md max-width-lg"
                                                            alt="VPLogo">
                                                    </span>
                                                </div>

                                                <!-- Column 2: Project Title -->
                                                <div
                                                    class="col text-center col-xl-8 col-md-5 col-12 pl-3 d-flex align-items-center justify-content-center">
                                                    <span>
                                                        <strong>
                                                            <h3 class="mt-0 mb-0 underline-text pt-2 h3-dark">PROGRESS PROJECT
                                                                MONITORING
                                                            </h3>
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
                                <!-- Left Card 1st -->
                            </div>

                            <div class="row match-height KOP-1">

                                <!--  Check $data as array -->
                                {{-- <div class="col-xl-12 col-md-12 col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <pre style="color: white">{{ print_r($project->toArray(), true) }}</pre>
                                            <br>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Left Card -->
                                <div class="col-xl-6 col-md-6 col-12">
                                    <div class="card mb-0 mb-0">
                                        <div class="card-body overflow-x-scroll dis-overflow-y-hidden">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-nowrap"><strong>Project-No</strong></td>
                                                        <td class="pl-2">: </td>
                                                        <td>{{ $project->id_project }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"><strong>Project Name</strong></td>
                                                        <td class="pl-2">: </td>
                                                        <td>{{ $project->na_project }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-nowrap"><strong>Customer</strong></td>
                                                        <td class="pl-2">: </td>
                                                        <td>{{ $project->client->na_client }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Left Card -->

                                <!-- Right Card -->
                                <div class="col-xl-6 col-md-6 col-12">
                                    <div class="card mb-0">
                                        <div class="card-body overflow-x-scroll dis-overflow-y-hidden">
                                            <div class="text-end text-nowrap">
                                                <h61><strong>PT. VERTECH PERDANA</strong></h61>
                                            </div>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        @php
                                                            $teamName = [];
                                                            $teamInfo = '';
                                                            // Check if there are teams in the project
                                                            if (!empty($project['prjteams']) && $project['prjteams']) {
                                                                foreach ($project['prjteams'] as $prjteam) {
                                                                    $teamInfo .=
                                                                        "<span class='bg-primary text-white rounded' style='padding: 0.01rem;'>" .
                                                                        $prjteam['team']['na_team'] .
                                                                        '</span>:<br>';

                                                                    // Assuming you have a way to get karyawans for each team
                                                                    if (!empty($prjteam['team']['karyawans'])) {
                                                                        // Convert the karyawans collection to an array
                                                                        $karyawansArray = $prjteam['team'][
                                                                            'karyawans'
                                                                        ]->toArray();
                                                                        $teamInfo .= implode(
                                                                            ', ',
                                                                            array_column(
                                                                                $karyawansArray,
                                                                                'na_karyawan',
                                                                            ),
                                                                        );
                                                                    } else {
                                                                        $teamInfo .= 'No team members available';
                                                                    }
                                                                    $teamInfo .= '<br>'; // Use <br> for line breaks
                                                                    $teamName[] = $prjteam['team']['na_team'];
                                                                }
                                                            } else {
                                                                $teamInfo = 'No team information available';
                                                            }
                                                        @endphp

                                                        <td colspan="3" class="text-nowrap" data-toggle="tooltip"
                                                            data-placement="left" data-html="true" class="pull-up"
                                                            data-original-title="{!! '<div class=\'text-left\'>' . $teamInfo . '</div>' !!}">
                                                            <strong>Engineer Team</strong>

                                                        </td>
                                                        <td class="pl-2">: </td>
                                                        <td>
                                                            @if ($teamName)
                                                                <div>
                                                                    {{ implode(', ', $teamName) }}
                                                                </div>
                                                            @else
                                                                <div>
                                                                    -
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-nowrap"><strong>Project
                                                                Coordinator</strong></td>
                                                        <td class="pl-2">: </td>
                                                        <td>
                                                            @php
                                                                $coordinatorNames = [];
                                                                foreach ($project->coordinators as $index => $co) {
                                                                    $coordinatorNames[] =
                                                                        $co->karyawan !== null
                                                                            ? $co->karyawan->na_karyawan
                                                                            : '-';
                                                                }
                                                            @endphp
                                                            {{ implode(', ', $coordinatorNames) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-nowrap"><strong>Timeline</strong>
                                                        </td>
                                                        <td class="pl-2">: </td>
                                                        <td>
                                                            @php
                                                                $startDate = convertDateOnly(
                                                                    $project->start_project,
                                                                    'en',
                                                                );
                                                                $endDate = convertDateOnly(
                                                                    $project->deadline_project,
                                                                    'en',
                                                                );
                                                            @endphp
                                                            {{ $startDate . ' s/d ' . $endDate }}
                                                        </td>

                                                    </tr>
                                                    {{-- <tr>
                                                        <td colspan="3" class="text-nowrap"><strong>Start Date</strong>
                                                        </td>
                                                        <td class="pl-2">: </td>
                                                        <td>
                                                            @if ($project->created_at)
                                                                {{ \Carbon\Carbon::parse($project->start_project)->isoFormat($cust_date_format) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-nowrap"><strong>Deadline</strong>
                                                        </td>
                                                        <td class="pl-2">: </td>
                                                        <td>
                                                            @if ($project->created_at)
                                                                {{ \Carbon\Carbon::parse($project->deadline_project)->isoFormat($cust_date_format) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--/ Right Card -->

                            </div>

                            <div class="row match-height mb-1 px-1 DIVI-1">
                                @php
                                    $authUserId = $authenticated_user_data->id_karyawan;
                                    // $authUserType = auth()->user()->type;
                                    $monUserId = $project->id_karyawan;
                                @endphp

                                <div class="divider-container">
                                    <div class="divider"></div> <!-- Divider line -->
                                    <div class="button-wrapper">
                                        <div class="nav-item">
                                            @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                                    @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                        @if ($modalData['modal_add_moni'])
                                                            <button
                                                                onclick="openModal('{{ $modalData['modal_add_moni'] }}')"
                                                                class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success add-new-record text-white"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom" data-original-title="Add Task!">
                                                                <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @elseif ($authUserType === 'Engineer')
                                                    <button
                                                        class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                        style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                        data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom"
                                                        data-original-title="You're Not Authorized!">
                                                        <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                    </button>
                                                @endif
                                            @else
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                                    @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                        @if ($modalData['modal_add_moni'])
                                                            <button
                                                                class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Project Locked by SPV!">
                                                                <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                        {{-- <div class="nav-item">
                                            @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                                @if ($authUserType == 'Superuser' || $authUserId == $monUserId)
                                                    @if ($modalData['modal_add_moni'])
                                                        <button onclick="openModal('{{ $modalData['modal_add_moni'] }}')"
                                                            class="btn bg-success mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-success add-new-record text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom" data-original-title="Add Task!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i>
                                                        </button>
                                                    @endif
                                                @else
                                                    <button
                                                        class="btn bg-danger mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-danger"
                                                        style="width: fit-content; height: 3rem; padding: 0.5rem;">
                                                        <i class="fas fa-plus-circle fa-xs me-1"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div> --}}

                                        <div class="nav-item">
                                            @php
                                                $relPrjStat = $project->status_project;
                                                $blinkBGClass0 = $relPrjStat === 'OPEN' ? 'blink-bg' : '';
                                            @endphp
                                            @if ($isProjectOpen)
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                                    @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                        @if (isset($modalData['modal_lock_prj']))
                                                            @if ($authUserType === 'Superuser' || ($isCoInPrj && $project->prj_progress_totals() >= 100))
                                                                <button
                                                                    lock_prj_id_value = "{{ $project->id_project ?: 0 }}"
                                                                    class="lock-prj-cmd btn mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white {{ $blinkBGClass0 }}"
                                                                    style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                    data-toggle="tooltip" data-popup="tooltip-custom"
                                                                    data-placement="bottom"
                                                                    data-original-title="Lock Project!">
                                                                    <i class="fas fa-lock-open fa-xs me-1"></i> Lock
                                                                </button>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="You're Not Authorized!">
                                                            <i class="fas fa-lock-open fa-xs me-1"></i> Lock
                                                        </button>
                                                    @endif
                                                @elseif ($authUserType === 'Engineer')
                                                    <button
                                                        class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                        style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                        data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom"
                                                        data-original-title="You're Not Authorized!">
                                                        <i class="fas fa-lock-open fa-xs me-1"></i> Lock
                                                    </button>
                                                @endif
                                            @else
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                                    @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                        @if (isset($modalData['modal_unlock_prj']))
                                                            <button
                                                                unlock_prj_id_value = "{{ $project->id_project ?: 0 }}"
                                                                class="unlock-prj-cmd btn mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white bg-success"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Project Locked by SPV, Unlock Project!">
                                                                <i class="fas fa-lock fa-xs me-1"></i> Unlock
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                            <i class="fas fa-lock fa-xs me-1"></i> Unlock
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif

                                            @if ($authUserType === 'Client')
                                                <div class="d-flex justify-content-center align-items-ce d-none">
                                                    @if (isset($modalData['modal_moni_print']))
                                                        <button
                                                            onclick="event.preventDefault(); openModal('{{ $modalData['modal_moni_print'] }}')"
                                                            class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom" data-original-title="Export">
                                                            <i class="fad fa-file-export me-1"></i> Export
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>


                                        <div class="nav-item">
                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                <div class="d-flex justify-content-center align-items-ce d-none">
                                                    @if (isset($modalData['modal_moni_print']))
                                                        <button
                                                            onclick="event.preventDefault(); openModal('{{ $modalData['modal_moni_print'] }}')"
                                                            class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom" data-original-title="Export">
                                                            <i class="fad fa-file-export me-1"></i> Export
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--- TABLE MUST'NT INSIDE: row match-height --->
                            <div class="TABLE-1 overflow-x-scroll dis-overflow-y-hidden">
                                @php
                                    $totalQty = 0;
                                @endphp
                                @foreach ($project->monitor as $mon)
                                    @if ($mon->qty)
                                        @php
                                            $totalQty += $mon->qty;
                                        @endphp
                                    @endif
                                @endforeach

                                @php
                                    $tbodyTotalActual = 0;
                                @endphp
                                @if (isset($project))
                                    @foreach ($project->monitor as $mon)
                                        {{-- @if ($mon['qty'])
                                            @php
                                                $qty = $mon['qty'];
                                                // Find related tasks where expired_ws is null
                                                $relatedTasks = collect($project->task)->filter(function ($task) use (
                                                    $mon,
                                                    $project,
                                                ) {
                                                    $worksheet = collect($project->worksheet)->firstWhere(
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
                                            @endphp
                                        @else
                                            @php
                                                $total = 0;
                                            @endphp
                                        @endif --}}



                                        @php
                                            //  THIS IS ORIGINALLY TOTAL PROGRESS THAT NEEDED !
                                            $qty = $mon['qty'];
                                            // Get all tasks associated with the project
                                            $relatedTasks = $project->task; // This gets all tasks related to the project
                                            $totalProgress = 0;

                                            // Iterate over each task and sum the progress
                                            foreach ($relatedTasks as $task) {
                                                $totalProgress += $task->sumProgressByMonitoring($mon['id_monitoring']);
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


                                <table id="daftarMonitoringTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                                    @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                        <th rowspan="2" class="text-center">Act</th>
                                                    @endif
                                                @endif
                                            @endif
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Category</th>
                                            <th colspan="2" class="text-center">Date</th>
                                            @php
                                                if ($totalActual != 0) {
                                                    $actPro = number_format($totalActual, 0);
                                                } else {
                                                    $actPro = number_format($totalActual, 0);
                                                }
                                            @endphp
                                            {{-- <th colspan="2"
                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                data-placement="bottom"
                                                data-original-title="Total Progress Update ({{ $actPro }}%)"
                                                class="text-center {{ $totalActual == 100 ? 'text-success' : ($totalActual > 100 ? 'text-danger' : 'text-warning') }}">
                                                Progress ({{ $actPro }}%)
                                            </th> --}}
                                            <th colspan="2" class="text-center">
                                                Progress%
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Start</th>
                                            <th class="text-center">End</th>
                                            {{-- <th class="text-center">Update</th> --}}
                                            <th
                                                class="text-center
                                                    {{ $totalQty == 100 ? 'text-success' : ($totalQty > 100 ? 'text-danger' : 'text-warning') }}">
                                                Weight<br>({{ $totalQty }}%)
                                            </th>
                                            {{-- @php
                                                if ($totalActual != 0) {
                                                    $actPro = number_format($totalActual, 0);
                                                } else {
                                                    $actPro = number_format($totalActual, 0);
                                                }
                                            @endphp
                                            <th
                                                class="text-center {{ $totalActual == 100 ? 'text-success' : ($totalActual > 100 ? 'text-danger' : 'text-warning') }}">
                                                Actual<br>({{ $actPro }}%)
                                            </th> --}}
                                            <th class="text-center" data-toggle="tooltip" data-popup="tooltip-custom"
                                                data-placement="bottom" data-html="true"
                                                data-original-title="{!! 'Total Progress</br>Update (<span class=\'text-center ' .
                                                    ($actPro == 100 ? 'text-success' : ($actPro > 100 ? 'text-danger' : 'text-warning')) .
                                                    '\'>' .
                                                    $actPro .
                                                    '%</span>)' !!}">
                                                Actual<br>(0~100%)
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody id="draggable-table">
                                        @php
                                            $no = 1;
                                        @endphp
                                        @if ($project->monitor)
                                            @foreach ($project->monitor as $mon)
                                                @php
                                                    $authUserId = $authenticated_user_data->id_karyawan;
                                                    // $authUserType = auth()->user()->type;
                                                    $monUserId = $mon->karyawan->id_karyawan;
                                                @endphp

                                                <tr data-id="{{ $mon->id_monitoring }}" class="draggable-row">
                                                    @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                        @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                                            @if ($authUserType === 'Superuser' || $isCoInPrj)
                                                                <td
                                                                    class="td-drag{{ $isProjectOpen ? ($authUserType === 'Superuser' ? ' dragable-handle ' : ($isCoInPrj ? ' dragable-handle ' : '')) : '' }}cell-fit text-center align-middle">
                                                                    <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                                        <button
                                                                            class="dragable-handle btn btn-icon navbar-toggler p-0 d-inline-flex"
                                                                            type="button" id="tableActionDropdown"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            <i data-feather="align-justify"
                                                                                class="font-medium-5"></i>
                                                                        </button>
                                                                        <!-- dropdown menu -->


                                                                        @if ($modalData['modal_add_ws'])
                                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                                aria-labelledby="tableActionDropdown">
                                                                                <a class="edit-record-moni dropdown-item d-flex align-items-center"
                                                                                    edit_monitoring_id_value = "{{ $mon->id_monitoring ?: 0 }}"
                                                                                    edit_monitoring_prj_id_value = "{{ $mon->id_project ?: 0 }}"
                                                                                    edit_monitoring_kar_id_value = "{{ $mon->id_karyawan ?: 0 }}"
                                                                                    onclick="openModal('{{ $modalData['modal_edit_moni'] }}')">
                                                                                    <i data-feather="edit" class="mr-1"
                                                                                        style="color: #28c76f;"></i>
                                                                                    Edit
                                                                                </a>

                                                                                <a class="delete-record-moni dropdown-item d-flex align-items-center"
                                                                                    del_monitoring_id_value = "{{ $mon->id_monitoring ?: 0 }}"
                                                                                    onclick="openModal('{{ $modalData['modal_delete_moni'] }}')">
                                                                                    <i data-feather="trash" class="mr-1"
                                                                                        style="color: #ea5455;"></i>
                                                                                    Delete
                                                                                </a>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    <td
                                                        class="td-drag{{ $isProjectOpen ? ($authUserType === 'Superuser' ? ' dragable-handle ' : ($isCoInPrj ? ' dragable-handle ' : '')) : '' }}cell-fit text-center align-middle">
                                                        {{ $no++ }}</td>

                                                    <td class="text-start align-middle txt-break text-wrap">
                                                        {{ $mon->category ?: '-' }}
                                                    </td>
                                                    <td class="text-center fit-content align-middle txt-break text-wrap">
                                                        @if ($mon->start_date)
                                                            {{ \Carbon\Carbon::parse($mon->start_date)->isoFormat($cust_date_format) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center fit-content align-middle txt-break text-wrap">
                                                        @if ($mon->end_date)
                                                            {{ \Carbon\Carbon::parse($mon->end_date)->isoFormat($cust_date_format) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center fit-content align-middle">
                                                        {{ $mon->qty . '%' ?: '-' }}</td>
                                                    {{-- <td class="text-center align-middle">{{ $mon->task->last_task_progress_update($mon->id_monitoring) . '%' ?: '-' }}</td> --}}




                                                    @php
                                                        $total = 0; // Initialize total for this monitoring entry
                                                    @endphp

                                                    @if ($mon['qty'])
                                                        @php
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
                                                    @else
                                                        @php
                                                            $total = 0; // No quantity, total remains 0
                                                        @endphp
                                                    @endif
                                                    <td class="text-center fit-content align-middle" data-toggle="tooltip"
                                                        data-popup="tooltip-custom" data-placement="left"
                                                        data-html="true" data-original-title="{!! 'Progress</br>Update (<span class=\'text-center ' .
                                                        (number_format($total, 1) == 100.0 ? 'text-success' : (number_format($total, 1) > 100.0 ? 'text-danger' : 'text-warning')) .
                                                        '\'>' .
                                                        number_format($total, 1) .
                                                        '%</span>)' !!}">
                                                        <!-- THIS IS ORIGINALLY TOTAL PROGRESS AT EXCEL -->

                                                        {{-- {{ number_format($total, 1) }}% --}}
                                                        {{ number_format($up, 1) }}%
                                                    </td>



                                                </tr>
                                            @endforeach
                                        @else
                                            -
                                        @endif


                                    </tbody>
                                </table>


                            </div>

                            <div class="row match-height MODALS-1">
                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $isProjectOpen)
                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                                        @if ($authUserType === 'Superuser' || $isCoInPrj)
                                            <!-- BEGIN: AddMonitorModal--> @include('v_res.m_modals.userpanels.m_daftarmonitor.v_add_moniModal')
                                            <!-- END: AddMonitorModal-->
                                            <!-- BEGIN: EditMonitorModal--> @include('v_res.m_modals.userpanels.m_daftarmonitor.v_edit_moniModal')
                                            <!-- END: EditMonitorModal-->
                                            <!-- BEGIN: DelMonitorModal--> @include('v_res.m_modals.userpanels.m_daftarmonitor.v_del_moniModal')
                                            <!-- END: DelMonitorModal-->
                                            @if ($reset_btn)
                                                <!-- BEGIN: ResetMonitorModal--> @include('v_res.m_modals.userpanels.m_daftarmonitor.v_reset_moniModal')
                                                <!-- END: ResetMonitorModal-->
                                            @endif
                                            <!-- BEGIN: LockPrjModal--> @include('v_res.m_modals.userpanels.m_daftarproject.v_lock_prjModal')
                                            <!-- END: LockPrjModal-->
                                            <!-- BEGIN: UnlockPrjModal--> @include('v_res.m_modals.userpanels.m_daftarproject.v_unlock_prjModal')
                                            <!-- END: UnlockPrjModal-->
                                        @endif
                                    @endif
                                    <!-- BEGIN: ExportMoniModal--> @include('v_res.m_modals.userpanels.m_daftarmonitor.v_export_moniModal')
                                    <!-- END: ExportMoniModal-->
                                @endif
                            </div>




                        </div>


                        <!-- Change Worksheet Team Tab Content -->
                        <div class="tab-pane active" id="pm-vertical-ws" role="tabpanel" aria-labelledby="pm-pill-ws"
                            aria-expanded="true">
                            <div class="row match-height KOP-2">
                                <!-- Left Card 1st -->
                                <div class="col-xl-12 col-md-12 col-12 d-flex align-items-center logo_eng_text px-0">
                                    <div class="card mb-0 w-100">
                                        <div class="card-body pt-0">
                                            <!-- Column 3: Engineer Text -->
                                            {{-- <div class="col text-end col-xl-3 col-md-6 col-12 d-flex align-items-top"> --}}
                                            <span class="btn btn-primary auth-role-eng-text">
                                                <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                            </span>
                                            {{-- </div> --}}
                                            <div class="row w-100 justify-content-between">
                                                <!-- Column 1: Brand Logo -->
                                                <div
                                                    class="col text-start brand-logo col-xl-2 col-md-2 col-12 d-flex align-items-center">
                                                    <span class="brand-logo">
                                                        <img src="{{ asset('public/assets/logo/dws_header_vplogo.svg') }}"
                                                            class="img-fluid max-width-sm max-width-md max-width-lg"
                                                            alt="VPLogo">
                                                    </span>
                                                </div>

                                                <!-- Column 2: Project Title -->
                                                <div
                                                    class="col text-center col-xl-8 col-md-5 col-12 pl-3 d-flex align-items-center justify-content-center">
                                                    <span>
                                                        <strong>
                                                            <h3 class="mt-0 mb-0 underline-text pt-2 h3-dark">WORKSHEET
                                                                LIST<br>(DAFTAR LEMBAR KERJA)</h3>
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
                                <!-- Left Card 1st -->
                            </div>

                            <div class="row match-height mb-1 px-1 DIVI-2">
                                <div class="divider-container">
                                    @php
                                        // Initialize a variable to track the overall status
                                        $overallStatus = 'CLOSED';
                                        // Check the status of each worksheet
                                        foreach ($project->worksheet as $worksheet) {
                                            // Call the checkAllWSStatus method on each worksheet instance
                                            $ws_status = $worksheet->checkAllWSStatus(); // This will return 'OPEN' or 'CLOSED'

                                            // If any worksheet status is OPEN, set overall status to OPEN
                                            if ($ws_status === 'OPEN') {
                                                $overallStatus = 'OPEN';
                                                break; // No need to check further if we found an OPEN status
                                            }
                                        }
                                        // Determine the class for blinking background
                                        $blinkBGClass = $overallStatus === 'OPEN' ? 'blink-bg' : '';
                                    @endphp
                                    <div class="divider"></div> <!-- Divider line -->
                                    <div class="button-wrapper">
                                        <div class="nav-item">
                                            @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                    @if ($authUserType === 'Superuser' || $isCoInPrj || $isEmployeeInTeam)
                                                        @if ($modalData['modal_add_ws'])
                                                            <button
                                                                onclick="openModal('{{ $modalData['modal_add_ws'] }}')"
                                                                class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success add-new-record text-white"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Add Worksheet">
                                                                <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @endif
                                            @else
                                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                    @if ($authUserType === 'Superuser' || $isEmployeeInTeam)
                                                        @if ($modalData['modal_add_ws'])
                                                            <button
                                                                class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Project Locked by SPV!">
                                                                <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @endif

                                            @endif



                                            {{-- @if ($authUserType === 'Superuser' || $authUserType === 'Engineer')
                                                @if ($authUserType === 'Superuser' || $engPrjTeam == $authUserTeam)
                                                    @if ($modalData['modal_add_ws'])
                                                        <button onclick="openModal('{{ $modalData['modal_add_ws'] }}')"
                                                            class="btn bg-success mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-success add-new-record text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i>
                                                        </button>
                                                    @endif
                                                @else
                                                    <button
                                                        class="btn bg-danger mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-danger"
                                                        style="width: fit-content; height: 3rem; padding: 0.5rem;">
                                                        <i class="fas fa-plus-circle fa-xs me-1"></i>
                                                    </button>
                                                @endif
                                            @else
                                                <button
                                                    class="btn bg-danger mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-danger"
                                                    style="width: fit-content; height: 3rem; padding: 0.5rem;">
                                                    <i class="fas fa-plus-circle fa-xs me-1"></i>
                                                </button>
                                            @endif --}}
                                        </div>
                                        <div class="nav-item">
                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                <button
                                                    class="btn d-inline-block {{ $overallStatus == 'OPEN' ? '' : 'bg-success' }} mx-1 rounded-1 border-0 auth-role-lock-text text-white {{ $blinkBGClass }}"
                                                    style="width: 3rem; height: 3rem;" data-toggle="tooltip"
                                                    data-popup="tooltip-custom" data-placement="bottom"
                                                    data-original-title="{{ $overallStatus == 'OPEN' ? 'There\'s Unlocked Worksheet!' : 'All Worksheets Locked :)' }}">
                                                    <i
                                                        class="fas {{ $overallStatus == 'OPEN' ? 'fa-lock-open' : 'fa-user-lock' }} fa-sm d-flex justify-content-center align-items-center w-auto h-100 me-1"></i>
                                                </button>
                                            @endif
                                            {{-- @if ($authUserType === 'Client')
                                                <button
                                                    class="btn d-inline-block {{ $overallStatus == 'OPEN' ? '' : 'bg-success' }} mx-1 rounded-1 border-0 auth-role-lock-text text-white {{ $blinkBGClass }}"
                                                    style="width: 3rem; height: 3rem;"
                                                    data-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-placement="bottom"
                                                    data-original-title="{{ $overallStatus == 'OPEN' ? 'There\'s Unlocked Worksheet!' : 'All Worksheets Locked :)' }}">
                                                    <i
                                                        class="fas {{ $overallStatus == 'OPEN' ? 'fa-lock-open' : 'fa-user-lock' }} fa-sm d-flex justify-content-center align-items-center w-auto h-100 me-1"></i>
                                                </button>
                                            @endif --}}

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="TABLE-2 overflow-x-scroll dis-overflow-y-hidden">
                                <table id="daftarDWSTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle">Act</th>
                                            <th class="text-center align-middle">Date</th>
                                            <th class="text-center align-middle">Arrival</th>
                                            <th class="text-center align-middle">Finish</th>
                                            <th class="text-center align-middle">Executed by</th>
                                            <th class="text-center align-middle">Status</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        @if ($project->worksheet)

                                            @foreach ($project->worksheet as $ws)
                                                @php
                                                    $isStatusOpen = $ws->status_ws == 'OPEN' ? true : false;
                                                @endphp
                                                @php
                                                    $exeUserId = $ws->id_karyawan;
                                                    // echo 'exeUserId: ' . $exeUserId . '<br>';
                                                @endphp

                                                @php
                                                    $currentDateTime = \Carbon\Carbon::now();
                                                    $expiredAt = \Carbon\Carbon::parse($ws->expired_at_ws);
                                                    $isExpired = $expiredAt < $currentDateTime;
                                                @endphp

                                                @if ($authUserType == 'Client')
                                                    @if (!$isStatusOpen)
                                                        <tr class="{{ $isExpired ? 'expired' : '' }}">
                                                            <td class="text-center align-middle">
                                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                                    <button
                                                                        class="btn btn-icon navbar-toggler p-0 d-inline-flex"
                                                                        type="button" id="tableActionDropdown"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        <i data-feather="align-justify"
                                                                            class="font-medium-5"></i>
                                                                    </button>

                                                                    <!-- dropdown menu -->
                                                                    <div class="dropdown-menu dropdown-menu-end"
                                                                        aria-labelledby="tableActionDropdown">
                                                                        <a class="open-project-ws dropdown-item d-flex align-items-center"
                                                                            projectws_id_value = "{{ $project->id_project }}"
                                                                            client_id_value = "{{ $project->client !== null ? $project->client->id_client : 0 }}"
                                                                            href="{{ route('m.ws') . '?projectID=' . $ws->id_project . '&wsID=' . $ws->id_ws . '&wsDate=' . $ws->working_date_ws }}">
                                                                            <i data-feather="navigation" class="mr-1"
                                                                                style="color: #288cc7;"></i>
                                                                            Navigate
                                                                        </a>


                                                                        @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                                                    @if ($isStatusOpen && !$isExpired)
                                                                                        @if (isset($modalData['modal_edit_ws']))
                                                                                            <a class="edit-record-ws dropdown-item d-flex align-items-center"
                                                                                                edit_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                                edit_ws_prj_id_value = "{{ $ws->id_project }}"
                                                                                                edit_ws_kar_id_value = "{{ $ws->id_karyawan }}"
                                                                                                onclick="openModal('{{ $modalData['modal_edit_ws'] }}')">
                                                                                                <i data-feather="edit"
                                                                                                    class="mr-1"
                                                                                                    style="color: #28c76f;"></i>
                                                                                                Edit
                                                                                            </a>
                                                                                        @endif

                                                                                        @if ($authUserType === 'Superuser')
                                                                                            @if (isset($modalData['modal_delete_ws']))
                                                                                                <a class="delete-record-ws dropdown-item d-flex align-items-center"
                                                                                                    del_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                                    onclick="openModal('{{ $modalData['modal_delete_ws'] }}')">
                                                                                                    <i data-feather="trash"
                                                                                                        class="mr-1"
                                                                                                        style="color: #ea5455;"></i>
                                                                                                    Delete
                                                                                                </a>
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif


                                                                        {{--
                                                                @if ($ws->status_ws == 'OPEN')
                                                                    @if ($authUserType === 'Superuser' || !$isExpired)
                                                                        @if ($authUserType === 'Superuser' || $authUserTeam === $engPrjTeam)
                                                                            @if ($authUserType == 'Superuser' || $ws->status_ws == 'OPEN')
                                                                                @if (isset($modalData['modal_edit_ws']))
                                                                                    <a class="edit-record-ws dropdown-item d-flex align-items-center"
                                                                                        edit_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                        edit_ws_prj_id_value = "{{ $ws->id_project }}"
                                                                                        edit_ws_kar_id_value = "{{ $ws->id_karyawan }}"
                                                                                        onclick="openModal('{{ $modalData['modal_edit_ws'] }}')">
                                                                                        <i data-feather="edit"
                                                                                            class="mr-1"
                                                                                            style="color: #28c76f;"></i>
                                                                                        Edit
                                                                                    </a>

                                                                                @endif
                                                                                @if (isset($modalData['modal_delete_ws']))
                                                                                    <a class="delete-record-ws dropdown-item d-flex align-items-center"
                                                                                        del_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                        onclick="openModal('{{ $modalData['modal_delete_ws'] }}')">
                                                                                        <i data-feather="trash" class="mr-1"
                                                                                        style="color: #ea5455;"></i>
                                                                                        Delete
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                    @if (!$isExpired)
                                                                        @if ($authUserType === 'Superuser' || $authUserTeam === $engPrjTeam)
                                                                            @if ($authUserType == 'Superuser' || $ws->status_ws == 'OPEN')
                                                                                <a class="delete-record-ws dropdown-item d-flex align-items-center"
                                                                                    del_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                    onclick="openModal('{{ $modalData['modal_delete_ws'] }}')">
                                                                                    <i data-feather="trash" class="mr-1"
                                                                                        style="color: #ea5455;"></i>
                                                                                    Delete
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @elseif ($ws->status_ws == 'CLOSED')
                                                                    @if (!$isExpired)
                                                                        @if ($authUserType === 'Superuser' || $authUserTeam === $engPrjTeam)
                                                                            @if ($authUserType == 'Superuser' || $ws->status_ws == 'OPEN')
                                                                                @if (isset($modalData['modal_edit_ws']))
                                                                                    <a class="edit-record-ws dropdown-item d-flex align-items-center"
                                                                                        edit_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                        edit_ws_prj_id_value = "{{ $ws->id_project }}"
                                                                                        edit_ws_kar_id_value = "{{ $ws->id_karyawan }}"
                                                                                        onclick="openModal('{{ $modalData['modal_edit_ws'] }}')">
                                                                                        <i data-feather="edit"
                                                                                            class="mr-1"
                                                                                            style="color: #28c76f;"></i>
                                                                                        Edit
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif --}}
                                                                    </div>
                                                                    <!--/ dropdown menu -->
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <div data-toggle="tooltip" data-popup="tooltip-custom"
                                                                    data-placement="bottom"
                                                                    data-original-title="Click to navigate!"
                                                                    class="pull-up">
                                                                    <a class="open-project-ws text-nowrap {{ $isExpired ? 'text-white' : '' }}"
                                                                        projectws_id_value = "{{ $ws->id_ws }}"
                                                                        href="{{ route('m.ws') . '?projectID=' . $ws->id_project . '&wsID=' . $ws->id_ws . '&wsDate=' . $ws->working_date_ws }}">
                                                                        {{ \Carbon\Carbon::parse($ws->working_date_ws)->isoFormat($cust_date_format) }}
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td
                                                                class="text-center align-middle {{ $isExpired ? 'text-white' : '' }}">
                                                                {{ \Carbon\Carbon::parse($ws->arrival_time_ws)->isoFormat($cust_time_format) }}
                                                            </td>
                                                            <td
                                                                class="text-center align-middle {{ $isExpired ? 'text-white' : '' }}">
                                                                @php
                                                                    $isWsFinished = !is_null($ws->finish_time_ws);
                                                                @endphp
                                                                {{ $isWsFinished ? \Carbon\Carbon::parse($ws->finish_time_ws)->isoFormat($cust_time_format) : '-' }}
                                                            </td>
                                                            <td
                                                                class="text-center align-middle {{ $isExpired ? 'text-white' : '' }} txt-break text-wrap">
                                                                {{ $ws->executedby === null ?: $ws->executedby->na_karyawan }}
                                                            </td>
                                                            <td
                                                                class="text-center align-middle text-nowrap {{ $isExpired ? 'text-white' : '' }}">
                                                                @if ($authUserType == 'Superuser')
                                                                    @php
                                                                        $ws_status = $ws->status_ws;
                                                                        $blinkClass =
                                                                            $ws_status == 'OPEN' ? 'blink-bg' : '';
                                                                    @endphp
                                                                    @if ($isStatusOpen)
                                                                        @if (isset($modalData['modal_lock']))
                                                                            <button
                                                                                class="lock-ws-cmd btn rounded small text-white {{ $blinkClass }}"
                                                                                lock_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                lock_prj_id_value = "{{ $ws->id_project ?: 0 }}"
                                                                                style="padding: 0.4rem">
                                                                                <i
                                                                                    class="fas fa-lock-open fa-shake fa-sm"></i>
                                                                            </button>
                                                                        @endif
                                                                    @else
                                                                        @if (isset($modalData['modal_unlock']))
                                                                            <button
                                                                                class="unlock-ws-cmd btn bg-success rounded small text-white"
                                                                                unlock_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                unlock_prj_id_value = "{{ $ws->id_project ?: 0 }}"
                                                                                style="padding: 0.4rem">
                                                                                <i class="fas fa-user-lock fa-sm"></i>
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $ws_status = $ws->status_ws;
                                                                        $blinkClass =
                                                                            $ws_status == 'OPEN' ? 'blink-bg' : '';
                                                                    @endphp
                                                                    @if ($ws->status_ws == 'OPEN')
                                                                        <div
                                                                            class="row g-2 needs-validation d-flex justify-content-center">
                                                                            <button
                                                                                class="btn rounded small text-white {{ $blinkClass }}"
                                                                                style="padding: 0.4rem">
                                                                                <i
                                                                                    class="fas fa-lock-open fa-shake fa-sm"></i>
                                                                            </button>
                                                                        </div>
                                                                    @else
                                                                        <div
                                                                            class="row g-2 needs-validation d-flex justify-content-center">
                                                                            <button
                                                                                class="btn bg-success rounded small text-white"
                                                                                style="padding: 0.4rem">
                                                                                <i class="fas fa-user-lock fa-sm"></i>
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            {{-- <td>{{ $ws->monitoring->task }}</td>
                                                    <td>{{ $ws->descb_dws }}</td>
                                                    <td class="text-center align-middle">{{ $ws->progress_actual_dws }}%</td>
                                                    <td class="text-center align-middle">{{ $ws->progress_current_dws }}%</td> --}}
                                                        </tr>
                                                    @endif
                                                @else
                                                    <tr class="{{ $isExpired ? 'expired' : '' }}">
                                                        <td class="text-center align-middle">
                                                            <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                                <button
                                                                    class="btn btn-icon navbar-toggler p-0 d-inline-flex"
                                                                    type="button" id="tableActionDropdown"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i data-feather="align-justify"
                                                                        class="font-medium-5"></i>
                                                                </button>

                                                                <!-- dropdown menu -->
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="tableActionDropdown">
                                                                    <a class="open-project-ws dropdown-item d-flex align-items-center"
                                                                        projectws_id_value = "{{ $project->id_project }}"
                                                                        client_id_value = "{{ $project->client !== null ? $project->client->id_client : 0 }}"
                                                                        href="{{ route('m.projects.getprjmondws') . '?projectID=' . $project->id_project }}">
                                                                        <i data-feather="navigation" class="mr-1"
                                                                            style="color: #288cc7;"></i>
                                                                        Navigate
                                                                    </a>


                                                                    @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                                        @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                                            @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                                                @if ($isStatusOpen && !$isExpired)
                                                                                    @if (isset($modalData['modal_edit_ws']))
                                                                                        <a class="edit-record-ws dropdown-item d-flex align-items-center"
                                                                                            edit_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                            edit_ws_prj_id_value = "{{ $ws->id_project }}"
                                                                                            edit_ws_kar_id_value = "{{ $ws->id_karyawan }}"
                                                                                            onclick="openModal('{{ $modalData['modal_edit_ws'] }}')">
                                                                                            <i data-feather="edit"
                                                                                                class="mr-1"
                                                                                                style="color: #28c76f;"></i>
                                                                                            Edit
                                                                                        </a>
                                                                                    @endif

                                                                                    @if ($authUserType === 'Superuser')
                                                                                        @if (isset($modalData['modal_delete_ws']))
                                                                                            <a class="delete-record-ws dropdown-item d-flex align-items-center"
                                                                                                del_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                                onclick="openModal('{{ $modalData['modal_delete_ws'] }}')">
                                                                                                <i data-feather="trash"
                                                                                                    class="mr-1"
                                                                                                    style="color: #ea5455;"></i>
                                                                                                Delete
                                                                                            </a>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif


                                                                    {{--
                                                                @if ($ws->status_ws == 'OPEN')
                                                                    @if ($authUserType === 'Superuser' || !$isExpired)
                                                                        @if ($authUserType === 'Superuser' || $authUserTeam === $engPrjTeam)
                                                                            @if ($authUserType == 'Superuser' || $ws->status_ws == 'OPEN')
                                                                                @if (isset($modalData['modal_edit_ws']))
                                                                                    <a class="edit-record-ws dropdown-item d-flex align-items-center"
                                                                                        edit_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                        edit_ws_prj_id_value = "{{ $ws->id_project }}"
                                                                                        edit_ws_kar_id_value = "{{ $ws->id_karyawan }}"
                                                                                        onclick="openModal('{{ $modalData['modal_edit_ws'] }}')">
                                                                                        <i data-feather="edit"
                                                                                            class="mr-1"
                                                                                            style="color: #28c76f;"></i>
                                                                                        Edit
                                                                                    </a>

                                                                                @endif
                                                                                @if (isset($modalData['modal_delete_ws']))
                                                                                    <a class="delete-record-ws dropdown-item d-flex align-items-center"
                                                                                        del_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                        onclick="openModal('{{ $modalData['modal_delete_ws'] }}')">
                                                                                        <i data-feather="trash" class="mr-1"
                                                                                        style="color: #ea5455;"></i>
                                                                                        Delete
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                    @if (!$isExpired)
                                                                        @if ($authUserType === 'Superuser' || $authUserTeam === $engPrjTeam)
                                                                            @if ($authUserType == 'Superuser' || $ws->status_ws == 'OPEN')
                                                                                <a class="delete-record-ws dropdown-item d-flex align-items-center"
                                                                                    del_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                    onclick="openModal('{{ $modalData['modal_delete_ws'] }}')">
                                                                                    <i data-feather="trash" class="mr-1"
                                                                                        style="color: #ea5455;"></i>
                                                                                    Delete
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @elseif ($ws->status_ws == 'CLOSED')
                                                                    @if (!$isExpired)
                                                                        @if ($authUserType === 'Superuser' || $authUserTeam === $engPrjTeam)
                                                                            @if ($authUserType == 'Superuser' || $ws->status_ws == 'OPEN')
                                                                                @if (isset($modalData['modal_edit_ws']))
                                                                                    <a class="edit-record-ws dropdown-item d-flex align-items-center"
                                                                                        edit_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                                        edit_ws_prj_id_value = "{{ $ws->id_project }}"
                                                                                        edit_ws_kar_id_value = "{{ $ws->id_karyawan }}"
                                                                                        onclick="openModal('{{ $modalData['modal_edit_ws'] }}')">
                                                                                        <i data-feather="edit"
                                                                                            class="mr-1"
                                                                                            style="color: #28c76f;"></i>
                                                                                        Edit
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif --}}
                                                                </div>
                                                                <!--/ dropdown menu -->
                                                            </div>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Click to navigate!" class="pull-up">
                                                                <a class="open-project-ws text-nowrap {{ $isExpired ? 'text-white' : '' }}"
                                                                    projectws_id_value = "{{ $ws->id_ws }}"
                                                                    href="{{ route('m.ws') . '?projectID=' . $ws->id_project . '&wsID=' . $ws->id_ws . '&wsDate=' . $ws->working_date_ws }}">
                                                                    {{ \Carbon\Carbon::parse($ws->working_date_ws)->isoFormat($cust_date_format) }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="text-center align-middle {{ $isExpired ? 'text-white' : '' }}">
                                                            {{ \Carbon\Carbon::parse($ws->arrival_time_ws)->isoFormat($cust_time_format) }}
                                                        </td>
                                                        <td
                                                            class="text-center align-middle {{ $isExpired ? 'text-white' : '' }}">
                                                            @php
                                                                $isWsFinished = !is_null($ws->finish_time_ws);
                                                            @endphp
                                                            {{ $isWsFinished ? \Carbon\Carbon::parse($ws->finish_time_ws)->isoFormat($cust_time_format) : '-' }}
                                                        </td>
                                                        <td
                                                            class="text-center align-middle {{ $isExpired ? 'text-white' : '' }} txt-break text-wrap">
                                                            {{ $ws->executedby === null ?: $ws->executedby->na_karyawan }}
                                                        </td>
                                                        <td
                                                            class="text-center align-middle text-nowrap {{ $isExpired ? 'text-white' : '' }}">
                                                            @php
                                                                $ws_status = $ws->status_ws;
                                                                $blinkClass = $ws_status == 'OPEN' ? 'blink-bg' : '';
                                                                $expiredDT =
                                                                    $authUserType != 'Client'
                                                                        ? ($ws->expired_at_ws
                                                                            ? convertDateTime($ws->expired_at_ws, 'en')
                                                                            : null)
                                                                        : null;
                                                            @endphp
                                                            @if ($authUserType == 'Superuser')
                                                                @if ($isStatusOpen)
                                                                    @if (isset($modalData['modal_lock']))
                                                                        <button data-toggle="tooltip"
                                                                            data-popup="tooltip-custom"
                                                                            data-placement="bottom"
                                                                            data-original-title="{{ $expiredDT ? 'Expired at:<br>' . $expiredDT : 'Worksheet Locked<br>by Executor' }}"
                                                                            data-html="true"
                                                                            class="lock-ws-cmd btn rounded small text-white {{ $blinkClass }}"
                                                                            lock_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                            lock_prj_id_value = "{{ $ws->id_project ?: 0 }}"
                                                                            style="padding: 0.4rem">
                                                                            <i class="fas fa-lock-open fa-shake fa-sm"></i>
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    @if (isset($modalData['modal_unlock']))
                                                                        <button data-toggle="tooltip"
                                                                            data-popup="tooltip-custom"
                                                                            data-placement="bottom"
                                                                            data-original-title="{{ $expiredDT ? 'Expired at:<br>' . $expiredDT : 'Worksheet Locked<br>by Executor' }}"
                                                                            data-html="true"
                                                                            class="unlock-ws-cmd btn bg-success rounded small text-white"
                                                                            unlock_ws_id_value = "{{ $ws->id_ws ?: 0 }}"
                                                                            unlock_prj_id_value = "{{ $ws->id_project ?: 0 }}"
                                                                            style="padding: 0.4rem">
                                                                            <i class="fas fa-user-lock fa-sm"></i>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @php
                                                                    $ws_status = $ws->status_ws;
                                                                    $blinkClass =
                                                                        $ws_status == 'OPEN' ? 'blink-bg' : '';
                                                                @endphp

                                                                @if ($ws->status_ws == 'OPEN')
                                                                    <div
                                                                        class="row g-2 needs-validation d-flex justify-content-center">
                                                                        <button data-toggle="tooltip"
                                                                            data-popup="tooltip-custom"
                                                                            data-placement="bottom"
                                                                            data-original-title="{{ $expiredDT ? 'Expired at:<br>' . $expiredDT : 'Worksheet Locked<br>by Executor' }}"
                                                                            data-html="true"
                                                                            class="btn rounded small text-white {{ $blinkClass }}"
                                                                            style="padding: 0.4rem">
                                                                            <i class="fas fa-lock-open fa-shake fa-sm"></i>
                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <div data-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-placement="bottom"
                                                                        data-original-title="{{ $expiredDT ? 'Expired at:<br>' . $expiredDT : 'Worksheet Locked<br>by Executor' }}"
                                                                        data-html="true"
                                                                        class="row g-2 needs-validation d-flex justify-content-center">
                                                                        <button
                                                                            class="btn bg-success rounded small text-white"
                                                                            style="padding: 0.4rem">
                                                                            <i class="fas fa-user-lock fa-sm"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        {{-- <td>{{ $ws->monitoring->task }}</td>
                                                    <td>{{ $ws->descb_dws }}</td>
                                                    <td class="text-center align-middle">{{ $ws->progress_actual_dws }}%</td>
                                                    <td class="text-center align-middle">{{ $ws->progress_current_dws }}%</td> --}}
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>

                            </div>

                            <div class="row match-height MODALS-2">
                                @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer' || $isProjectOpen)
                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                        <!-- BEGIN: AddWorksheetModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_add_wsModal')
                                        <!-- END: AddWorksheetModal-->
                                        <!-- BEGIN: EditWorksheetModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_edit_wsModal')
                                        <!-- END: EditWorksheetModal-->
                                        <!-- BEGIN: DelWorksheetModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_del_wsModal')
                                        <!-- END: DelWorksheetModal-->
                                        @if ($reset_btn)
                                            <!-- BEGIN: ResetWorksheetModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_reset_wsModal')
                                            <!-- END: ResetWorksheetModal-->
                                        @endif
                                        <!-- BEGIN: LockWSModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_lock_wsModal')
                                        <!-- END: LockWSModal-->
                                        <!-- BEGIN: UnlockWSModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_unlock_wsModal')
                                        <!-- END: UnlockWSModal-->
                                    @endif
                                @endif
                            </div>



                        </div>
                    </div>




                    <!-- ############################################################################################################################ -->
                    <!-- ############################################################################################################################ -->
                    <!-- ############################################################################################################################ -->
                    <!-- ############################################################################################################################ -->
                </div>
            </div>

        @endsection


        @section('footer_page_js')
            <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

            <script>
                $(document).ready(function() {
                    var lengthMenu = [10, 50, 100, 500, 1000, 2000, 3000]; // Length menu options

                    // Initialize the first DataTable
                    var $table = $('#daftarMonitoringTable').DataTable({
                        lengthMenu: lengthMenu,
                        pageLength: 50,
                        responsive: false,
                        ordering: true,
                        searching: true,
                        language: {
                            lengthMenu: 'Display _MENU_ records per page',
                            info: 'Showing page _PAGE_ of _PAGES_',
                            search: 'Search',
                            paginate: {
                                first: 'First',
                                last: 'Last',
                                // next: '&rarr;',
                                // previous: '&larr;'
                            }
                        },
                        scrollCollapse: true,
                        dom: '<"card-header border-bottom p-1"<"head-label1"><"d-flex justify-content-between align-items-center"<"dt-search-field"f>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        columnDefs: [{
                            targets: [],
                            visible: false
                        }],
                        initComplete: function() {
                            // $(this.api().column([0]).header()).addClass('cell-fit text-center align-middle');
                            // $(this.api().column([1]).header()).addClass('cell-fit text-center align-middle');
                            // $(this.api().column([2]).header()).addClass('text-center align-middle w-25');
                            // $(this.api().column([3]).header()).addClass('text-center fit-content align-middle');
                            // $(this.api().column([4]).header()).addClass('text-center fit-content align-middle');
                            // $(this.api().column([5]).header()).addClass('text-center fit-content align-middle');
                            // $(this.api().column([6]).header()).addClass('text-center fit-content align-middle');


                            var TaskTH_w = 29;
                            // var DescbTH_w = TaskTH_w + 8;
                            // After setting the width, trigger a redraw
                            $('#daftarMonitoringTable th:contains("No")').css('width', '2%');
                            $('#daftarMonitoringTable th:contains("Act")').css('width', '2%');
                            $('#daftarMonitoringTable th:contains("Category")').css('width', `${ TaskTH_w }%`);

                            $('#daftarMonitoringTable th:contains("Date")').css('width', '4.4%');
                            $('#daftarMonitoringTable th:contains("Start")').css('width', '1.5%');
                            // $('#daftarMonitoringTable th:contains("End")').css('width', '3.2%');
                            $('#daftarMonitoringTable th:contains("End")').css('width', '7.5%');
                            $('#daftarMonitoringTable th:contains("Weight")').css('width', '1.5%');
                            $('#daftarMonitoringTable th:contains("Actual")').css('width', '1.5%');


                            var pageInfo = this.api().page.info();
                            $('#lengthMenu1').val(pageInfo.length); // Updated ID
                        },
                        drawCallback: function() {
                            var pageInfo = this.api().page.info();
                            $('#lengthMenu1').val(pageInfo.length); // Updated ID
                        },
                    });

                    // Create dropdown button for the first table
                    var dropdownButton = `
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle mx-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-table fa-xs"></i>
                            </button>
                            <div class="dropdown-menu p-1" style="z-index: 1052; max-height: 300px; overflow-y: auto; overflow-x: auto;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="dropdown-item">
                                        <label for="lengthMenu1" class="my-0">Records per page:</label>
                                        <select class="select2 form-control form-select-sm" id="lengthMenu1" name="lengthMenu1" aria-label="Select page length">
                                            ${lengthMenu.map(function(length) {
                                                return `<option value="${length}">${length}</option>`;
                                            }).join('')}
                                        </select>
                                    </div>
                                    <div class="dropdown-item colvis-container">
                                        <label>Column Visibility:</label>
                                        <div class="colvis-options1 my-0"></div> <!-- Unique class for table 1 -->
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item d-flex justify-content-center align-content-center">Progress Project Monitoring</span>
                            </div>
                        </div>
                    `;

                    // Append the dropdown button to the first table's head label
                    $('.head-label1').prepend(dropdownButton);

                    // Handle length change for the first table
                    $('#lengthMenu1').on('change', function(event) {
                        event.stopPropagation(); // Prevent the dropdown from closing
                        var newLength = $(this).val();
                        $table.page.len(new Length).draw(); // Set new page length and redraw
                    });

                    // Prevent dropdown from closing when interacting with the dropdown menu
                    $('.dropdown-menu').on('click', function(event) {
                        event.stopPropagation(); // Prevent closing when clicking inside the dropdown
                    });

                    // Generate dynamic column visibility options for the first table
                    var columnCount = $table.columns().count();
                    for (var i = 0; i < columnCount; i++) {
                        var column = $table.column(i);
                        var columnVisible = column.visible();
                        var checkbox = `
                            <label>
                                <input type="checkbox" class="colvis-checkbox" data-column="${i}" ${columnVisible ? 'checked' : ''}> ${ column.header().textContent}
                            </label><br>
                        `;
                        $('.colvis-options1').append(checkbox); // Append to unique class for table 1
                    }

                    // Handle column visibility toggle for the first table
                    $('.colvis-options1').on('change', '.colvis-checkbox', function() {
                        var column = $(this).data('column');
                        var isVisible = $(this).is(':checked');
                        $table.column(column).visible(isVisible); // Toggle column visibility
                    });

                    // Initialize the second DataTable
                    var $table2 = $('#daftarDWSTable').DataTable({
                        lengthMenu: lengthMenu,
                        pageLength: 50,
                        responsive: true,
                        ordering: true,
                        searching: true,
                        language: {
                            lengthMenu: 'Display _MENU_ records per page',
                            info: 'Showing page _PAGE_ of _PAGES_',
                            search: 'Search',
                            paginate: {
                                first: 'First',
                                last: 'Last',
                                // next: '&rarr;',
                                // previous: '&larr;'
                            }
                        },
                        scrollCollapse: true,
                        dom: '<"card-header border-bottom p-1"<"head-label2"><"d-flex justify-content-between align-items-center"<"dt-search-field"f>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        columnDefs: [{
                            targets: [],
                            visible: false
                        }],
                        initComplete: function() {
                            // $(this.api().column([0]).header()).addClass('cell-fit text-center align-middle');
                            // $(this.api().column([1]).header()).addClass('cell-fit text-center align-middle');
                            // $(this.api().column([2]).header()).addClass('text-center align-middle');
                            // $(this.api().column([3]).header()).addClass('text-center align-middle w-25');
                            // $(this.api().column([4]).header()).addClass('cell-fit text-center align-middle');
                            // $(this.api().column([5]).header()).addClass('cell-fit text-center align-middle');


                            var TaskTH_w = 29;
                            // var DescbTH_w = TaskTH_w + 8;
                            // After setting the width, trigger a redraw
                            $('#daftarDWSTable th:contains("Act")').css('width', '1%');
                            $('#daftarDWSTable th:contains("Date")').css('width', '2%');
                            $('#daftarDWSTable th:contains("Arrival")').css('width', '1.5%');
                            $('#daftarDWSTable th:contains("Finish")').css('width', '1.5%');
                            $('#daftarDWSTable th:contains("Executed By")').css('width', `${ TaskTH_w }%`);
                            $('#daftarDWSTable th:contains("Status")').css('width', '1%');



                            var pageInfo = this.api().page.info();
                            $('#lengthMenu2').val(pageInfo.length); // Updated ID
                        },
                        drawCallback: function() {
                            var pageInfo = this.api().page.info();
                            $('#lengthMenu2').val(pageInfo.length); // Updated ID
                        },
                    });

                    // Create dropdown button for the second table
                    var dropdownButton2 = `
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle mx-0 px-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-table fa-xs"></i>
                            </button>
                            <div class="dropdown-menu p-1" style="z-index: 1052; max-height: 300px; overflow-y: auto; overflow-x: auto;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="dropdown-item">
                                        <label for="lengthMenu2" class="my-0">Records per page:</label>
                                        <select class="select2 form-control form-select-sm" id="lengthMenu2" name="lengthMenu2" aria-label="Select page length">
                                            ${lengthMenu.map(function(length) {
                                                return `<option value="${length}">${length}</option>`;
                                            }).join('')}
                                        </select>
                                    </div>
                                    <div class="dropdown-item colvis-container">
                                        <label>Column Visibility:</label>
                                        <div class="colvis-options2 my-0"></div> <!-- Unique class for table 2 -->
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item d-flex justify-content-center align-content-center">Project Worksheet Lists</span>
                            </div>
                        </div>
                    `;

                    // Append the dropdown button to the second table
                    // Append the dropdown button to the second table's head label
                    $('.head-label2').prepend(dropdownButton2);

                    // Handle length change for the second table
                    $('#lengthMenu2').on('change', function(event) {
                        event.stopPropagation(); // Prevent the dropdown from closing
                        var newLength = $(this).val();
                        $table2.page.len(newLength).draw(); // Set new page length and redraw
                    });

                    // Prevent dropdown from closing when interacting with the dropdown menu
                    $('.dropdown-menu').on('click', function(event) {
                        event.stopPropagation(); // Prevent closing when clicking inside the dropdown
                    });

                    // Generate dynamic column visibility options for the second table
                    var columnCount2 = $table2.columns().count();
                    for (var i = 0; i < columnCount2; i++) {
                        var column2 = $table2.column(i);
                        var columnVisible2 = column2.visible();
                        var checkbox2 = `
                            <label>
                                <input type="checkbox" class="colvis-checkbox" data-column="${i}" ${columnVisible2 ? 'checked' : ''}> ${column2.header().textContent}
                            </label><br>
                        `;
                        $('.colvis-options2').append(checkbox2); // Append to unique class for table 2
                    }

                    // Handle column visibility toggle for the second table
                    $('.colvis-options2').on('change', '.colvis-checkbox', function() {
                        var column = $(this).data('column');
                        var isVisible = $(this).is(':checked');
                        $table2.column(column).visible(isVisible); // Toggle column visibility
                    });
                });
            </script>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(() => {
                        $('.open-project-ws').on('click', function() {
                            var wsID = $(this).attr('projectws_id_value');
                            console.log("Navigate to ProjectWS-ID: " + wsID);
                        });
                    }, 200);
                });
            </script>




            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modalId = 'edit_wsModal';
                    const modalSelector = document.getElementById(modalId);
                    let targetedModalForm; // Declare the variable in a broader scope

                    if (modalSelector) {
                        $('.dropdown-menu').on('click', '.edit-record-ws', function(event) {
                            var wsID = $(this).attr('edit_ws_id_value');
                            var projectID = $(this).attr('edit_ws_prj_id_value');
                            var karyawanID = $(this).attr('edit_ws_kar_id_value');

                            const modalToShow = new bootstrap.Modal(modalSelector);
                            targetedModalForm = document.querySelector('#' + modalId +
                                ' #edit_wsModalFORM'); // Assign the form here

                            // console.log('Edit button clicked for ws_id:', wsID);
                            setTimeout(() => {
                                $.ajax({
                                    url: '{{ route('m.ws.getws') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        wsID: wsID,
                                        projectID: projectID,
                                        karyawanID: karyawanID
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        $('#edit-ws_id').val(response.id_ws);
                                        setWsWorkDateTime(response);
                                        setWsArrivalTime(response);
                                        setWsFinishTime(response);
                                        $('#edit-ws_project_id').val(response.id_project);
                                        $('#edit-ws_id_karyawan').val(response.id_karyawan);

                                        // console.log('SHOWING MODAL');
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

                        function setWsWorkDateTime(response) {
                            $('#edit-ws_working_date').val(response.work_date);
                            var datePickerInput = modalSelector.querySelector("#edit-ws_working_date");
                            if (datePickerInput) {
                                flatpickr(datePickerInput, {
                                    enableTime: true,
                                    dateFormat: "Y-m-d H:i:S", // Correct date format
                                    altInput: true,
                                    altFormat: "F j, Y h:i K", // Format for the alternative input display
                                    allowInput: true, // Allow typing in the input field
                                    minDate: "1900-01-01", // Set minimum date
                                    maxDate: "8000-12-31", // Set maximum date
                                    onOpen: function(selectedDates, dateStr, instance) {
                                        modalSelector.removeAttribute(
                                            'tabindex'); // Remove tabindex when the modal opens
                                    },
                                    onClose: function(selectedDates, dateStr, instance) {
                                        modalSelector.setAttribute('tabindex', -
                                            1); // Set tabindex when the modal closes
                                    }
                                });
                            }
                        }

                        function setWsArrivalTime(response) {
                            $('#edit-ws_arrival_time').val(response.arrival_time);
                            // Initialize Flatpickr after setting the value
                            flatpickr("#edit-ws_arrival_time", {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i:S",
                                altInput: true,
                                altFormat: "h:i:s K",
                                allowInput: true,
                                enableSeconds: true,
                                time_24hr: false,
                                onOpen: function(selectedDates, dateStr, instance) {
                                    modalSelector.removeAttribute(
                                        'tabindex'); // Remove tabindex when the modal opens
                                },
                                onClose: function(selectedDates, dateStr, instance) {
                                    modalSelector.setAttribute('tabindex', -
                                        1); // Set tabindex when the modal closes
                                }
                            });
                        }

                        function setWsFinishTime(response) {
                            var authUserType = response.authUserType;
                            if (authUserType == 'Superuser') {
                                $('#edit-ws_finish_time').val(response.finish_time);
                                flatpickr("#edit-ws_finish_time", {
                                    enableTime: true,
                                    noCalendar: true,
                                    dateFormat: "H:i:S",
                                    altInput: true,
                                    altFormat: "h:i:s K",
                                    allowInput: true,
                                    enableSeconds: true,
                                    time_24hr: false,
                                    onOpen: function(selectedDates, dateStr, instance) {
                                        modalSelector.removeAttribute(
                                            'tabindex'); // Remove tabindex when the modal opens
                                    },
                                    onClose: function(selectedDates, dateStr, instance) {
                                        modalSelector.setAttribute('tabindex', -
                                            1); // Set tabindex when the modal closes
                                    }
                                });
                            } else {
                                $('#edit-ws_finish_time_section').hide();
                            }
                        }

                        const saveRecordBtn = document.querySelector('#' + modalId + ' #confirmSave');
                        if (saveRecordBtn) {
                            saveRecordBtn.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent the default button behavior
                                if (targetedModalForm) {
                                    targetedModalForm.submit(); // Submit the form if validation passes
                                }
                            });
                        }
                    }
                });
            </script>



            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modalId = 'edit_moniModal';
                    const modalSelector = document.getElementById(modalId);

                    if (modalSelector) {
                        const modalToShow = new bootstrap.Modal(modalSelector);
                        const targetedModalForm = document.querySelector('#' + modalId + ' #edit_moniModalFORM');

                        $('.dropdown-menu').on('click', '.edit-record-moni', function(event) {
                            var monitorID = $(this).attr('edit_monitoring_id_value');
                            var projectID = $(this).attr('edit_monitoring_prj_id_value');
                            var karyawanID = $(this).attr('edit_monitoring_kar_id_value');
                            // console.log('Edit button clicked for monitoring_id:', monitorID);
                            setTimeout(() => {
                                $.ajax({
                                    url: '{{ route('m.mon.getmon') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        monitorID: monitorID,
                                        projectID: projectID,
                                        karyawanID: karyawanID
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        $('#edit-mon_id').val(response.id_mon);
                                        $('#edit-mon_category').val(response.cat_mon);
                                        // $('#edit-mon_start_date').val(response.start_dmon.substr(0,
                                        //     10));
                                        // $('#edit-mon_end_date').val(response.end_dmon.substr(0,
                                        //     10));
                                        $('#edit-mon_start_end_date').val(response.start_dmon
                                            .substr(0,
                                                10) + ' to ' + response.end_dmon.substr(0,
                                                10));
                                        $('#edit-mon_qty').val(response.qty_mon);
                                        $('#edit-mon_project_id').val(response.id_project);
                                        $('#edit-mon_karyawan_id').val(response.id_karyawan);

                                        // console.log('SHOWING MODAL');
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

                        const saveRecordBtn = document.querySelector('#' + modalId + ' #confirmSave');
                        if (saveRecordBtn) {
                            saveRecordBtn.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent the default button behavior
                                targetedModalForm.submit(); // Submit the form if validation passes
                            });
                        }

                    }
                });
            </script>



            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    whichModal = "delete_moniModal";
                    const modalSelector = document.querySelector('#' + whichModal);

                    if (modalSelector) {
                        const modalToShow = new bootstrap.Modal(modalSelector);
                        setTimeout(() => {
                            $('.delete-record-moni').on('click', function() {
                                var monitorID = $(this).attr('del_monitoring_id_value');
                                // console.log('Monitor ID:', monitorID);

                                // Simplified selector to target #del-mon_id directly
                                var delMonInput = $('#del-mon_id');
                                // console.log('Input Element:', delMonInput);

                                if (delMonInput.length) {
                                    delMonInput.val(monitorID);
                                    // console.log('Value Set:', delMonInput.val());
                                    // document.body.style.overflowY = 'hidden';
                                    modalToShow.show();
                                } else {
                                    console.log('Monitor-ID Element not found.');
                                }

                            });
                        }, 800);
                    }
                });
            </script>



            <style>
                /* Add styles for the draggable rows */
                .selected4drag-start {
                    background-color: #ff9f43 !important;
                    /* Light green background when selected for drag */
                    cursor: grabbing !important;
                    /* Change cursor to grabbing */
                }

                .selected4drag-end {
                    background-color: #28c76f !important;
                    /* Light red background when released */
                    cursor: default !important;
                    /* Change cursor back to default */
                }

                .reorder-active {
                    /* cursor: move; */
                    cursor: grab;
                    cursor: -moz-grab;
                    cursor: -webkit-grab;
                }

                .reorder-inactive {
                    cursor: default !important;
                    cursor: -moz-default !important;
                    cursor: -webkit-default !important;
                }
            </style>



            @if ($isProjectOpen)
                @if ($authUserType != 'Client' && $authUserType != 'Engineer')
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            window.isReorderActive = false;
                            let drake;
                            let selectedRow = null;


                            const allDraggableRow = document.querySelectorAll('.draggable-row .td-drag');
                            if (window.isReorderActive) {
                                allDraggableRow.forEach(row => {
                                    row.classList.remove('reorder-inactive');
                                    row.classList.add('reorder-active');
                                });
                            } else {
                                allDraggableRow.forEach(row => {
                                    row.classList.remove('reorder-active');
                                    row.classList.add('reorder-inactive');
                                });
                            }


                            // Define the modReorder function in the global scope
                            window.modReorder = function() {
                                // Toggle the active state
                                window.isReorderActive = !window.isReorderActive;
                                const button = document.querySelector('.monitoring-task-reorder-btn');
                                const defaultIcon = button.querySelector('.fal.fa-folder');
                                const activeIcon = button.querySelector('.fal.fa-folders');

                                // Check if reorder is active
                                if (window.isReorderActive) {
                                    // Show active icon and hide default icon
                                    defaultIcon.style.display = 'none';
                                    activeIcon.style.display = 'inline';

                                    // Change button class to active
                                    button.classList.remove('btn-primary'); // Remove default class
                                    button.classList.add('btn-warning'); // Add active class

                                    allDraggableRow.forEach(row => {
                                        row.classList.remove('reorder-inactive');
                                        row.classList.add('reorder-active');
                                    });

                                    const allDraggableRows = document.querySelectorAll('#draggable-table .td-drag');
                                    allDraggableRows.forEach(row => {
                                        row.style.cursor = 'grab';
                                    });


                                    // Initialize Dragula to enable dragging
                                    initializeDragula();
                                } else {
                                    // Show default icon and hide active icon
                                    defaultIcon.style.display = 'inline';
                                    activeIcon.style.display = 'none';

                                    // Reset button class to default
                                    button.classList.remove('btn-warning'); // Remove active class
                                    button.classList.add('btn-primary'); // Add default class


                                    // Destroy Dragula instance to disable dragging
                                    if (drake) {
                                        console.log("Destroying Dragula instance");
                                        drake.destroy(); // Destroy the current instance
                                        drake = null; // Reset the drake variable
                                        removeEventListeners(); // Remove event listeners

                                        const allRows = document.querySelectorAll('#draggable-table tr');
                                        allRows.forEach(row => {
                                            row.style.cursor = '';
                                            row.classList.remove('selected4drag-end'); // Remove the end class
                                            row.classList.remove(
                                                'selected4drag-start'); // Remove the start class if needed
                                        });


                                        allDraggableRow.forEach(row => {
                                            row.classList.remove('reorder-active');
                                            row.classList.add('reorder-inactive');
                                        });


                                    }
                                }
                            };

                            function initializeDragula() {
                                // Initialize Dragula only if it hasn't been initialized yet
                                if (drake) {
                                    console.log("Dragula is already initialized");
                                    return; // Prevent reinitialization
                                }

                                drake = dragula([document.getElementById('draggable-table')], {
                                    moves: function(el, container, handle) {
                                        // Allow dragging only if reorder is active
                                        el.style.cursor = 'grabbing';

                                        return window.isReorderActive && handle.classList.contains('dragable-handle');
                                    }
                                });

                                // Add event listeners for drag events
                                drake.on('drop', function(el, target, source, sibling) {
                                    if (window.isReorderActive) {
                                        updateOrder();
                                        if (selectedRow) {
                                            selectedRow.classList.remove('selected4drag-start'); // Remove the start class
                                            selectedRow.classList.add('selected4drag-end'); // Add end class on drop

                                            // Remove the .selected4drag-end class after 3 seconds
                                            setTimeout(() => {
                                                const allRows = document.querySelectorAll('#draggable-table tr');
                                                allRows.forEach(row => {
                                                    row.classList.remove(
                                                        'selected4drag-end'); // Remove the end class
                                                    row.classList.remove(
                                                        'selected4drag-start'
                                                    ); // Remove the start class if needed
                                                });
                                            }, 3000);

                                            selectedRow = null; // Reset selectedRow
                                        }
                                    }
                                    el.style.cursor = '';
                                });

                                drake.on('cancel', function(el) {
                                    if (selectedRow) {
                                        selectedRow.classList.remove(
                                            'selected4drag-start'); // Remove the start class if drag is canceled
                                        selectedRow = null; // Reset selectedRow
                                        el.style.cursor = '';
                                    }
                                });

                                // Select all rows and add event listeners to all handles
                                addEventListeners();
                            }

                            // Store the event listener functions in a way that allows removal
                            const clickListeners = new Map();
                            const touchListeners = new Map();

                            function addEventListeners() {
                                const rows = document.querySelectorAll('#draggable-table tr.draggable-row');
                                rows.forEach(row => {
                                    const handles = row.querySelectorAll(
                                        '.dragable-handle'); // Select all handles in the row
                                    handles.forEach(handle => {
                                        const clickListener = function(e) {
                                            handleRowClick(e, row);
                                        };
                                        const touchListener = function(e) {
                                            e.preventDefault(); // Prevent default behavior
                                            handleRowClick(e, row);
                                        };

                                        // Store the listener functions in the maps
                                        clickListeners.set(handle, clickListener);
                                        touchListeners.set(handle, touchListener);

                                        // Add click and touchend event listeners to each handle
                                        handle.addEventListener('click', clickListener);
                                        handle.addEventListener('touchend', touchListener);
                                    });
                                });
                            }

                            function removeEventListeners() {
                                const rows = document.querySelectorAll('#draggable-table tr.draggable-row');
                                rows.forEach(row => {
                                    const handles = row.querySelectorAll(
                                        '.dragable-handle'); // Select all handles in the row
                                    handles.forEach(handle => {
                                        // Retrieve the stored listener functions
                                        const clickListener = clickListeners.get(handle);
                                        const touchListener = touchListeners.get(handle);

                                        // Remove click and touchend event listeners from each handle
                                        if (clickListener) {
                                            handle.removeEventListener('click', clickListener);
                                        }
                                        if (touchListener) {
                                            handle.removeEventListener('touchend', touchListener);
                                        }

                                        // Remove the listeners from the maps
                                        clickListeners.delete(handle);
                                        touchListeners.delete(handle);
                                    });
                                });
                            }

                            // function handleRowClick(e, row) {
                            //     console.log('Row clicked:', row);
                            //     console.log("id:" + row.dataset.id);
                            //     if (!selectedRow) {
                            //         selectedRow = row;
                            //         selectedRow.classList.add('selected4drag-start'); // Add the class when selecting
                            //         console.log('Selected row to move:', selectedRow);
                            //     } else {
                            //         const targetRow = e.currentTarget.closest('tr');
                            //         if (targetRow && targetRow !== selectedRow) {
                            //             const parent = selectedRow.parentNode;
                            //            // if (row.dataset.id)
                            //                 parent.insertBefore(selectedRow, targetRow.nextSibling);
                            //             updateOrder();
                            //             console.log('Moved row after target:', targetRow);
                            //         }
                            //         selectedRow.classList.remove('selected4drag-start'); // Remove the start class
                            //         selectedRow.classList.add(
                            //             'selected4drag-end'); // Add a different class to indicate the end of selection
                            //         setTimeout(() => {
                            //             // Select all rows and remove the classes
                            //             const allRows = document.querySelectorAll('#draggable-table tr');
                            //             allRows.forEach(row => {
                            //                 row.classList.remove('selected4drag-end'); // Remove the end class
                            //                 row.classList.remove(
                            //                     'selected4drag-start'); // Remove the start class if needed
                            //             });
                            //         }, 3000);

                            //         selectedRow = null; // Reset selectedRow
                            //     }
                            // }



                            function handleRowClick(e, row) {
                                console.log('Row clicked:', row);
                                console.log("id:" + row.dataset.id);

                                // Get all sibling rows
                                const allRows = Array.from(row.parentNode.children); // Get all sibling rows
                                const startRowIndex = allRows.indexOf(selectedRow); // Find the index of the selected row
                                const allDraggableRows = document.querySelectorAll(
                                    'table#draggable-table tr.draggable-row td.td-drag');


                                // Check if the clicked element is a <td> with the class 'td-drag'
                                const clickedCell = e.target.closest('tr.draggable-row td.td-drag');

                                // If the clicked cell does not match the selector, ignore the click
                                if (!clickedCell) {
                                    return; // Exit the function early
                                }

                                allDraggableRows.forEach(row => {
                                    row.style.cursor = 'grabbing';
                                });
                                if (!selectedRow) {
                                    selectedRow = row; // Set the selected row
                                    selectedRow.classList.add('selected4drag-start'); // Add the class when selecting
                                    // selectedRow.style.cursor = 'grabbing';
                                } else {
                                    // Get the index of the target row
                                    const targetRow = e.currentTarget.closest('tr'); // Get the row that was clicked
                                    const endRowIndex = allRows.indexOf(targetRow); // Find the index of the target row

                                    // Ensure that the target row is different from the selected row
                                    if (targetRow && targetRow !== selectedRow) {
                                        const parent = selectedRow.parentNode; // Get the parent element (e.g., <tbody>)
                                        // console.log(`startRowIndex ${startRowIndex} < endRowIndex ${endRowIndex} ? ${startRowIndex < endRowIndex}`);
                                        // console.log(`startRowIndex ${startRowIndex} > endRowIndex ${endRowIndex} ? ${startRowIndex > endRowIndex}`);

                                        if (startRowIndex < endRowIndex) {
                                            // Move down: insert selectedRow after targetRow
                                            parent.insertBefore(selectedRow, targetRow.nextSibling); // Insert after targetRow
                                        } else {
                                            // Move up: insert selectedRow before targetRow
                                            parent.insertBefore(selectedRow, targetRow); // Move up
                                        }
                                        updateOrder(); // Call a function to update the order if necessary
                                    }

                                    // Class management
                                    selectedRow.classList.remove('selected4drag-start'); // Remove the start class
                                    selectedRow.classList.add(
                                        'selected4drag-end'); // Add a different class to indicate the end of selection

                                    // Reset classes after a timeout
                                    setTimeout(() => {
                                        const allRows = document.querySelectorAll('#draggable-table tr');
                                        allRows.forEach(row => {
                                            row.classList.remove('selected4drag-end'); // Remove the end class
                                            row.classList.remove(
                                                'selected4drag-start'); // Remove the start class if needed
                                        });
                                    }, 3000);


                                    // const allRows = document.querySelectorAll('#draggable-table tr');
                                    allRows.forEach(row => {
                                        row.style.cursor = '';
                                    });


                                    allDraggableRows.forEach(row => {
                                        row.style.cursor = 'grab';
                                    });

                                    // e.style.cursor = 'grab';
                                    selectedRow = null; // Reset selectedRow
                                }



                            }



                            function updateOrder() {
                                var order = [];
                                var rows = document.querySelectorAll('#draggable-table tr');
                                rows.forEach(function(row, index) {
                                    order.push({
                                        id: row.dataset.id,
                                        order: index + 1
                                    });
                                });
                                makeRequest('{{ route('m.mon.dws.uor') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify(order)
                                    })
                                    .then(data => {
                                        if (data.message) {
                                            jsonToastReceiver(data.message);
                                        }
                                        console.log('Order updated:', data);
                                    })
                                    .catch((error) => {
                                        if (error.message) {
                                            jsonToastReceiver(error.message);
                                        }
                                        console.error('Error:', error);
                                    });
                            }
                        });
                    </script>
                @endif
            @endif
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modalId = 'edit_wsModal';
                    const modalSelector = document.getElementById(modalId);

                    if (modalSelector) {
                        $('.dropdown-menu').on('click', '.edit-record-ws', function(event) {
                            var wsID = $(this).attr('edit_ws_id_value');
                            var projectID = $(this).attr('edit_ws_prj_id_value');
                            var karyawanID = $(this).attr('edit_ws_kar_id_value');

                            const modalToShow = new bootstrap.Modal(modalSelector);
                            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_wsModalFORM');

                            // console.log('Edit button clicked for ws_id:', wsID);
                            setTimeout(() => {
                                $.ajax({
                                    url: '{{ route('m.ws.getws') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        wsID: wsID,
                                        projectID: projectID,
                                        karyawanID: karyawanID
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        $('#edit-ws_id').val(response.id_ws);
                                        setWsWorkDateTime(response);
                                        setWsArrivalTime(response);
                                        setWsFinishTime(response);
                                        $('#edit-ws_project_id').val(response.id_project);
                                        $('#edit-ws_id_karyawan').val(response.id_karyawan);

                                        // console.log('SHOWING MODAL');
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

                        function setWsWorkDateTime(response) {
                            // $('#edit-ws_working_date').val(response.work_date.substr(0, 10));
                            $('#edit-ws_working_date').val(response.work_date);
                            var datePickerInput = modalSelector.querySelector("#edit-ws_working_date");
                            if (datePickerInput) {
                                flatpickr(datePickerInput, {
                                    enableTime: true,
                                    dateFormat: "Y-m-d H:i:S", // Correct date format
                                    altInput: true,
                                    altFormat: "F j, Y h:i K", // Format for the alternative input display
                                    allowInput: true, // Allow typing in the input field
                                    minDate: "1900-01-01", // Set minimum date
                                    maxDate: "8000-12-31", // Set maximum date
                                    onOpen: function(selectedDates, dateStr, instance) {
                                        modalSelector.removeAttribute(
                                            'tabindex'); // Remove tabindex when the modal opens
                                    },
                                    onClose: function(selectedDates, dateStr, instance) {
                                        modalSelector.setAttribute('tabindex', -
                                            1); // Set tabindex when the modal closes
                                    }
                                });
                            }

                        }

                        function setWsArrivalTime(response) {
                            $('#edit-ws_arrival_time').val(response.arrival_time);
                            // Initialize Flatpickr after setting the value
                            flatpickr("#edit-ws_arrival_time", {
                                enableTime: true,
                                noCalendar: true,
                                dateFormat: "H:i:S",
                                altInput: true,
                                altFormat: "h:i:s K",
                                allowInput: true,
                                enableSeconds: true,
                                time_24hr: false,
                                onOpen: function(selectedDates, dateStr, instance) {
                                    modalSelector.removeAttribute(
                                        'tabindex'); // Remove tabindex when the modal opens
                                },
                                onClose: function(selectedDates, dateStr, instance) {
                                    modalSelector.setAttribute('tabindex', -
                                        1); // Set tabindex when the modal closes
                                }
                            });
                        }

                        function setWsFinishTime(response) {
                            var authUserType = response.authUserType;
                            if (authUserType == 'Superuser') {
                                $('#edit-ws_finish_time').val(response.finish_time);
                                flatpickr("#edit-ws_finish_time", {
                                    enableTime: true,
                                    noCalendar: true,
                                    dateFormat: "H:i:S",
                                    altInput: true,
                                    altFormat: "h:i:s K",
                                    allowInput: true,
                                    enableSeconds: true,
                                    time_24hr: false,
                                    onOpen: function(selectedDates, dateStr, instance) {
                                        modalSelector.removeAttribute(
                                            'tabindex'); // Remove tabindex when the modal opens
                                    },
                                    onClose: function(selectedDates, dateStr, instance) {
                                        modalSelector.setAttribute('tabindex', -
                                            1); // Set tabindex when the modal closes
                                    }
                                });
                            } else {
                                $('#edit-ws_finish_time_section').hide();
                            }

                        }
                        const saveRecordBtn = document.querySelector('#' + modalId + ' #confirmSave');
                        if (saveRecordBtn) {
                            saveRecordBtn.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevent the default button behavior
                                targetedModalForm.submit(); // Submit the form if validation passes
                            });
                        }
                    }

                });
            </script>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    whichModal = "delete_wsModal";
                    const modalSelector = document.querySelector('#' + whichModal);

                    if (modalSelector) {
                        const modalToShow = new bootstrap.Modal(modalSelector);

                        setTimeout(() => {
                            $('.delete-record-ws').on('click', function() {
                                var wsID = $(this).attr('del_ws_id_value');
                                $('#' + whichModal + ' #del_ws_id').val(wsID);
                                // document.body.style.overflowY = 'hidden';
                                modalToShow.show();
                            });
                        }, 800);
                    }
                });
            </script>


            <script>
                whichModal = "add_wsModal";
                const modalSelector = document.querySelector('#' + whichModal);

                if (modalSelector) {
                    const workingDatePickerInput = document.querySelector("#ws-working_date"); // Select only one input

                    if (workingDatePickerInput) {
                        flatpickr(workingDatePickerInput, {
                            enableTime: true,
                            dateFormat: "Y-m-d H:i:S", // Format for the date and time
                            altInput: true,
                            altFormat: "j F, Y", // Format for the alternative input display
                            allowInput: true, // Allow typing in the input field
                            minDate: "1900-01-01", // Set minimum date
                            maxDate: "8000-12-31", // Set maximum date
                            onOpen: function(selectedDates, dateStr, instance) {
                                modalSelector.removeAttribute('tabindex'); // Remove tabindex when the modal opens
                            },
                            onClose: function(selectedDates, dateStr, instance) {
                                modalSelector.setAttribute('tabindex', -1); // Set tabindex when the modal closes
                            }
                        });
                    }
                }
            </script>


            @if (isset($modalData['modal_lock']))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        whichModal1 = "lock_wsModal";

                        setTimeout(() => {
                            $('.lock-ws-cmd').on('click', function() {
                                var wsID = $(this).attr('lock_ws_id_value');
                                // var prjID = $(this).attr('lock_prj_id_value');

                                const modalSelector = document.querySelector('#' + whichModal1);
                                const modalToShow = new bootstrap.Modal(modalSelector);

                                $.ajax({
                                    url: '{{ route('m.ws.getws4lockunlock') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        wsID: wsID,
                                        // prjID: prjID
                                    },
                                    success: function(response) {
                                        // console.log(response);
                                        $('#' + whichModal1 + ' #lock-ws_id').val(response.wsID);
                                        $('#' + whichModal1 + ' #lock-project_id').val(response
                                            .projectID);
                                        setInfoText(response);

                                        // document.body.style.overflowY = 'hidden';
                                        modalToShow.show();
                                    },
                                    error: function(error) {
                                        console.log("Err [JS]:\n");
                                        console.log(error);
                                    }
                                });


                                function setInfoText(response) {
                                    setTimeout(() => {
                                        const infoText = document.querySelector('#' + whichModal1 + ' .info-text');
                                        if (infoText) {
                                            infoText.innerHTML =
                                                `Are you sure you want to <a class="text-warning">Lock the worksheet for ${response.projectID} with working date *${response.workingDate} that was executed by ${response.namaKaryawan}?</a> Please confirm by filling "<a class="text-danger">FINISH-TIME</a>" and clicking "<a class="text-danger">LOCK</a>" below.`; // Update with your desired content
                                        } else {
                                            console.error(
                                                "infoText element not found in the specified modal:",
                                                whichModal1);
                                        }
                                    }, 100);
                                }


                            });
                        }, 800);

                    });
                </script>
            @endif


            @if (isset($modalData['modal_unlock']))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {

                        setTimeout(() => {
                            $('.unlock-ws-cmd').on('click', function() {
                                var wsID = $(this).attr('unlock_ws_id_value');
                                var prjID = $(this).attr('unlock_prj_id_value');

                                whichModal2 = "unlock_wsModal";
                                const modalSelector = document.querySelector('#' + whichModal2);
                                const modalToShow = new bootstrap.Modal(modalSelector);

                                $.ajax({
                                    url: '{{ route('m.ws.getws4lockunlock') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        wsID: wsID,
                                        // prjID: prjID
                                    },
                                    success: function(response) {
                                        // console.log(response);
                                        $('#' + whichModal2 + ' #unlock-ws_id').val(response.wsID);
                                        setInfoText(response);

                                        // document.body.style.overflowY = 'hidden';
                                        modalToShow.show();
                                    },
                                    error: function(error) {
                                        console.log("Err [JS]:\n");
                                        console.log(error);
                                    }
                                });

                                function setInfoText(response) {
                                    setTimeout(() => {
                                        const infoText2 = document.querySelector('#' + whichModal2 + ' .info-text');
                                        if (infoText2) {
                                            infoText2.innerHTML =
                                                `Are you sure you want to <a class="text-warning">Unlock the worksheet for ${response.projectID} with working date *${response.workingDate} that was executed by ${response.namaKaryawan}?</a> Please confirm by clicking "<a class="text-danger">UNLOCK</a>" below.`;
                                        } else {
                                            console.error(
                                                "infoText element not found in the specified modal:",
                                                whichModal2);
                                        }
                                    }, 100);
                                }

                            });
                        }, 800);
                    });
                </script>
            @endif








            @if (isset($modalData['modal_lock_prj']))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        whichModal3 = "lock_prjModal";

                        setTimeout(() => {
                            $('.lock-prj-cmd').on('click', function() {
                                var projectID = $(this).attr('lock_prj_id_value');

                                const modalSelector3 = document.querySelector('#' + whichModal3);
                                const modalToShow3 = new bootstrap.Modal(modalSelector3);

                                $.ajax({
                                    url: '{{ route('m.ws.getprj4lockunlock') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        projectID: projectID,
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        $('#' + whichModal3 + ' #lock-prj_id').val(response
                                            .project_id);
                                        setInfoText(response);

                                        modalToShow3.show();
                                    },
                                    error: function(error) {
                                        console.log("Err [JS]:\n");
                                        console.log(error);
                                    }
                                });


                                function setInfoText(response) {
                                    setTimeout(() => {
                                        const infoText = document.querySelector('#' + whichModal3 +
                                            ' .info-prj-text');
                                        if (infoText) {
                                            infoText.innerHTML =
                                                `Are you sure you want to <a class="text-warning">Lock the project with ID ${response.project_id}?</a> Please confirm by clicking "<a class="text-danger">LOCK</a>" below.`; // Update with your desired content
                                        } else {
                                            console.error(
                                                "infoText element not found in the specified modal:",
                                                whichModal3);
                                        }
                                    }, 100);
                                }

                            });
                        }, 800);

                    });
                </script>
            @endif


            {{-- @if (isset($modalData['modal_unlock_prj'])) --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    setTimeout(() => {
                        $('.unlock-prj-cmd').on('click', function() {
                            var projectID = $(this).attr('unlock_prj_id_value');

                            whichModal4 = "unlock_prjModal";
                            const modalSelector = document.querySelector('#' + whichModal4);

                            if (modalSelector) {
                                const modalToShow = new bootstrap.Modal(modalSelector);

                                $.ajax({
                                    url: '{{ route('m.ws.getprj4lockunlock') }}',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                                    },
                                    data: {
                                        projectID: projectID,
                                    },
                                    success: function(response) {
                                        console.log(response);
                                        $('#' + whichModal4 + ' #unlock-prj_id').val(response
                                            .project_id);
                                        setInfoText(response);

                                        // document.body.style.overflowY = 'hidden';
                                        modalToShow.show();
                                    },
                                    error: function(error) {
                                        console.log("Err [JS]:\n");
                                        console.log(error);
                                    }
                                });


                                function setInfoText(response) {
                                    setTimeout(() => {
                                        const infoText2 = document.querySelector('#' + whichModal4 +
                                            ' .info-prj-text');
                                        if (infoText2) {
                                            infoText2.innerHTML =
                                                `Are you sure you want to <a class="text-warning">Unlock the project with ID ${response.project_id}?</a> Please confirm by clicking "<a class="text-danger">UNLOCK</a>" below.`; // Update with your desired content
                                        } else {
                                            console.error(
                                                "infoText element not found in the specified modal:",
                                                whichModal4);
                                        }
                                    }, 100);
                                }

                            }

                        });
                    }, 800);
                });
            </script>
            {{-- @endif --}}
        @endsection
