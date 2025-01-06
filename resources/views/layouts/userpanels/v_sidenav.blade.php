@php
    // $authUserId = $authenticated_user_data->id_karyawan ?? $authenticated_user_data->id_client;
    $authUserType = auth()->user()->type;
@endphp


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header expanded">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ config('app.url') }}"><span class="brand-logo">
                        <!-- route('userPanels.dashboard') }} -->
                        <img src="{{ asset('public/assets/logo/vp_logo.svg') }}" alt="Project MonitorLogo">
                    </span>
                    <h2 class="brand-text" style="line-height: 1.1 !important;">Project<br>Monitoring</h2>
                    {{-- {{ env('APP_NAME') }} --}}
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <style>
        li.nav-item.mr-auto {
            margin-top: -0.5rem;
        }
    </style>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if (Route::has('userPanels.projects'))
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="{{ route('userPanels.projects') }}"><i
                            data-feather="home"></i><span class="menu-title text-truncate"
                            data-i18n="Projects">Projects</span></a>
                </li>
            @endif
            {{-- @if (Route::has('userPanels.dashboard'))
                <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('userPanels.dashboard') }}"><i
                            data-feather="home"></i><span class="menu-title text-truncate"
                            data-i18n="Dashboard">Dashboard</span></a>
                </li>
            @endif --}}
            @if ($authUserType == 'Superuser')
                <li class=" navigation-header"><span data-i18n="Data Employee">Employees A&OR&T</span><i
                        data-feather="more-horizontal"></i>
                </li>
            @endif
            @if ($authUserType === 'Superuser')
                @if (Route::has('m.emp'))
                    <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('m.emp') }}"><i
                                data-feather="users"></i><span class="menu-title text-truncate"
                                data-i18n="Employees">Employees</span></a>
                    </li>
                @endif
                @if (Route::has('m.user.emp'))
                    <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('m.user.emp') }}"><i
                                data-feather="users"></i><span class="menu-title text-truncate"
                                data-i18n="Teams">Accounts</span></a>
                    </li>
                @endif
                @if (Route::has('m.emp.roles'))
                    <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('m.emp.roles') }}"><i
                                data-feather="briefcase"></i><span class="menu-title text-truncate"
                                data-i18n="Office Roles">Office Roles</span></a>
                    </li>
                @endif
                @if (Route::has('m.emp.teams'))
                    <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('m.emp.teams') }}"><i
                                data-feather="users"></i><span class="menu-title text-truncate"
                                data-i18n="Teams">Teams</span></a>
                    </li>
                @endif

            @endif


            {{-- @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor' || $authUserType == 'Engineer' || $authUserType == 'Client')
                <li class=" navigation-header"><span data-i18n="Data Employee">Projects M&W</span><i
                        data-feather="more-horizontal"></i>
                </li>
                @if (Route::has('m.projects'))
                    <li class=" nav-item">
                        <a class="d-flex align-items-center" href="{{ route('m.projects') }}"><i
                                data-feather="monitor"></i><span class="menu-title text-truncate"
                                data-i18n="Projects">Project List</span></a>
                    </li>
                @endif
            @endif --}}



            @if ($authUserType === 'Superuser' || $authUserType === 'Supervisor')
                <li class=" navigation-header"><span data-i18n="Data Accounts">Clients</span><i
                        data-feather="more-horizontal"></i>
                </li>
                @if (Route::has('m.cli'))
                    <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('m.cli') }}"><i
                                data-feather="users"></i><span class="menu-title text-truncate"
                                data-i18n="Clients">Clients</span></a>
                    </li>
                @endif
                @if (Route::has('m.user.cli'))
                    <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('m.user.cli') }}"><i
                                data-feather="users"></i><span class="menu-title text-truncate"
                                data-i18n="Accounts">Accounts</span></a>
                    </li>
                @endif
            @endif


            {{-- @if ($authUserType == 'Superuser' || $authUserType == 'Supervisor' || $authUserType == 'Engineer' || $authUserType == 'Client' || $authUserType == 'Public' || $authUserType == '') --}}
            <li class="navigation-header">
                <span data-i18n="System &amp; Supports">System &amp; Supports</span>
                <i data-feather="more-horizontal"></i>
            </li>
            <li onclick="openModal('#contactUsModal')">
                <a class="d-flex align-items-center" id="contactUsLink">
                    <i data-feather="mail"></i>
                    <span class="menu-item text-truncate" data-i18n="ContactUS">ContactUS</span>
                </a>
            </li>
            <li onclick="openModal('#aboutUsModal')">
                <a class="d-flex align-items-center" id="aboutUsLink">
                    <i data-feather="help-circle"></i>
                    <span class="menu-item text-truncate" data-i18n="AboutUs">AboutUs</span>
                </a>
            </li>
            @if ($authUserType === 'Superuser')
                @if (Route::has('m.sys'))
                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="{{ route('m.sys') }}">
                            <i class="fas fa-cogs"></i>
                            <span class="menu-title text-truncate" data-i18n="Setting">Settings</span>
                        </a>
                    </li>
                @endif
            @endif



        </ul>
    </div>
</div>
<!-- END: Main Menu-->
