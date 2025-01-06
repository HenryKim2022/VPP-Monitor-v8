{{-- @php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = $page['custom_date_format'];
    $authenticated_user_data = Session::get('authenticated_user_data');
    // $avatar_src = $authenticated_user_data && $authenticated_user_data->foto_karyawan ? asset('public/avatar/uploads/' . $authenticated_user_data->foto_karyawan) : asset(env('public/assets/defaults/avatar_default.png'));
    $avatar_src = $authenticated_user_data && $authenticated_user_data->foto_karyawan && file_exists(public_path('avatar/uploads/' . $authenticated_user_data->foto_karyawan)) ? asset('public/avatar/uploads/' . $authenticated_user_data->foto_karyawan) : asset(env('public/assets/defaults/avatar_default.png'));
    $loadDataWorksheetFromDB = Session::get('loadDataWorksheetFromDB');

    // dd($authenticated_user_data->toArray());
@endphp
 --}}




<!DOCTYPE html>
<html class="light-layout loaded" lang="en" data-layout="" data-textdirection="ltr">
<!-- BEGIN: Head--> @include('layouts.userpanels.v_header') <!-- END: Head-->



<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <div id="preloader">
        <div class="loader">
        </div>
        <div class="loader-logo-container d-flex col-3">
            <img src="{{ asset('public/assets/logo/vp_logo.svg') }}" alt="Project MonitorLogo">
        </div>
    </div>
    <script>
        function hidePreloader() {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.display = 'none';
                document.body.classList.remove('no-scroll');
            }, 1000); // 2000ms = 2 seconds
        }
        document.body.classList.add('no-scroll'); // Add no-scroll class when preloader is shown
        window.onload = function() {
            hidePreloader();
        };
    </script>

    {{--
    @php
        $page = Session::get('page');
        $page_title = $page['page_title'];
        $cust_date_format = $page['custom_date_format'];
        $authenticated_user_data = Session::get('authenticated_user_data');

        // Initialize avatar_src to default avatar
        $default_avatar_path = 'public/assets/defaults/avatar_default.png';
        $avatar_src = asset($default_avatar_path);

        // Check if the authenticated user is a karyawan or client and set avatar_src accordingly
        if (
            isset($authenticated_user_data['foto_karyawan']) &&
            !empty($authenticated_user_data['foto_karyawan']) &&
            file_exists(public_path('avatar/uploads/' . $authenticated_user_data['foto_karyawan']))
        ) {
            // For karyawan
            $avatar_src = asset('public/avatar/uploads/' . $authenticated_user_data['foto_karyawan']);
        } elseif (
            isset($authenticated_user_data['foto_client']) &&
            !empty($authenticated_user_data['foto_client']) &&
            file_exists(public_path('avatar/uploads/' . $authenticated_user_data['foto_client']))
        ) {
            // For client
            $avatar_src = asset('public/avatar/uploads/' . $authenticated_user_data['foto_client']);
        }

        // Check session for user_image only if the avatar_src is still the default
        if ($avatar_src === asset($default_avatar_path)) {
            // Get the user_image from session
            $session_user_image = Session::get('user_image');
            // If session_user_image is available, use it as avatar_src
            if ($session_user_image) {
                $avatar_src = $session_user_image;
            }
        } else {
            // If a valid user avatar exists, store it in the session
            Session::put('user_image', $avatar_src);
        }
    @endphp --}}


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





    <!-- BEGIN: Nav-head--> @include('layouts.userpanels.v_topnav') <!-- END: Nav-head-->
    <!-- BEGIN: Nav-side--> @include('layouts.userpanels.v_sidenav') <!-- END: Nav-side-->
    <!-- BEGIN: Content-->
    <div class="app-content content ">


        {{-- <!--  Check $data as array -->
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <pre style="color: white">{{ print_r($authenticated_user_data->toArray(), true) }}</pre>
                    <br>
                </div>
            </div>
        </div> --}}



        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div id="image-popup"
                class="modal-dialog-centered-cust modal-lg modal-dialog-scrollable col-8 col-sm-6 col-md-4 p-2">
                <span class="close-btn btn btn-sm btn-text-primary rounded-pill btn-icon"><i
                        class="mdi mdi-close"></i></span>
                <img src="" alt="Large Image" style="max-height: 85vh" />
            </div>
            <div id="qr-popup" class="modal-dialog-centered-cust col-8 col-sm-6 col-md-4 p-2">
                <span class="close-btn btn btn-sm btn-text-primary rounded-pill btn-icon"><i
                        class="fad fa-times-circle fa-2x"></i></span>
                <img src="" alt="Large Image" style="max-height: 85vh" />
            </div>


            {{-- <div class="card">
                {{ dd($authenticated_user_data->toArray())}}
            </div> --}}


            @auth
                <section id="dashboard-ecommerce" style="position: relative;">

                    <div class="content-header row">
                        <div class="content-header-left col-md-9 col-12 mb-2">
                            <div class="row breadcrumbs-top">
                                <div class="col-12">
                                    <div class="breadcrumbs">
                                        <ul>
                                            @foreach ($breadcrumbs as $index => $breadcrumb)
                                                <li class="d-flex justify-content-center align-content-center">
                                                    @if ($loop->last)
                                                        <!-- Render the last breadcrumb as plain text -->
                                                        <span class="disabled active">{{ $breadcrumb['text'] }}</span>
                                                    @else
                                                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['text'] }}</a>
                                                    @endif
                                                    @if (!$loop->last)
                                                        <span class="separator"><i class="fas fa-chevron-right"
                                                                style="font-size: 0.8rem;"></i></span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('page-content')
                </section>
            @endauth
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN: Footer--> @include('layouts.userpanels.v_footer') <!-- END: Footer-->

    <!-- BEGIN: Footer JS Bundle's--> @include('v_res.userpanels.v_footer_js_bundle') <!-- END: Footer JS Bundle's-->
    <!-- BEGIN: Toast CustomJS Bundle's--> @include('v_res.toasts.v_toast_js_bundle') <!-- END: Toast CustomJS Bundle's-->
    <!-- BEGIN: FYI Modals--> @include('v_res.modals.p_fyi_modals') <!-- END: FYI Modals-->

    <!-- BEGIN: PAGE JS's--> @yield('footer_page_js') <!-- END: PAGE JS's-->


</body>

</html>
