@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = $page['custom_date_format'];
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




    <div class="row match-height">
        <!--  Check $data as array -->
        {{-- <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <pre style="color: white">{{ print_r($loadDaftarTeamFromDB->toArray(), true) }}</pre>
                    <pre style="color: white">{{ print_r($employee_list->toArray(), true) }}</pre>
                    <br>
                </div>
            </div>
        </div> --}}

        <!-- QRCodeCheck-out Card -->
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-developer-meetup">
                <div class="card-body p-1">

                    <!-- Tab menu -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="teams-pill-general" data-toggle="pill" href="#teams-vertical-general"
                                role="tab" aria-controls="teams-vertical-general" aria-selected="false">
                                <i class="fas fa-list"></i> Team List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="emp-pill-team" data-toggle="pill" href="#emp-vertical-team"
                                role="tab" aria-controls="emp-vertical-team" aria-selected="true">
                                <i class="fas fa-user-plus"></i> Assign Employee
                            </a>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content">
                        <!-- General Team List Content -->
                        <div role="tabpanel" class="tab-pane fade" id="teams-vertical-general"
                            aria-labelledby="teams-pill-general" aria-expanded="false">


                            <div class="row match-height my-1 px-1">
                                <div class="divider-container">
                                    <div class="divider"></div> <!-- Divider line -->
                                    <div class="button-wrapper">
                                        <div class="nav-item">
                                            @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                                @if ($modalData['modal_add'])
                                                    <button onclick="openModal('{{ $modalData['modal_add'] }}')"
                                                        class="btn bg-success mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-success add-new-record"
                                                        style="width: 3rem; height: 3rem; padding: 0;">
                                                        <i class="fas fa-plus-circle fa-xs text-white"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="nav-item">
                                            @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                                <form class="needs-validation" method="POST"
                                                    {{-- action="{{ route('m.mon.printmon') }}" --}} id="print_moniFORM" novalidate>
                                                    @csrf
                                                    <input type="hidden" id="print-moni_id" name="print-moni_id" />
                                                    <button
                                                        class="btn bg-success mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-success add-new-record"
                                                        style="width: 3rem; height: 3rem; padding: 0;">
                                                        <i class="fas fa-print fa-xs text-white"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <table id="daftarTeamTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Act</th>
                                        <th>Team Name</th>
                                        <th>Assigned Employee</th>
                                        <th>Created</th>
                                        <th>Last-Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{dd($loadDaftarTeamFromDB->toArray());}} --}}
                                    @foreach ($loadDaftarTeamFromDB as $team)
                                        <tr>
                                            <td class="cell-fit text-center">
                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                    <button class="btn btn-icon navbar-toggler p-0" type="button"
                                                        id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                                    </button>
                                                    <!-- dropdown menu -->
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="tableActionDropdown">
                                                        <a class="edit-record dropdown-item d-flex align-items-center"
                                                            team_id_value = "{{ $team->id_team }}"
                                                            karyawan_id_value = "{{ $team->karyawan !== null ? $team->karyawan->id_karyawan : 0 }}"
                                                            onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                            <i data-feather="edit" class="mr-1"
                                                                style="color: #28c76f;"></i>
                                                            Edit
                                                        </a>
                                                        <a class="delete-record dropdown-item d-flex align-items-center"
                                                            team_id_value = "{{ $team->id_team }}"
                                                            onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                            <i data-feather="trash" class="mr-1"
                                                                style="color: #ea5455;"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                    <!--/ dropdown menu -->
                                                </div>
                                            </td>
                                            <td>{{ $team->na_team ?: '-' }}</td>
                                            <td>
                                                <div class="col-12">
                                                    <select class="team-select2-assign form-control" multiple>
                                                        @foreach ($employee_list as $employee)
                                                            <option value="{{ $employee->id_karyawan }}"
                                                                @if ($employee->id_team) disabled @endif
                                                                @if ($employee->id_team == $team->id_team) selected @endif>
                                                                {{ $employee->na_karyawan }}
                                                                @if ($employee->id_team)
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>{{ $team->created_at ?: '-' }}</td>
                                            <td>{{ $team->updated_at ?: '-' }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <!-- Change Employee Team Tab Content -->
                        <div class="tab-pane active" id="emp-vertical-team" role="tabpanel" aria-labelledby="emp-pill-team"
                            aria-expanded="true">

                            <div class="row match-height my-1 px-1">
                                <div class="divider-container">
                                    <div class="divider"></div> <!-- Divider line -->
                                    <div class="button-wrapper">
                                        <div class="nav-item">
                                            @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                                @if ($modalData['modal_add'])
                                                    <button onclick="openModal('{{ $modalData['modal_add'] }}')"
                                                        class="btn bg-success mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-success add-new-record"
                                                        style="width: 3rem; height: 3rem; padding: 0;">
                                                        <i class="fas fa-plus-circle fa-xs text-white"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="nav-item">
                                            @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                                <form class="needs-validation" method="POST"
                                                    {{-- action="{{ route('m.mon.printmon') }}" --}} id="print_moniFORM" novalidate>
                                                    @csrf
                                                    <input type="hidden" id="print-moni_id" name="print-moni_id" />
                                                    <button
                                                        class="btn bg-success mx-1 d-inline-block rounded-circle d-flex justify-content-center align-items-center border border-success add-new-record"
                                                        style="width: 3rem; height: 3rem; padding: 0;">
                                                        <i class="fas fa-print fa-xs text-white"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table id="daftarEmployeeTeamTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Act</th>
                                        <th>Employee Name</th>
                                        <th>Team</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{dd($loadDaftarTeamFromDB->toArray());}} --}}
                                    @foreach ($employee_list as $emp)
                                        <tr>
                                            <td class="cell-fit text-center">
                                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                                    <button class="btn btn-icon navbar-toggler p-0" type="button"
                                                        id="tableActionDropdown" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                                    </button>
                                                    <!-- dropdown menu -->
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="tableActionDropdown">
                                                        <a class="edit-record dropdown-item d-flex align-items-center"
                                                            karyawan_id_value = "{{ $emp !== null ? $emp->id_karyawan : 0 }}"
                                                            team_id_value = "{{ $emp->team != null ? $emp->team->id_team : 0 }}"
                                                            onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                            <i data-feather="edit" class="mr-1"
                                                                style="color: #28c76f;"></i>
                                                            Edit
                                                        </a>
                                                        <a class="delete-record dropdown-item d-flex align-items-center"
                                                            karyawan_id_value = "{{ $emp !== null ? $emp->id_karyawan : 0 }}"
                                                            team_id_value = "{{ $emp->team != null ? $emp->team->id_team : 0 }}"
                                                            onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                            <i data-feather="trash" class="mr-1"
                                                                style="color: #ea5455;"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                    <!--/ dropdown menu -->
                                                </div>
                                            </td>
                                            <td>{{ $emp->na_karyawan ?: '-' }}</td>
                                            <td>{{ $emp->team !== null ? $emp->team->na_team : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-body p-1"></div> --}}
            </div>

            {{--
            <div class="card card-developer-meetup">
                <div class="card-body p-0">

                </div>
            </div> --}}



        </div>
        <!--/ QRCodeCheck-out Card -->

        {{-- <!-- TableAbsen Card -->
        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card card-developer-meetup">
            </div>
        </div>
        <!--/ TableAbsen Card --> --}}



    </div>







    <!-- BEGIN: AddTimModal--> @include('v_res.m_modals.userpanels.m_daftartim.v_add_timModal') <!-- END: AddTimModal-->
    <!-- BEGIN: EditTimModal--> @include('v_res.m_modals.userpanels.m_daftartim.v_edit_timModal') <!-- END: EditTimModal-->
    <!-- BEGIN: DelTimModal--> @include('v_res.m_modals.userpanels.m_daftartim.v_del_timModal') <!-- END: DelTimModal-->
    @if ($reset_btn)
        <!-- BEGIN: ResetTimModal--> @include('v_res.m_modals.userpanels.m_daftartim.v_reset_timModal') <!-- END: ResetTimModal-->
    @endif
@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#daftarTeamTable').DataTable({
                lengthMenu: [5, 10, 15, 20, 25, 50, 100, 150, 200, 250],
                pageLength: 10,
                responsive: true,
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
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#daftarEmployeeTeamTable').DataTable({
                lengthMenu: [5, 10, 15, 20, 25, 50, 100, 150, 200, 250],
                pageLength: 10,
                responsive: true,
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
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = 'edit_roleModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_teamModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var timID = $(this).attr('team_id_value');
                var karyawanID = $(this).attr('karyawan_id_value');
                // console.log('Edit button clicked for team_id:', timID);

                setTimeout(() => {
                    $.ajax({
                        url: '{{ route('m.emp.teams.getteam') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                        },
                        data: {
                            timID: timID,
                            karyawanID: karyawanID
                        },
                        success: function(response) {
                            console.log(response);
                            $('#team_id').val(response.id_team);
                            $('#karyawan_id').val(response.id_karyawan);
                            $('#team_name').val(response.na_team);
                            setEmpList(response);

                            // console.log('SHOWING MODAL');
document.body.style.overflowY = 'hidden';
modalToShow.show();
                        },
                        error: function(error) {
                            console.log("Err [JS]:\n");
                            console.log(error);
                        }
                    });
                }); // <-- Closing parenthesis for setTimeout
            });




            function setEmpList(response) {
                var empSelect = $('#' + modalId +
                    ' #edit-team-karyawan-id');
                empSelect.empty(); // Clear existing options
                empSelect.append($('<option>', {
                    value: "",
                    text: "Select Employee"
                }));
                $.each(response.employeeList, function(index,
                    empOption) {
                    var option = $('<option>', {
                        value: empOption.value,
                        text: `[${empOption.value}] ${empOption.text}`
                    });
                    if (empOption.selected) {
                        option.attr('selected',
                            'selected'); // Select the option
                    }
                    empSelect.append(option);
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


    {{--
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
    </script> --}}




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            whichModal = "delete_teamModal";
            const modalSelector = document.querySelector('#' + whichModal);
            const modalToShow = new bootstrap.Modal(modalSelector);

            setTimeout(() => {
                $('.delete-record').on('click', function() {
                    var teamID = $(this).attr('team_id_value');
                    $('#' + whichModal + ' #team_id').val(teamID);
                     document.body.style.overflowY = 'hidden';
modalToShow.show();
                });
            }, 200);

        });
    </script>

    <script>
        $(document).ready(function() {
            function loadEmployees(teamId, selectElement) {
                $.ajax({
                    url: '{{ route('m.emp.teams.loadopt') }}', // Use the route to get employees
                    type: 'GET',
                    success: function(data) {
                        var selectedValues = selectElement.val() ||
                    []; // Store currently selected values
                        selectElement.empty(); // Clear existing options

                        // Create a map to track disabled employee IDs
                        var disabledEmployees = {};

                        // Filter employees based on teamId
                        $.each(data, function(index, employee) {
                            var isDisabled = employee.id_team ? true :
                            false; // Disable if employee is assigned to a team
                            if (employee.id_team == teamId || !employee
                                .id_team) { // Include employees with the same team ID or without a team
                                selectElement.append($('<option>', {
                                    value: employee.id_karyawan,
                                    text: employee.na_karyawan,
                                    disabled: isDisabled
                                }));

                                // If the employee is disabled, track their ID
                                if (isDisabled) {
                                    disabledEmployees[employee.id_karyawan] = true;
                                }
                            }
                        });

                        // Reselect the previously selected values
                        selectElement.val(selectedValues).trigger(
                        'change'); // Set selected values directly and notify Select2 to refresh the dropdown
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Initialize Select2 for each row
            $('#daftarEmployeeTeamTable tbody tr').each(function() {
                var teamId = $(this).find('.edit-record').attr(
                'team_id_value'); // Get the team ID from the row
                var selectElement = $(this).find(
                '.team-select2-assign'); // Find the select element in the current row

                // Load employees for this specific team
                loadEmployees(teamId, selectElement);
            });

            $('.team-select2-assign').select2({
                placeholder: "Assign Employees",
                allowClear: false,
                closeOnSelect: false // Prevent closing the dropdown after selection
            }).on("select2:unselect", function(e) {
                var employeeId = e.params.data.id; // Get the ID of the unselected employee
                var teamId = $(this).closest('tr').find('.edit-record').attr(
                'team_id_value'); // Get the team ID from the row

                // Send AJAX request to update the database
                $.ajax({
                    url: '{{ route('m.emp.teams.unassign') }}',
                    type: 'POST',
                    data: {
                        employee_id: employeeId,
                        team_id: teamId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.message);
                        loadEmployees(teamId, $(this)); // Reload employees to reflect changes
                    }.bind(this), // Bind 'this' to maintain context
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }).on("select2:select", function(e) {
                var employeeId = e.params.data.id; // Get the ID of the selected employee
                var teamId = $(this).closest('tr').find('.edit-record').attr(
                'team_id_value'); // Get the team ID from the row

                // Send AJAX request to update the database
                $.ajax({
                    url: '{{ route('m.emp.teams.assign') }}',
                    type: 'POST',
                    data: {
                        employee_id: employeeId,
                        team_id: teamId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.message);
                        loadEmployees(teamId, $(this)); // Reload employees to reflect changes
                    }.bind(this), // Bind 'this' to maintain context
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
