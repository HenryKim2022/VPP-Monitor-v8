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

                    <div class="row match-height KOP-1">
                        <!-- Left Card 1st -->
                        <div class="col-xl-12 col-md-12 col-12 d-flex align-items-center logo_eng_text px-0">
                            <div class="card mb-0 w-100">
                                <div class="card-body pt-0">
                                    <!-- Column 3: Engineer Text -->
                                    {{-- <div class="col text-end col-xl-3 col-md-6 col-12 d-flex align-items-top"> --}}
                                    <span class="btn btn-primary auth-role-eng-text">
                                        <a class="mt-0 mb-0 cursor-default text-end">SU</a>
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
                                                    <h3 class="mt-0 mb-0 underline-text pt-2 h3-dark">EMPLOYEE TEAMS</h3>
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
                                    @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                        @if ($modalData['modal_add'])
                                            <button onclick="openModal('{{ $modalData['modal_add'] }}')"
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


                    <table id="daftarTeamTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">Act</th>
                                <th class="align-middle text-center">Team Name</th>
                                <th class="align-middle text-center">Assigned Employee</th>
                                <th class="align-middle text-center">Created</th>
                                <th class="align-middle text-center">Last-Update</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

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

    {{-- <script>
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
    </script> --}}



    {{--
    <script>
        $(document).ready(function() {
            let employeelists = [];
            let teamAssignments = {}; // Object to store assignments

            // Fetch employee data first
            $.ajax({
                url: '{{ route('m.emp.teams.load.emplists') }}',
                type: 'GET',
                success: function(data) {
                    employeelists = data.employeelists; // Store the employee list
                    initializeDataTable(); // Initialize DataTable after fetching employees
                }
            });

            function initializeDataTable() {
                $('#daftarTeamTable').DataTable({
                    ajax: {
                        url: '{{ route('m.emp.teams.load.teamlists') }}',
                        type: 'GET',
                        dataSrc: 'teamlists'
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row) {
                                return `
                                <div class="dropdown d-lg-block d-sm-block d-md-block">
                                    <button class="btn btn-icon navbar-toggler p-0" type="button" id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="tableActionDropdown">
                                        <a class="edit-record dropdown-item d-flex align-items-center" team_id_value="${row.id_team}" karyawan_id_value="${row.karyawans.length > 0 ? row.karyawans[0].id_karyawan : 0}" onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                            <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                            Edit
                                        </a>
                                        <a class="delete-record dropdown-item d-flex align-items-center" team_id_value="${row.id_team}" onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                            <i data-feather="trash" class="mr-1" style="color: #ea5455;"></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>`;
                            }
                        },
                        {
                            data: 'na_team',
                            defaultContent: '-'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let options = '';
                                // Initialize the teamAssignments for this team if not already done
                                if (!teamAssignments[row.id_team]) {
                                    teamAssignments[row.id_team] = row.karyawans.map(k => k.id_karyawan);
                                }

                                // Loop through the employees and create options
                                employeelists.forEach(employee => {
                                    options += `
                                        <option value="${employee.id_karyawan}"
                                        ${teamAssignments[row.id_team].includes(employee.id_karyawan) ? 'selected' : ''}
                                        ${employee.id_team ? 'disabled' : ''}>
                                        ${employee.na_karyawan}
                                        </option>`;
                                });
                                return `<select class="team-select2-assign form-control" multiple>${options}</select>`;
                            }
                        },
                        {
                            data: 'created_at',
                            defaultContent: '-'
                        },
                        {
                            data: 'updated_at',
                            defaultContent: '-'
                        }
                    ],
                    lengthMenu: [5, 10, 15, 20, 25, 50, 100, 150, 200, 250],
                    pageLength: 10,
                    responsive: true,
                    ordering: true,
                    searching: true,
                    language: {
                        lengthMenu: 'Display _MENU_ records per page',
                        info: 'Showing page _PAGE _ of _PAGES_',
                        search: 'Search',
                    }
                });

                // Initialize Select2 after the DataTable is created
                $('#daftarTeamTable').on('draw.dt', function() {
                    $('.team-select2-assign').select2({
                        placeholder: "Assign Employees",
                        allowClear: false,
                        closeOnSelect: false
                    }).on("select2:unselect", function(e) {
                        let $select = $(this);
                        let employeeId = e.params.data.id;
                        let teamId = $(this).closest('tr').find('.edit-record').attr('team_id_value');

                        // Update the teamAssignments mapping
                        teamAssignments[teamId] = teamAssignments[teamId].filter(id => id !== employeeId);

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
                                // Enable the option in other teams
                                enableOptionInOtherTeams(employeeId, teamId);
                            }.bind(this),
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });
                    }).on("select2:select", function(e) {
                        let $select = $(this);
                        let employeeId = e.params.data.id;
                        let teamId = $(this).closest('tr').find('.edit-record').attr('team_id_value');

                        // Update the teamAssignments mapping
                        if (!teamAssignments[teamId]) {
                            teamAssignments[teamId] = [];
                        }
                        teamAssignments[teamId].push(employeeId);

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
                                // Disable the option in other teams
                                disableOptionInOtherTeams(employeeId, teamId);
                            }.bind(this),
                            error: function(xhr) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            }

            // Function to enable an option in other teams
            function enableOptionInOtherTeams(employeeId, currentTeamId) {
                $('#daftarTeamTable').find('tr').each(function() {
                    let teamId = $(this).find('.edit-record').attr('team_id_value');
                    if (teamId !== currentTeamId) {
                        $(this).find(`option[value="${employeeId}"]`).prop('disabled', false);
                    }
                });
            }

            // Function to disable an option in other teams
            function disableOptionInOtherTeams(employeeId, currentTeamId) {
                $('#daftarTeamTable').find('tr').each(function() {
                    let teamId = $(this).find('.edit-record').attr('team_id_value');
                    if (teamId !== currentTeamId) {
                        $(this).find(`option[value="${employeeId}"]`).prop('disabled', true);
                    }
                });
            }
        });
    </script>
 --}}








    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = 'edit_teamModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_teamModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var timID = $(this).attr('team_id_value');
                var karyawanID = $(this).attr('karyawan_id_value');
                // console.log('Edit button clicked for team_id:', timID);

                // setTimeout(() => {
                //     $.ajax({
                //         url: '{{ route('m.emp.teams.getteam') }}',
                //         method: 'POST',
                //         headers: {
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                //         },
                //         data: {
                //             timID: timID,
                //             // karyawanID: karyawanID
                //         },
                //         success: function(response) {
                //             console.log(response);
                //             $('#team_id').val(response.id_team);
                //             // $('#karyawan_id').val(response.id_karyawan);
                //             $('#team_name').val(response.na_team);

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
                    makeRequest('{{ route('m.emp.teams.getteam') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                timID: timID,
                                // karyawanID: karyawanID // Uncomment if needed
                            })
                        })
                        .then(response => {
                            console.log(response);
                            $('#team_id').val(response.id_team);
                            // $('#karyawan_id').val(response.id_karyawan); // Uncomment if needed
                            $('#team_name').val(response.na_team);

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
        var currentOpenSelect2 = null; // Variable to track the currently open Select2
        var lastUpdatedAt = null; // Variable to store the last updated timestamp
        var isUpdating = false; // Flag to prevent immediate updates
        $(document).ready(function() {
            var modalData = {
                modal_add: '#add_teamModal',
                modal_edit: '#edit_teamModal',
                modal_delete: '#delete_teamModal',
                modal_reset: '#reset_teamModal',
            };

            let employeelists = [];
            let teamAssignments = {}; // Object to store assignments

            // // Fetch employee data first
            // $.ajax({
            //     url: '{{ route('m.emp.teams.load.emplists') }}',
            //     type: 'GET',
            //     success: function(data) {
            //         employeelists = data.employeelists; // Store the employee list
            //         initializeDataTable(); // Initialize DataTable after fetching employees
            //         startPolling(); // Start polling for database updates
            //     }
            // });

            // Fetch employee data first
            makeRequest('{{ route('m.emp.teams.load.emplists') }}', {
                    method: 'GET'
                })
                .then(data => {
                    employeelists = data.employeelists; // Store the employee list
                    initializeDataTable(); // Initialize DataTable after fetching employees
                    startPolling(); // Start polling for database updates
                })
                .catch(error => {
                    console.error('Error fetching employee data:', error);
                });

            // Call this function after your table is rendered or updated
            function initializeFeatherIcons() {
                feather.replace();
            }

            function formatDate(dateString) {
                const options = {
                    weekday: 'short',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('en-US', options);
            }

            function initializeDataTable() {
                var lengthMenu = [10, 50, 100, 500, 1000, 2000, 3000]; // Length menu options

                var $table = $('#daftarTeamTable').DataTable({
                    ajax: {
                        url: '{{ route('m.emp.teams.load.teamlists') }}',
                        type: 'GET',
                        dataSrc: 'teamlists',
                        complete: function(data) {
                            console.log(data.responseJSON.teamlists);
                        }
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row) {
                                return `
                            <div class="dropdown d-lg-block d-sm-block d-md-block">
                                <button class="btn btn-icon navbar-toggler p-0 d-inline-flex" type="button" id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="align-justify" class="font-medium-5"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="tableActionDropdown">
                                    <a class="edit-record dropdown-item d-flex align-items-center" team_id_value="${row.id_team}" karyawan_id_value="${row.karyawans.length > 0 ? row.karyawans[0].id_karyawan : 0}" onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                        <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                        Edit
                                    </a>
                                    <a class="delete-record dropdown-item d-flex align-items-center" team_id_value="${row.id_team}" onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                        <i data-feather="trash" class="mr-1" style="color: #ea5455;"></i>
                                        Delete
                                    </a>
                                </div>
                            </div>`;
                            },
                            className: 'cell-fit text-center align-middle'
                        },
                        {
                            data: 'na_team',
                            defaultContent: '-',
                            className: 'cell-fit text-center align-middle'
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let options = '';
                                // Initialize the team Assignments for this team if not already done
                                if (!teamAssignments[row.id_team]) {
                                    teamAssignments[row.id_team] = row.karyawans.map(k => k
                                        .id_karyawan);
                                }

                                // Loop through the employees and create options
                                employeelists.forEach(employee => {
                                    options += `
                            <option value="${employee.id_karyawan}"
                            ${teamAssignments[row.id_team].includes(employee.id_karyawan) ? 'selected' : ''}
                            ${employee.id_team ? 'disabled' : ''}>
                            ${employee.na_karyawan}
                            </option>`;
                                });
                                return `<select class="team-select2-assign form-control" multiple>${options}</select>`;
                            }
                        },
                        {
                            data: 'created_at',
                            render: function(data) {
                                return formatDate(data); // Format the created_at date
                            },
                            className: 'text-center align-middle',
                            defaultContent: '-'
                        },

                        {
                            data: 'updated_at',
                            render: function(data) {
                                return formatDate(data); // Format the updated_at date
                            },
                            className: 'text-center align-middle',
                            defaultContent: '-'
                        }
                    ],
                    lengthMenu: lengthMenu,
                    pageLength: 100,
                    responsive: false,
                    ordering: true,
                    searching: true,
                    language: {
                        lengthMenu: 'Display _MENU_ records per page',
                        info: 'Showing page _PAGE_ of _PAGES_',
                        search: 'Search',
                    },
                    scrollCollapse: true,
                    dom: '<"card-header border-bottom p-1"<"head-label"><"d-flex justify-content-between align-items-center"<"dt-search-field"f>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    columnDefs: [{ // Set the initial column visibility
                        targets: [3, 4], // Specify the columns to hide
                        visible: false // Set visibility to false
                    }],
                    initComplete: function() {
                        $(this.api().column([0]).header()).addClass('cell-fit text-center');
                        $(this.api().column([1]).header()).addClass('cell-fit text-center');

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
                            <span class="dropdown-item d-flex justify-content-center align-content-center">Employee Teams</span>
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
                    initializeFeatherIcons();
                });

                // Prevent dropdown from closing when interacting with select field or column visibility options
                $(document).on('click', '.dropdown-item select, .dropdown-item a, .colvis-checkbox', function(
                    event) {
                    event.stopPropagation(); // Prevent the dropdown from closing
                });

                // Initialize Select2 after the DataTable is created
                $('#daftarTeamTable').on('draw.dt', function() {
                    $('.team-select2-assign').select2({
                        placeholder: "Assign Employees",
                        allowClear: false,
                        closeOnSelect: true
                    }).on("select2:unselect", function(e) {
                        let employeeId = e.params.data.id;
                        let teamId = $(this).closest('tr').find('.edit-record').attr(
                            'team_id_value');

                        // Check if teamAssignments[teamId] exists and is an array
                        if (teamAssignments[teamId] && Array.isArray(teamAssignments[teamId])) {
                            // Update the teamAssignments mapping
                            teamAssignments[teamId] = teamAssignments[teamId].filter(id => id !==
                                employeeId);
                        } else {
                            console.warn(`teamAssignments[${teamId}] is undefined or not an array`);
                            // Optionally initialize it if needed
                            teamAssignments[teamId] = [];
                        }

                        // // Send AJAX request to update the database
                        // $.ajax({
                        //     url: '{{ route('m.emp.teams.unassign') }}',
                        //     type: 'POST',
                        //     data: {
                        //         employee_id: employeeId,
                        //         team_id: teamId,
                        //         _token: '{{ csrf_token() }}'
                        //     },
                        //     success: function(response) {
                        //         console.log(response.message);
                        //         if (response.message) {
                        //             jsonToastReceiver(response.message);
                        //         }

                        //         // Enable the option in other teams
                        //         enableOptionInOtherTeams(employeeId, teamId);
                        //     },
                        //     error: function(xhr) {
                        //         console.error(xhr.responseText);
                        //     }
                        // });


                        // Send request to update the database
                        makeRequest('{{ route('m.emp.teams.unassign') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    employee_id: employeeId,
                                    team_id: teamId,
                                    _token: '{{ csrf_token() }}' // This can be omitted if CSRF token is managed globally
                                })
                            })
                            .then(response => {
                                console.log(response.message);
                                if (response.message) {
                                    jsonToastReceiver(response.message);
                                }

                                // Enable the option in other teams
                                enableOptionInOtherTeams(employeeId, teamId);
                            })
                            .catch(error => {
                                console.error('Error unassigning employee:', error);
                            });


                    }).on("select2:select", function(e) {
                        let employeeId = e.params.data.id;
                        let teamId = $(this).closest('tr').find('.edit-record').attr(
                            'team_id_value');

                        // Update the teamAssignments mapping
                        if (!teamAssignments[teamId]) {
                            teamAssignments[teamId] = [];
                        }
                        teamAssignments[teamId].push(employeeId);

                        // // Send AJAX request to update the database
                        // $.ajax({
                        //     url: '{{ route('m.emp.teams.assign') }}',
                        //     type: 'POST',
                        //     data: {
                        //         employee_id: employeeId,
                        //         team_id: teamId,
                        //         _token: '{{ csrf_token() }}'
                        //     },
                        //     success: function(response) {
                        //         console.log(response.message);
                        //         if (response.message) {
                        //             jsonToastReceiver(response
                        //                 .message
                        //             ); // Pass response.message instead of response
                        //         }

                        //         // Disable the option in other teams
                        //         disableOptionInOtherTeams(employeeId, teamId);
                        //     },
                        //     error: function(xhr) {
                        //         console.error(xhr.responseText);
                        //     }
                        // });


                        // Send request to update the database
                        makeRequest('{{ route('m.emp.teams.assign') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    employee_id: employeeId,
                                    team_id: teamId,
                                    _token: '{{ csrf_token() }}' // This can be omitted if CSRF token is managed globally
                                })
                            })
                            .then(response => {
                                console.log(response.message);
                                if (response.message) {
                                    jsonToastReceiver(response
                                        .message); // Pass response.message instead of response
                                }

                                // Disable the option in other teams
                                disableOptionInOtherTeams(employeeId, teamId);
                            })
                            .catch(error => {
                                console.error('Error assigning employee:', error);
                            });


                    }).on("select2:open", function() {
                        if (currentOpenSelect2 && currentOpenSelect2 !== this) {
                            $(currentOpenSelect2).select2(
                                'close'); // Close the previously opened Select2
                        }
                        currentOpenSelect2 = this; // Update the currentOpenSelect2
                    }).on("select2:close", function() {
                        currentOpenSelect2 =
                            null; // Reset the currentOpenSelect2 when this one is closed
                    });

                    feather.replace();
                });
            }

            // Function to enable an option in other teams
            function enableOptionInOtherTeams(employeeId, currentTeamId) {
                $('#daftarTeamTable').find('tr').each(function() {
                    let teamId = $(this).find('.edit-record').attr('team_id_value');
                    if (teamId !== currentTeamId) {
                        $(this).find(`option[value="${employeeId}"]`).prop('disabled', false);
                    }
                });
            }

            // Function to disable an option in other teams
            function disableOptionInOtherTeams(employeeId, currentTeamId) {
                $('#daftarTeamTable').find('tr').each(function() {
                    let teamId = $(this).find('.edit-record').attr('team_id_value');
                    if (teamId !== currentTeamId) {
                        $(this).find(`option[value="${employeeId}"]`).prop('disabled', true);
                    }
                });
            }

            // Start polling for database updates
            function startPolling() {
                // Clear any existing intervals to prevent multiple polling instances
                if (window.pollingInterval) {
                    clearInterval(window.pollingInterval);
                }

                // Set a new polling interval
                window.pollingInterval = setInterval(checkForUpdates, 10000); // Check for updates every 10 seconds
            }

            // Check for updates in the database
            function checkForUpdates() {
                // $.ajax({
                //     url: '{{ route('m.emp.teams.detect.chg', ['modelType' => 'employee']) }}',
                //     type: 'GET',
                //     success: function(data) {
                //         if (data.last_updated) {
                //             var newLastUpdatedAt = new Date(data.last_updated); // This is in UTC
                //             console.log('Old Last Updated At:', lastUpdatedAt);
                //             console.log('New Last Updated At:', newLastUpdatedAt);

                //             var oldLastUpdatedAt = lastUpdatedAt ? new Date(lastUpdatedAt) :
                //                 null; // This is in UTC

                //             // Log the comparison for debugging
                //             console.log('Comparing timestamps:');
                //             console.log('oldLastUpdatedAt (UTC):', oldLastUpdatedAt);
                //             console.log('newLastUpdatedAt (UTC):', newLastUpdatedAt);

                //             // Compare both timestamps in UTC
                //             if (!oldLastUpdatedAt || newLastUpdatedAt > oldLastUpdatedAt) {
                //                 lastUpdatedAt = newLastUpdatedAt
                //                     .toISOString(); // Update the last updated timestamp
                //                 console.log("AF Updated Last Updated At:",
                //                     lastUpdatedAt); // Log the updated timestamp
                //                 console.log("DETECTED NEW DATA"); // This logs when new data is detected

                //                 // Update employeelists and teamAssignments with the latest data
                //                 employeelists = data.employeelists; // Update employeelists
                //                 updateTeamAssignments(data.teamlists); // Update team assignments

                //                 // Reload the DataTable only if not currently updating
                //                 if (!isUpdating) {
                //                     isUpdating = true; // Set the flag to prevent immediate updates
                //                     setTimeout(function() {
                //                         $('#daftarTeamTable').DataTable().ajax.reload(null,
                //                             false);
                //                         isUpdating = false; // Reset the flag after reload
                //                     }, 1000); // Delay to allow user to make multiple selections
                //                 }
                //             } else {
                //                 console.log("No new data detected (timestamp unchanged).");
                //             }
                //         }
                //     },
                //     error: function(xhr, status, error) {
                //         console.log('Polling Error:', xhr.responseText);
                //         console.log('Status:', status);
                //         console.log('Error:', error);
                //     }
                // });


                makeRequest('{{ route('m.emp.teams.detect.chg', ['modelType' => 'employee']) }}', {
                        method: 'GET'
                    })
                    .then(data => {
                        if (data.last_updated) {
                            var newLastUpdatedAt = new Date(data.last_updated); // This is in UTC
                            console.log('Old Last Updated At:', lastUpdatedAt);
                            console.log('New Last Updated At:', newLastUpdatedAt);

                            var oldLastUpdatedAt = lastUpdatedAt ? new Date(lastUpdatedAt) :
                            null; // This is in UTC

                            // Log the comparison for debugging
                            console.log('Comparing timestamps:');
                            console.log('oldLastUpdatedAt (UTC):', oldLastUpdatedAt);
                            console.log('newLastUpdatedAt (UTC):', newLastUpdatedAt);

                            // Compare both timestamps in UTC
                            if (!oldLastUpdatedAt || newLastUpdatedAt > oldLastUpdatedAt) {
                                lastUpdatedAt = newLastUpdatedAt
                            .toISOString(); // Update the last updated timestamp
                                console.log("AF Updated Last Updated At:",
                                lastUpdatedAt); // Log the updated timestamp
                                console.log("DETECTED NEW DATA"); // This logs when new data is detected

                                // Update employeelists and teamAssignments with the latest data
                                employeelists = data.employeelists; // Update employeelists
                                updateTeamAssignments(data.teamlists); // Update team assignments

                                // Reload the DataTable only if not currently updating
                                if (!isUpdating) {
                                    isUpdating = true; // Set the flag to prevent immediate updates
                                    setTimeout(function() {
                                        $('#daftarTeamTable').DataTable().ajax.reload(null, false);
                                        isUpdating = false; // Reset the flag after reload
                                    }, 1000); // Delay to allow user to make multiple selections
                                }
                            } else {
                                console.log("No new data detected (timestamp unchanged).");
                            }
                        }
                    })
                    .catch(error => {
                        console.log('Polling Error:', error);
                    });
            }

            // Function to update teamAssignments based on the new teamlists
            function updateTeamAssignments(teamlists) {
                teamAssignments = {}; // Reset teamAssignments
                // Loop through the new teamlists to populate teamAssignments
                teamlists.forEach(function(team) {
                    teamAssignments[team.id_team] = team.karyawans.map(k => k
                        .id_karyawan); // Update assignments
                });
                // Reinitialize Select2 to reflect the updated assignments
                $('#daftarTeamTable').find('.team-select2-assign').each(function() {
                    var teamId = $(this).closest('tr').find('.edit-record').attr('team_id_value');
                    $(this).val(teamAssignments[teamId]).trigger(
                        'change'); // Update the Select2 with new assignments
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
                // $('.delete-record').on('click', function() {
                // $('table .dropdown-menu').on('click', '.delete-record', function(event) {
                $(document).on('click', '.delete-record', function(event) {
                    var teamID = $(this).attr('team_id_value');
                    $('#' + whichModal + ' #del-team_id').val(teamID);
                    // document.body.style.overflowY = 'hidden';
                    modalToShow.show();
                });
            }, 200);

        });
    </script>


    {{--

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
                                .id_team
                                ) { // Include employees with the same team ID or without a team
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
                            'change'
                            ); // Set selected values directly and notify Select2 to refresh the dropdown
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Initialize Select2 for each row
            $('#daftarTeamTable tbody tr').each(function() {
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
    </script> --}}
@endsection
