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

    <style>
        @font-face {
            font-family: 'Montserrat';
            font-weight: 300;
            /* ExtraLight */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-ExtraLight.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 300;
            /* ExtraLight Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-ExtraLightItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 400;
            /* Regular */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-Regular.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 400;
            /* Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-Italic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 500;
            /* Medium */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-Medium.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 500;
            /* Medium Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-MediumItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 600;
            /* SemiBold */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-SemiBold.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 600;
            /* SemiBold Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-SemiBoldItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 700;
            /* Bold */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-Bold.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 700;
            /* Bold Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-BoldItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 800;
            /* ExtraBold */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-ExtraBold.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 800;
            /* ExtraBold Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-ExtraBoldItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 900;
            /* Black */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-Black.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 900;
            /* Black Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-BlackItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 200;
            /* Thin */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-Thin.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 200;
            /* Thin Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-ThinItalic.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 100;
            /* ExtraLight */
            font-style: normal;
            src: url('{{ asset('public/assets/fonts/Montserrat-ExtraLight.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: 'Montserrat';
            font-weight: 100;
            /* ExtraLight Italic */
            font-style: italic;
            src: url('{{ asset('public/assets/fonts/Montserrat-ExtraLightItalic.ttf') }}') format('truetype');
        }
    </style>


    <link rel="stylesheet" type="text/css"
        href="{{ asset('public/assets/css/dev.very.custom.mon.dompdf.css') }}?v={{ time() }}">





</head>

<body>
    <header class="form-ver">
        <span>
            Form : VP-ENG-01A Date : 12.11.24 Rev.0
        </span>
    </header>

    @php
        $cust_date_format = 'dddd, DD MMM YYYY';
        $cust_time_format = 'hh:mm:ss A';
        function convertDate($workingDate)
        {
            \Carbon\Carbon::setLocale('id');
            $date = \Carbon\Carbon::parse($workingDate);
            $formattedDate = $date->isoFormat('dddd, DD MMM YYYY');
            return $formattedDate;
        }
    @endphp

    @php
        $totalChunks = count($monChunks); // Count the total number of chunks

        // Ensure that $taskChunks is an array
        if (!is_array($monChunks)) {
            $monChunks = [];
        }
        $totalPages = $totalChunks > 0 ? ceil($totalChunks / $eachmonitorChunk) : 1; // Avoid division by zero
    @endphp


    @foreach ($monChunks as $index => $chunk)
        @php
            $maxCharsCategories = 34; // Max characters for DESCRIPTION
            // Set the base height for each line of text
            $lineHeight = 20; // Height for each line in pixels

            // Calculate the maximum height for the TASK and DESCRIPTION columns
            $maxCategoryHeight = 0;
            foreach ($chunk as $relMONITOR) {
                $categoryText = $relMONITOR['category'];
                // Calculate the number of lines needed for wrapping
                $categoryLines = ceil(strlen($categoryText) / $maxCharsCategories);
                // Update the maximum height based on the number of lines
                $maxCategoryHeight = max($maxCategoryHeight, $categoryLines * $lineHeight);
            }

            // Set the total height for the tbody
            $tbodyHeight = $baseHeight + $maxCategoryHeight; // current Base height (185) + dynamic height
            $rowCount = count($chunk);
            $cellHeight = max($tbodyHeight / $rowCount, $lineHeight); // Ensure it is at least the line height
        @endphp
        <style>
            #main-tb {
                table-layout: fixed;
                width: 100%;
                border-collapse: collapse;
            }

            tbody td {
                height: {{ $cellHeight }}px;
                padding: 0rem 0.2rem !important;
                margin: 0px !important;
                overflow-wrap: break-word;
            }

            tfoot td {
                /* padding: 0px !important; */
                padding: 0rem 0.2rem !important;
                margin: 0px !important;
                height: fit-content !important;
                overflow-wrap: break-word;
                /* Break words if necessary */
                /*  */
            }

            .th-no {
                width: 5.5% !important;
            }

            .th-qty {
                width: 9.5% !important;
            }

            .th-tot-pro {
                width: 10% !important;
            }

            .th-up-pro {
                width: 10% !important;
            }

            @page {
                margin: {{ $margin_top }}mm {{ $margin_right }}mm {{ $margin_bottom }}mm {{ $margin_left }}mm;
                /*  */
            }
        </style>

        <div class="page">
            <table id="main-tb" class="table table-striped m-auto border-solid border-thin bg-trans">
                @php
                    $totalQty = 0;
                    $totalProgress = 0;
                    foreach ($project->monitor as $index => $mon) {
                        $totalQty += $mon->qty;

                        // From here is for $totalProgress
                        $qty = $mon['qty'];
                        $relatedTasks = $project->task;
                        $tempTot = 0;
                        foreach ($relatedTasks as $task) {
                            $tempTot += $task->sumProgressByMonitoring($mon['id_monitoring']);
                        }
                        $up = $relatedTasks->count() > 0 ? $tempTot / $relatedTasks->count() : 0; // Average progress
                        $total = ($qty * $up) / 100;
                        $totalProgress += $total;
                    }
                @endphp

                <thead class="border-left-bold border-right-bold">
                    <tr class="border-c-default">
                        <th colspan="6"
                            class="th-0 p-0 m-0 border-top-bold border-left-bold border-bottom-0 border-right-solid border-thin">
                        </th>
                        <th colspan="2"
                            class="th-0 p-0 m-0 align-top border-solid border-top-bold border-bottom-bold border-left-bold border-right-bold border-c-default">
                            <div class="text-center page-label">
                                <h3 class="m-0"><strong>COORDINATOR</strong></h3>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th colspan="8"
                            class="th-0 border-top-0 border-right-bold border-left-bold border-solid border-thin position-relative">
                            <span class="page-logo-container">
                                <div class="border-0 p-4 text-center">
                                    <img src="{{ asset('public/assets/logo/dws_header_vplogo.jpg') }}"
                                        class="page-logo">
                                </div>
                            </span>
                            <div class="text-center m-1 underline-text page-title">
                                <h3><strong>PROGRESS PROJECT MONITORING<br><span
                                            style="margin-top: 10px; display: inline-block;"></span></strong></h3>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th class="th-0 border-0 th-no"></th>
                        <th colspan="1" class="th-0 border-0 text-start align-middle">Project-No</th>
                        <th colspan="1" class="th-0 border-0 text-start align-middle">
                            {{ Str::limit($project->id_project, 25, '...') }}
                        </th>
                        <th class="th-0 border-0"></th>
                        <th colspan="4" class="th-0 border-0 text-start align-middle">PT. VERTECH PERDANA</th>
                    </tr>
                    <tr class="border-0">
                        <th class="th-0 border-0 th-no"></th>
                        <th colspan="1" class="th-0 border-0 text-start align-middle">Project-Name</th>
                        <th colspan="2" class="th-0 border-0 text-start align-middle">
                            {{ Str::limit($project->na_project, 29, '...') }}</th>
                        <th colspan="1" class="th-0 border-0 text-start align-middle">Engineer Team</th>
                        <th colspan="3" class="th-0 border-0 text-start align-middle">
                            {{-- {{ Str::limit($project->team->na_team, 25, '...') }} --}}
                            @php
                                $teamName = [];
                                if (!empty($project['prjteams']) && $project['prjteams']) {
                                    foreach ($project['prjteams'] as $prjteam) {
                                        $teamName[] = $prjteam['team']['na_team'];
                                    }
                                }
                            @endphp
                            @if ($teamName)
                                {{ Str::limit(implode(', ', $teamName), 25, '...') }}
                                <!-- Limit the total name length -->
                            @else
                                -
                            @endif
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th class="th-0 border-0 th-no"></th>
                        <th colspan="1" class="th-0 border-0 text-start align-middle">Customer</th>
                        <th colspan="2" class="th-0 border-0 text-start align-middle">
                            {{ Str::limit($project->client->na_client, 29, '...') }}</th>
                        <th colspan="1" class="th-0 border-0 text-start no-wrap align-middle">Project Co</th>
                        <th colspan="3" class="th-0 border-0 text-start align-middle">
                            {{-- {{ Str::limit($project->karyawan->na_karyawan, 25, '...') }} --}}
                            @php
                                $coordinatorNames = [];
                                foreach ($project->coordinators as $index => $co) {
                                    $coordinatorNames[] = $co->karyawan !== null ? $co->karyawan->na_karyawan : '-';
                                }
                                if (empty($coordinatorNames)) {
                                    $coordinatorNames = ['-'];
                                }
                            @endphp
                            {{ Str::limit(implode(', ', $coordinatorNames), 25, '...') }}
                            <!-- Limit the total name length -->
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th colspan="4" class="th-0 border-0 th-no"></th>
                        <th colspan="1" class="th-0 border-0 text-start no-wrap align-middle">Date</th>
                        <th colspan="3" class="th-0 border-0 text-start align-middle">
                            {{ convertDate($project->start_project) }}</th>
                    </tr>
                    {{-- <tr class="border-0">
                        <th colspan="4" class="th-0 border-0 th-no"></th>
                        <th colspan="1" class="th-0 border-0 text-start no-wrap align-middle">Deadline</th>
                        <th colspan="2" class="th-0 border-0 text-start align-middle">{{ convertDate($project->deadline_project) }}</th>
                    </tr> --}}
                    <tr>
                        <th colspan="1" rowspan="2" class="th-no align-middle">NO.</th>
                        <th colspan="2" rowspan="2" class="align-middle">CATEGORY</th>
                        <th colspan="1" rowspan="2" class="align-middle">START DATE</th>
                        <th colspan="1" rowspan="2" class="align-middle">END DATE</th>
                        <th colspan="1" rowspan="1" class="align-middle th-qty">QTY</th>
                        <th colspan="1" rowspan="1" class="align-middle th-tot-pro">TOTAL<br>PROGRESS</th>
                        <th colspan="1" rowspan="1" class="align-middle th-up-pro">UPDATE<br>PROGRESS</th>
                    </tr>
                    <tr>
                        <th colspan="1" rowspan="1" class="align-middle th-qty">
                            {{ number_format($totalQty, 1) }}%</th>
                        <th colspan="1" rowspan="1" class="align-middle th-tot-pro">
                            {{ number_format($totalProgress, 1) }}%
                        </th>
                        <th colspan="1" rowspan="1" class="align-middle th-up-pro">0-100%</th>
                    </tr>
                </thead>

                <tbody class="border-left-bold border-right-bold border-bottom-bold">
                    @foreach ($chunk as $index2 => $mon)
                        {{-- @dd(["dd(['' => mon]); Output : " => $mon]); --}}
                        <tr>
                            <td class="cell-fit text-center align-top">{{ $index2 + 1 }}</td>
                            <td class="text-start align-top txt-break text-wrap" colspan="2">
                                {{ $mon['category'] ?? '-' }} <!-- Display category -->
                            </td>
                            <td class="text-center fit-content align-top txt-break text-wrap">
                                {{ !empty($mon['start_date']) ? \Carbon\Carbon::parse($mon['start_date'])->isoFormat($cust_date_format) : '-' }}
                            </td>
                            <td class="text-center fit-content align-top txt-break text-wrap">
                                {{ !empty($mon['end_date']) ? \Carbon\Carbon::parse($mon['end_date'])->isoFormat($cust_date_format) : '-' }}
                            </td>
                            <td class="text-center fit-content align-top th-qty">
                                {{ number_format($mon['qty'], 1) . '%' ?? '-' }}
                            </td>
                            <td class="text-center fit-content align-top th-tot-pro">
                                @php
                                    $total = 0;
                                @endphp

                                @if (!empty($mon['qty']))
                                    @php
                                        // Get all tasks associated with the project
                                        $relatedTasks = $project->task;
                                        $totalProgress = 0;

                                        foreach ($relatedTasks as $task) {
                                            $totalProgress += $task->sumProgressByMonitoring($mon['id_monitoring']);
                                        }

                                        $up = count($relatedTasks) > 0 ? $totalProgress / count($relatedTasks) : 0; // Average progress
                                        $total = ($mon['qty'] * $up) / 100;
                                    @endphp
                                @else
                                    @php
                                        $total = 0;
                                    @endphp
                                @endif
                                {{ number_format($total, 1) }}%
                            </td>
                            <td class="text-center fit-content align-top th-up-pro">
                                @if (!empty($mon['tasks']) && count($mon['tasks']) > 0)
                                    @php
                                        $totalProgress = 0;

                                        foreach ($mon['tasks'] as $task) {
                                            // Check if progress_current_task is not empty
                                            if (!empty($task['progress_current_task'])) {
                                                // Check if task is not soft-deleted
                                                if (empty($task['deleted_at'])) {
                                                    // Check if the related worksheet exists and meets the specified conditions
                                                    if (
                                                        isset($task['worksheet']) &&
                                                        is_null($task['worksheet']['expired_at_ws']) &&
                                                        $task['worksheet']['status_ws'] === 'CLOSED'
                                                    ) {
                                                        $totalProgress += $task['progress_current_task'];
                                                    }
                                                }
                                            }
                                        }

                                        $totalProgress = number_format($totalProgress, 1) . '%';
                                    @endphp
                                    {{ $totalProgress }}
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>



                {{-- <tfoot class="border-left-bold border-bottom-bold border-right-bold border-top-bold">
                </tfoot> --}}
            </table>



            <!-- Footer to display page number for each chunk -->
            <footer class="form-footer">
                @php
                    $currentPage = floor($index2 / $eachmonitorChunk) + 1; // Avoid division by zero
                @endphp
                <span>
                    Page {{ $currentPage }} of {{ $totalPages }} <!-- Page number based on total pages -->
                </span>
            </footer>



        </div>
        {{-- <div style='page-break-after: always;'></div> <!-- Page break after each chunk --> --}}
        @if (count($chunk) > 0 && isset($monChunks[$index + 1]))
            <!-- Only add page break if there's a next chunk -->
            <div style='page-break-after: always;'></div>
        @endif
    @endforeach








</body>

</html>
