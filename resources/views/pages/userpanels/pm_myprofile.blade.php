@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = $page['custom_date_format'];
    $authenticated_user_data = Session::get('authenticated_user_data');
    // dd($authenticated_user_data->toArray());

    $typeValues = ['Public', 'Client', 'Superuser', 'Supervisor', 'Engineer']; // Convert the text type User (e.g Admin to 1) value to its numeric representation
    $typeIndex = array_search(auth()->user()->type, $typeValues);
    $convertedUserType = $typeIndex !== false ? $typeIndex : null;

@endphp


@php
    // Retrieve page and authenticated user data from the session
    $page = Session::get('page', []);
    $page_title = $page['page_title'] ?? 'Default Title'; // Provide a default title if not set
    $cust_date_format = $page['custom_date_format'] ?? 'Y-m-d'; // Provide a default date format if not set
    $authenticated_user_data = Session::get('authenticated_user_data', []);

    // Initialize avatar_src to default avatar
    $default_avatar_path = 'public/assets/defaults/avatar_default.png'; // Ensure no leading slash
    $avatar_src = url($default_avatar_path . '?t=' . time()); // Use Laravel's url() helper

// Determine the avatar source based on user type
if ($authenticated_user_data['type'] === 'Client') {
    // For Client
    $client_photo = $authenticated_user_data['client']['foto_client'] ?? null;
    if (!empty($client_photo) && file_exists(public_path('avatar/uploads/' . $client_photo))) {
        $avatar_src = url('public/avatar/uploads/' . $client_photo . '?t=' . time()); // Use url() to generate the correct URL
    }
} elseif (
    $authenticated_user_data['type'] === 'Superuser' ||
    $authenticated_user_data['type'] === 'Supervisor' ||
    $authenticated_user_data['type'] === 'Engineer'
) {
    // For Karyawan (Superuser, Supervisor, Engineer)
    $karyawan_photo = $authenticated_user_data['karyawan']['foto_karyawan'] ?? null;
    if (!empty($karyawan_photo) && file_exists(public_path('avatar/uploads/' . $karyawan_photo))) {
        $avatar_src = url('public/avatar/uploads/' . $karyawan_photo . '?t=' . time()); // Use url() to generate the correct URL
    }
}

// Check session for user_image only if the avatar_src is still the default
if ($avatar_src === url($default_avatar_path)) {
    // Get the user_image from session
    $session_user_image = Session::get('user_image');
    // If session_user_image is available, use it as avatar_src
    if (!empty($session_user_image)) {
        $avatar_src = $session_user_image;
    }
} else {
    // If a valid user avatar exists, store it in the session
    Session::put('user_image', $avatar_src);
    }
@endphp



@extends('layouts.userpanels.v_main')
@section('header_page_cssjs')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/pages/page-profile.css') }}">
@endsection


