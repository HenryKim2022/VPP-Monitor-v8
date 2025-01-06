<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Project Monitoris super flexible, powerful, clean &amp; modern responsive bootstrap 4 website with unlimited possibilities.">
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
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/extensions/dragula.min.css') }}">
    <!-- END: Vendor CSS-->



    <!-- BEGIN: DataTables Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
    <!-- END: DataTables Vendor CSS-->

    <!-- BEGIN: Select2 Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Select2 Vendor CSS-->


    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/dark-layout.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/pages/dashboard-ecommerce.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/forms/pickers/form-flat-pickr.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/flatpickr/flatpicker.css') }}"> --}}
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/forms/pickers/form-pickadate.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/plugins/extensions/ext-component-drag-drop.css') }}">

    <!-- END: Page CSS-->





    <!--------------------------------------------------------------BEGIN: Custom CSS---------------------------------------------------------------->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/assets/css/style.css') }}">
    <!-- BEGIN: IMAGE ENLARGE POPUP -->
    <style>
        @-moz-document url-prefix() {

            input[type="text"].dark-mode,
            input[type="email"].dark-mode,
            input[type="password"].dark-mode {
                background-color: #343a40;
                color: #fff;
            }
        }

        .modal-dialog-centered-cust {
            display: flex;
            align-items: center;
            min-height: fit-content;
        }

        .modal-dialog-centered-cust {
            display: flex;
            align-items: center;
            min-height: fit-content;
            /* transform: translate(-50%, -50%); */
        }

        .hover-image {
            cursor: pointer;
        }

        #image-popup {
            display: none;
            position: fixed;
            padding: 10px;
            background-clip: padding-box;
            background-color: #30334e;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
            border-radius: 0.625rem;
            outline: 0;
            z-index: 9999;
        }

        .dark-layout #image-popup {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        .light-layout .dark-layout #image-popup {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        #image-popup img {
            width: 100%;
        }

        #image-popup .close-btn {
            position: absolute;
            top: 0.15rem;
            right: 0.15rem;
            cursor: pointer;
            color: #fff;
            background-color: rgba(248, 23, 23, 0.267);
        }

        #image-popup .close-btn:hover {
            background-color: rgba(248, 23, 23, 0.945);
        }
    </style>
    <!-- END: IMAGE ENLARGE POPUP -->

    <!-- BEGIN: IMAGE ENLARGE QRPOPUP -->
    <style>
        .modal-dialog-centered-cust {
            display: flex;
            align-items: center;
            min-height: fit-content;
        }

        .hover-qr-image {
            cursor: pointer;
        }

        #qr-popup {
            display: none;
            position: fixed;
            padding: 10px;
            background-clip: padding-box;
            background-color: #30334e;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
            border-radius: 0.625rem;
            outline: 0;
            z-index: 9999;
        }

        .dark-layout #qr-popup {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        .light-layout .dark-layout #qr-popup {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(20, 21, 33, 0.175);
        }

        #qr-popup img {
            width: 100%;
        }


        #qr-popup .close-btn {
            position: absolute;
            top: 0.15rem;
            right: 0.15rem;
            cursor: pointer;
        }

        .dark-layout #qr-popup .close-btn {
            --fa-primary-color: #28c26e;
            --fa-secondary-color: #283046;
            --fa-secondary-opacity: 1;
        }

        .dark-layout #qr-popup .close-btn:hover {
            --fa-primary-color: #28c26e;
            --fa-secondary-color: #fff;
            --fa-secondary-opacity: 1;
        }

        .light-layout #qr-popup .close-btn {
            --fa-primary-color: #28c26e;
            --fa-secondary-color: #fff;
            --fa-secondary-opacity: 1;
        }

        .light-layout #qr-popup .close-btn:hover {
            --fa-primary-color: #28c26e;
            --fa-secondary-color: #283046;
            --fa-secondary-opacity: 1;
        }
    </style>
    <!-- END: IMAGE ENLARGE QRPOPUP -->

    <!-- START: UNDERLINE & TABLE BORDER -->
    <style>
        .underline-text {
            text-decoration: underline;
        }

        .dark-layout table.table.table-striped>thead>tr>th {
            border: 1px solid var(--light) !important;
        }

        .light-layout table.table.table-striped>thead>tr>th {
            border: 1px solid var(--dark) !important;
        }

        .dark-layout table.table.table-striped>tfoot>tr>th {
            border: 1px solid var(--light) !important;
        }

        .light-layout table.table.table-striped>tfoot>tr>th {
            border: 1px solid var(--dark) !important;
        }

        .dark-layout table.table.table-striped>tfoot>tr>td {
            border: 1px solid var(--light) !important;
        }

        .light-layout table.table.table-striped>tfoot>tr>td {
            border: 1px solid var(--dark) !important;
        }


        .dark-layout table.table.table-striped>tbody>tr>td {
            border: 1px solid var(--light) !important;
        }

        .light-layout table.table.table-striped>tbody>tr>td {
            border: 1px solid var(--dark) !important;
        }
    </style>
    <!-- END: UNDERLINE & TABLE BORDER -->


    <!-- START: CUSTOMIZED DROPDOWN POS -->
    <style>
        .card {
            position: relative !important;
            overflow: visible !important;
        }

        .dropdown-menu {
            position: absolute !important;
        }
    </style>
    <!-- END: CUSTOMIZED DROPDOWN POS -->



    <!-- START: CUSTOMIZED AUTHORIZED ROLE TEXT -->
    <style>
        .auth-role-text {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            border: none;
            z-index: 2;
        }

        .auth-role-lock-text {
            /* position: absolute; */
            /* top: 1.25rem; */
            /* right: 1.25rem; */
            /* border: none; */
            /* z-index: 2; */
        }

        .add-record-text {
            position: absolute;
            top: 1rem;
            left: 1rem;
            border: none;
            z-index: 2;
        }

        /* .logo_eng_text {
            position: absolute;
            top: 5.6rem;
            border: none;
            z-index: 0;
        } */

        .auth-role-eng-text {
            position: absolute;
            /* top: 1.2rem; */
            top: auto;
            right: 0.9rem;
            border: none;
            z-index: 2;
        }

        .auth-role-text {
            color: var(--light) !important;
        }


        .auth-role-text a:hover {
            color: var(--light) !important;
        }

        button.auth-role-text:hover {
            color: var(--light) !important;
        }

        .auth-role-eng-text a:hover {
            color: var(--light) !important;
        }

        button.auth-role-eng-text:hover {
            color: var(--light) !important;
        }


        .btn:not([class*='btn-']).print-text {
            color: var(--white) !important;
        }
    </style>
    <!-- END: CUSTOMIZED AUTHORIZED ROLE TEXT -->


    <!-- START: CUSTOMIZED BREADCRUMB -->
    <style>
        .breadcrumbs {
            font-family: Arial, sans-serif;
            /* Change font as needed */
            font-size: 14px;
            /* Adjust font size */
        }

        .breadcrumbs ul {
            list-style: none;
            /* Remove default list styles */
            padding: 0;
            /* Remove padding */
            margin: 0;
            /* Remove margin */
            display: flex;
            /* Use flexbox for horizontal layout */
            align-items: center;
            /* Center items vertically */
        }

        .breadcrumbs li {
            display: flex;
            /* Flexbox for items */
            align-items: center;
            /* Center items vertically */
        }

        .breadcrumbs a {
            text-decoration: none;
            /* Remove underline from links */
            color: #007bff;
            /* Link color */
            transition: color 0.3s;
            /* Transition for hover effect */
        }

        .breadcrumbs a:hover {
            color: #0056b3;
            /* Darker color on hover */
        }

        .breadcrumbs .separator {
            margin: 0 5px;
            /* Space around separator */
            color: #888;
            /* Color of the separator */
        }

        .breadcrumbs .separator i {
            font-size: 14px;
            /* Font size for the separator icon */
        }
    </style>
    <!-- END: CUSTOMIZED BREADCRUMB -->


    <!-- START: CUSTOMIZED AUTHORIZED ROLE TEXT -->
    <style>
        @keyframes blink_text {

            0%,
            49% {
                opacity: 1;
                color: var(--danger);
            }

            50%,
            100% {
                opacity: 1;
                color: var(--light);
            }
        }

        .btn:not([class*='btn-']).blink-text {
            animation: blink_text 1s infinite;
        }



        @keyframes blink_bg {

            0%,
            49% {
                opacity: 1;
                background-color: var(--danger);
            }

            50%,
            100% {
                opacity: 1;
                background-color: var(--primary);
            }
        }

        .btn:not([class*='btn-']).blink-bg {
            animation: blink_bg 1s infinite;
        }

        .rowlock:not([class*='rowlock-']).blink-bg {
            animation: blink_bg 1s infinite;
        }

        /* .blink-bg {
            animation: blink_bg 1s infinite;
        }
 */

        .auth-role-lock-text {
            color: var(--light);
        }



        .auth-role-lock-text a:hover {
            color: var(--warning) !important;
        }

        button.auth-role-lock-text:hover {
            color: var(--warning) !important;
        }
    </style>
    <!-- END: CUSTOMIZED AUTHORIZED ROLE TEXT -->


    <!-- BEGIN: BLURRING SENSITIVE DATA -> TEXT -->
    <style>
        .phone-container {
            display: flex;
            align-items: center;
        }

        .blurred-part {
            color: transparent;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            transition: color 0.3s;
            /* display: inline; */
            /* white-space: nowrap; */
        }

        .blurred-part:hover {
            color: inherit;
            text-shadow: none;
        }
    </style>
    <!-- END: BLURRING SENSITIVE DATA -> TEXT -->


    <!-- BEGIN: ADD LACKS PY -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/dev.general.custom.css') }}?v={{ time() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/dev.very.custom.css') }}?v={{ time() }}">
    <!-- END: ADD LACKS PY -->


    <!-- BEGIN: JS DYNAMIC CUSTOM LEFT FLOATING BUTTON -->
    <style>
        .left-floating-container {
            position: fixed;
            bottom: 4.6%;
            z-index: 1000;
        }

        /* .floating-btn {
            position: fixed;
            bottom: 5%;
            z-index: 1000;
        } */
    </style>
    <!-- END: JS DYNAMIC CUSTOM LEFT FLOATING BUTTON -->


    <!-- BEGIN: EXPIRED TR BG -->
    <style>
        tr.expired {
            color: var(--white) !important;
            background: var(--danger) !important;
        }

        /* .dark-layout tbody > td > div > a.open-project-ws{
            color: var(--white) !important;
        }
        .light-layout tbody > td > div > a.open-project-ws{
            color: var(--white) !important;
        } */
    </style>
    <!-- END: EXPIRED TR BG -->

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


        .modal .modal-body::-webkit-scrollbar {
            scrollbar-width: 4px;
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
            top: 0.5%;
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



    <!-- BEGIN: CUSTOM PICKER POS -->
    <style>
        .picker {
            z-index: 1052 !important;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

        }

        .picker__holder {
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, 2%) !important;
            position: relative !important;
        }

        /* .flatpickr-time.form-control.input.active {
            display: none;
        } */
    </style>
    <!-- END: CUSTOM PICKER POS -->



    <!-- BEGIN: CUSTOM DATATABLE BUTTON CSS -->
    <style>
        .dark-layout div.dataTables_wrapper .dt-button-collection {
            background: rgba(23, 30, 49, 1) !important;
        }

        .light-layout div.dataTables_wrapper .dt-button-collection {
            background: rgba(246, 246, 246, 1) !important;
        }

        div.dt-button-collection .dt-button:hover:not(.disabled) {
            border: 0px;
        }

        div.dt-action-buttons>.dt-buttons {
            width: 100%;
            height: 2.714rem;
            padding: 0.2rem 0rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.45;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;

        }
    </style>
    <!-- END: /CUSTOM DATATABLE BUTTON CSS -->


    <!--------------------------------------------------------------END: Custom CSS---------------------------------------------------------------->
    {{-- <!-- BEGIN: Fontawesome v5.7.0 CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/fa.pro@5.7.0/css/all.css') }}">
    <!-- END: Fontawesome v5.7.0 CSS--> --}}
    <!-- BEGIN: Fontawesome v5.15.4 CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/fa.pro@5.15.4.web/css/all.css') }}?v={{ time() }}">
    <!-- END: Fontawesome v5.15.4 CSS-->

    @yield('header_page_cssjs')
</head>
