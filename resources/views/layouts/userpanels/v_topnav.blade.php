<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow">
    <div class="navbar-container d-flex content">
        {{-- {{ $currentRouteName }} --}}
        {{-- @if ($currentRouteName != 'm.projects.getprjmondws') --}}
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none mr-1">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>

            {{-- @if ($currentRouteName != 'm.ws' && $currentRouteName != 'm.projects')
                    @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                        @if (isset($modalData))
                            <ul class="nav navbar-nav d-flex justify-content-between gap-2">
                                @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Supervisor')
                                    @if ($loadDataWS->status_ws == 'OPEN')
                                        @if (isset($modalData['modal_add']))
                                            <li class="nav-item mr-1" onclick="openModal('{{ $modalData['modal_add'] }}')">
                                                <a class="dropdown-item d-flex align-items-center border rounded border-success add-new-record"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Add New Record!">
                                                    <span><i class="ficon text-success"
                                                            data-feather="plus-circle"></i></span>
                                                    <span class="d-none d-lg-block ml-1">Add Record</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                @endif
                                @if (auth()->user()->type === 'Superuser')
                                    @if (isset($modalData['modal_reset']))
                                        <li class="nav-item"
                                            onclick="openModal('{{ $modalData['modal_reset'] }}')">
                                            <a class="dropdown-item d-flex align-items-center border rounded border-warning reset-all-record"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Reset all Records!">
                                                <span><i class="ficon text-warning"
                                                        data-feather="refresh-cw"></i></span>
                                                <span class="d-none d-lg-block ml-1">Reset Records</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>

                        @endif
                    @endif
                @else
                    @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Engineer')
                        @if (isset($modalData))
                            <ul class="nav navbar-nav d-flex justify-content-between gap-2">
                                @if (auth()->user()->type === 'Superuser' || auth()->user()->type === 'Engineer')
                                    @if (isset($modalData['modal_add']))
                                        <li class="nav-item mr-1" onclick="openModal('{{ $modalData['modal_add'] }}')">
                                            <a class="dropdown-item d-flex align-items-center border rounded border-success add-new-record"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Add New Record!">
                                                <span><i class="ficon text-success"
                                                        data-feather="plus-circle"></i></span>
                                                <span class="d-none d-lg-block ml-1">Add Record</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                                @if (auth()->user()->type === 'Superuser')
                                    @if (isset($modalData['modal_reset']))
                                        <li class="nav-item"
                                            onclick="openModal('{{ $modalData['modal_reset'] }}')">
                                            <a class="dropdown-item d-flex align-items-center border rounded border-warning reset-all-record"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Reset all Records!">
                                                <span><i class="ficon text-warning"
                                                        data-feather="refresh-cw"></i></span>
                                                <span class="d-none d-lg-block ml-1">Reset Records</span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>

                        @endif
                    @endif
                @endif --}}

        </div>
        {{-- @endif --}}





        <ul class="nav navbar-nav align-items-center ml-auto">
            {{-- <li class="overflow-x-auto overflow-y-scroll" style="height: 45vh">
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <pre style="color: white">{{ print_r($authenticated_user_data->toArray(), true) }}</pre>
                            <br>
                        </div>
                    </div>
                </div>
            </li> --}}
            <li class="nav-item dropdown dropdown-language d-none"><a class="nav-link dropdown-toggle"
                    id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span
                        class="selected-language">English</span></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag"><a class="dropdown-item"
                        href="javascript:void(0);" data-language="en"><i class="flag-icon flag-icon-us"></i>
                        English</a><a class="dropdown-item" href="javascript:void(0);" data-language="fr"><i
                            class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item"
                        href="javascript:void(0);" data-language="de"><i class="flag-icon flag-icon-de"></i>
                        German</a><a class="dropdown-item" href="javascript:void(0);" data-language="pt"><i
                            class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
            </li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                        data-feather="sun"></i></a></li>
            <li class="nav-item nav-search d-none"><a class="nav-link nav-link-search"><i class="ficon"
                        data-feather="search"></i></a>
                <div class="search-input">
                    <div class="search-input-icon"><i data-feather="search"></i></div>
                    <input class="form-control input" type="text" placeholder="Explore {{ env('APP_NAME') }}..."
                        tabindex="-1" data-search="search">
                    <div class="search-input-close"><i data-feather="x"></i></div>
                    <ul class="search-list search-list-main"></ul>
                </div>
            </li>

            <li class="nav-item dropdown dropdown-notification mr-25 d-none"><a class="nav-link"
                    href="javascript:void(0);" data-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span
                        class="badge badge-pill badge-danger badge-up">5</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                            <div class="badge badge-pill badge-light-primary">6 New</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list"><a class="d-flex" href="javascript:void(0)">
                            <div class="media d-flex align-items-start">
                                <div class="media-left">
                                    <div class="avatar"><img
                                            src="{{ asset('public/theme/vuexy/app-assets/images/portrait/small/avatar-s-15.jpg') }}"
                                            alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading"><span class="font-weight-bolder">Congratulation Sam
                                            🎉</span>winner!</p><small class="notification-text"> Won the monthly best
                                        seller badge.</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="javascript:void(0)">
                            <div class="media d-flex align-items-start">
                                <div class="media-left">
                                    <div class="avatar"><img
                                            src="{{ asset('public/theme/vuexy/app-assets/images/portrait/small/avatar-s-3.jpg') }}"
                                            alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading"><span class="font-weight-bolder">New
                                            message</span>&nbsp;received</p><small class="notification-text"> You have
                                        10 unread messages</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="javascript:void(0)">
                            <div class="media d-flex align-items-start">
                                <div class="media-left">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content">MD</div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading"><span class="font-weight-bolder">Revised Order
                                            👋</span>&nbsp;checkout</p><small class="notification-text"> MD Inc. order
                                        updated</small>
                                </div>
                            </div>
                        </a>
                        <div class="media d-flex align-items-center">
                            <h6 class="font-weight-bolder mr-auto mb-0">System Notifications</h6>
                            <div class="custom-control custom-control-primary custom-switch">
                                <input class="custom-control-input" id="systemNotification" type="checkbox"
                                    checked="">
                                <label class="custom-control-label" for="systemNotification"></label>
                            </div>
                        </div><a class="d-flex" href="javascript:void(0)">
                            <div class="media d-flex align-items-start">
                                <div class="media-left">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content"><i class="avatar-icon" data-feather="x"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading"><span class="font-weight-bolder">Server
                                            down</span>&nbsp;registered</p><small class="notification-text"> USA Server
                                        is down due to hight CPU usage</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="javascript:void(0)">
                            <div class="media d-flex align-items-start">
                                <div class="media-left">
                                    <div class="avatar bg-light-success">
                                        <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading"><span class="font-weight-bolder">Sales
                                            report</span>&nbsp;generated</p><small class="notification-text"> Last
                                        month sales report generated</small>
                                </div>
                            </div>

                    </li>
                    <li class="dropdown-menu-footer"><a class="btn btn-primary btn-block"
                            href="javascript:void(0)">Read all notifications</a></li>
                </ul>
            </li>


            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link AVATAR-1" id="dropdown-user"
                    href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- @php
                        // Retrieve the account name from authenticated user data
                        $accName = isset($authenticated_user_data)
                            ? ($authenticated_user_data->na_karyawan ?:
                            $authenticated_user_data->na_client)
                            : 'No Name';

                        // Define the maximum length
                        $maxLength = 25;

                        // Check if the account name exceeds the maximum length
                        if (strlen($accName) > $maxLength) {
                            // Clip the name to the maximum length
                            $clippedName = substr($accName, 0, $maxLength);

                            // Find the last space within the clipped name
                            $lastSpacePos = strrpos($clippedName, ' ');

                            // If there is a space, clip the name to that position; otherwise, use the clipped name
                            $accName = $lastSpacePos !== false ? substr($clippedName, 0, $lastSpacePos) : $clippedName;
                        }
                    @endphp --}}
                    @php
                        // Retrieve the account name from authenticated user data
                        $accName = 'No Name'; // Default value

                        // Check if the user is a Client or Karyawan and set accName accordingly
                        if ($authenticated_user_data) {
                            if ($authenticated_user_data['type'] === 'Client') {
                                // For Client
                                $accName = $authenticated_user_data['client']['na_client'] ?? 'No Name';
                            } elseif (
                                $authenticated_user_data['type'] === 'Superuser' ||
                                $authenticated_user_data['type'] === 'Supervisor' ||
                                $authenticated_user_data['type'] === 'Engineer'
                            ) {
                                // For Karyawan
                                $accName = $authenticated_user_data['karyawan']['na_karyawan'] ?? 'No Name';
                            }
                        }

                        // Define the maximum length
                        $maxLength = 25;

                        // Check if the account name exceeds the maximum length
                        if (strlen($accName) > $maxLength) {
                            // Clip the name to the maximum length
                            $clippedName = substr($accName, 0, $maxLength);

                            // Find the last space within the clipped name
                            $lastSpacePos = strrpos($clippedName, ' ');

                            // If there is a space, clip the name to that position; otherwise, use the clipped name
                            $accName = $lastSpacePos !== false ? substr($clippedName, 0, $lastSpacePos) : $clippedName;
                        }
                    @endphp

                    <div class="user-nav d-sm-flex">
                        <span class="user-name font-weight-bolder">{!! $accName !!}</span>
                        {{-- <span
                            class="user-status">{{ $authenticated_user_data ? ($authenticated_user_data->daftar_login_4get?->type ?: $authenticated_user_data->daftar_login->type ?: 'Illegal Access') : 'Illegal Access' }}
                        </span> --}}
                        <span class="user-status">{!! $authenticated_user_data ? $authenticated_user_data['type'] ?? 'Illegal Access' : 'Illegal Access' !!}</span>
                    </div>
                    <span class="avatar"><img class="round" src="{{ $avatar_src }}" alt="avatar"
                            height="40" width="40"><span class="avatar-status-online"></span></span>
                    {{-- src="{{ isset($authenticated_user_data) ? ($authenticated_user_data->foto_karyawan === null ? env('APP_DEFAULT_AVATAR') : 'public/avatar/uploads/' . $authenticated_user_data->foto_karyawan) : env('APP_DEFAULT_AVATAR') }}" --}}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item d-lg-none d-md-block d-sm-block nav-link-style"><i class="mr-50"
                            data-feather="sun"></i>
                        Mode</a>
                    <div class="dropdown-divider d-lg-none d-md-block d-sm-block"></div>
                    <a class="dropdown-item" href="{{ route('userPanels.myprofile') }}"><i class="mr-50"
                            data-feather="user"></i>
                        Profile</a>
                    <a class="dropdown-item d-none" href="app-email.html"><i class="mr-50" data-feather="mail"></i>
                        Inbox</a>
                    <a class="dropdown-item d-none" href="app-todo.html"><i class="mr-50"
                            data-feather="check-square"></i> Task</a>
                    <a class="dropdown-item d-none" href="app-chat.html"><i class="mr-50"
                            data-feather="message-square"></i> Chats</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item d-none" href="page-account-settings.html"><i class="mr-50"
                            data-feather="settings"></i> Settings</a>
                    <a class="dropdown-item d-none" href="page-pricing.html"><i class="mr-50"
                            data-feather="credit-card"></i> Pricing</a>
                    <a class="dropdown-item d-none" href="page-faq.html"><i class="mr-50"
                            data-feather="help-circle"></i> FAQ</a>
                    <a class="dropdown-item" href="{{ route('userPanels.logout.redirect') }}"><i class="mr-50"
                            data-feather="power"></i>
                        Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<ul class="main-search-list-defaultlist d-none">
    {{-- <li class="d-flex align-items-center"><a href="javascript:void(0);">
            <h6 class="section-label mt-75 mb-0">Files</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="mr-75"><img src="{{ asset('public/theme/vuexy/app-assets/images/icons/xls.png') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing
                        Manager</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="mr-75"><img src="{{ asset('public/theme/vuexy/app-assets/images/icons/jpg.png') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="mr-75"><img src="{{ asset('public/theme/vuexy/app-assets/images/icons/pdf.png') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                        Marketing Manager</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
            href="app-file-manager.html">
            <div class="d-flex">
                <div class="mr-75"><img src="{{ asset('public/theme/vuexy/app-assets/images/icons/doc.png') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web
                        Designer</small>
                </div>
            </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
        </a></li>
    <li class="d-flex align-items-center"><a href="javascript:void(0);">
            <h6 class="section-label mt-75 mb-0">Members</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar mr-75"><img
                        src="{{ asset('public/theme/vuexy/app-assets/images/portrait/small/avatar-s-8.jpg') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar mr-75"><img
                        src="{{ asset('public/theme/vuexy/app-assets/images/portrait/small/avatar-s-1.jpg') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar mr-75"><img
                        src="{{ asset('public/theme/vuexy/app-assets/images/portrait/small/avatar-s-14.jpg') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing
                        Manager</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
            href="app-user-view.html">
            <div class="d-flex align-items-center">
                <div class="avatar mr-75"><img
                        src="{{ asset('public/theme/vuexy/app-assets/images/portrait/small/avatar-s-6.jpg') }}"
                        alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                </div>
            </div>
        </a></li> --}}
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between"><a
            class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="mr-75"
                    data-feather="alert-circle"></span><span>No results found.</span></div>
        </a></li>
</ul>