@section('page-content')
    {{-- @if (auth()->user()->type == 'Superuser' || auth()->user()->type == 'Supervisor')
        <h1>HI MIN :)</h1>
    @endif

    @if (auth()->user()->type == 'Engineer')
        <h1>HI WAN :)</h1>
    @endif --}}


    @php
        $authUserType = auth()->user()->type;
    @endphp


    {{-- <div class="container row match-height pr-0"> --}}
    <div class="container match-height px-0">


        @if ($authUserType != '')
            <div class="content-body">
                <!-- profile header -->
                <div id="user-profile">
                    <div class="row">
                        <div class="col-12 pr-1">

                            {{-- <div class="col-xl-12 col-md-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <pre style="color: white">{{ print_r($authenticated_user_data->toArray(), true) }}</pre>
                                        <br>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="card profile-header mb-2">
                                {{-- <!-- profile cover photo -->
                                <img class="card-img-top responsive-bg-c"
                                    src="{{ asset('public/theme/vuexy/app-assets/images/profile/user-uploads/timeline-2.png') }}"
                                    alt="User Profile Image" />
                                <!--/ profile cover photo --> --}}

                                <div class="position-relative">
                                    <!-- profile picture -->
                                    <div class="profile-img-container mb-1 mb-lg-0 mb-md-0 d-flex align-items-center">
                                        <style>
                                            .profile-img {
                                                width: 2rem;
                                                /* Adjust the width as needed */
                                                height: 2rem;
                                                /* Adjust the height as needed */
                                                overflow: hidden;
                                            }

                                            .profile-img img {
                                                width: 100%;
                                                height: 100%;
                                                object-fit: fill;
                                                object-position: center center;
                                            }
                                        </style>

                                        <div class="profile-img">
                                            <img src="{{ $avatar_src }}" class="rounded img-fluid hover-qr-image"
                                                alt="Card image" />
                                        </div>
                                        <!-- profile title -->
                                        <div class="profile-title ml-3">
                                            <h2 class="ellipsis-v1 h2-dark" style="max-width: 45vw;">{!! isset($authenticated_user_data)
                                                    ? (isset($authenticated_user_data['karyawan']['na_karyawan'])
                                                        ? $authenticated_user_data['karyawan']['na_karyawan']
                                                        : (isset($authenticated_user_data['client']['na_client'])
                                                            ? $authenticated_user_data['client']['na_client']
                                                            : 'No Name'))
                                                    : 'No Name' !!}
                                            </h2>

                                            {{-- @php
                                                dd($authenticated_user_data->toArray());
                                            @endphp --}}

                                            @php
                                                $roles = [];

                                                // Determine the role based on the user type
                                                $role1 =
                                                    $authenticated_user_data['type'] == 'Superuser'
                                                        ? 'WebSite ' . $authenticated_user_data['type']
                                                        : $authenticated_user_data['type'];

                                                // Add the first role to the roles array
                                                if ($role1) {
                                                    $roles[] = $role1;
                                                }

                                                // Check if the user is a Client or has a Karyawan role
                                                if (isset($authenticated_user_data['karyawan'])) {
                                                    $role2 = $authenticated_user_data['karyawan']['jabatan'] ?? [];

                                                    // Add the additional roles from the jabatan relationship
                                                    foreach ($role2 as $role) {
                                                        $roles[] = $role['na_jabatan'];
                                                    }
                                                }



                                                $allRoles = implode(' & ', $roles);
                                            @endphp
                                            <h6 class="h6-dark">{{ $allRoles ?: 'Pasukan Rendang' }}</h6>

                                        </div>
                                    </div>
                                </div>

                                <!-- tabs pill -->
                                <div class="profile-header-nav">
                                    <!-- navbar -->
                                    <nav
                                        class="navbar navbar-expand-md navbar-light justify-content-end justify-content-md-between w-100">
                                        <button class="btn btn-icon navbar-toggler p-0" type="button"
                                            aria-controls="navbarSupportedContent" aria-expanded="false"
                                            aria-label="Toggle navigation">
                                            <i data-feather="align-justify" class="font-medium-5"></i>
                                        </button>
                                        {{-- <button class="btn btn-icon navbar-toggler p-0" type="button" data-toggle="collapse"
                                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <i data-feather="align-justify" class="font-medium-5"></i>
                                    </button> --}}

                                        <!-- collapse  -->
                                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                            <div
                                                class="profile-tabs d-flex justify-content-between flex-wrap mt-1 mt-md-0 p-2">
                                            </div>
                                        </div>
                                        <!--/ collapse  -->
                                    </nav>
                                    <!--/ navbar -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ profile header -->

                <!-- account setting page -->
                <section id="page-account-settings">
                    <div class="row">
                        <!-- left menu section -->
                        <div class="col-md-3 pr-sm-2">
                            <ul class="nav nav-pills flex-column nav-left">
                                <!-- information -->
                                <li class="nav-item">
                                    <a class="nav-link active" id="account-pill-info" data-toggle="pill"
                                        href="#account-vertical-profile" aria-expanded="true">
                                        <i data-feather="user" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Profile</span>
                                    </a>
                                </li>

                                <!-- general -->
                                <li class="nav-item">
                                    <a class="nav-link" id="account-pill-general" data-toggle="pill"
                                        href="#account-vertical-general" aria-expanded="false">
                                        <i data-feather="edit" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Edit BioData</span>
                                    </a>
                                </li>
                                <!-- change password -->
                                <li class="nav-item">
                                    <a class="nav-link" id="account-pill-password" data-toggle="pill"
                                        href="#account-vertical-password" aria-expanded="false">
                                        <i data-feather="lock" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Change Account Auth</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                        <!--/ left menu section -->

                        <!-- right content section -->
                        <div class="col-md-9 ml-0 ml-sm-3 ml-md-0 pr-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">

                                        @if ($authUserType != 'Client')
                                            <div class="tab-pane active" id="account-vertical-profile" role="tabpanel"
                                                aria-labelledby="account-pill-info" aria-expanded="false">
                                                <div class="container">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>UserID</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{-- {{ $authenticated_user_data->daftar_login->user_id }} --}}
                                                                    {{ $authenticated_user_data ? $authenticated_user_data->user_id : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>EmployeeID</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data ? ($authenticated_user_data->karyawan ? $authenticated_user_data->karyawan->id_karyawan : 'n/a') : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Username</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data ? $authenticated_user_data->username : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Name</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data->karyawan ? $authenticated_user_data->karyawan->na_karyawan : 'n/a' }}
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td><strong>Office Role</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    @php
                                                                        // Initialize rolesCount to 0
                                                                        $rolesCount = 0;

                                                                        // Check if karyawan is set and not null
                                                                        if (
                                                                            !empty(
                                                                                $authenticated_user_data['karyawan']
                                                                            ) &&
                                                                            !empty(
                                                                                $authenticated_user_data['karyawan'][
                                                                                    'jabatan'
                                                                                ]
                                                                            )
                                                                        ) {
                                                                            // Get the count of roles
                                                                            $rolesCount = count(
                                                                                $authenticated_user_data['karyawan'][
                                                                                    'jabatan'
                                                                                ],
                                                                            );
                                                                        }
                                                                    @endphp

                                                                    @if ($rolesCount > 0)
                                                                        @foreach ($authenticated_user_data['karyawan']['jabatan'] as $index => $role)
                                                                            {{ $role['na_jabatan'] }}@if ($index < $rolesCount - 1)
                                                                                ,
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        n/a
                                                                    @endif
                                                                </td>
                                                            </tr>


                                                            <tr>
                                                                <td><strong>Email</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data ? ($authenticated_user_data->email ? $authenticated_user_data->email : 'n/a') : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- <br><br><br><br><br> --}}
                                                </div>
                                            </div>

                                            <!-- general tab -->
                                            <div role="tabpanel" class="tab-pane" id="account-vertical-general"
                                                aria-labelledby="account-pill-general" aria-expanded="true">
                                                <!-- header media -->
                                                <div class="media">
                                                    <a href="javascript:void(0);" class="mr-25">
                                                        <img src="{{ $avatar_src }}" id="account-upload-img"
                                                            class="rounded hover-qr-image mr-50" alt="profile image"
                                                            height="80" width="80" />
                                                    </a>
                                                    <!-- upload and reset button -->
                                                    <div class="media-body mt-75 ml-1">
                                                        <label for="account-upload"
                                                            class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                                        <input type="file" id="account-upload" hidden
                                                            accept="image/png, image/jpeg, image/*" />
                                                        <button
                                                            class="btn btn-sm acc-avatar-reset btn-outline-secondary mb-75">Reset</button>
                                                        <p>Allowed JPG, GIF or PNG. Max size of 5MB</p>
                                                    </div>
                                                    <!--/ upload and reset button -->
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const uploadInput = document.getElementById('account-upload');
                                                        const uploadedAvatar = document.getElementById('account-upload-img');

                                                        // Safely access id_karyawan
                                                        const userId =
                                                            '{{ isset($authenticated_user_data['karyawan']) ? $authenticated_user_data['karyawan']['id_karyawan'] : 'null' }}';

                                                        uploadInput.addEventListener('change', function() {
                                                            const file = uploadInput.files[0];
                                                            const reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                const uploadedImage = e.target.result;
                                                                uploadedAvatar.src = uploadedImage;

                                                                const formData = new FormData();
                                                                formData.append('id_karyawan', userId);
                                                                formData.append('foto_karyawan', file);

                                                                // Use makeRequest to send the FormData
                                                                makeRequest('{{ route('userPanels.avatar.edit') }}', {
                                                                        method: 'POST',
                                                                        body: formData, // Send FormData directly
                                                                        // headers: {
                                                                        //     'X-CSRF-Token': '{{ csrf_token() }}' // Include CSRF token in headers
                                                                        // }
                                                                    })
                                                                    .then(response => {
                                                                        if (response.reload) {
                                                                            window.location.reload();
                                                                        }
                                                                    })
                                                                    .catch(error => {
                                                                        console.error('Error uploading avatar:', error);
                                                                    });
                                                            };

                                                            reader.readAsDataURL(file);
                                                        });

                                                        var userProfilePhotoPreview = uploadedAvatar;
                                                        var userProfilePhotoInput = uploadInput;
                                                        userProfilePhotoInput.addEventListener('change', function() {
                                                            const file = this.files[0];
                                                            if (file && file.type.startsWith('image/')) {
                                                                const img = document.createElement('img');
                                                                img.src = URL.createObjectURL(file);

                                                                img.onload = function() {
                                                                    userProfilePhotoPreview.src = img.src;
                                                                };
                                                            }
                                                        });

                                                        var resetButton = document.querySelector('.acc-avatar-reset');
                                                        resetButton.addEventListener('click', function() {
                                                            userProfilePhotoPreview.src =
                                                                '{{ isset($authenticated_user_data['karyawan']['foto_karyawan']) && !empty($authenticated_user_data['karyawan']['foto_karyawan']) ? asset('public/avatar/uploads/' . $authenticated_user_data['karyawan']['foto_karyawan']) : (isset($authenticated_user_data['client']['foto_client']) && !empty($authenticated_user_data['client']['foto_client']) ? asset('public/avatar/uploads/' . $authenticated_user_data['client']['foto_client']) : asset('public/assets/defaults/avatar_default.png')) }}';
                                                            userProfilePhotoInput.value = null;
                                                        });
                                                    });
                                                </script>
                                                <!--/ header media -->




                                                <!-- form -->
                                                <form class="validate-form mt-2"
                                                    action="{{ route('userPanels.biodata.edit') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control"
                                                                    id="id_karyawan" name="id_karyawan" placeholder="ID"
                                                                    value="{{ isset($authenticated_user_data['karyawan']) ? $authenticated_user_data['karyawan']['id_karyawan'] ?? 'n/a' : 'n/a' }}" />

                                                                <label for="account-name">Name</label>
                                                                <input type="text" class="form-control"
                                                                    id="account-name" name="account-name"
                                                                    placeholder="Name"
                                                                    value="{{ isset($authenticated_user_data['karyawan']) ? $authenticated_user_data['karyawan']['na_karyawan'] ?? 'n/a' : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="birth-loc">Birth Location</label>
                                                                <input type="text" class="form-control" id="birth-loc"
                                                                    name="birth-loc" placeholder="Location of Birth"
                                                                    value="{{ isset($authenticated_user_data['karyawan']) ? $authenticated_user_data['karyawan']['tlah_karyawan'] ?? 'n/a' : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="birth-date">Birth Date</label>
                                                                <input type="date"
                                                                    class="form-control pickadate-birth-date"
                                                                    id="birth-date" name="birth-date"
                                                                    placeholder="Date of Birth"
                                                                    value="{{ isset($authenticated_user_data['karyawan']) && !empty($authenticated_user_data['karyawan']['tglah_karyawan']) ? \Carbon\Carbon::parse($authenticated_user_data['karyawan']['tglah_karyawan'])->format('Y-m-d') : '' }}" />
                                                            </div>
                                                        </div>


                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label>Religion</label>
                                                                <select class="select2 form-control form-control-lg"
                                                                    name="religion" id="religion">
                                                                    @php
                                                                        // Safely access agama_karyawan
                                                                        $religion = isset(
                                                                            $authenticated_user_data['karyawan'],
                                                                        )
                                                                            ? $authenticated_user_data['karyawan'][
                                                                                'agama_karyawan'
                                                                            ]
                                                                            : null;
                                                                    @endphp
                                                                    <option value=""
                                                                        {{ is_null($religion) ? 'selected' : '' }}>
                                                                        Select religion
                                                                    </option>
                                                                    <option value="Islam"
                                                                        {{ $religion === 'Islam' ? 'selected' : '' }}>
                                                                        Islam
                                                                    </option>
                                                                    <option value="Kristen"
                                                                        {{ $religion === 'Kristen' ? 'selected' : '' }}>
                                                                        Kristen
                                                                    </option>
                                                                    <option value="Hindu"
                                                                        {{ $religion === 'Hindu' ? 'selected' : '' }}>
                                                                        Hindu
                                                                    </option>
                                                                    <option value="Buddha"
                                                                        {{ $religion === 'Buddha' ? 'selected' : '' }}>
                                                                        Buddha
                                                                    </option>
                                                                    <option value="Konghucu"
                                                                        {{ $religion === 'Konghucu' ? 'selected' : '' }}>
                                                                        Konghucu
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="address">Address</label>
                                                                <input type="text" class="form-control" id="address"
                                                                    name="address" placeholder="Address"
                                                                    value="{{ isset($authenticated_user_data['karyawan']) ? $authenticated_user_data['karyawan']['alamat_karyawan'] ?? 'n/a' : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="notelp">No. Telp</label>
                                                                <input type="text" class="form-control" id="notelp"
                                                                    name="notelp" placeholder="No. Telp"
                                                                    value="{{ isset($authenticated_user_data['karyawan']) ? $authenticated_user_data['karyawan']['notelp_karyawan'] ?? '+62 ' : '+62 ' }}" />
                                                            </div>
                                                        </div>



                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mt-2 mr-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                class="btn btn-outline-secondary mt-2">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                            <!--/ general tab -->

                                            <!-- change password -->
                                            <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                                                aria-labelledby="account-pill-password" aria-expanded="false">
                                                <!-- form -->
                                                <form class="validate-form"
                                                    action="{{ route('userPanels.accdata.edit') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- HTML -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="user_id" placeholder="ID"
                                                                    autocomplete="user_id"
                                                                    value="{{ $authenticated_user_data ? $authenticated_user_data->user_id : 'n/a' }}" />
                                                                <input type="hidden" class="form-control" id="type"
                                                                    name="type" placeholder="TYPE" autocomplete="type"
                                                                    value="{{ $convertedUserType }}" />
                                                                <label for="account-username">Username</label>
                                                                <input type="text" class="form-control"
                                                                    autocomplete="username" id="account-username"
                                                                    name="username" placeholder="Username"
                                                                    value="{{ $authenticated_user_data ? $authenticated_user_data->username : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-e-mail">E-mail</label>
                                                                <input type="email" class="form-control"
                                                                    id="account-e-mail" name="email"
                                                                    placeholder="Email"
                                                                    value="{{ $authenticated_user_data ? $authenticated_user_data->email : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-new-password">New
                                                                    Password</label>
                                                                <div
                                                                    class="input-group form-password-toggle input-group-merge">
                                                                    <input type="password" class="form-control"
                                                                        id="account-new-password"
                                                                        autocomplete="new-password" name="new-password"
                                                                        placeholder="New Password" />
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text cursor-pointer">
                                                                            <i data-feather="eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-retype-new-password">Retype New
                                                                    Password</label>
                                                                <div
                                                                    class="input-group form-password-toggle input-group-merge">
                                                                    <input type="password" class="form-control"
                                                                        id="account-retype-new-password"
                                                                        name="confirm-new-password"
                                                                        autocomplete="confirm-new-password"
                                                                        placeholder="Retype Password" />
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text cursor-pointer">
                                                                            <i data-feather="eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mr-1 mt-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                class="btn btn-outline-secondary mt-1">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                            <!--/ change password -->
                                        @else
                                            <div class="tab-pane active" id="account-vertical-profile" role="tabpanel"
                                                aria-labelledby="account-pill-info" aria-expanded="false">
                                                <div class="container">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td><strong>UserID</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data ? $authenticated_user_data->user_id : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>ClientID</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>{{ $authenticated_user_data ? ($authenticated_user_data->client ? $authenticated_user_data->client->id_client : 'n/a') : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Username</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data ? $authenticated_user_data->username : 'n/a' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Name</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data->client ? $authenticated_user_data->client->na_client : 'n/a' }}
                                                                </td>

                                                            </tr>



                                                            <tr>
                                                                <td><strong>Email</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data ? ($authenticated_user_data->email ? $authenticated_user_data->email : 'n/a') : 'n/a' }}
                                                                </td>

                                                            </tr>


                                                            <tr>
                                                                <td><strong>Address</strong></td>
                                                                <td class="pl-2">: </td>
                                                                <td>
                                                                    {{ $authenticated_user_data->client ? $authenticated_user_data->client->alamat_client : 'n/a' }}
                                                                </td>

                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    {{-- <br><br><br><br><br> --}}
                                                </div>
                                            </div>

                                            <!-- general tab -->
                                            <div role="tabpanel" class="tab-pane" id="account-vertical-general"
                                                aria-labelledby="account-pill-general" aria-expanded="true">
                                                <!-- header media -->
                                                <div class="media">
                                                    <a href="javascript:void(0);" class="mr-25">
                                                        <img src="{{ $avatar_src }}" id="account-upload-img"
                                                            class="rounded hover-qr-image mr-50" alt="profile image"
                                                            height="80" width="80" />
                                                    </a>
                                                    <!-- upload and reset button -->
                                                    <div class="media-body mt-75 ml-1">
                                                        <label for="account-upload"
                                                            class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
                                                        <input type="file" id="account-upload" hidden
                                                            accept="image/png, image/jpeg, image/*" />
                                                        <button
                                                            class="btn btn-sm acc-avatar-reset btn-outline-secondary mb-75">Reset</button>
                                                        <p>Allowed JPG, GIF or PNG. Max size of 5MB</p>
                                                    </div>
                                                    <!--/ upload and reset button -->
                                                </div>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const uploadInput = document.getElementById('account-upload');
                                                        const uploadedAvatar = document.getElementById('account-upload-img');

                                                        // Safely access id_karyawan
                                                        const userId =
                                                            '{{ isset($authenticated_user_data['client']) ? $authenticated_user_data['client']['id_client'] : 'null' }}';

                                                        uploadInput.addEventListener('change', function() {
                                                            const file = uploadInput.files[0];
                                                            const reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                const uploadedImage = e.target.result;
                                                                uploadedAvatar.src = uploadedImage;

                                                                const formData = new FormData();
                                                                formData.append('id_client', userId);
                                                                formData.append('foto_client', file);

                                                                // Use makeRequest to send the FormData
                                                                makeRequest('{{ route('userPanels.avatar.edit') }}', {
                                                                        method: 'POST',
                                                                        body: formData, // Send FormData directly
                                                                        // headers: {
                                                                        //     'X-CSRF-Token': '{{ csrf_token() }}' // Include CSRF token in headers
                                                                        // }
                                                                    })
                                                                    .then(response => {
                                                                        if (response.reload) {
                                                                            window.location.reload();
                                                                        }
                                                                    })
                                                                    .catch(error => {
                                                                        console.error('Error uploading avatar:', error);
                                                                    });
                                                            };

                                                            reader.readAsDataURL(file);
                                                        });

                                                        var userProfilePhotoPreview = uploadedAvatar;
                                                        var userProfilePhotoInput = uploadInput;
                                                        userProfilePhotoInput.addEventListener('change', function() {
                                                            const file = this.files[0];
                                                            if (file && file.type.startsWith('image/')) {
                                                                const img = document.createElement('img');
                                                                img.src = URL.createObjectURL(file);

                                                                img.onload = function() {
                                                                    userProfilePhotoPreview.src = img.src;
                                                                };
                                                            }
                                                        });

                                                        var resetButton = document.querySelector('.acc-avatar-reset');
                                                        resetButton.addEventListener('click', function() {
                                                            userProfilePhotoPreview.src =
                                                                '{{ isset($authenticated_user_data['karyawan']['foto_karyawan']) && !empty($authenticated_user_data['karyawan']['foto_karyawan']) ? asset('public/avatar/uploads/' . $authenticated_user_data['karyawan']['foto_karyawan']) : (isset($authenticated_user_data['client']['foto_client']) && !empty($authenticated_user_data['client']['foto_client']) ? asset('public/avatar/uploads/' . $authenticated_user_data['client']['foto_client']) : asset('public/assets/defaults/avatar_default.png')) }}';
                                                            userProfilePhotoInput.value = null;
                                                        });
                                                    });
                                                </script>
                                                <!--/ header media -->



                                                <!-- form -->
                                                <form class="validate-form mt-2"
                                                    action="{{ route('userPanels.biodata.edit') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control"
                                                                    id="id_client" name="id_client" placeholder="ID"
                                                                    value="{{ isset($authenticated_user_data['client']) ? $authenticated_user_data['client']['id_client'] ?? 'n/a' : 'n/a' }}" />

                                                                <label for="account-name">Name</label>
                                                                <input type="text" class="form-control"
                                                                    id="account-name" name="account-name"
                                                                    placeholder="Name"
                                                                    value="{{ isset($authenticated_user_data['client']) ? $authenticated_user_data['client']['na_client'] ?? 'n/a' : 'n/a' }}" />
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="address">Address</label>
                                                                <input type="text" class="form-control" id="address"
                                                                    name="address" placeholder="Address"
                                                                    value="{{ isset($authenticated_user_data['client']) ? $authenticated_user_data['client']['alamat_client'] ?? 'n/a' : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="notelp">No.Telp</label>
                                                                <input type="text" class="form-control" id="notelp"
                                                                    name="notelp" placeholder="No. Telp"
                                                                    value="{{ isset($authenticated_user_data['client']) ? $authenticated_user_data['client']['notelp_client'] ?? '+62 ' : '+62 ' }}" />
                                                            </div>
                                                        </div>



                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mt-2 mr-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                class="btn btn-outline-secondary mt-2">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                            <!--/ general tab -->

                                            <!-- change password -->
                                            <div class="tab-pane fade" id="account-vertical-password" role="tabpanel"
                                                aria-labelledby="account-pill-password" aria-expanded="false">
                                                <!-- form -->
                                                <form class="validate-form"
                                                    action="{{ route('userPanels.accdata.edit') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <!-- HTML -->
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="user_id" placeholder="ID"
                                                                    value="{{ $authenticated_user_data ? $authenticated_user_data->user_id : 'n/a' }}" />
                                                                <input type="hidden" class="form-control" id="type"
                                                                    name="type" placeholder="TYPE"
                                                                    value="{{ $convertedUserType }}" />
                                                                <label for="account-username">Username</label>
                                                                <input type="text" class="form-control"
                                                                    id="account-username" name="username"
                                                                    placeholder="Username"
                                                                    value="{{ $authenticated_user_data ? $authenticated_user_data->username : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-e-mail">E-mail</label>
                                                                <input type="email" class="form-control"
                                                                    id="account-e-mail" name="email"
                                                                    placeholder="Email"
                                                                    value="{{ $authenticated_user_data ? $authenticated_user_data->email : 'n/a' }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-new-password"> New
                                                                    Password</label>
                                                                <div
                                                                    class="input-group form-password-toggle input-group-merge">
                                                                    <input type="password" class="form-control"
                                                                        id="account-new-password"
                                                                        name="new-password" placeholder="New Password" />
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text cursor-pointer">
                                                                            <i data-feather="eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-group">
                                                                <label for="account-retype-new-password">Retype New
                                                                    Password</label>
                                                                <div
                                                                    class="input-group form-password-toggle input-group-merge">
                                                                    <input type="password" class="form-control"
                                                                        id="account-retype-new-password"
                                                                        name="confirm-new-password"
                                                                        placeholder="Retype Password" />
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text cursor-pointer">
                                                                            <i data-feather="eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button type="submit" class="btn btn-primary mr-1 mt-1">Save
                                                                changes</button>
                                                            <button type="reset"
                                                                class="btn btn-outline-secondary mt-1">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!--/ form -->
                                            </div>
                                            <!--/ change password -->
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ right content section -->
                    </div>
                </section>
                <!-- / account setting page -->

            </div>
        @else
            We're sorry, you're not have enought autorization to access this page :(
        @endif



    </div>

@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#daftarLoginKaryawanTable').DataTable({
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
        var bdayDatePickerInput = document.querySelector(".pickadate-birth-date");
        if (bdayDatePickerInput) {
            flatpickr(bdayDatePickerInput, {
                enableTime: false,
                dateFormat: "Y-m-d", // Format for the date and time
                altInput: true,
                altFormat: "j F, Y", // Format for the alternative input display
                allowInput: true, // Allow typing in the input field
                minDate: "1900-01-01", // Set minimum date
                maxDate: "8000-12-31" // Set maximum date
            });

        }
    </script>
@endsection
