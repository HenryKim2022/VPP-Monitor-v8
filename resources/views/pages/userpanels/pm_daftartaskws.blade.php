@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = 'ddd, DD MMM YYYY';
    $cust_time_format = 'hh:mm:ss A';
    $reset_btn = false;
    // $authenticated_user_data = Session::get('authenticated_user_data');
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
        /* Custom CSS for Engineer Text */
        .engineer-text {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: inherit;
            /* padding: 10px; */
            border: none;
            z-index: 2;
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



    <div class="row match-height">
        <!-- QRCodeCheck-out Card -->
        <div class="col-lg-4 col-md-6 col-12">
        </div>
        <!--/ QRCodeCheck-out Card -->


        {{-- <!--  Check $data as array -->
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <pre style="color: white">{{ print_r($loadDataWS->toArray(), true) }}</pre>
                    <br>
                </div>
            </div>
        </div> --}}

        <!-- BEGIN: PhpLogicsBundle --> @include('v_res.php_logics.date_time_converter') <!-- END: PhpLogicsBundle -->
        @php
            $authUserId = $authenticated_user_data->id_karyawan ?? null;
            $authUserType = auth()->user()->type ?? null;
            $coUserId = $project->id_karyawan ?? null;
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
            $isWsStatusOpen = $loadDataWS->status_ws == 'OPEN' ? true : false;
            $blinkBGClass = $isWsStatusOpen == true ? 'blink-bg' : '';
        @endphp


        {{-- <pre style="color: white">{{ print_r($taskCategoryList->toArray(), true) }}</pre>
        <br> --}}


        <!-- TableAbsen Card -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card card-developer-meetup">
                <div class="card-body p-1">
                    @php
                        $ws_status = $loadDataWS->status_ws;
                        $blinkClass = $ws_status == 'OPEN' ? 'blink-text' : '';
                    @endphp

                    <div class="row match-height">
                        <!-- Left Card 1st -->
                        <div class="col-xl-12 col-md-12 col-12 d-flex align-items-center logo_eng_text px-0">
                            <div class="card mb-0 w-100">
                                <div class="card-body pt-0">
                                    <!-- Column 3: Engineer Text -->
                                    {{-- <div class="col text-end col-xl-3 col-md-6 col-12 d-flex align-items-top"> --}}


                                    {{-- <span class="btn btn-primary auth-role-eng-text">
                                        <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                    </span> --}}
                                    @if ($authUserType == 'Superuser')
                                        @php
                                            $ws_status = $loadDataWS->status_ws;
                                        @endphp
                                        @if ($ws_status == 'OPEN')
                                            @if (isset($modalData['modal_lock']))
                                                <button class="lock-ws-cmd btn btn-primary auth-role-eng-text"
                                                    lock_ws_id_value = "{{ $loadDataWS->id_ws ?: 0 }}"
                                                    lock_prj_id_value = "{{ $loadDataWS->id_project ?: 0 }}">
                                                    <a class="mt-0 mb-0 cursor-default text-end">
                                                        @if ($authUserType === 'Client')
                                                            CLI
                                                        @else
                                                            ENG
                                                        @endif
                                                    </a>
                                                </button>
                                            @endif

                                            {{-- <form class="row g-2 needs-validation d-flex justify-content-center"
                                                method="POST" action="{{ route('m.ws.status.lock') }}" id="lock_wsFORM"
                                                novalidate>
                                                @csrf
                                                <input type="hidden" id="lock-ws_id" name="lock-ws_id"
                                                    value="{{ $loadDataWS->id_ws }}" />
                                                <button id="confirmSave" class="btn btn-primary auth-role-eng-text">
                                                    <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                                </button>
                                            </form> --}}
                                        @else
                                            @if (isset($modalData['modal_unlock']))
                                                <button class="unlock-ws-cmd btn btn-primary auth-role-eng-text"
                                                    unlock_ws_id_value = "{{ $loadDataWS->id_ws ?: 0 }}">
                                                    <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                                </button>
                                            @endif

                                            {{-- <form class="row g-2 needs-validation d-flex justify-content-center"
                                                method="POST" action="{{ route('m.ws.status.unlock') }}" id="unlock_wsFORM"
                                                novalidate>
                                                @csrf
                                                <input type="hidden" id="unlock-ws_id" name="unlock-ws_id"
                                                    value="{{ $loadDataWS->id_ws }}" />
                                                <button id="confirmSave" class="btn btn-primary auth-role-eng-text">
                                                    <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                                </button>
                                            </form> --}}
                                        @endif
                                    @else
                                        @php
                                            $ws_status = $loadDataWS->status_ws;
                                        @endphp
                                        @if ($ws_status == 'OPEN')
                                            <button class="btn btn-primary auth-role-eng-text">
                                                <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                            </button>
                                        @else
                                            <button class="btn btn-primary auth-role-eng-text">
                                                <a class="mt-0 mb-0 cursor-default text-end">ENG</a>
                                            </button>
                                        @endif
                                    @endif






                                    {{-- </div> --}}
                                    <div class="row w-100 justify-content-between">
                                        <!-- Column 1: Brand Logo -->
                                        <div
                                            class="col text-start brand-logo col-xl-2 col-md-2 col-12 d-flex align-items-center">
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
                                                    <h3 class="mt-0 mb-0 underline-text pt-2 h3-dark">PROJECT DAILY
                                                        WORKSHEET<br>(LEMBAR KERJA HARIAN)</h3>
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
                        <div class="col-xl-7 col-md-7 col-12">
                            <div class="card mb-0 mb-0">
                                <div class="card-body overflow-x-scroll dis-overflow-y-hidden">
                                    <table class="w-100">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap cell-fit"><strong class="me-6">DESCRIPTION</strong>
                                                </td>
                                                <td class="cell-fit">: </td>
                                                <td>{{ $project->id_project }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap cell-fit"><strong class="me-6">CLIENT'S
                                                        NAME</strong></td>
                                                <td class="cell-fit">: </td>
                                                <td>
                                                    {{ $loadDataWS->project->client->na_client }}
                                                </td>
                                                {{-- <td>{{ Str::limit($loadDataWS->project->client->na_client, 35, '...') }}</td> --}}
                                            </tr>
                                            <tr>
                                                <td class="text-nowrap cell-fit"><strong class="me-6">DATE</strong></td>
                                                <td class="cell-fit">: </td>
                                                <td>
                                                    {{ convertDate($loadDataWS->working_date_ws) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/ Left Card -->

                        <!-- Right Card -->
                        <div class="col-xl-5 col-md-5 col-12">
                            <div class="card mb-0">
                                <div class="card-body overflow-x-scroll dis-overflow-y-hidden">
                                    {{-- <a class="text-end">
                                        <h6><strong>PT. VERTECH PERDANA</strong></h6>
                                    </a> --}}
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td colspan="3" class="text-nowrap"><strong>ARRIVAL TIME</strong></td>
                                                <td class="pl-2">: </td>
                                                <td>{{ convertTime($loadDataWS->arrival_time_ws) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-nowrap"><strong>FINISH TIME</strong></td>
                                                <td class="pl-2">: </td>
                                                <td>
                                                    {{ $loadDataWS->finish_time_ws != null ? convertTime($loadDataWS->finish_time_ws) : '-' }}
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--/ Right Card -->
                    </div>

                    <div class="row match-height mb-1 px-1 DIVI-1">
                        @php
                            $authUserId = $authenticated_user_data->id_karyawan ?? null;
                            $authUserType = auth()->user()->type ?? null;
                            $authUserTeam = $authenticated_user_data->id_team ?? null;
                            $engPrjTeam = $project->id_team ?? null;
                            $exeUserId = $loadDataWS->id_karyawan ?? null;
                            // echo 'engPrjTeam: ' . $engPrjTeam . ' ------ ';
                            // echo 'authUserTeam: ' . $authUserTeam . '<br>';
                            // echo 'authUserId: ' . $authUserId . ' ------ ';
                            // echo 'exeUserId: ' . $exeUserId . '<br>';
                        @endphp

                        <div class="divider-container">
                            @php
                                $ws_status = $loadDataWS->status_ws;
                                $blinkBGClass = $ws_status == 'OPEN' ? 'blink-bg' : '';
                            @endphp
                            <div class="divider"></div> <!-- Divider line -->
                            <div class="button-wrapper">
                                <div class="nav-item">
                                    <div class="d-flex justify-content-center align-items-ce d-none">
                                        <!-- Add WS -->
                                        @if ($authUserType === 'Superuser' || $isProjectOpen)
                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                    @if ($isWsStatusOpen)
                                                        <button onclick="openModal('{{ $modalData['modal_add'] }}')"
                                                            class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white add-new-record"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom" data-original-title="Add Task">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom" data-original-title="Worksheet Locked!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @else
                                                    @if ($isWsStatusOpen)
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Worksheet Locked & You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                    @if ($isWsStatusOpen)
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & Worksheet Unlocked!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & Worksheet Locked by Executor!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
                                                    @endif
                                                @else
                                                    @if ($isWsStatusOpen)
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                            <i class="fas fa-plus-circle fa-xs me-1"></i> Add
                                                        </button>
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
                                        @endif

                                    </div>
                                </div>



                                <div class="nav-item">
                                    <div class="d-flex justify-content-center align-items-ce d-none">
                                        <!-- LOCK & UNLOCK -->
                                        @if ($authUserType === 'Superuser' || $isProjectOpen)
                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                    @if ($isWsStatusOpen)
                                                        @if (isset($modalData['modal_lock']))
                                                            <button lock_ws_id_value = "{{ $loadDataWS->id_ws ?: 0 }}"
                                                                lock_prj_id_value = "{{ $loadDataWS->id_project ?: 0 }}"
                                                                class="lock-ws-cmd btn mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white {{ $blinkBGClass }}"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Lock Worksheet!">
                                                                <i class="fas fa-lock-open fa-xs me-1"></i> Lock
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Worksheet Locked!">
                                                            <i class="fas fa-lock fa-xs me-1"></i> Locked
                                                        </button>
                                                    @endif
                                                @else
                                                    @if ($isWsStatusOpen)
                                                        @if (isset($modalData['modal_lock']))
                                                            <button
                                                                class="btn mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white {{ $blinkBGClass }}"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="You're Not Authorized!">
                                                                <i class="fas fa-lock-open fa-xs me-1"></i> Lock
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="You're Not Authorized!">
                                                            <i class="fas fa-lock fa-xs me-1"></i> Unlock
                                                        </button>
                                                    @endif
                                                @endif
                                            @endif
                                        @else
                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                    @if ($isWsStatusOpen)
                                                        @if (isset($modalData['modal_lock']))
                                                            <button lock_ws_id_value = "{{ $loadDataWS->id_ws ?: 0 }}"
                                                                class="btn mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white {{ $blinkBGClass }}"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Project Locked by SPV & Worksheet Unlocked!">
                                                                <i class="fas fa-lock-open fa-xs me-1"></i> Lock
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button
                                                            class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                            style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & Worksheet Locked by Executor!">
                                                            <i class="fas fa-lock fa-xs me-1"></i> Unlock
                                                        </button>
                                                    @endif
                                                @else
                                                    @if ($isWsStatusOpen)
                                                        @if (isset($modalData['modal_lock']))
                                                            <button
                                                                class="btn mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white {{ $blinkBGClass }}"
                                                                style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                                data-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-placement="bottom"
                                                                data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                                <i class="fas fa-lock-open fa-xs me-1"></i> Lock
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

                                        @endif

                                        @if ($ws_status == 'CLOSED')
                                            @if ($authUserType === 'Client')
                                                <div class="d-flex justify-content-center align-items-ce d-none">
                                                    <button
                                                        onclick="event.preventDefault(); openModal('{{ $modalData['modal_print'] }}')"
                                                        class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white"
                                                        style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                        data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom" data-original-title="Export">
                                                        <i class="fad fa-file-export me-1"></i> Export
                                                    </button>

                                                </div>
                                            @endif
                                        @else
                                            @if ($authUserType === 'Client')
                                                <div class="d-flex justify-content-center align-items-ce d-none">
                                                    <button
                                                        class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                        style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                        data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom"
                                                        data-original-title="Worksheet Not Locked!">
                                                        <i class="fad fa-file-export me-1"></i> Export
                                                    </button>
                                                </div>
                                            @endif
                                        @endif

                                    </div>
                                </div>



                                <div class="nav-item">
                                    @if ($ws_status == 'CLOSED')
                                        @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                            <div class="d-flex justify-content-center align-items-ce d-none">
                                                <button
                                                    onclick="event.preventDefault(); openModal('{{ $modalData['modal_print'] }}')"
                                                    class="btn bg-success mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-success text-white"
                                                    style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                    data-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-placement="bottom" data-original-title="Export">
                                                    <i class="fad fa-file-export me-1"></i> Export
                                                </button>

                                            </div>
                                        @endif
                                    @else
                                        @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                            <div class="d-flex justify-content-center align-items-ce d-none">
                                                <button
                                                    class="btn bg-danger mx-1 d-inline-block rounded-1 d-flex justify-content-center align-items-center border border-danger text-white"
                                                    style="width: fit-content; height: 3rem; padding: 0.5rem;"
                                                    data-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-placement="bottom" data-original-title="Worksheet Not Locked!">
                                                    <i class="fad fa-file-export me-1"></i> Export
                                                </button>
                                            </div>
                                        @endif
                                    @endif


                                </div>
                            </div>
                        </div>

                    </div>



                    {{-- @php
                        $totalActualAtHeader = 0;
                        $totalAtHeader = 0;
                        $tempActualUnlocked = 0;
                        $tempActualLocked = 0;
                        $refnum = 0;

                        foreach ($loadDataWS['task'] as $index => $relDWS) {
                            $total = 0; // Initialize total for this monitoring entry
                            $qty = $relDWS->monitor->qty;

                            // Check if qty is defined and greater than zero
                            if ($qty) {
                                // Find the tasks related to the current monitor where the associated worksheet's expired_ws is null
        $relatedTasks = collect($project->task)->filter(function ($task) use (
            $relDWS,
            $project,
        ) {
            // Find the related worksheet for the task
            $worksheet = collect($project->worksheet)->firstWhere('id_ws', $task['id_ws']);
            // Check if the task's worksheet expired_ws is null
                                    return $task['id_monitoring'] === $relDWS->id_monitoring &&
                                        ($worksheet['expired_at_ws'] ?? null) === null; // Match tasks by id_monitoring and check expired_ws
                                });

                                // Calculate the total progress from related tasks
                                $totalProgress = 0;
                                foreach ($relatedTasks as $task) {
                                    $totalProgress += $task->progress_current_task; // Sum up the progress of related tasks
                                }

                                // Assuming you want to calculate based on the average progress
                                $up = $relatedTasks->count() > 0 ? $totalProgress / $relatedTasks->count() : 0; // Average progress
                                $total = ($qty * $up) / 100; // Calculate total percentage
                                $tempActualUnlocked += $relDWS->progress_current_task;
                                $tempActualLocked += $total; // Accumulate to totalActual
                                $refnum = $index + 1;
                            }
                        }

                            $tempActualUnlocked = number_format($tempActualUnlocked, 0);
                        // if ($isWsStatusOpen){
                            // $totalActualAtHeader = number_format($tempActualUnlocked, 1);
                        // }else{
                            $totalActualAtHeader = number_format($tempActualLocked / $refnum, 0);
                        // }
                    @endphp --}}




                    @php
                        $tbodyTotalActual = 0;
                    @endphp

                    @if (isset($project))
                        @foreach ($project->monitor as $mon)
                            @php
                                // THIS IS ORIGINALLY TOTAL PROGRESS THAT NEEDED !
                                $qty = $mon['qty'];
                                // Get all tasks associated with the project
                                $relatedTasks = $project->task; // This gets all tasks related to the project
                                $totalProgress = 0;

                                // Iterate over each task and sum the progress
                                foreach ($relatedTasks as $task) {
                                    $totalProgress += $task->sumProgressByMonitoringUnsaved($mon['id_monitoring']);
                                }

                                // Assuming you want to calculate based on the average progress
                                $up = $relatedTasks->count() > 0 ? $totalProgress / $relatedTasks->count() : 0; // Average progress

                                // Calculate total percentage (TOT)
                                $total = $qty > 0 ? ($qty * $up) / 100 : 0; // Prevent division by zero
                                $tbodyTotalActual += number_format($total, 1); // Accumulate to totalActual if needed
                            @endphp
                        @endforeach
                    @endif





                    @php
                        $theadTotalActual = 0;
                    @endphp

                    @if (isset($project))
                        @foreach ($project->monitor as $mon)
                            @php
                                // THIS IS ORIGINALLY TOTAL PROGRESS THAT NEEDED !
                                $qty = $mon['qty'];
                                // Get all tasks associated with the project
                                $relatedTasks = $project->task; // This gets all tasks related to the project
                                $totalProgress = 0;

                                // Iterate over each task and sum the progress
                                foreach ($relatedTasks as $task) {
                                    $totalProgress += $task->sumProgressByMonitoring($mon['id_monitoring']);
                                }

                                // Assuming you want to calculate based on the average progress
                                $up = $relatedTasks->count() > 0 ? $totalProgress / $relatedTasks->count() : 0; // Average progress

                                // Calculate total percentage (TOT)
                                $total = $qty > 0 ? ($qty * $up) / 100 : 0; // Prevent division by zero
                                $theadTotalActual += number_format($total); // Accumulate to totalActual if needed
                            @endphp
                        @endforeach
                    @endif
                    @php
                        $mergedThead_TbodyActual = number_format($theadTotalActual + $tbodyTotalActual, 0);

                        $headerLabel = '';
                        if ($isWsStatusOpen) {
                            $headerLabel = "($theadTotalActual%)<span class='text-warning'> + ($tbodyTotalActual%)</span>";
                        } else {
                            $headerLabel = "($theadTotalActual%)";
                        }
                    @endphp

                    <div class="TABLE-1 overflow-x-scroll dis-overflow-y-hidden">
                        {{-- <div> --}}
                        <table id="daftarTaskTable" class="table table-striped">
                            <thead>
                                <tr>
                                    @if ($loadDataWS->status_ws === 'OPEN')
                                        <th rowspan="2" class="cell-fit text-center align-middle">Act</th>
                                    @endif
                                    <th rowspan="2" class="cell-fit text-center align-middle">Time</th>
                                    <th rowspan="2" class="text-center align-middle" style="width: 26%">Task</th>
                                    <th rowspan="2" class="txt-wrap text-center align-middle">Description</th>


                                    @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                        <th colspan="2" data-toggle="tooltip" data-popup="tooltip-custom"
                                            data-placement="bottom"
                                            data-original-title="Saved: {{ number_format($theadTotalActual, 1) }}% + Unsaved: {{ number_format($tbodyTotalActual, 1) }}%"
                                            class="{{ $blinkClass }} text-center align-middle pull-up {{ $mergedThead_TbodyActual == 100 ? 'text-success' : ($mergedThead_TbodyActual > 100 ? 'text-danger' : 'text-success') }}">
                                            Progress {!! $headerLabel !!}</th>
                                    @else
                                        <th colspan="2"
                                            class="{{ $blinkClass }} text-center align-middle {{ $mergedThead_TbodyActual == 100 ? 'text-success' : ($mergedThead_TbodyActual > 100 ? 'text-danger' : 'text-success') }}">
                                            Progress {!! $headerLabel !!}</th>
                                    @endif



                                    {{-- <th colspan="2"
                                        class="{{ $blinkClass }} text-center {{ $totalActualAtHeader == 100 ? 'text-success' : ($totalActualAtHeader > 100 ? 'text-danger' : 'text-warning') }}">
                                        Progress ({{ $totalActualAtHeader }}%)
                                    </th> --}}
                                </tr>
                                <tr>
                                    <th class="cell-fit text-center align-middle">Actual</th>
                                    {{-- <th class="text-center align-middle">Current({{ $tempActualUnlocked }})</th> --}}
                                    <th class="cell-fit text-center align-middle">Current</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loadDataWS['task'] as $index => $relDWS)
                                    {{-- @dd($relDWS->toarray()); --}}
                                    <tr>
                                        @if ($loadDataWS->status_ws === 'OPEN')
                                            <td class="text-center align-middle">
                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                    <button class="btn btn-icon navbar-toggler p-0 d-inline-flex"
                                                        type="button" id="tableActionDropdown" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                                    </button>

                                                    {{-- @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                        @if ($authUserType === 'Superuser' || $authUserId == $coUserId || ($isEmployeeInTeam && $authUserId == $exeUserId)) --}}
                                                    <!-- dropdown menu -->
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="tableActionDropdown">

                                                        @if ($authUserType === 'Superuser' || $isProjectOpen)
                                                            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                                    <a class="edit-record dropdown-item d-flex align-items-center"
                                                                        edit_task_id_value = "{{ $relDWS->id_task ?: 0 }}"
                                                                        edit_project_id_value = "{{ $relDWS->id_project ?: 0 }}"
                                                                        onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                                        <i data-feather="edit" class="mr-1"
                                                                            style="color: #28c76f;"></i>
                                                                        Edit
                                                                    </a>
                                                                    <a class="delete-record dropdown-item d-flex align-items-center"
                                                                        del_task_id_value = "{{ $relDWS->id_task ?: 0 }}"
                                                                        onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                                        <i data-feather="trash" class="mr-1"
                                                                            style="color: #ea5455;"></i>
                                                                        Delete
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <!--/ dropdown menu -->
                                                </div>
                                            </td>
                                        @endif

                                        <td class="text-center align-middle">
                                            {{ convertTimeV2($relDWS->start_time_task) }}
                                        </td>
                                        <td class="txt-wrap">
                                            {{ $relDWS->monitor->category }}
                                        </td>
                                        <td class="txt-wrap">
                                            @php
                                                $descbTask = $relDWS->descb_task;
                                                if (strpos($descbTask, '*- ') !== false) {
                                                    $descbTask = str_replace(
                                                        '*- ',
                                                        '<i class="fas fa-circle fs-sm"></i>&nbsp;',
                                                        $descbTask,
                                                    );
                                                } elseif (strpos($descbTask, '- ') !== false) {
                                                    $descbTask = str_replace(
                                                        '- ',
                                                        '<i class="fas fa-circle fs-sm"></i>&nbsp;',
                                                        $descbTask,
                                                    );
                                                }
                                                $descbTask = str_replace("\n", '<br>', $descbTask);
                                            @endphp
                                            {!! $descbTask !!}
                                        </td>
                                        {{-- <td class="text-center align-middle">
                                                    @if ($relDWS->progress_actual_task != null || $relDWS->progress_actual_task != 0)
                                                        {{ $relDWS->progress_actual_task }}%
                                                    @else
                                                        0%
                                                    @endif
                                                </td> --}}
                                        {{-- <td class="text-center align-middle">
                                            @php
                                                $qty = $relDWS->monitor->qty;
                                                $up = $relDWS->last_task_progress_update($relDWS->id_monitoring);
                                                $total = ($qty * $up) / 100;
                                                // $totalActual += $total;
                                            @endphp
                                            {{ $total }}%
                                        </td> --}}

                                        {{-- <td class="text-center align-middle"
                                            rowspan="{{ $rowspanData[$relDWS->id_task] ?? 1 }}">
                                            @php
                                                $total = 0; // Initialize total for this monitoring entry
                                                $qty = $relDWS->monitor->qty;

                                                // Check if qty is defined and greater than zero
                                                if ($qty) {
                                                    // Find the tasks related to the current monitor where the associated worksheet's expired_ws is null
                                                    $relatedTasks = collect($project->task)->filter(function (
                                                        $task,
                                                    ) use ($relDWS, $project) {
                                                        // Find the related worksheet for the task
                                                        $worksheet = collect($project->worksheet)->firstWhere(
                                                            'id_ws',
                                                            $task['id_ws'],
                                                        );
                                                        // Check if the task's worksheet expired_ws is null
                                                        return $task['id_monitoring'] === $relDWS->id_monitoring &&
                                                            ($worksheet['expired_at_ws'] ?? null) === null; // Match tasks by id_monitoring and check expired_ws
                                                    });

                                                    // Calculate the total progress from related tasks
                                                    $totalProgress = 0;
                                                    foreach ($relatedTasks as $task) {
                                                        $totalProgress += $task->progress_current_task; // Sum up the progress of related tasks
                                                    }

                                                    // Assuming you want to calculate based on the average progress
                                                    $up =
                                                        $relatedTasks->count() > 0
                                                            ? $totalProgress / $relatedTasks->count()
                                                            : 0; // Average progress
                                                    $total = ($qty * $up) / 100; // Calculate total percentage

                                                    // $tbodyTotalActual += $total;
                                                }
                                            @endphp

                                            {{ number_format($total, 1) }}% <!-- Display total with 2 decimal places -->
                                        </td> --}}

                                        {{-- <td class="text-center align-middle">
                                            @php
                                                $qty = number_format($relDWS->monitor->qty, 1) . '%';
                                                echo $qty;
                                            @endphp
                                        </td> --}}


                                        {{-- <td class="text-center fit-content align-middle">
                                            <!-- THIS IS ORIGINALLY TOTAL PROGRESS AT EXCEL -->
                                            @php
                                                $totalActual = 0; // Initialize total for this monitoring entry
                                            @endphp

                                            @if ($relDWS->monitor->qty)
                                                @php
                                                    $qty = $relDWS->monitor->qty;
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
                                                    $totalActual = ($qty * $up) / 100; // Calculate total percentage
                                                @endphp
                                            @endif
                                            {{ number_format($totalActual, 1) }}%
                                        </td> --}}


                                        <td class="text-center fit-content align-middle">
                                            @php
                                                $totalActual = 0; // Initialize total for this monitoring entry
                                            @endphp

                                            @if ($relDWS->monitor->qty)
                                                @php
                                                    $qty = $relDWS->monitor->qty;
                                                    $relatedTasks = $project->task;
                                                    $totalProgress = 0;

                                                    foreach ($relatedTasks as $task) {
                                                        $totalProgress += $task->sumProgressByMonitoring(
                                                            $relDWS->monitor->id_monitoring,
                                                        );
                                                    }

                                                    $up =
                                                        $relatedTasks->count() > 0
                                                            ? $totalProgress / $relatedTasks->count()
                                                            : 0;
                                                    $totalActual = ($qty * $up) / 100;
                                                @endphp
                                            @endif
                                            {{ number_format($totalActual, 1) }}%
                                        </td>

                                        <td class="text-center align-middle">
                                            @if ($relDWS->progress_current_task != null || $relDWS->progress_current_task != 0)
                                                {{-- {{ $relDWS->progress_current_task }}% --}}
                                                {{ number_format($relDWS->progress_current_task, 1) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                            <!-- TABLE FOOTER -->
                            <tfoot>
                                <tr>
                                    <td colspan="{{ $isWsStatusOpen ? '6' : '5' }}" class="px-1">
                                        <div class="d-flex justify-content-between">
                                            @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                <strong data-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-placement="bottom"
                                                    data-original-title="Maximal remarks is 9-lines, 951-characters"
                                                    class="pull-up">
                                                    REMARK (CATATAN AKHIR)
                                                </strong>
                                            @else
                                                <strong>
                                                    REMARK (CATATAN AKHIR)
                                                </strong>
                                            @endif

                                            @if ($authUserType != 'Client')
                                                @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                                    <strong id="charCount" data-toggle="tooltip"
                                                        data-popup="tooltip-custom" data-placement="bottom"
                                                        data-original-title="Note: Please be aware that your remarks will not be saved if they exceed 951 characters in length!"
                                                        class="pull-down">(0)
                                                    </strong>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    @php
                                        $remarkWS =
                                            isset($loadDataWS->remark_ws) && !empty($loadDataWS->remark_ws)
                                                ? $loadDataWS->remark_ws
                                                : '- Tidak Ada';

                                        if ($remarkWS !== '- Tidak Ada') {
                                            // Replace bullet points with icons for display outside the textarea
                                            $formattedRemarkWS = str_replace(
                                                '*- ',
                                                '<i class="fas fa-circle fs-sm"></i>&nbsp;',
                                                $remarkWS,
                                            );
                                            $formattedRemarkWS = str_replace(
                                                '- ',
                                                '<i class="fas fa-circle fs-sm"></i>&nbsp;',
                                                $formattedRemarkWS,
                                            );
                                            // Replace new lines with line breaks for display outside the textarea
                                            $formattedRemarkWS = str_replace("\n", '<br>', $formattedRemarkWS);
                                        } else {
                                            $formattedRemarkWS = '- Tidak Ada';
                                        }

                                        // Strip HTML tags for textarea
                                        $textareaRemarkWS = strip_tags($remarkWS);
                                    @endphp

                                    <td colspan="{{ $isWsStatusOpen ? '6' : '5' }}" rowspan="1"
                                        class="p-0 align-middle">
                                        <textarea class="remark-textarea w-100 h-fit px-1 m-0 text-left border-0" ws_id_value="{{ $loadDataWS->id_ws }}"
                                            rows="9" {{ $loadDataWS->status_ws == 'OPEN' ? '' : 'disabled' }}>{!! Str::limit(htmlspecialchars($textareaRemarkWS, ENT_QUOTES, 'UTF-8'), 951, '...') !!}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="{{ $isWsStatusOpen ? '4' : '3' }}" rowspan="5" class="px-1">

                                        <div class="d-flex flex-col justify-content-around">
                                            <div class="d-flex flex-column align-items-start">
                                                <span>
                                                    <h6-sig>
                                                        <strong>
                                                            EXECUTED BY, (DIKERJAKAN OLEH)
                                                        </strong>
                                                    </h6-sig>
                                                </span>
                                                <div style="height: 8em;"></div> <!-- Empty div for spacing -->
                                                <span class="justify-content-center w-100 align-text-bottom">
                                                    <h6-sig>
                                                        {{ Str::limit($loadDataWS->karyawan->na_karyawan, 30, '...') }}
                                                    </h6-sig>
                                                </span>
                                                <span class="underline-text">
                                                    <h6-sig>
                                                        <strong>
                                                            PT. VERTECH PERDANA
                                                        </strong>
                                                    </h6-sig>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-column align-items-start ml-1">
                                                <span>
                                                    <h6-sig>
                                                        <strong>
                                                            ACKNOWLEDGED BY, (DIKETAHUI OLEH)
                                                        </strong>
                                                    </h6-sig>
                                                </span>
                                                <div style="height: 8em;"></div> <!-- Empty div for spacing -->
                                                <span class="justify-content-center w-100 align-text-bottom">
                                                    <h6-sig>
                                                        {{ Str::limit($loadDataWS->project->client->na_client, 31, '...') }}
                                                    </h6-sig>
                                                </span>
                                                <span class="underline-text">
                                                    <h6-sig>
                                                        <strong>
                                                            @php
                                                                $clientName = $loadDataWS->project->client->na_client;
                                                                $clientNameLength = mb_strlen(
                                                                    Str::limit($clientName, 37, '...'),
                                                                );
                                                                if ($clientNameLength < 38) {
                                                                    $clientNameLength = 37;
                                                                }
                                                                $clientLabelLength = mb_strlen('(CLIENT) ');
                                                                $totalLength = $clientNameLength * 3 - 2;
                                                                $dotsCount = max(
                                                                    0,
                                                                    $totalLength -
                                                                        $clientLabelLength -
                                                                        $clientNameLength,
                                                                );
                                                                echo '(CLIENT)' . str_repeat('.', $dotsCount);
                                                            @endphp
                                                        </strong>
                                                        </h6>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="2" class="px-1 text-center"><strong>Time Stamp</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="px-1 tfoot-date">
                                        <strong>
                                            Start Date:
                                        </strong>
                                        <br>
                                        {{ convertDateTime($loadDataWS->working_date_ws) }}
                                    </td>
                                    {{-- <td class="border-0"></td> --}}
                                </tr>
                                <tr>
                                    <td colspan="2" class="px-1 tfoot-date">
                                        <strong>
                                            Closed Date:
                                        </strong>
                                        <br>
                                        @if ($loadDataWS->status_ws == 'OPEN')
                                            -
                                        @else
                                            {{ convertDateTime($loadDataWS->closed_at_ws) }}
                                        @endif

                                    </td>
                                    {{-- <td class="border-0"></td> --}}
                                </tr>
                                <tr>
                                    <td colspan="2" class="px-1 text-center align-middle"><strong>Status</strong></td>
                                </tr>

                                @if ($authUserType === 'Superuser' || $isProjectOpen)
                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                        @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                            @if ($isWsStatusOpen)
                                                <tr class="lock-ws-cmd cursor-pointer"
                                                    lock_ws_id_value="{{ $loadDataWS->id_ws ?: 0 }}"
                                                    lock_prj_id_value = "{{ $loadDataWS->id_project ?: 0 }}">
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center">
                                                        <button lock_ws_id_value="{{ $loadDataWS->id_ws ?: 0 }}"
                                                            class="lock-ws-cmd btn w-100 border-0"
                                                            style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                            data-popup="tooltip-custom" data-placement="bottom"
                                                            data-original-title="Lock Worksheet!">
                                                            <h3 class="mb-0"><strong>OPEN</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button
                                                            class="border-0 d-flex bg-transparent text-white w-100 align-items-center justify-content-center"
                                                            style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                            data-popup="tooltip-custom" data-placement="bottom"
                                                            data-original-title="Worksheet Locked!">
                                                            <h3 class="mb-0"><strong>CLOSED</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            @if ($isWsStatusOpen)
                                                <tr>
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button
                                                            class="lock-ws-cmd btn border-0 align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="You're Not Authorized!">
                                                            <h3 class="mb-0"><strong>OPEN</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button
                                                            class="border-0 d-flex bg-transparent text-white align-items-center justify-content-center w-100"
                                                            style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                            data-popup="tooltip-custom" data-placement="bottom"
                                                            data-original-title="Worksheet Locked!">
                                                            <h3 class="mb-0"><strong>CLOSED</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @else
                                        @if ($isWsStatusOpen)
                                            <tr>
                                                <td colspan="2"
                                                    class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                    style="height: fit-content;">
                                                    <button
                                                        class="lock-ws-cmd btn border-0 align-items-center justify-content-center"
                                                        data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom"
                                                        data-original-title="You're Not Authorized!">
                                                        <h3 class="mb-0"><strong>OPEN</strong></h3>
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2"
                                                    class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                    style="height: fit-content;">
                                                    <button
                                                        class="border-0 d-flex bg-transparent text-white align-items-center justify-content-center w-100"
                                                        style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                        data-popup="tooltip-custom" data-placement="bottom"
                                                        data-original-title="Worksheet Locked!">
                                                        <h3 class="mb-0"><strong>CLOSED</strong></h3>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @else
                                    @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
                                        @if ($authUserType === 'Superuser' || $authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId))
                                            @if ($isWsStatusOpen)
                                                <tr class="cursor-pointer"
                                                    lock_ws_id_value="{{ $loadDataWS->id_ws ?: 0 }}">
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button lock_ws_id_value="{{ $loadDataWS->id_ws ?: 0 }}"
                                                            class="btn w-100 border-0 d-flex align-items-center justify-content-center"
                                                            style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                            data-popup ="tooltip-custom" data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & Worksheet Unlocked!">
                                                            <h3 class="mb-0"><strong>OPEN</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button
                                                            class="border-0 d-flex bg-transparent text-white align-items-center justify-content-center w-100"
                                                            style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                            data-popup="tooltip-custom" data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & Worksheet Locked!">
                                                            <h3 class="mb-0"><strong>CLOSED</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @else
                                            @if ($isWsStatusOpen)
                                                <tr>
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button
                                                            class="btn w-100 border-0 d-flex align-items-center justify-content-center"
                                                            data-toggle="tooltip" data-popup="tooltip-custom"
                                                            data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                            <h3 class="mb-0"><strong>OPEN</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="2"
                                                        class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                        style="height: fit-content;">
                                                        <button
                                                            class="mx-0 border-0 d-flex bg-transparent text-white align-items-center justify-content-center w-100"
                                                            style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                            data-popup="tooltip-custom" data-placement="bottom"
                                                            data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                            <h3 class="mb-0"><strong>CLOSED</strong></h3>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @else
                                        @if ($isWsStatusOpen)
                                            <tr>
                                                <td colspan="2"
                                                    class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                    style="height: fit-content;">
                                                    <button
                                                        class="btn w-100 border-0 d-flex align-items-center justify-content-center"
                                                        data-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-placement="bottom"
                                                        data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                        <h3 class="mb-0"><strong>OPEN</strong></h3>
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2"
                                                    class="rowlock text-center {{ $blinkBGClass != '' ? $blinkBGClass : 'bg-success' }} justify-content-center align-items-center"
                                                    style="height: fit-content;">
                                                    <button
                                                        class="mx-0 border-0 d-flex bg-transparent text-white align-items-center justify-content-center w-100"
                                                        style="padding: 0.5rem 1rem;" data-toggle="tooltip"
                                                        data-popup="tooltip-custom" data-placement="bottom"
                                                        data-original-title="Project Locked by SPV & You're Not Authorized!">
                                                        <h3 class="mb-0"><strong>CLOSED</strong></h3>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif

                                    @endif
                                @endif

                            </tfoot>

                        </table>
                    </div>


                </div>

            </div>
        </div>
        <!--/ TableAbsen Card -->

    </div>




    <!-- BEGIN: AddTaskModal--> @include('v_res.m_modals.userpanels.m_daftartask.v_add_taskModal') <!-- END: AddTaskModal-->
    <!-- BEGIN: EditTaskModal--> @include('v_res.m_modals.userpanels.m_daftartask.v_edit_taskModal') <!-- END: EditTaskModal-->
    <!-- BEGIN: DelTaskModal--> @include('v_res.m_modals.userpanels.m_daftartask.v_del_taskModal') <!-- END: DelTaskModal-->
    @if ($reset_btn)
        <!-- BEGIN: ResetTaskModal--> @include('v_res.m_modals.userpanels.m_daftartask.v_reset_taskModal') <!-- END: ResetTaskModal-->
    @endif

    @if ($isWsStatusOpen)
        <!-- BEGIN: LockWSModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_lock_wsModal') <!-- END: LockWSModal-->
    @else
        <!-- BEGIN: UnlockWSModal--> @include('v_res.m_modals.userpanels.m_daftarworksheet.v_unlock_wsModal') <!-- END: UnlockWSModal-->
        <!-- BEGIN: UnlockWSModal--> @include('v_res.m_modals.userpanels.m_daftartask.v_export_taskModal') <!-- END: UnlockWSModal-->
    @endif
@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

    <script>
        $(document).ready(function() {
            var lengthMenu = [10, 50, 100, 500, 1000, 2000, 3000]; // Length menu options

            var $table = $('#daftarTaskTable').DataTable({
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
                // autoWidth: false,
                dom: '<"card-header border-bottom p-1"<"head-label"><"d-flex justify-content-between align-items-center"<"dt-search-field"f>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                columnDefs: [{ // Set the initial column visibility
                    targets: [], // Specify the columns to hide
                    visible: false // Set visibility to false
                }],
                initComplete: function() {
                    // $(this.api().column([0]).header()).addClass('cell-fit text-center align-middle');
                    // $(this.api().column([1]).header()).addClass('cell-fit text-center align-middle');
                    // $(this.api().column([2]).header()).addClass('cell-fit text-center align-middle');
                    // $(this.api().column([3]).header()).addClass('cell-fit text-center align-middle');
                    // $(this.api().column([4]).header()).addClass('cell-fit text-center align-middle');

                    var TaskTH_w = 30;
                    var DescbTH_w = TaskTH_w + 8;
                    // After setting the width, trigger a redraw
                    $('#daftarTaskTable th:contains("Act")').css('width', '2%');
                    $('#daftarTaskTable th:contains("Time")').css('width', '3%');
                    $('#daftarTaskTable th:contains("Task")').css('width', `${ TaskTH_w }%`);
                    $('#daftarTaskTable th:contains("Description")').css('width', `${DescbTH_w}%`);
                    $('#daftarTaskTable th:contains("Actual")').css('width', '2%');
                    $('#daftarTaskTable th:contains("Current")').css('width', '2%');

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
                        <span class="dropdown-item d-flex justify-content-center align-content-center">Project Daily Worksheets</span>
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


            // configDoPrint();

            // function configDoPrint() {
            //     $('#print_taskFORM button').on('click', function(event) {
            //         event.preventDefault(); // Prevent default form submission

            //         // Get the current page length
            //         var currentLength = $table.page.len();
            //         $('#print-task-length').val(currentLength);

            //         // Get visible columns
            //         var visibleColumns = [];
            //         $table.columns().every(function(index) {
            //             if (this.visible()) {
            //                 visibleColumns.push(this.header()
            //                     .textContent); // Push the column header text
            //             }
            //         });
            //         $('#print-task-columns').val(JSON.stringify(visibleColumns)); // Store as JSON string

            //         // // Optionally set the ID for printing
            //         // $('#print-task_id').val($(this).attr('print_task_id_value'));

            //         // Submit the form
            //         $('#print_taskFORM').submit();
            //     });
            // }

            // $table.columns.adjust().responsive.recalc(); // Adjust columns

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = 'edit_taskModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_taskModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var taskID = $(this).attr('edit_task_id_value');
                var projectID = $(this).attr('edit_project_id_value');
                // console.log('Edit button clicked for task_id:', taskID);
                // setTimeout(() => {
                //     $.ajax({
                //         url: '{{ route('m.task.gettask') }}',
                //         method: 'POST',
                //         headers: {
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                //         },
                //         data: {
                //             taskID: taskID,
                //             projectID: projectID
                //         },
                //         success: function(response) {
                //             console.log(response);
                //             $('#edit-task_id').val(response.id_task);
                //             // $('#edit-task_work_time').val(response.task_worktime);
                //             // setTaskWorkTime(response);
                //             $('#edit-task_description').val(response.task_description);
                //             $('#edit-task_current_progress').val(response
                //                 .task_currentprogress);
                //             $('#edit-ws_id_ws').val(response.id_ws);
                //             $('#edit-ws_id_project').val(response.id_project);
                //             $('#edit-ws_arrival_time').val(response.arrivalTime);
                //             $('#edit-ws_finish_time').val(response.finishTime);


                //             setDescbCharCount(response);
                //             setTaskWorkTime(response);
                //             setTask(response);


                //             // console.log('SHOWING MODAL');
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
                    makeRequest('{{ route('m.task.gettask') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                taskID: taskID,
                                projectID: projectID
                            })
                        })
                        .then(response => {
                            console.log(response);
                            $('#edit-task_id').val(response.id_task);
                            // $('#edit-task_work_time').val(response.task_worktime);
                            // setTaskWorkTime(response);
                            $('#edit-task_description').val(response.task_description);
                            $('#edit-task_current_progress').val(response.task_currentprogress);
                            $('#edit-ws_id_ws').val(response.id_ws);
                            $('#edit-ws_id_project').val(response.id_project);
                            $('#edit-ws_arrival_time').val(response.arrivalTime);
                            $('#edit-ws_finish_time').val(response.finishTime);

                            setDescbCharCount(response);
                            setTaskWorkTime(response);
                            setTask(response);

                            // console.log('SHOWING MODAL');
                            // document.body.style.overflowY = 'hidden';
                            modalToShow.show();
                        })
                        .catch(error => {
                            console.log("Err [JS]:\n");
                            console.log(error);
                        });
                }); // <-- Closing parenthesis for setTimeout

            });

            function setDescbCharCount(response) {
                const charCount = response.task_description_charcount;
                const charCountDisplay = $('#' + modalId + ' #charCount');
                charCountDisplay.text(`(${charCount})`);
                if (charCount < 20) {
                    charCountDisplay.removeClass('text-success').addClass('text-danger');
                } else {
                    charCountDisplay.removeClass('text-danger').addClass('text-success');
                }
            }

            function setTaskWorkTime(response) {
                $('#edit-task_work_time').val(response.task_worktime);
                // Initialize Flatpickr after setting the value
                flatpickr("#edit-task_work_time", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i:S",
                    altInput: true,
                    altFormat: "h:i:s K",
                    allowInput: true,
                    enableSeconds: true,
                    time_24hr: false
                });
            }


            // function setTask(response) {
            //     var taskSelect = $('#' + modalId +
            //         ' #edit-task_id_monitoring');
            //     taskSelect.empty(); // Clear existing options
            //     taskSelect.append($('<option>', {
            //         value: "",
            //         text: "Select Task"
            //     }));
            //     $.each(response.taskList, function(index,
            //         taskOption) {
            //         var option = $('<option>', {
            //             value: taskOption.value,
            //             text: `${taskOption.text}`
            //         });

            //         // // Disable the option if current_progress is 0
            //         // if (parseFloat(taskOption.current_progress) === 0) {
            //         //     option.attr('disabled', 'disabled'); // Disable the option
            //         // }

            //         // Check if the option should be selected
            //         if (taskOption.selected) {
            //             option.attr('selected',
            //                 'selected'); // Select the option
            //         }

            //         taskSelect.append(option);
            //     });


            // }



            // function setTask(response) {
            //     console.log(response.taskList);

            //     var taskSelect = $('#' + modalId + ' #edit-task_id_monitoring');
            //     taskSelect.empty(); // Clear existing options
            //     taskSelect.append($('<option>', {
            //         value: "",
            //         text: "Select Task"
            //     }));

            //     $.each(response.taskList, function(index, taskOption) {
            //         var option = $('<option>', {
            //             value: taskOption.value,
            //             text: taskOption.text
            //         });

            //         // Check if the option should be selected
            //         if (taskOption.selected) {
            //             option.prop('selected', true); // Use prop instead of attr for boolean attributes
            //         }

            //         taskSelect.append(option);
            //     });
            // }



            function setTask(response) {
                console.log(response.taskList); // Log the task list for debugging

                var taskSelect = $('#edit-task_id_monitoring'); // Use the correct selector
                taskSelect.empty(); // Clear existing options
                taskSelect.append($('<option>', {
                    value: "",
                    text: "Select Task"
                }));

                $.each(response.taskList, function(index, taskOption) {
                    var option = $('<option>', {
                        value: taskOption.value,
                        text: (index+1) + ". " + taskOption.text
                    });

                    // Check if the option should be selected
                    if (taskOption.selected) {
                        option.prop('selected', true); // Use prop instead of attr for boolean attributes
                    }

                    taskSelect.append(option);
                });


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



    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                var passwordInput = $('#Password');
                var passwordFieldType = passwordInput.attr('type');
                var passwordIcon = $('.password-icon');

                if (passwordFieldType === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordIcon.attr('data-feather', 'eye-off');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordIcon.attr('data-feather', 'eye');
                }

                feather.replace(); // Refresh the Feather icons after changing the icon attribute
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            whichDelModal = "delete_taskModal";
            const modalDelSelector = document.querySelector('#' + whichDelModal);

            if (modalDelSelector) {
                const modalToShow = new bootstrap.Modal(modalDelSelector);

                setTimeout(() => {
                    $('.dropdown-menu').on('click', '.delete-record', function(event) {
                        console.log("CLICKED");
                        var taskID = $(this).attr('del_task_id_value');
                        $('#' + whichDelModal + ' #del_task_id').val(taskID);
                        // document.body.style.overflowY = 'hidden';
                        modalToShow.show();
                    });
                }, 800);

            }
        });
    </script>


    @if ($authUserType === 'Superuser' || $isWsStatusOpen)
        @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType === 'Engineer')
            @if ($authUserType === 'Superuser' || ($authUserId == $exeUserId || ($isEmployeeInTeam && $authUserId == $exeUserId)))
                <script>
                    $(document).ready(function() {
                        // Function to handle AJAX request
                        function sendRemarkUpdate() {
                            var remarkText = $('.remark-textarea').val();
                            var wsId = $('.remark-textarea').attr('ws_id_value'); // Get the worksheet ID

                            console.log(wsId);

                            // $.ajax({
                            //     url: '{{ route('m.ws.remark.edit') }}',
                            //     type: 'POST',
                            //     data: {
                            //         id_ws: wsId,
                            //         remarkText: remarkText,
                            //         _token: '{{ csrf_token() }}' // CSRF token for security
                            //     },
                            //     success: function(response) {
                            //         if (response != null && response.message) {
                            //             jsonToastReceiver(response
                            //                 .message); // Pass response.message instead of response
                            //         }

                            //         console.log('Remark updated successfully:', response);
                            //     },
                            //     error: function(xhr, status, error) {
                            //         if (xhr.responseJSON != null && xhr.responseJSON.message) {
                            //             jsonToastReceiver(xhr.responseJSON
                            //                 .message); // Pass response.message instead of response
                            //         }
                            //         console.error('Error updating remark:', error);
                            //     }
                            // });

                            makeRequest('{{ route('m.ws.remark.edit') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id_ws: wsId,
                                        remarkText: remarkText,
                                        _token: '{{ csrf_token() }}' // This can be omitted if CSRF token is managed globally
                                    })
                                })
                                .then(response => {
                                    if (response != null && response.message) {
                                        jsonToastReceiver(response.message); // Pass response.message instead of response
                                    }

                                    console.log('Remark updated successfully:', response);
                                })
                                .catch(error => {
                                    if (error.responseJSON != null && error.responseJSON.message) {
                                        jsonToastReceiver(error.responseJSON
                                        .message); // Pass response.message instead of response
                                    }
                                    console.error('Error updating remark:', error);
                                });
                        }

                        // Keydown event for Ctrl + Enter or Up Arrow + Enter
                        $('.remark-textarea').on('keydown', function(event) {
                            // Check if Enter key is pressed
                            if (event.key === 'Enter') {
                                // Check if Ctrl key is pressed or Up Arrow key was pressed
                                if (event.ctrlKey || (event.originalEvent.key === 'ArrowUp')) {
                                    event.preventDefault(); // Prevent the default action (e.g., adding a new line)
                                    sendRemarkUpdate(); // Call the function to send AJAX request
                                }
                            }
                        });

                        // Blur event for leaving the textarea
                        $('.remark-textarea').on('blur', function() {
                            // Send AJAX request when the textarea loses focus
                            sendRemarkUpdate();
                        });
                    });
                </script>
            @endif
        @endif
    @endif



    {{-- <script>
        // v_res/m_modals/userpanels/m_daftarproject/v_lock_prjModal.blade.php
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = 'lock_prjModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #lock_prjModalFORM');
            $('button').on('click', '.lock-ws-cmd', function(event) {
                var wsID = $(this).attr('lock_ws_id_value');
               console.log(wsID);


            });
        });
    </script> --}}



    @if ($isWsStatusOpen)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                whichModal = "lock_wsModal";
                const modalSelector = document.querySelector('#' + whichModal);

                if (modalSelector) {
                    const modalToShow = new bootstrap.Modal(modalSelector);

                    setTimeout(() => {
                        $('.lock-ws-cmd').on('click', function() {
                            console.log("CLICKED");
                            var wsID = $(this).attr('lock_ws_id_value');
                            var prjID = $(this).attr('lock_prj_id_value');
                            $('#' + whichModal + ' #lock-ws_id').val(wsID);
                            $('#' + whichModal + ' #lock-project_id').val(prjID);
                            setInfoText_v2_1();

                            // document.body.style.overflowY = 'hidden';
                            modalToShow.show();
                        });
                    }, 800);

                    function setInfoText_v2_1() {
                        const infoText = document.querySelector('#' + whichModal + ' .info-text');
                        const projectId = "{{ $loadDataWS->id_project }}";
                        const workingDate = "{{ $loadDataWS->working_date_ws() }}";
                        const employeeName = "{{ $loadDataWS->karyawan->na_karyawan }}";

                        infoText.innerHTML = `
                            Are you sure you want to
                            <a class="text-warning">Lock the worksheet for ${projectId} with working date *${workingDate} that was executed by ${employeeName}?</a>
                            This action <a class="text-danger">cannot be undone</a>.
                            Please confirm by filling "<a class='text-danger'>FINISH-TIME</a>" and clicking "<a class="text-danger">LOCK</a>" below.
                        `;
                    }
                }
            });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                whichModal = "unlock_wsModal";
                const modalSelector = document.querySelector('#' + whichModal);

                if (modalSelector) {
                    const modalToShow = new bootstrap.Modal(modalSelector);

                    setTimeout(() => {
                        $('.unlock-ws-cmd').on('click', function() {
                            var wsID = $(this).attr('unlock_ws_id_value');
                            $('#' + whichModal + ' #unlock-ws_id').val(wsID);
                            setInfoText_v2_2();

                            // document.body.style.overflowY = 'hidden';
                            modalToShow.show();
                        });

                    }, 800);

                    function setInfoText_v2_2() {
                        const infoText = document.querySelector('#' + whichModal + ' .info-text');
                        const projectId = "{{ $loadDataWS->id_project }}";
                        const workingDate = "{{ $loadDataWS->working_date_ws() }}";
                        const employeeName = "{{ $loadDataWS->karyawan->na_karyawan }}";

                        infoText.innerHTML = `
                            Are you sure you want to
                            <a class="text-warning">Unlock the worksheet for ${projectId} with working date *${workingDate} that was executed by ${employeeName}?</a>
                            Please confirm by clicking "<a class="text-danger">UNLOCK</a>" below.
                        `;
                    }
                }

            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const remarkstextarea = document.querySelector('.remark-textarea');
            const charCountDisplay = document.getElementById('charCount');

            if (remarkstextarea && charCountDisplay) {
                function updateCharacterCount() {
                    const charCount = remarkstextarea.value.length;
                    charCountDisplay.textContent = `(${charCount})`;
                    if (charCount > 951) {
                        charCountDisplay.classList.remove('text-success');
                        charCountDisplay.classList.add('text-danger');
                    } else {
                        charCountDisplay.classList.remove('text-danger');
                        charCountDisplay.classList.add('text-success');
                    }

                    if (charCount === 0) {
                        setTimeout(() => {
                            if (remarkstextarea.value.length === 0) {
                                remarkstextarea.value = "- Tidak Ada";
                                updateCharacterCount();
                            }
                        }, 3000); // 3 seconds
                    }

                }

                updateCharacterCount();
                remarkstextarea.addEventListener('input', updateCharacterCount);
            } else {
                console.error('Textarea or character count display not found.');
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //4 ADD MODAL
            const whichAddModal = "add_taskModal";
            const modalAddSelector = document.querySelector('#' + whichAddModal);
            if (modalAddSelector) {
                const taskdscbtextareaModalAdd = modalAddSelector.querySelector(
                    '#task-description');
                const charCountDisplayModalAdd = modalAddSelector.querySelector(
                    '#charCount');
                if (taskdscbtextareaModalAdd && charCountDisplayModalAdd) {
                    function updateCharacterCountModalAdd() {
                        const charCount = taskdscbtextareaModalAdd.value
                            .length;
                        charCountDisplayModalAdd.textContent = `(${charCount})`;

                        if (charCount < 20) {
                            charCountDisplayModalAdd.classList.remove('text-success');
                            charCountDisplayModalAdd.classList.add('text-danger');
                        } else {
                            charCountDisplayModalAdd.classList.remove('text-danger');
                            charCountDisplayModalAdd.classList.add('text-success');
                        }
                    }

                    updateCharacterCountModalAdd();
                    taskdscbtextareaModalAdd.addEventListener('input', updateCharacterCountModalAdd);
                } else {
                    console.error('Textarea or character count display not found.');
                }
            }

            //4 EDIT MODAL
            const whichEditModal = "edit_taskModal";
            const modalEditSelector = document.querySelector('#' + whichEditModal);
            if (modalEditSelector) {
                const taskdscbtextareaModalEdit = modalEditSelector.querySelector(
                    '#edit-task_description');
                const charCountDisplayModalEdit = modalEditSelector.querySelector(
                    '#charCount');
                if (taskdscbtextareaModalEdit && charCountDisplayModalEdit) {
                    function updateCharacterCountModalEdit() {
                        const charCount = taskdscbtextareaModalEdit.value
                            .length;
                        charCountDisplayModalEdit.textContent = `(${charCount})`;

                        if (charCount < 20) {
                            charCountDisplayModalEdit.classList.remove('text-success');
                            charCountDisplayModalEdit.classList.add('text-danger');
                        } else {
                            charCountDisplayModalEdit.classList.remove('text-danger');
                            charCountDisplayModalEdit.classList.add('text-success');
                        }
                    }

                    updateCharacterCountModalEdit();
                    taskdscbtextareaModalEdit.addEventListener('input', updateCharacterCountModalEdit);
                } else {
                    console.error('Textarea or character count display not found.');
                }
            }
        });
    </script>

@endsection
