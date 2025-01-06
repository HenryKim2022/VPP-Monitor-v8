@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
@endphp

<!DOCTYPE html>
<html class="light-layout loaded" lang="en" data-layout="" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Project Monitor is super flexible, powerful, clean &amp; modern responsive bootstrap 4 website with unlimited possibilities.">
    <meta name="keywords"
        content="Projects, Progress, Monitors">
    <meta name="author" content="PIXINVENT">
    <title>{{ $page_title }}</title>
    <link rel="apple-touch-icon" href="{{ asset('public/theme/vuexy/app-assets/images/ico/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('public/theme/vuexy/app-assets/images/ico/favicon.ico') }}">
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

    <!-- BEGIN: Fontawesome v5.7.0 CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/fa.pro@5.7.0/css/all.css') }}?v={{ time() }}">
    <!-- END: Fontawesome v5.7.0 CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page  navbar-floating footer-static  " data-open="hover"
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
                        <!-- Brand logo--><a class="brand-logo" href="{{ env('APP_URL') }}">
                            <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%"
                                        y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%"
                                        x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path"
                                                d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                style="fill: currentColor"></path>
                                            <path id="Path1"
                                                d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                                points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                            </polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                                points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                            </polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)"
                                                opacity="0.099999994"
                                                points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                            </polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <h2 class="brand-text text-primary ml-1">{{ $site_name }}</h2>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img
                                    class="img-fluid"
                                    src="{{ asset('public/theme/vuexy/app-assets/images/pages/register-v2-dark.svg') }}"
                                    alt="Register V2" /></div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Register-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 pr-lg-5 pl-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto my-5">
                                <h3 class="card-title font-weight-bold mb-1 h3-dark">Adventure starts here 🚀</h3>
                                <p class="card-text mb-2">Register yourself as Our Client!</p>
                                <form class="auth-register-form mt-2" action="{{ route('register.do') }}"
                                    method="POST">
                                    @csrf
                                    {{-- <div class="form-group">
                                        <label class="form-label" for="register-id-karyawan">Employee-ID</label>
                                        <input class="form-control" id="register-id-karyawan" type="text"
                                            name="register-id-karyawan" placeholder="1152125001"
                                            aria-describedby="register-id-karyawan" autofocus="" tabindex="1"
                                            value="{{ old('register-id-karyawan', $inputs['register-id-karyawan'] ?? '') }}" />
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="form-label" for="register-name-karyawan">Fullname</label>
                                        <input class="form-control" id="register-name-karyawan" type="text"
                                            name="register-name-karyawan" placeholder="johndoe"
                                            aria-describedby="register-name-karyawan" autofocus="" tabindex="1"
                                            value="{{ old('register-name-karyawan', $inputs['register-name-karyawan'] ?? '') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="register-username">Username</label>
                                        <input class="form-control" id="register-username" type="text"
                                            name="register-username" placeholder="johndoe"
                                            aria-describedby="register-username" autofocus="" tabindex="1"
                                            value="{{ old('register-username', $inputs['register-username'] ?? '') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="register-email">Email</label>
                                        <input class="form-control" id="register-email" type="text"
                                            name="register-email" placeholder="example@mail.com"
                                            aria-describedby="register-email" tabindex="2"
                                            value="{{ old('register-email', $inputs['register-email'] ?? '') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="register-password">Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="register-password"
                                                type="password" name="register-password" placeholder="············"
                                                aria-describedby="register-password" tabindex="3"
                                                value="{{ old('register-password', $inputs['register-password'] ?? '') }}" />
                                            <div class="input-group-append"><span
                                                    class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="register-confirm-password">Confirm
                                            Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge"
                                                id="register-confirm-password" type="password"
                                                name="register-confirm-password" placeholder="············"
                                                aria-describedby="register-password" tabindex="3"
                                                value="{{ old('register-confirm-password', $inputs['register-confirm-password'] ?? '') }}" />
                                            <div class="input-group-append"><span
                                                    class="input-group-text cursor-pointer"><i
                                                        data-feather="eye"></i></span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" id="register-privacy-policy"
                                                name="register-privacy-policy" type="checkbox" tabindex="4"
                                                value="1"
                                                {{ old('register-privacy-policy') ? 'checked' : '' }} />
                                            <label class="custom-control-label" for="register-privacy-policy" data-toggle="modal"
                                            data-target="#modalPrivacyPolicy">I agree
                                                to<a
                                                {{-- href="javascript:void(0);" --}}
                                                >&nbsp;privacy policy &
                                                    terms</a></label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" tabindex="5">Sign up</button>
                                </form>
                                <p class="text-center mt-2"><span>Already have an account?<br></span><a
                                        href="{{ route('login.page') }}"><span>&nbsp;Sign in instead</span></a></p>

                            </div>
                        </div>
                        <!-- /Register-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    <!-- Modal: PrivacyPolicy / privacy policy modal -->
    <div class="modal fade" id="modalPrivacyPolicy" data-bs-backdrop="static" tabindex="-1" aria-hidden="true"
        style="z-index: 1102;">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center">
                    <h4 class="modal-title h4-dark" id="modalScrollableTitle">Privacy Policy Agreements</h4>
                </div>

                <div>
                    <div class="divider">
                        <div class="divider-text">
                            <div class="divider-icon">
                                <i class="mdi mdi-star-outline"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body text-justify text-wrap">
                    <p>At {{ env('APP_NAME') }}, we are committed to protecting your
                        privacy and ensuring the security of any personal information you provide to us. This
                        Privacy Policy outlines how we collect, use, and protect your information when you sign
                        up for our services on our website.</p>

                    <h6 class="h6-dark">Information We Collect:</h6>
                    <ul>
                        <li>When you sign up for an account on {{ env('APP_NAME') }}, we may collect personal
                            information such as your name, email address, and contact details.</li>
                        <li>We may also collect non-personal information such as your IP address, browser type,
                            and device information for analytical purposes.</li>
                    </ul>

                    <h6 class="h6-dark">Use of Information:</h6>
                    <ul>
                        <li>We use the information you provide to create and manage your account on
                            {{ env('APP_NAME') }}, allowing you to access our services and features.</li>
                        <li>Your personal information may be used to communicate with you regarding your
                            account, updates, and important notices related to {{ env('APP_NAME') }}.</li>
                        <li>We may use non-personal information for statistical analysis, improving our
                            services, and enhancing the user experience on our website.</li>
                    </ul>

                    <h6 class="h6-dark">Data Security:</h6>
                    <ul>
                        <li>We implement strict security measures to protect your personal information from
                            unauthorized access, alteration, or disclosure.</li>
                        <li>Your account is password-protected, and we recommend choosing a strong password and
                            keeping it confidential.</li>
                        <li>We use encryption technology to transmit sensitive information securely over the
                            internet.</li>
                    </ul>

                    <h6 class="h6-dark">Third-Party Disclosure:</h6>
                    <ul>
                        <li>We do not sell, trade, or transfer your personal information to third parties
                            without your consent, except as required by law or when necessary to provide our
                            services.</li>
                        <li>We may share non-personal information with trusted third-party service providers who
                            assist us in operating our website or analyzing data.</li>
                    </ul>

                    <h6 class="h6-dark">Terms of Service</h6>
                    <ul>
                        <li>By signing up for an account on {{ env('APP_NAME') }}, you agree to abide by our
                            Terms of Service.</li>
                        <li>You are responsible for maintaining the confidentiality of your account credentials
                            and for all activities that occur under your account.</li>
                        <li>You agree not to use {{ env('APP_NAME') }} for any illegal, unauthorized, or
                            unethical purposes.</li>
                        <li>We reserve the right to suspend or terminate your account if you violate our Terms
                            of Service.</li>
                    </ul>

                    <h6 class="h6-dark">Changes to the Privacy Policy:</h6>
                    <ul>
                        <li>
                            We may update this Privacy Policy from time to time. Any changes will be posted on
                            this page, and it is your responsibility to review the Privacy Policy periodically.
                        </li>
                    </ul>
                </div>

                <div>
                    <div class="divider">
                        <div class="divider-text">
                            <div class="divider-icon">
                                <i class="far fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer align-content-center pt-1 pr-1">
                    <div class="d-flex flex-column m-0">
                        <div>
                            <a class="text-sm pl-0 pt-3 text-wrap">
                                <i>
                                    By signing up for an account on {{ env('APP_NAME') }}, you acknowledge that
                                    you have read, understood, and agreed to the Privacy Policy and Terms of
                                    Service.
                                </i>
                            </a>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            <button id="confirmPolicyBtn" type="button" class="btn btn-primary"
                                data-dismiss="modal">Accept</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- / Content -->








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
    {{-- <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/pages/page-auth-register.js') }}"></script> --}}
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

    <!-- BEGIN: CSRF Auto Regen --> @include('v_res.csrf_regen.v_csrf_regen') <!-- END: CSRF Auto Regen -->




</body>
<!-- END: Body-->

</html>
