@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = 'dd, DD MMM YYYY';
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
@endsection


@section('page-content')
    {{-- @if (auth()->user()->type == 'Superuser' || auth()->user()->type == 'Supervisor')
        <h1>HI MIN :)</h1>
    @endif

    @if (auth()->user()->type == 'Engineer')
        <h1>HI WAN :)</h1>
    @endif --}}

    {{-- {{ dd($authenticated_user_data) }} --}}


    @php
        $authUserType = auth()->user()->type;
    @endphp




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
                                                    <h3 class="mt-0 mb-0 underline-text pt-2 h3-dark">CLIENT LISTS</h3>
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


                    <table id="daftarClientsTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Act</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>No. Telp</th>
                                <th>Photo</th>
                                <th>Created</th>
                                {{-- <th>Last-Update</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{dd($clients->toArray());}} --}}
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="text-center align-middle">{{ $client->id_client ?: '-' }}</td>

                                    <td class="text-center">
                                        <div class="dropdown d-lg-block d-sm-block d-md-block">
                                            <button class="btn btn-icon navbar-toggler p-0 d-inline-flex" type="button"
                                                id="tableActionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i data-feather="align-justify" class="font-medium-5"></i>
                                            </button>
                                            <!-- dropdown menu -->
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="tableActionDropdown">
                                                <a class="edit-record dropdown-item d-flex align-items-center"
                                                    edit_client_id_value = "{{ $client->id_client ?: 0 }}"
                                                    onclick="openModal('{{ $modalData['modal_edit'] }}')">
                                                    <i data-feather="edit" class="mr-1" style="color: #28c76f;"></i>
                                                    Edit
                                                </a>
                                                @if ($authUserType === 'Superuser')
                                                    <a class="delete-record dropdown-item d-flex align-items-center"
                                                        del_client_id_value = "{{ $client->id_client ?: 0 }}"
                                                        onclick="openModal('{{ $modalData['modal_delete'] }}')">
                                                        <i data-feather="trash" class="mr-1" style="color: #ea5455;"></i>
                                                        Delete
                                                    </a>
                                                @endif
                                            </div>
                                            <!--/ dropdown menu -->
                                        </div>
                                    </td>

                                    <td>{{ $client->na_client ?: '-' }}</td>

                                    <td>
                                        <span class="blurred-part">{{ $client->alamat_client ?: '-' }}</span>
                                        {{-- @php
                                            $address = $client->alamat_client ?: '-';
                                            $halfLength = strlen($address) / 2;
                                            $firstHalf = substr($address, 0, $halfLength);
                                            $secondHalf = substr($address, $halfLength);
                                        @endphp
                                        <span data-original-content="{{ $address }}">
                                            {{ $firstHalf }}<span class="blurred-part">{{ $secondHalf }}</span>
                                        </span> --}}
                                    </td>
                                    <td>
                                        <span class="blurred-part">{{ $client->notelp_client }}</span>
                                        {{-- <div class="phone-container">
                                            @php
                                                $phoneLength = strlen($client->notelp_client);
                                                $blurredPartLength = 4; // Number of digits to blur
                                                $nonBlurredPart = substr(
                                                    $client->notelp_client,
                                                    0,
                                                    $phoneLength - $blurredPartLength,
                                                );
                                                $blurredPart = substr($client->notelp_client, -$blurredPartLength);
                                            @endphp
                                            <span>{{ $nonBlurredPart }}</span>
                                            <span class="blurred-part">{{ $blurredPart }}</span>
                                        </div> --}}
                                    </td>
                                    <td>
                                        @if ($client->foto_client !== null)
                                            <div class="d-flex align-items-center justify-content-around">
                                                <img src="{{ 'public/avatar/uploads/' . $client->foto_client }}"
                                                    alt="Proof 0" style="height: 24px; width: 24px;"
                                                    class="hover-qr-image">
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center justify-content-around">
                                                -
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($client->created_at)
                                            {{ \Carbon\Carbon::parse($client->created_at)->isoFormat($cust_date_format) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if ($client->updated_at)
                                            {{ \Carbon\Carbon::parse($client->updated_at)->isoFormat($cust_date_format) }}
                                        @else
                                            -
                                        @endif
                                    </td> --}}

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--/ TableAbsen Card -->



    </div>




    <div class="MODALS-1">
        <!-- BEGIN: AddKustomerModal--> @include('v_res.m_modals.userpanels.m_daftarkustomer.v_add_kustomerModal') <!-- END: AddKustomerModal-->
        <!-- BEGIN: EditKustomerModal--> @include('v_res.m_modals.userpanels.m_daftarkustomer.v_edit_kustomerModal') <!-- END: EditKustomerModal-->
        <!-- BEGIN: DelKustomerModal--> @include('v_res.m_modals.userpanels.m_daftarkustomer.v_del_kustomerModal') <!-- END: DelKustomerModal-->
        @if ($reset_btn)
            <!-- BEGIN: ResetKustomerModal--> @include('v_res.m_modals.userpanels.m_daftarkustomer.v_reset_kustomerModal') <!-- END: ResetKustomerModal-->
        @endif
    </div>
