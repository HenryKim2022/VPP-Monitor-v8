@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = $page['custom_date_format'];
    $reset_btn = false;
    // $authenticated_user_data = Session::get('authenticated_user_data');
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




    <div class="row match-height">
        <!-- QRCodeCheck-out Card -->
        <div class="col-lg-4 col-md-6 col-12">
        </div>
        <!--/ QRCodeCheck-out Card -->

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
                                                    <h3 class="mt-0 mb-0 underline-text pt-2">EMPLOYEE ACCOUNTS</h3>
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
                                    @if (auth()->user()->type === 'Superuser')
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



                    <table id="daftarLoginKaryawanTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Act</th>
                                <th>Employee Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Avatar</th>
                                <th>Type</th>
                                <th>Created</th>
                                {{-- <th>Last-Update</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            {{-- <div class="card-body">
                                <pre style="color: white">{{ print_r($loadDaftarLoginFromDB->toArray(), true) }}</pre>
                                <br>
                            </div> --}}
                            @foreach ($loadDaftarLoginFromDB as $userLogin)
                                <tr>
                                    <td class="text-center">
                                        <div class="dropdown d-lg-block d-sm-block d-md-block">
                                            <button class="btn btn-icon navbar-toggler p-0 d-inline-flex" type="button"
                                                id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="align-justify" class="font-medium-5"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="tableActionDropdown">
                                                <a class="edit-record dropdown-item d-flex align-items-center"
                                                    user_id_value="{{ $userLogin->user_id }}"
                                                    karyawan_id_value="{{ $userLogin->karyawan->id_karyawan ?? ($userLogin->id_karyawan ?? '-') }}"
                                                    onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                    <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                                    Edit
                                                </a>
                                                <a class="delete-record dropdown-item d-flex align-items-center"
                                                    user_id_value="{{ $userLogin->user_id }}"
                                                    onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                    <i data-feather="trash" class="mr-1" style="color: #ea5455;"></i>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $userLogin->karyawan->na_karyawan ?? ($userLogin->na_karyawan ?? '-') }}</td>
                                    <td>{{ $userLogin->karyawan->username ?? ($userLogin->username ?? '-') }}</td>
                                    <td>{{ $userLogin->karyawan->email ?? ($userLogin->email ?? '-') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-around">
                                            @php
                                                $fotoKaryawan =
                                                    $userLogin->karyawan->foto_karyawan ?? $userLogin->foto_karyawan;
                                            @endphp
                                            @if (!empty($fotoKaryawan) && file_exists(public_path('avatar/uploads/' . $fotoKaryawan)))
                                                <img src="{{ asset('public/avatar/uploads/' . $fotoKaryawan) }}"
                                                    alt="User  Photo" style="height: 24px; width: 24px;"
                                                    class="hover-qr-image">
                                            @else
                                                <span>-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $userLogin->type ?? '-' }}</td>
                                    <td>
                                        {{ $userLogin->created_at ? \Carbon\Carbon::parse($userLogin->created_at)->isoFormat($cust_date_format) : '-' }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--/ TableAbsen Card -->



    </div>






    <!-- BEGIN: AddUserModal--> @include('v_res.m_modals.userpanels.m_daftarlogin_employee.v_add_userModal') <!-- END: AddUserModal-->
    <!-- BEGIN: EditUserModal--> @include('v_res.m_modals.userpanels.m_daftarlogin_employee.v_edit_userModal') <!-- END: EditUserModal-->
    <!-- BEGIN: DelUserModal--> @include('v_res.m_modals.userpanels.m_daftarlogin_employee.v_del_userModal') <!-- END: DelUserModal-->
    @if ($reset_btn)
        <!-- BEGIN: ResetUserModal--> @include('v_res.m_modals.userpanels.m_daftarlogin_employee.v_reset_userModal') <!-- END: ResetUserModal-->
    @endif





@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

    <script>
        $(document).ready(function() {
            var lengthMenu = [10, 50, 100, 500, 1000, 2000, 3000]; // Length menu options

            var $table = $('#daftarLoginKaryawanTable').DataTable({
                lengthMenu: lengthMenu,
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
                scrollCollapse: true,
                dom: '<"card-header border-bottom p-1"<"head-label"><"d-flex justify-content-between align-items-center"<"dt-search-field"f>>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                columnDefs: [{ // Set the initial column visibility
                    targets: [6], // Specify the columns to hide
                    visible: false // Set visibility to false
                }],
                initComplete: function() {
                    $(this.api().column([0]).header()).addClass('cell-fit text-center');
                    $(this.api().column([1]).header()).addClass('cell-fit text-center');
                    $(this.api().column([4]).header()).addClass('cell-fit text-center');

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
                        <span class="dropdown-item d-flex justify-content-center align-content-center">Employee Accounts</span>
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


        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalId = 'edit_userModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_userModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var userID = $(this).attr('user_id_value');
                var karyawanID = $(this).attr('karyawan_id_value');
                // console.log('Edit button clicked for user_id:', userID);

                // setTimeout(() => {
                //     $.ajax({
                //         url: '{{ route('m.user.emp.getuser') }}',
                //         method: 'POST',
                //         headers: {
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                //         },
                //         data: {
                //             userID: userID,
                //             karyawanID: karyawanID
                //         },
                //         success: function(response) {
                //             console.log(response);
                //             $('#user_id').val(response.user_id);
                //             $('#modalEditEmployee').val(response.id_karyawan);
                //             $('#modalEditUsername').val(response.username);
                //             $('#modalEditEmail').val(response.email);
                //             setEmpList();
                //             setUserTypeList(response);

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
                    makeRequest('{{ route('m.user.emp.getuser') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                userID: userID,
                                karyawanID: karyawanID
                            })
                        })
                        .then(response => {
                            console.log(response);
                            $('#user_id').val(response.user_id);
                            $('#modalEditEmployee').val(response.id_karyawan);
                            $('#modalEditUsername').val(response.username);
                            $('#modalEditEmail').val(response.email);
                            setEmpList(response);
                            setUserTypeList(response);

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


            function setEmpList(response) {
                // Populate the select options for modalEditInstitutionMARKID1
                var empSelect = $('#' + modalId +
                    ' #modalEditEmployee');
                empSelect.empty(); // Clear existing options
                empSelect.append($('<option>', {
                    value: "",
                    text: "Select Employee"
                }));
                $.each(response.employeeList, function(index,
                    empOption) {
                    var option = $('<option>', {
                        value: empOption.value,
                        text: `${empOption.text}`
                    });
                    if (empOption.selected) {
                        option.attr('selected',
                            'selected'); // Select the option
                    }
                    empSelect.append(option);
                });

            }


            function setUserTypeList(response) {
                console.log(response.userTypeList);
                var userTypeSelect = $('#' + modalId +
                    ' modalEditUserType');
                userTypeSelect.empty(); // Clear existing options
                var receivedUserType = response.userTypeList;

                var userTypeArr = [{
                        text: 'Select UserType',
                        value: '',
                        selected: receivedUserType === ''
                    },
                    {
                        text: 'Client',
                        value: 'Client',
                        selected: receivedUserType === 'Client'
                    },
                    {
                        text: 'Superuser',
                        value: 'Superuser',
                        selected: receivedUserType === 'Superuser'
                    },
                    {
                        text: 'Supervisor',
                        value: 'Supervisor',
                        selected: receivedUserType === 'Supervisor'
                    },
                    {
                        text: 'Engineer',
                        value: 'Engineer',
                        selected: receivedUserType === 'Engineer'
                    }
                ];

                $.each(userTypeArr, function(index, userTypeOption) {
                    var option = $('<option>');
                    option.attr('value', userTypeOption.value);
                    option.text(userTypeOption.text);

                    if (userTypeOption.selected) {
                        option.prop('selected', true);
                    }

                    userTypeSelect.append(option);
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
            whichModal = "delete_userModal";
            const modalSelector = document.querySelector('#' + whichModal);
            const modalToShow = new bootstrap.Modal(modalSelector);

            setTimeout(() => {
                // $('.delete-record').on('click', function() {
                $('table .dropdown-menu').on('click', '.delete-record', function(event) {
                    var userID = $(this).attr('user_id_value');
                    $('#' + whichModal + ' #user_id').val(userID);
                    // document.body.style.overflowY = 'hidden';
                    modalToShow.show();
                });
            }, 200);

        });
    </script>
@endsection
