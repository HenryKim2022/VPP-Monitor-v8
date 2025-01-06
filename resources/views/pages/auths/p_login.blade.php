@php
    $page = Session::get('page');
    $page_title = $page['page_title'];

    // // Define an array of allowed local addresses and IP ranges
    // $disableCapthaOnBaseUrl = [
    //     // 'localhost',
    //     // '127.0.0.1',
    //     // '::1',
    //     // 'http://localhost',
    //     // 'https://localhost',
    //     // '100.100.100.162', // Specific IP address
    //     // 'http://100.100.100.162',
    //     // 'https://100.100.100.162',
    //     'ip_ranges' => [ // Define multiple IP ranges here
    //         ['100.100.100.0', '100.100.100.200'],
    //         ['192.168.1.0', '192.168.1.254'],
    //     ],
    // ];

    // // Get the client's IP address
// $clientIp = request()->ip();

// // Function to convert IP address to an integer
// function ipToInt($ip) {
//     return sprintf('%u', ip2long($ip));
// }

// // Check if the client's IP is within any of the specified ranges
    // $isInRange = false;
    // if (isset($disableCapthaOnBaseUrl['ip_ranges'])) {
    //     foreach ($disableCapthaOnBaseUrl['ip_ranges'] as $range) {
    //         $ipRangeStart = $range[0];
    //         $ipRangeEnd = $range[1];
    //         if (ipToInt($clientIp) >= ipToInt($ipRangeStart) && ipToInt($clientIp) <= ipToInt($ipRangeEnd)) {
    //             $isInRange = true;
    //             break; // Exit the loop if the IP is found in any range
    //         }
    //     }
    // }

    // // Check if the current request's IP or URL is in the allowed local addresses
    // $isLocal = in_array($clientIp, $disableCapthaOnBaseUrl) ||
    //            in_array(request()->fullUrl(), $disableCapthaOnBaseUrl) ||
    //            $isInRange;

@endphp




<!DOCTYPE html>
<html class="light-layout loaded" lang="en" data-layout="" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/vendors.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/extensions/toastr.min.css') }}?v={{ time() }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap-extended.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/colors.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/components.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/dark-layout.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/bordered-layout.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/semi-dark-layout.css') }}?v={{ time() }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/forms/form-validation.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/pages/page-auth.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/extensions/ext-component-toastr.css') }}?v={{ time() }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/assets/css/style.css') }}?v={{ time() }}">
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
    <!-- END: CUSTOM PRELOADER -->

    <!-- BEGIN: CUSTOM RECAPTHA ICONSIZE -->
    <style>
        .rc-anchor-logo-img-large {
            -webkit-background-size: 28px !important;
            background-size: 28px !important;
            height: 28px !important;
            width: 28px !important;
        }

        .rc-anchor-invisible-nohover .rc-anchor-logo-img-large,
        .rc-anchor-invisible-hover-hovered .rc-anchor-logo-img-large {
            -webkit-background-size: 28px !important;
            -o-background-size: 28px !important;
            background-size: 28px !important;
            margin: 8px 13px 0 13px;
            height: 28px !important;
            width: 28px !important;
        }

        .grecaptcha-badge {
            bottom: -20px !important;
            right: -209px !important;
            transform: scale(0.77);
            -webkit-transform: scale(0.67);
            transform-origin: 0 0;
            -webkit-transform-origin: 0 0;
        }
        .grecaptcha-badge:hover {
           right: -83px !important;
        }
    </style>
    <!-- END: CUSTOM RECAPTHA ICONSIZE -->

    <!-- BEGIN: Fontawesome v5.15.4 CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/fa.pro@5.15.4.web/css/all.css') }}?v={{ time() }}">
    <!-- END: Fontawesome v5.15.4 CSS-->

    @if (!$isLocal)
        <!-- BEGIN: Google API Recaptcha v3 -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaKey }}"></script>
        <!-- END: Google API Recaptcha v3 -->
    @endif

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover"
    data-menu="horizontal-menu" data-col="blank-page">
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
                        {{-- <a class="brand-logo" href="{{ env('APP_URL') }}">
                            <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill: currentColor"></path>
                                            <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <h2 class="brand-text text-primary ml-1">PMonitor</h2>

                        </a> --}}


                        <a class="brand-logo d-flex align-items-center justify-content-start"
                            href="{{ env('APP_URL') }}">
                            <img src="{{ asset('public/assets/logo/vp_logo.svg') }}" alt="Project MonitorLogo"
                                style="width: fit-content; height: 35px;">
                            <h2 class="brand-text text-primary ml-1 mb-0">{{ $site_name }}</h2>
                        </a>


                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img
                                    class="img-fluid"
                                    src="{{ asset('public/theme/vuexy/app-assets/images/pages/login-v2-dark.svg') }}"
                                    alt="Login V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h4 class="card-title font-weight-bold mb-1 text-center h4-dark">Adventure starts here
                                    &#x1F44B;</h4>
                                <p class="card-text mb-2 text-center">Please sign-in to your account and start the adventure</p>
                                <form class="auth-login-form mt-2" action="{{ route('login.do') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="username-email">Email/ Username</label>
                                        <input class="form-control" id="username-email" type="text"
                                            name="username-email" placeholder="youremail@example.com"
                                            aria-describedby="username-email" autofocus="" tabindex="1"
                                            value="{{ old('username-email', $inputs['username-email'] ?? '') }}" />
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="login-password">Password</label>
                                            <a class="" href="{{ route('reset.page') }}"><small>Forgot
                                                    Password?</small>
                                            </a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="login-password"
                                                type="password" name="login-password"
                                                placeholder="&#x22C5;&#x22C5;&#x22C5;&#x22C5;&#x22C5;&#x22C5;&#x22C5;&#x22C5;&#x22C5;"
                                                aria-describedby="login-password" tabindex="2"
                                                value="{{ old('login-password', $inputs['login-password'] ?? '') }}" />
                                            <div class="input-group-append"><span
                                                    class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="remember-me" name="remember-me"
                                                type="checkbox" tabindex="3" />
                                            <label class="custom-control-label" for="remember-me"> Remember Me</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" tabindex="4">Sign in</button>
                                </form>


                                @php
                                    $regRef = !empty($filtered_settings) && $filtered_settings->isNotEmpty();
                                @endphp
                                @if ($regRef)
                                    <div class="text-center mt-2">
                                        @php
                                            // Check the first and second settings to determine registration status
                                            $firstSetting = $filtered_settings->first();
                                            $secondSetting = $filtered_settings->get(1); // Get the second setting (index 1)
                                            $isFirstSettingEnabled =
                                                !empty($firstSetting['val_sett']) && $firstSetting['val_sett'] == 1;
                                            $isSecondSettingEnabled =
                                                !empty($secondSetting['val_sett']) && $secondSetting['val_sett'] == 1;

                                            // Determine registration status
                                            $regStat = $isFirstSettingEnabled || $isSecondSettingEnabled;
                                        @endphp

                                        <span
                                            @if (!$regStat) data-toggle="tooltip"
                                        data-popup="tooltip-custom"
                                        data-placement="bottom"
                                        data-original-title="{{ 'Contact at: ' . $company_phone_number['tooltip_text_sett'] }}"
                                        class="pull-up" @endif>
                                            {{ $regStat ? 'New on our platform?' : 'Contact site owner to register!' }}
                                        </span>
                                    </div>

                                    <div>
                                        @php
                                            // Filter active settings using Collection's filter method
