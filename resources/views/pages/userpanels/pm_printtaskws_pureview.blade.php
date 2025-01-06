<!-- resources/views/pages/userpanels/pm_printtaskws.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <html lang="en">
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="apple-touch-icon" href="{{ asset('public/assets/logo/favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/logo/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap-extended.css') }}">

    <!-- BEGIN: DataTables Core CSS -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/fa.pro@5.15.4.web/css/all.css') }}?v={{ time() }}">

    <!-- -->
    <style>
        /* Base Document Styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 3rem 4rem 3rem 3rem;
            background-color: #ffffff !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        thead {
            display: table-header-group;
        }


        /* Print-specific Styles */
        @media print {
            body {
                margin: 0.5cm 0.5cm 0.5cm 1.2cm;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Ensure background colors are printed */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Ensure thead each pagebreak are printed */
            thead {
                display: table-header-group !important;
            }

            /* Bootstrap Background Colors */
            .bg-primary {
                background-color: #0d6efd !important;
                color: white !important;
            }

            .bg-secondary {
                background-color: #6c757d !important;
                color: white !important;
            }

            .bg-success {
                background-color: #198754 !important;
                color: white !important;
            }

            .bg-danger {
                background-color: #dc3545 !important;
                color: white !important;
            }

            .bg-warning {
                background-color: #ffc107 !important;
                color: #000 !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
                color: #000 !important;
            }

            .bg-dark {
                background-color: #212529 !important;
                color: white !important;
            }

            .bg-white {
                background-color: #ffffff !important;
                color: #000 !important;
            }

            .page-break {
                page-break-inside: avoid;
            }
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            color: #000 !important;
        }

        strong {
            font-weight: bold;
        }

        /* Table Styles */
        table {
            /* table-layout: fixed; */
            width: 100%;
            border-collapse: collapse;
            color: #000 !important;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }

        td.text-wrap {
            white-space: normal !important;
            word-wrap: break-word !important;
        }

        .table:not(.table-dark):not(.table-light) thead:not(.thead-dark) th {
            border: 1px solid #000;
        }

        th {
            background-color: #ffffff;
            text-align: center;
        }

        th.th-0 {
            background-color: #ffffff;
            text-align: start !important;
            vertical-align: middle !important;
        }

        /* Specific Table Styles */
        #main-tb tbody tr:nth-child(odd) {
            background-color: #ffffff !important;
        }

        #main-tb tbody tr:nth-child(even) {
            background-color: #f2f2f2 !important;
        }

        tbody {
            height: fit-content;
            transition: height 0.3s ease; /* Smooth transition for height change */

            overflow-y: auto; /* Allow scrolling if content exceeds height */
        }


        /* Utility Classes */
        .text-center {
            text-align: center;
        }

        .cell-fit {
            width: 1%;
            white-space: nowrap;
        }

        .underline-text {
            text-decoration: underline;
        }

        .logo {
            max-width: 150px;
        }

        /* Signature Section */
        .signatures {
            margin-top: 50px;
        }

        .signatures table {
            border: none;
        }

        .signatures td {
            border: none;
            padding: 10px;
            text-align: center;
        }

        .tikdu_eq {
            padding: 0.01rem 0.01rem !important;
            text-align: center;
            /* width: 0.4px !important; */
            font-weight: 700;
        }

        .tikdu_eq_2 {
            border: none !important;
            padding: 0rem 0rem !important;
            text-align: center;
            width: 0rem !important;
            font-weight: 700;
        }

        .text-trans {
            color: transparent;
        }

        /* Table Padding Adjustment */
        .table th,
        .table td {
            padding: 0.2rem 0.2rem !important;
        }

        /* Footer Border */
        tfoot {
            border-top: 1px solid #000 !important;
        }
    </style>
    <!-- -->


    <!-- -->
    <!-- -->
    <!-- -->


    <div class="table-responsive" id="printableArea">
        {{-- <div class="page" style="border-style: solid; border-width: thin; background-color: transparent !important;"> --}}


        <!--  Check $data as array -->
        {{-- <div class="col-xl-12 col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <pre style="color: black">{{ print_r($loadDataWS->toArray(), true) }}</pre>
                    <br> XXXXXXXXXXXXX ABC XXXXXXXXXXXX <br>
                    {{ $loadDataWS->monitor }}

                    <pre style="color: black">{{ print_r($project->toArray(), true) }}</pre>
                </div>
            </div>
        </div> --}}

        <div class="page">
            @php
                $totalActualAtHeader = 0;
                $totalAtHeader = 0;
            @endphp
            @foreach ($project->monitor as $mon)
            @if ($mon->qty > 0)
                @php
                    $qty = $mon->qty;
                    // Find the tasks related to the current monitor where the associated worksheet's expired_ws is null
                    $relatedTasks = collect($project->task)->filter(function ($task) use ($mon, $project) {
                        $worksheet = collect($project->worksheet)->firstWhere('id_ws', $task['id_ws']);
                        return $task['id_monitoring'] === $mon['id_monitoring'] &&
                            ($worksheet['expired_at_ws'] ?? null) === null; // Match tasks by id_monitoring and check expired_ws
                    });

                    // Calculate the total progress from related tasks
                    $totalProgress = 0;
                    foreach ($relatedTasks as $task) {
                        $totalProgress += $task->progress_current_task; // Sum up the progress of related tasks
                    }

                    // Safely calculate average progress
                    $relatedTaskCount = $relatedTasks->count();
                    $up = $relatedTaskCount > 0 ? $totalProgress / $relatedTaskCount : 0; // Average progress

                    // Calculate total percentage safely
                    $totalAtHeader = ($qty * $up) / 100; // Calculate total percentage
                    $totalActualAtHeader += $totalAtHeader; // Accumulate to totalActualAtHeader
                @endphp
            @else
                @php
                    $totalActualAtHeader = 0; // No quantity, total remains 0
                @endphp
            @endif
        @endforeach
            @php
                $totalActual = 0; // Initialize totalActual
            @endphp



            <table id="main-tb" class="table table-striped"
                style="width: 100%; margin: auto; border-style: solid !important; border-width: thin !important; background-color: transparent !important;">
                <thead>
                    <tr class="border-top-1" style="border-top-style: solid; border-width: thin; border-color: #000">
                        <th rowspan="1" colspan="12" class="th-0 border-top-0 border-left-1 border-bottom-0"
                            style="border-right-style: solid; border-width: thin;">
                        </th>
                        <th rowspan="1" colspan="2"
                            class="th-0 align-top border-top-0 border-left-2 border-right-1 border-bottom-2"
                            style="border-style: solid; border-left-width: thin; border-bottom-width: thin; border-color: #000">
                            <div class="text-center">
                                <h4 class="mb-0"><strong>ENGINEER</strong></h4>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th rowspan="1" colspan="14" class="th-0 border-top-0">
                            <span id="logo" class="position-absolute">
                                <div class="border-0 p-1 text-center">
                                    <img src="{{ asset('public/assets/logo/dws_header_vplogo.svg') }}" class="logo">
                                </div>
                            </span>
                            <div class="text-center m-4 underline-text">
                                <h2><strong>PROJECT DAILY WORKSHEET</strong></h2>
                                <h3><strong>(LEMBAR KERJA HARIAN)</strong></h3>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="5" class="th-0 text-start"><strong>DESCRIPTION<br>(KETERANGAN)</strong></th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="8" class="th-0 text-start">{{ $loadDataWS->project->id_project }}</th>
                    </tr>
                    <tr>
                        <th colspan="5" class="th-0 text-start"><strong>CLIENT'S NAME<br>(NAMA CUSTOMER)</strong>
                        </th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="3" class="th-0 text-start">{{ $loadDataWS->project->client->na_client }}</th>
                        <th colspan="1" class="th-0 text-start cell-fit text-trans tikdu_eq">:</th>
                        <th colspan="1" class="th-0 "><strong>ARRIVAL TIME<br>(WAKTU DATANG)</strong></td>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="4" class="th-0 text-start">
                            {{ \Carbon\Carbon::parse($loadDataWS->arrival_time_ws)->format('h:i:s A') }}</td>
                    </tr>
                    @php
                        $workingDate = $loadDataWS->working_date_ws;
                        \Carbon\Carbon::setLocale('id');
                        $date = \Carbon\Carbon::parse($workingDate);
                        $formattedDate = $date->isoFormat('dddd, DD MMM YYYY');
                    @endphp
                    <tr>
                        <th colspan="5" class="th-0 text-start"><strong>DATE<br>(TANGGAL)</strong></th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="3" class="th-0 text-start">{{ $formattedDate }}</th>
                        <th colspan="1" class="th-0 text-start cell-fit text-trans tikdu_eq">:</th>
                        <th colspan="1" class="th-0 text-start"><strong>FINISH TIME<br>(WAKTU SELESAI)</strong></th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="4" class="th-0 text-start">
                            {{ \Carbon\Carbon::parse($loadDataWS->finish_time_ws)->format('h:i:s A') }}</th>
                    </tr>
                    <tr>
                        <th rowspan="2" colspan="3" class="text-center cell-fit align-middle">TIME (WAKTU)</th>
                        <th rowspan="2" colspan="7" class="text-center align-middle" style="width: 32%;">TASK
                        </th>
                        <th rowspan="2" colspan="1" class="text-center align-middle" style="width: 44%;">
                            DESCRIPTION</th>
                        <th colspan="3" class="text-center align-middle">PROGRESS</th>
                    </tr>
                    <tr>
                        <th colspan="2" class="align-middle">ACTUAL</th>
                        <th colspan="1" class="align-middle" style="width: 11.5%;">CURRENT</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="height: 708px;">
                    @foreach ($loadDataWS['task'] as $relDWS)
                    <tr>
                        <td colspan="3" class="text-center cell-fit">
                            {{ \Carbon\Carbon::parse($relDWS->start_time_task)->format('h:i:s A') }}
                        </td>
                        <td colspan="7" class="text-wrap">{{ $relDWS->monitor->category }}</td>
                        <td colspan="1" class="text-wrap">
                            @php
                                // Handle description task safely
                                $descbTask = $relDWS->descb_task;
                                $descbTask = str_replace(["*- ", "- "], '<i class="fas fa-circle fs-xs"></i>&nbsp;', $descbTask);
                                $descbTask = str_replace("\n", '<br>', $descbTask);
                            @endphp
                            {!! $descbTask !!}
                        </td>
                        <td class="text-center" colspan="2">
                            @php
                                $total = 0; // Initialize total for this monitoring entry
                                $qty = $relDWS->monitor->qty;

                                // Check if qty is defined and greater than zero
                                if ($qty > 0) {
                                    // Find the tasks related to the current monitor where the associated worksheet's expired_ws is null
                                    $relatedTasks = collect($project->task)->filter(function ($task) use ($relDWS, $project) {
                                        $worksheet = collect($project->worksheet)->firstWhere('id_ws', $task['id_ws']);
                                        return $task['id_monitoring'] === $relDWS->id_monitoring && ($worksheet['expired_ws'] ?? null) === null;
                                    });

                                    // Calculate the total progress from related tasks
                                    $totalProgress = 0;
                                    foreach ($relatedTasks as $task) {
                                        $totalProgress += $task->progress_current_task; // Sum up the progress of related tasks
                                    }

                                    // Safely calculate average progress
                                    $relatedTaskCount = $relatedTasks->count();
                                    $up = $relatedTaskCount > 0 ? $totalProgress / $relatedTaskCount : 0; // Average progress
                                    $total = ($qty * $up) / 100; // Calculate total percentage
                                    $totalActual += $total; // Accumulate to totalActual
                                }
                            @endphp
                            {{ number_format($total, 1) }}% <!-- Display total with 0 decimal places -->
                        </td>
                        <td class="text-center" colspan="1">
                            @if ($relDWS->progress_current_task != null && $relDWS->progress_current_task > 0)
                                {{ number_format($relDWS->progress_current_task, 1) }}%
                            @else
                                0%
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot style="border-top: 1px !important;">
                    <tr>
                        <td colspan="14" class="text-left align-middle"><strong>REMARK (CATATAN AKHIR)</strong></td>
                    </tr>
                    <tr>
                        <td colspan="14" rowspan="1" class="w-100" style="padding: 0.35rem 0.35rem;">
                            <textarea class="w-100 border-0 bg-transparent" rows="7" @disabled(true)>{{  $relDWS->remark_ws ? $relDWS->remark_ws : 'None' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" rowspan="8" class="" style="padding: 0.35rem 0.35rem;">
                            <div class="d-flex flex-col justify-content-around">
                                <div class="d-flex flex-column align-items-start">
                                    <span>
                                        <strong>
                                            EXECUTED BY, (DIKERJAKAN OLEH)
                                        </strong>
                                    </span>
                                    <div style="height: 8em;"></div> <!-- Empty div for spacing -->
                                    <span class="justify-content-center">
                                        <a class="w-100 align-text-bottom">
                                            {{ $loadDataWS->karyawan->na_karyawan }}
                                        </a>
                                    </span>
                                    <span class="underline-text">
                                        <strong>
                                            PT. VERTECH PERDANA
                                        </strong>
                                    </span>
                                </div>
                                <div class="d-flex flex-column align-items-start">
                                    <span>
                                        <strong>
                                            ACKNOWLEDGED BY, (DIKETAHUI OLEH)
                                        </strong>
                                    </span>
                                    <div style="height: 8em;"></div> <!-- Empty div for spacing -->
                                    <span class="justify-content-center">
                                        <a class="w-100 align-text-bottom underline-text">
                                            {{ $loadDataWS->project->client->na_client }}
                                        </a>
                                    </span>
                                    <span class="underline-text">
                                        <strong>
                                            (CLIENT)
                                            ..................................................................
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td colspan="2" rowspan="1" class="text-center" style="padding: 0.35rem 0.35rem;">
                            <strong>Time Stamp</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="" style="padding: 0.35rem 0.35rem;">
                            <strong>
                                Start Date:
                            </strong>
                            <br>
                            @php
                                $startDate = $loadDataWS->working_date_ws;
                                $dateStart = \Carbon\Carbon::parse($startDate);
                                // Format date in Indonesian
                                \Carbon\Carbon::setLocale('in');
                                $formattedDateStart = $dateStart->isoFormat('dddd, DD MMM YYYY');
                                // Format time in English
                                \Carbon\Carbon::setLocale('en');
                                $formattedTimeStart = $dateStart->isoFormat('hh:mm:ss A');
                                // Combine date and time
                                $formattedDateTimeStart = $formattedDateStart . ' at ' . $formattedTimeStart;
                                echo $formattedDateTimeStart;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="" style="padding: 0.35rem 0.35rem;">
                            <strong>
                                Closed Date:
                            </strong>
                            <br>
                            @if ($loadDataWS->status_ws == 'OPEN')
                                -
                            @else
                                @php
                                    $closedDate = $loadDataWS->closed_at_ws;
                                    $dateClose = \Carbon\Carbon::parse($closedDate);

                                    // Format date in Indonesian
                                    \Carbon\Carbon::setLocale('in');
                                    $formattedDateClose = $dateClose->isoFormat('dddd, DD MMM YYYY');

                                    // Format time in English
                                    \Carbon\Carbon::setLocale('en');
                                    $formattedTimeClose = $dateClose->isoFormat('hh:mm:ss A');

                                    // Combine date and time
                                    $formattedDateTimeClose = $formattedDateClose . ' at ' . $formattedTimeClose;
                                    echo $formattedDateTimeClose;
                                @endphp
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center align-middle" style="padding: 0.35rem 0.35rem;">
                            <strong>Status</strong>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $isStatusOpen = $loadDataWS->status_ws == 'OPEN' ? true : false;
                        @endphp
                        <td colspan="2" style="padding: 0.35rem 0.35rem;"
                            class="text-center {{ $isStatusOpen ? 'bg-danger text-black' : 'bg-warning text-black' }}">
                            <h2 class="mb-0">
                                <strong>
                                    @if ($isStatusOpen)
                                        OPEN
                                    @else
                                        CLOSED
                                    @endif
                                </strong>
                            </h2>
                        </td>
                    </tr>

                </tfoot>
            </table>


        </div>
    </div>

    <!-- BEGIN: Core JS -->
    <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/js/core/app.js') }}"></script>
{{--
    <script>
        function setTbodyHeight() {
            // Get the heights of the thead and tfoot
            var theadHeight = document.querySelector('thead').offsetHeight;
            var tfootHeight = document.querySelector('tfoot').offsetHeight - 245;

            // A4 page height in pixels (approximately)
            var a4Height = 1123; // 297 mm in pixels

            // Calculate the available height for tbody
            var tbodyHeight = a4Height - (theadHeight + tfootHeight);

            // Set the tbody height dynamically
            var tbody = document.getElementById('tableBody');
            tbody.style.height = tbodyHeight + 'px';
        }

        // Set tbody height on page load
        window.onload = setTbodyHeight;

        // Set tbody height when logo is clicked
        document.getElementById('logo').addEventListener('click', function() {
            setTbodyHeight();
        });
    </script> --}}


    </body>

    </html>