@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>
    <script>
        $(document).ready(function() {
            var lengthMenu = [10, 50, 100, 500, 1000, 2000, 3000]; // Length menu options

            // Initialize the DataTable
            var $table = $('#daftarClientsTable').DataTable({
                lengthMenu: lengthMenu,
                pageLength: 100,
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
                    $(this.api().column([5]).header()).addClass('cell-fit text-center');

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
                        <span class="dropdown-item d-flex justify-content-center align-content-center">Employee Lists</span>
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
            const modalId = 'edit_kustomerModal';
            const modalSelector = document.getElementById(modalId);
            const modalToShow = new bootstrap.Modal(modalSelector);
            const targetedModalForm = document.querySelector('#' + modalId + ' #edit_kustomerModalFORM');

            $(document).on('click', '.edit-record', function(event) {
                var clientID = $(this).attr('edit_client_id_value');
                // console.log('Edit button clicked for client_id:', clientID);
                // setTimeout(() => {
                //     $.ajax({
                //         url: '{{ route('m.cli.getcli') }}',
                //         method: 'POST',
                //         headers: {
                //             'X-CSRF-TOKEN': '{{ csrf_token() }}' // Update the CSRF token here
                //         },
                //         data: {
                //             clientID: clientID
                //         },
                //         success: function(response) {
                //             console.log(response);
                //             $('#edit_cli_id').val(response.id_client);
                //             $('#edit-cli-name').val(response.na_client);
                //             $('#edit-cli-addr').val(response.addr_client);
                //             $('#edit-cli-telp').val(response.telp_client);

                //             setAvatar(response);
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
                    makeRequest('{{ route('m.cli.getcli') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                clientID: clientID
                            })
                        })
                        .then(response => {
                            console.log(response);
                            $('#edit_cli_id').val(response.id_client);
                            $('#edit-cli-name').val(response.na_client);
                            $('#edit-cli-addr').val(response.addr_client);
                            $('#edit-cli-telp').val(response.telp_client);

                            setAvatar(response);
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




            function setAvatar(response) {
                const uploadedAvatar = document.getElementById('avatar-upload-img-2');
                const imgFromDB = '{{ asset('public/avatar/uploads') }}/' + response.ava_client;
                if (response.ava_client) {
                    const img = new Image();
                    img.onload = function() {
                        uploadedAvatar.src = img.src;
                    };
                    img.src = imgFromDB;
                } else {
                    uploadedAvatar.src = '{{ asset('public/assets/defaults/avatar_default.png') }}';
                }

                const uploadInput = document.getElementById('edit-avatar-upload');
                var resetButton = document.querySelector('.acc-avatar-reset-edit');
                resetButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    uploadInput.value = null;
                    uploadedAvatar.src = imgFromDB;
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
            whichModal = "delete_kustomerModal";
            const modalSelector = document.querySelector('#' + whichModal);
            const modalToShow = new bootstrap.Modal(modalSelector);

            $('.dropdown-menu').on('click', '.delete-record', function(event) {
                var clientID = $(this).attr('del_client_id_value');
                $('#' + whichModal + ' #del_client_id').val(clientID);
                // document.body.style.overflowY = 'hidden';
                modalToShow.show();
            });

        });
    </script>

    <script>
        var bdayDatePickerInputs = document.querySelectorAll(".pickadate-birth-date");
        if (bdayDatePickerInputs.length > 0) {
            bdayDatePickerInputs.forEach(function(bdayDatePickerInput) {
                flatpickr(bdayDatePickerInput, {
                    enableTime: false,
                    dateFormat: "Y-m-d", // Format for the date and time
                    altInput: true,
                    altFormat: "j F, Y", // Format for the alternative input display
                    allowInput: true, // Allow typing in the input field
                    minDate: "1900-01-01", // Set minimum date
                    maxDate: "8000-12-31" // Set maximum date
                });
            });
        }
    </script>
@endsection
