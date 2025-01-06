@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
@endphp

<!DOCTYPE html>
<html class="loading dark-layout" lang="en" data-layout="dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Project Monitor is super flexible, powerful, clean &amp; modern responsive bootstrap 4 website with unlimited possibilities.">
    <meta name="keywords" content="Projects, Progress, Monitors">
    <meta name="author" content="PT. VERTECH PERDANA">
    <title>{{ $page_title }}</title>
    <link rel="apple-touch-icon" href="{{ asset('public/assets/logo/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/logo/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/extensions/toastr.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/pages/page-auth.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <!-- BEGIN: ADD LACKS PY -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/css/dev.general.custom.css') }}?v={{ time() }}">
    <!-- END: ADD LACKS PY -->

    <!-- BEGIN: CHROME & FIREFOX HTML CUSTOM SCROLLBAR -->
    <style>
        /* For WebKit browsers (Chrome, Safari) */
        html::-webkit-scrollbar {
            width: 0;
            /* Hide scrollbar */
            height: 0;
            /* Hide horizontal scrollbar */
            display: none;
        }

        /* Show scrollbar when hovering over the scrollbar area */
        html:hover::-webkit-scrollbar {
            width: 8px;
            /* Width of the scrollbar */
            height: 12px;
            /* Height of the scrollbar */
            display: inline;
        }

        /* Scrollbar track styles */
        html::-webkit-scrollbar-track {
            background: #f8f9fa;
            /* Default background of the scrollbar track */
            border-radius: 10px;
            /* Rounded corners for track */
        }

        /* Scrollbar thumb styles */
        html::-webkit-scrollbar-thumb {
            background-color: #6c757d;
            /* Color of the scrollbar thumb */
            border-radius: 10px;
            /* Rounded corners for the thumb */
        }

        html::-webkit-scrollbar-thumb:hover {
            background-color: #6E6B7B;
            /* Darker grey on hover */
        }

        /* For Firefox */
        html.light-layout {
            scrollbar-width: thin;
            /* Make scrollbar thin */
            scrollbar-color: #6c757d transparent;
            /* Thumb color and track color */
        }

        /* For Firefox */
        html.dark-layout {
            scrollbar-width: thin;
            /* Make scrollbar thin */
            scrollbar-color: #6c757d transparent;
            /* Thumb color and track color */
        }

        /* Show scrollbar color when hovering over the track */
        html:hover {
            scrollbar-color: #6c757d transparent;
            /* Thumb color and track color on hover */
        }
    </style>
    <!-- END: CHROME & FIREFOX HTML CUSTOM SCROLLBAR -->


    <!-- BEGIN: CUSTOM PRELOADER-->
    <style>
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background: rgba(255, 255, 255, 0.9); */
            /* Light background */
            z-index: 99999;
            /* Ensure it covers everything */
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            /* Initial opacity */
            transition: opacity 0.8 ease;
            /* Transition for fade effect */
        }

        .dark-layout #preloader {
            background: rgba(23, 30, 49, 1);
        }

        .light-layout #preloader {
            background: rgba(246, 246, 246, 1);
        }

        .loader {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid var(--primary);
            /* Blue */
            border-radius: 50%;
            width: 112px;
            height: 112px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-logo-container {
            position: absolute;
            /* Position it in the center */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-logo-container img {
            width: 100px;
            height: auto;
        }

        body.no-scroll {
            overflow: hidden !important;
            /* Prevents scrolling */
        }
    </style>
    <!-- BEGIN: CUSTOM PRELOADER -->


    <!-- BEGIN: Fontawesome v5.15.4 CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/fa.pro@5.15.4.web/css/all.css') }}?v={{ time() }}">
    <!-- END: Fontawesome v5.15.4 CSS-->


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover"
    data-menu="horizontal-menu" data-col="blank-page">
      <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v2">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo-->
                            {{-- <a class="brand-logo d-flex align-items-center justify-content-start"
                                href="{{ env('APP_URL') }}">
                                <img src="{{ asset('public/assets/logo/vp_logo.svg')) }}" alt="{{ $site_name . ' Logo' }}"
                                    style="width: fit-content; height: 35px;">
                                <h2 class="brand-text text-primary ml-1 mb-0">{{ $site_name }}</h2>
                            </a>
                        --}}
                        {{-- <a class="brand-logo d-flex align-items-center justify-content-start" href="{{ env('APP_URL') }}">
                            <img src="{{ $message->embed($logoPath) }}" alt="Logo">
                            <h2 class="brand-text text-primary ml-1 mb-0">{{ $site_name }}</h2>
                        </a>

                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                                <img src="{{ $message->embed($resetImagePath) }}" alt="Reset Image">
                            </div>
                        </div> --}}
                        {{-- <div style="display: flex; justify-content: center; padding: 20px;">
                            <img class="img-fluid" src="data:image/png;base64,{{ base64_encode(file_get_contents(asset('public/theme/vuexy/app-assets/images/pages/reset-password-v2-dark.svg')))) }}" alt="Reset V2" style="max-width: 100%; height: auto;" />
                        </div> --}}

                        <!-- /Left Text-->
                        <!-- Reset-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h4 class="card-title font-weight-bold mb-1 text-center">Password Reset Request</h4>
                                <p>We received a request to reset your password. Click the button below to reset it:</p>
                                <p>
                                    <a href="{{ $url }}" style="text-decoration: none;">
                                        <button style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">
                                            Reset Password
                                        </button>
                                    </a>
                                </p>
                                <p>If you did not request a password reset, please ignore this email.</p>
                                <p>Regards,</p>
                                <p>{{ $site_owner }}</p>


                            </div>
                        </div>
                        <!-- /Reset-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->





</body>
<!-- END: Body-->

</html>
