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
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/css/bootstrap-extended.css') }}"> --}}

    <!-- BEGIN: DataTables Core CSS -->
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset('public/theme/vuexy/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css"> --}}
    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/fa.pro@5.15.4.web/css/all.css') }}?v={{ time() }}">


    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/css/dev.very.custom.dompdf.css') }}?v={{ time() }}">


    <style>
        @media print {
            table {
                flex: 1;
                width: 100%;
                border-collapse: collapse;
                /* Ensures borders are collapsed */
            }

            /* Hide thead on all pages except the first */
            thead {
                display: table-header-group;
                /* This will ensure it shows on the first page */
            }

            /* Hide thead after the first page */
            @page :nth(2) {
                thead {
                    display: none;
                    /* Hide thead on subsequent pages */
                }
            }

            /* Show tfoot only on the last page */
            tfoot {
                display: table-footer-group;
                /* This will show the footer */
            }

            /* Hide tfoot on all pages except the last */
            @page :not(:last) {
                tfoot {
                    display: none;
                    /* Hide tfoot on pages that are not the last */
                }
            }

            tbody {
                display: table-row-group;
                /* Ensures tbody is treated as a group */
                page-break-inside: avoid;
                /* Prevent page breaks inside tbody */
            }

            tr {
                page-break-inside: avoid;
                /* Prevent page breaks inside rows */
                page-break-after: auto;
                /* Allow page breaks after rows */
            }
        }
    </style>


    <!-- -->
    <!-- -->
    <!-- -->
</head>

<body>
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


            <table id="main-tb" class="table table-striped m-auto border-solid border-thin bg-trans">
                <thead>
                    <tr class="border-top-1 border-top-solid border-thin border-c-default">
                        <th rowspan="1" colspan="12"
                            class="th-0 p-0 m-0 border-top-0 border-left-1 border-bottom-0 border-right-solid border-thin">
                        </th>
                        <th rowspan="1" colspan="5"
                            class="th-0 p-0 m-0 align-top border-solid border-top-0 border-left-2 border-right-1 border-bottom-2 border-left-thin border-bottom-thin border-c-default">
                            <div class="text-center page-label">
                                <h3 class="m-0"><strong>ENGINEER</strong></h3>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th rowspan="1" colspan="17"
                            class="th-0 border-top-0 border-right-2 border-left-2 border-solid border-thin position-relative">
                            <!-- Added position-relative -->
                            <span class="page-logo-container"> <!-- Optional: Adjust position as needed -->
                                <div class="border-0 p-4 text-center">
                                    <img src="{{ asset('public/assets/logo/dws_header_vplogo.jpg') }}"
                                        class="page-logo">
                                </div>
                            </span>
                            <div class="text-center m-1 underline-text page-title">
                                <h3><strong>PROJECT DAILY WORKSHEET<br>(LEMBAR KERJA HARIAN)</strong></h3>
                                <!-- Fixed closing tag -->
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="th-0 text-start fit-content">DESCRIPTION<br>(KETERANGAN)</th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="12" class="th-0 text-start">{{ $loadDataWS->project->id_project }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="th-0 text-start fit-content">CLIENT'S NAME<br>(NAMA CUSTOMER)
                        </th>
                        <th colspan="1" class="th-0 text-center cell-fit tikdu_eq">:</th>
                        <th colspan="4" class="th-0 text-start">{{ $loadDataWS->project->client->na_client }}</th>
                        <th colspan="1" class="th-0 text-start cell-fit text-trans tikdu_eq">:</th>
                        <th colspan="1" class="th-0 text-start">ARRIVAL TIME<br>(WAKTU DATANG)</td>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="5" class="th-0 text-start">
                            {{ \Carbon\Carbon::parse($loadDataWS->arrival_time_ws)->format('h:i:s A') }}</td>
                    </tr>
                    @php
                        $workingDate = $loadDataWS->working_date_ws;
                        \Carbon\Carbon::setLocale('id');
                        $date = \Carbon\Carbon::parse($workingDate);
                        $formattedDate = $date->isoFormat('dddd, DD MMM YYYY');
                    @endphp
                    <tr>
                        <th colspan="4" class="th-0 text-start fit-content">DATE<br>(TANGGAL)</th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="4" class="th-0 text-start fit-content">{{ $formattedDate }}</th>
                        <th colspan="1" class="th-0 text-start cell-fit text-trans tikdu_eq">:</th>
                        <th colspan="1" class="th-0 text-start">FINISH TIME<br>(WAKTU SELESAI)</th>
                        <th colspan="1" class="th-0 text-start cell-fit tikdu_eq">:</th>
                        <th colspan="5" class="th-0 text-start">
                            {{ \Carbon\Carbon::parse($loadDataWS->finish_time_ws)->format('h:i:s A') }}</th>
                    </tr>
                    <tr>
                        <th rowspan="2" colspan="3" class="text-center align-middle th-time">
                            TIME (WAKTU)
                        </th>
                        <th rowspan="2" colspan="7" class="text-center align-middle" style="width: 17%;">
                            {{-- <th rowspan="2" colspan="7" class="text-center align-middle"> --}}
                            TASK
                        </th>
                        {{-- <th rowspan="2" colspan="1" class="text-center align-middle" style="width: 31%;"> --}}
                        <th rowspan="2" colspan="1" class="text-center align-middle" style="width: 28%;">
                            DESCRIPTION
                        </th>
                        <th colspan="6" class="text-center align-middle">
                            PROGRESS
                        </th>
                    </tr>
                    <tr>
                        {{-- <th colspan="3" class="text-center align-middle">ACTUAL</th> --}}
                        <th colspan="3" class="text-center align-middle" style="width: 60% !important;">ACTUAL</th>
                        {{-- <th colspan="3" class="text-center align-middle" style="width: 12.1%;">CURRENT</th> --}}
                        <th colspan="3" class="text-center align-middle" style="width: 40% !important;">CURRENT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loadDataWS['task'] as $index => $relDWS)
                        <tr>
                            <td colspan="3" class="text-center th-time">
                                {{ \Carbon\Carbon::parse($relDWS->start_time_task)->format('h:i') }}
                            </td>
                            <td colspan="7" class="text-wrap">{{ $relDWS->monitor->category }}</td>
                            <td colspan="1" class="text-wrap">
                                @php
                                    // Handle description task safely
                                    $descbTask = $relDWS->descb_task;
                                    $descbTask = str_replace(
                                        ['*- ', '- '],
                                        '<i class="fas fa-circle fs-xs"></i>&nbsp;',
                                        $descbTask,
                                    );
                                    $descbTask = str_replace("\n", '<br>', $descbTask);
                                @endphp
                                {!! $descbTask !!}
                            </td>
                            <td class="text-center" colspan="3">
                                @php
                                    $total = 0; // Initialize total for this monitoring entry
                                    $qty = $relDWS->monitor->qty;

                                    // Check if qty is defined and greater than zero
                                    if ($qty > 0) {
                                        // Find the tasks related to the current monitor where the associated worksheet's expired_ws is null
    $relatedTasks = collect($project->task)->filter(function ($task) use (
        $relDWS,
        $project,
    ) {
        $worksheet = collect($project->worksheet)->firstWhere(
            'id_ws',
            $task['id_ws'],
        );
        return $task['id_monitoring'] === $relDWS->id_monitoring &&
            ($worksheet['expired_ws'] ?? null) === null;
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
                            <td class="text-center" colspan="3">
                                @if ($relDWS->progress_current_task != null && $relDWS->progress_current_task > 0)
                                    {{ number_format($relDWS->progress_current_task, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>

                        @if (($index + 1) % 7 === 0)
                            <!-- Check for every 7 items -->
                        @endif
                    @endforeach
                </tbody>



                <tfoot style="border-top: 1px !important;">
                    <tr>
                        <td colspan="17" class="text-left align-middle"><strong>REMARK (CATATAN AKHIR)</strong></td>
                    </tr>
                    <tr>
                        <td colspan="17" rowspan="1" class="w-100" style="padding: 0.35rem 0.35rem;">
                            <textarea class="w-100 border-0 bg-trans" rows="7" @disabled(true)>{{  $loadDataWS->remark_ws ? $loadDataWS->remark_ws : 'None' }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" rowspan="5" class="border-right-0" style="padding: 0.35rem 0.35rem;">
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
                                    <br>
                                    <span class="underline-text">
                                        <strong>
                                            PT. VERTECH PERDANA
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td colspan="3" rowspan="5" class="border-left-0" style="padding: 0.35rem 0.35rem;">
                            <div class="d-flex flex-col justify-content-around">
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
                                    <br>
                                    <span class="underline-text">
                                        <strong>
                                            (CLIENT) ..........................................
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td colspan="5" rowspan="1" class="text-center th-0 p-0 m-0 " style="">
                            <strong>Time Stamp</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="fit-content" style="padding: 0.35rem 0.35rem;">
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
                        <td colspan="5" class="fit-content" style="padding: 0.35rem 0.35rem;">
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
                        <td colspan="5" class="text-center align-middle" style="padding: 0.35rem 0.35rem;">
                            <strong>Status</strong>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $isStatusOpen = $loadDataWS->status_ws == 'OPEN' ? true : false;
                        @endphp
                        <td colspan="5" style="padding: 0.35rem 0.35rem;"
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

    {{-- <!-- BEGIN: Core JS -->
    <script src="{{ asset('public/theme/vuexy/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/js/core/app.js') }}"></script>
 --}}


</body>

</html>