$activeSettings = $filtered_settings->filter(function ($setting) {
    return !empty($setting['val_sett']) && $setting['val_sett'] == 1;
                                            });
                                            $totalActiveSettings = $activeSettings->count(); // Count of active settings
                                        @endphp

                                        <div
                                            class="d-flex {{ $totalActiveSettings === 1 ? 'justify-content-center' : 'justify-content-between' }}">
                                            @foreach ($activeSettings as $setting)
                                                <!-- Iterate only over active settings -->
                                                <a data-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-placement="bottom"
                                                    data-original-title="{{ $setting['tooltip_text_sett'] ?? 'Default Tooltip' }}"
                                                    class="pull-up" href="{{ route($setting['url_sett'] ?? '#') }}">
                                                    {{ $setting['lbl_sett'] ?? 'Default Label' }}
                                                    <!-- Display the label -->
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{--
                                <p>
                                <div class="d-flex justify-content-between">
                                    @if (Route::has('register.client.page'))
                                        <a data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                            data-original-title="Create an client account" class="pull-down"
                                            href="{{ route('register.client.page') }}">
                                            Client account
                                        </a>
                                    @endif
                                    @if (Route::has('register.emp.page'))
                                        <a id="charCount" data-toggle="tooltip" data-popup="tooltip-custom"
                                            data-placement="bottom" data-original-title="Create an employee account"
                                            class="pull-down" href="{{ route('register.emp.page') }}">
                                            Employee account
                                        </a>
                                    @endif
                                </div>
                                </p> --}}


                            </div>
                        </div>
                        <!-- /Login-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('public/theme/vuexy/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/pages/page-auth-login.js') }}"></script> --}}
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>




    <!-- BEGIN: Toast CustomJS Bundle's--> @include('v_res.toasts.v_toast_js_bundle') <!-- END: Toast CustomJS Bundle's-->

    @if (!$isLocal)
        <!-- BEGIN: Login & Captcha v3 -->
        <script type="text/javascript">
            var form1 = '.auth-login-form';

            $(form1).submit(function(event) {
                event.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute("{{ $recaptchaKey }}", {
                        action: 'login'
                    }).then(function(token) {
                        $(form1).prepend('<input type="hidden" name="g-recaptcha-response" value="' +
                            token + '">');
                        $(form1).unbind('submit').submit();
                    });
                });
            });
        </script>
        <!-- END: Login & Captcha v3 -->
    @endif



    <!-- BEGIN: CSRF Auto Regen --> @include('v_res.csrf_regen.v_csrf_regen') <!-- END: CSRF Auto Regen -->




</body>
<!-- END: Body-->

</html>
