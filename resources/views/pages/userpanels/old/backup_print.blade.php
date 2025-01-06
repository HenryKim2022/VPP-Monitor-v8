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
        href="{{ asset('public/assets/css/dev.very.custom.dompdf_v2.css') }}?v={{ time() }}">





</head>

<body>
    <header class="form-ver">
        <span>
            Form : VP-ENG-03A Date : 12.11.24 Rev.3
        </span>
    </header>


    @php
        $totalChunks = count($taskChunks); // Count the total number of chunks
    @endphp


    {{-- <div class="table-responsive" id="printableArea"> --}}
    @foreach ($taskChunks as $index => $chunk)
        {{-- @php
            $tbodyHeight = 195; // Set your desired total height for the tbody
            // $rowCount = is_array($chunk) ? count($chunk) : 0; // Check if $chunk is an array
            $rowCount = $eachtaskChunk;
            $cellHeight = $rowCount > 0 ? $tbodyHeight / $rowCount : 0; // Calculate height per cell
        @endphp --}}
        @php
            // Define the maximum characters per line
            $maxCharsDescription = 40; // Max characters for DESCRIPTION
            $maxCharsTask = 25; // Max characters for TASK

            // Set the base height for each line of text
            $lineHeight = 20; // Height for each line in pixels

            // Calculate the maximum height for the TASK and DESCRIPTION columns
            $maxDescriptionHeight = 0;
            $maxTaskHeight = 0;

            foreach ($chunk as $relDWS) {
                // Get the text for task and description
                $taskText = $relDWS['monitor']['category'];
                $descriptionText = $relDWS['descb_task'];

                // Calculate the number of lines needed for wrapping
                $descriptionLines = ceil(strlen($descriptionText) / $maxCharsDescription);
                $taskLines = ceil(strlen($taskText) / $maxCharsTask);

                // Update the maximum height based on the number of lines
                $maxDescriptionHeight = max($maxDescriptionHeight, $descriptionLines * $lineHeight);
                $maxTaskHeight = max($maxTaskHeight, $taskLines * $lineHeight);
            }

            // Set the total height for the tbody
            $tbodyHeight = $baseHeight + $maxDescriptionHeight + $maxTaskHeight; // current Base height (185) + dynamic height
            $rowCount = count($chunk);
            // $cellHeight = $rowCount > 0 ? $tbodyHeight / $rowCount : 0; // Calculate height per cell
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


            /* Specific styles for TASK and DESCRIPTION columns to allow wrapping */
            .task-column,
            .description-column {
                height: auto;
                overflow-wrap: break-word;
                word-wrap: break-word;
                white-space: normal;
            }

            tfoot td {
                /* padding: 0px !important; */
                padding: 0rem 0.2rem !important;
                margin: 0px !important;
                height: fit-content !important;
                overflow-wrap: break-word; /* Break words if necessary */
                /*  */
            }


            .arv-th,
            .fin-th,
            .descb-th {
                width: 36% !important;
            }


            .time-th {
                width: 5% !important;
                padding: 0% !important;
                margin: 0% !important;
            }

            .pro-main {
                width: fit-content !important;
            }

            .pro-act {
                width: 2% !important;
            }

            .pro-cur {
                width: 0.5% !important;
            }

            @page {
                margin: {{ $margin_top }}mm {{ $margin_right }}mm {{ $margin_bottom }}mm {{ $margin_left }}mm;
                /*  */
            }
        </style>






        <div class="page">
            <table id="main-tb" class="table table-striped m-auto border-solid border-thin bg-trans">
                <thead class="border-left-bold border-right-bold">
                    <tr class="border-c-default">
                        <th colspan="12"
                            class="th-0 p-0 m-0 border-top-bold border-left-bold border-bottom-0 border-right-solid border-thin">
                        </th>
                        <th colspan="5"
                            class="th-0 p-0 m-0 align-top border-solid border-top-bold border-bottom-bold border-left-bold border-right-bold border-c-default">
                            <div class="text-center page-label">
                                <h3 class="m-0"><strong>ENGINEER</strong></h3>
                            </div>
                        </th>
                    </tr>
                    <tr class="border-0">
                        <th colspan="17"
                            class="th-0 border-top-0 border-right-bold border-left-bold border-solid border-thin position-relative">
                            <span class="page-logo-container">
                                <div class="border-0 p-4 text-center">
                                    <img src="{{ asset('public/assets/logo/dws_header_vplogo.jpg') }}"
                                        class="page-logo">
                                </div>
                            </span>
                            <div class="text-center m-1 underline-text page-title">
                                <h3><strong>PROJECT DAILY WORKSHEET<br>(LEMBAR KERJA HARIAN)</strong></h3>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="th-0 text-start">DESCRIPTION<br>(KETERANGAN)</th>
                        <th colspan="1" class="th-0 text-center cell-fit tikdu_eq">:</th>
                        <th colspan="12" class="th-0 text-start">{{ $loadDataWS->project->id_project }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4" class="th-0 text-start fit-content">CLIENT'S NAME<br>(NAMA CUSTOMER)</th>
                        <th colspan="1" class="th-0 text-center cell-fit tikdu_eq">:</th>
                        <th colspan="4" class="th-0 text-start">
                            {{ Str::limit($loadDataWS->project->client->na_client, 18, '...') }}
                        </th>
                        <th colspan="1" class="th-0 text-center cell-fit text-trans tikdu_eq">:</th>
                        <th colspan="1" class="th-0 text-start arv-th">ARRIVAL TIME<br>(WAKTU
                            DATANG)</th>
                        <th colspan="1" class="th-0 text-center cell-fit tikdu_eq">:</th>
                        <th colspan="5" class="th-0 text-start">
                            {{ \Carbon\Carbon::parse($loadDataWS->arrival_time_ws)->format('h:i:s A') }}</th>
                    </tr>
                    @php
                        $workingDate = $loadDataWS->working_date_ws;
                        \Carbon\Carbon::setLocale('id');
                        $date = \Carbon\Carbon::parse($workingDate);
                        $formattedDate = $date->isoFormat('dddd, DD MMM YYYY');
                    @endphp
                    <tr>
                        <th colspan="4" class="th-0 text-start fit-content th-date">DATE<br>(TANGGAL)</th>
                        <th colspan="1" class="th-0 text-center cell-fit tikdu_eq">:</th>
                        <th colspan="4" class="th-0 text-start fit-content">{{ $formattedDate }}</th>
                        <th colspan="1" class="th-0 text-center cell-fit text-trans tikdu_eq">:</th>
                        <th colspan="1" class="th-0 text-start fin-th">FINISH TIME<br>(WAKTU SELESAI)</th>
                        <th colspan="1" class="th-0 text-center cell-fit tikdu_eq">:</th>
                        <th colspan="5" class="th-0 text-start">
                            {{ \Carbon\Carbon::parse($loadDataWS->finish_time_ws)->format('h:i:s A') }}</th>
                    </tr>
                    <tr>
                        <th rowspan="2" colspan="3" class="text-center align-middle cell-fit time-th">TIME
                            (WAKTU)</th>
                        <th rowspan="2" colspan="7" class="text-center align-middle">TASK</th>
                        <th rowspan="2" colspan="1" class="text-center align-middle descb-th">DESCRIPTION</th>
                        <th colspan="6" class="text-center align-middle pro-main">PROGRESS</th>
                    </tr>
                    <tr>
                        {{-- <th colspan="3" class="text-center align-middle" style="width: 60% !important;">ACTUAL --}}
                        <th colspan="3" class="text-center align-middle pro-act">
                            <div class="text-center">ACTUAL</div>
                        </th>
                        {{-- <th colspan="3" class="text-center align-middle" style="width: 20% !important;">CURRENT --}}
                        <th colspan="3" class="text-center align-middle pro-cur">
                            <div class="text-center">CURRENT</div>
                        </th>
                    </tr>
                </thead>
                {{-- <tbody class="fixed-height"> --}}

                <tbody class="border-left-bold border-right-bold">
                    @foreach ($chunk as $relDWS)
                        <tr>
                            <td colspan="3" class="text-center align-top cell-fit time-th">
                                {{ \Carbon\Carbon::parse($relDWS['start_time_task'])->format('h:i') }}</td>
                            <td colspan="7" class="text-start align-top task-column">
                                {{ $relDWS['monitor']['category'] }}</td>
                            <td colspan="1" class="text-start align-top description-column descb-th">
                                @php
                                    $descbTask = $relDWS['descb_task'];
                                    $descbTask = str_replace(
                                        ['*- ', '- '],
                                        // '<i class="fas fa-circle fs-xs"></i>&nbsp;',
                                        '*- ',
                                        $descbTask,
                                    );
                                    $descbTask = str_replace("\n", '<br>', $descbTask);
                                @endphp
                                {!! $descbTask !!}
                            </td>
                            <td class="text-center align-top pro-act" colspan="3">
                                @php
                                    $total = 0; // Initialize total for this monitoring entry
                                    $qty = $relDWS['monitor']['qty'];

                                    if ($qty > 0) {
                                        $relatedTasks = collect($project->task)->filter(function ($task) use (
                                            $relDWS,
                                            $project,
                                        ) {
                                            $worksheet = collect($project->worksheet)->firstWhere(
                                                'id_ws',
                                                $task['id_ws'],
                                            );
                                            return $task['id_monitoring'] === $relDWS['id_monitoring'] &&
                                                ($worksheet['expired_ws'] ?? null) === null;
                                        });

                                        $totalProgress = 0;
                                        foreach ($relatedTasks as $task) {
                                            $totalProgress += $task->progress_current_task; // Sum up the progress of related tasks
                                        }

                                        $relatedTaskCount = $relatedTasks->count();
                                        $up = $relatedTaskCount > 0 ? $totalProgress / $relatedTaskCount : 0; // Average progress
                                        $total = ($qty * $up) / 100; // Calculate total percentage
                                    }
                                @endphp
                                {{ number_format($total, 1) }}% <!-- Display total with 1 decimal place -->
                            </td>
                            <td class="text-center align-top pro-cur" colspan="3">
                                @if ($relDWS['progress_current_task'] != null && $relDWS['progress_current_task'] > 0)
                                    {{ number_format($relDWS['progress_current_task'], 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-left-bold border-bottom-bold border-right-bold">
                    <tr>
                        <td colspan="17" class="text-left align-middle"><strong>REMARK (CATATAN AKHIR)</strong>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $remarkWS =
                                isset($loadDataWS->remark_ws) && !empty($loadDataWS->remark_ws)
                                    ? $loadDataWS->remark_ws
                                    : '- Tidak Ada';

                            if ($remarkWS !== '- Tidak Ada') {
                                // Replace bullet points with icons for display outside the textarea
                                $formattedRemarkWS = str_replace(
                                    '*- ',
                                    '<i class="fas fa-circle fs-sm"></i>&nbsp;',
                                    $remarkWS,
                                );
                                $formattedRemarkWS = str_replace(
                                    '- ',
                                    '<i class="fas fa-circle fs-sm"></i>&nbsp;',
                                    $formattedRemarkWS,
                                );
                                // Replace new lines with line breaks for display outside the textarea
                                $formattedRemarkWS = str_replace("\n", '<br>', $formattedRemarkWS);
                            } else {
                                $formattedRemarkWS = '- Tidak Ada';
                            }

                            // Strip HTML tags for textarea
                            $textareaRemarkWS = htmlspecialchars(strip_tags($remarkWS), ENT_QUOTES, 'UTF-8');
                        @endphp

                        <td colspan="17" rowspan="1" class="p-0">
                            <textarea class="w-98 h-12 px-1 m-0 text-left border-0 bg-trans" rows="14" @disabled(true)>{!! $textareaRemarkWS !!}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" rowspan="5" class="border-right-0" {{-- style="padding: 0.35rem 0.35rem;" --}}>
                            <div class="d-flex flex-col justify-content-around">
                                <div class="d-flex flex-column align-items-start">
                                    <span>
                                        <strong>EXECUTED BY, (DIKERJAKAN OLEH)</strong>
                                    </span>
                                    <div style="margin-bottom: 8em;"></div> <!-- Empty div for spacing -->
                                    <span class="justify-content-center">
                                        <a
                                            class="w-100 align-text-bottom">{{ Str::limit($loadDataWS->karyawan->na_karyawan, 30, '...') }}</a>
                                    </span>
                                    <br>
                                    <span class="underline-text">
                                        <strong>PT. VERTECH PERDANA</strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td colspan="3" rowspan="5" class="border-left-0" {{-- style="padding: 0.35rem 0.35rem;" --}}>
                            <div class="d-flex flex-col justify-content-around">
                                <div class="d-flex flex-column align-items-start">
                                    <span>
                                        <strong>ACKNOWLEDGED BY, (DIKETAHUI OLEH)</strong>
                                    </span>
                                    <div style="margin-bottom: 8em;"></div> <!-- Empty div for spacing -->
                                    <span class="justify-content-center" style="width: 500px;">
                                        <a class="w-100 align-text-bottom">
                                            {{ Str::limit($loadDataWS->project->client->na_client, 37, '...') }}
                                        </a>
                                    </span>
                                    <br>
                                    <span class="underline-text">
                                        <strong>
                                            @php
                                                $clientName = $loadDataWS->project->client->na_client;
                                                $clientNameLength = mb_strlen(Str::limit($clientName, 37, '...'));
                                                if ($clientNameLength < 38) {
                                                    $clientNameLength = 37;
                                                }
                                                $clientLabelLength = mb_strlen('(CLIENT) ');
                                                $totalLength = $clientNameLength * 3 - 2;
                                                $dotsCount = max(
                                                    0,
                                                    $totalLength - $clientLabelLength - $clientNameLength,
                                                );
                                                echo '(CLIENT)' . str_repeat('.', $dotsCount);
                                            @endphp
                                        </strong>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td colspan="5" rowspan="1" class="text-center"><strong>Time
                                Stamp</strong></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="" {{-- style="padding: 0.35rem 0.35rem;" --}}>
                            <strong>Start Date:</strong><br>
                            @php
                                $startDate = $loadDataWS->working_date_ws;
                                $dateStart = \Carbon\Carbon::parse($startDate);
                                \Carbon\Carbon::setLocale('in');
                                $formattedDateStart = $dateStart->isoFormat('dddd, DD MMM YYYY');
                                \Carbon\Carbon::setLocale('en');
                                $formattedTimeStart = $dateStart->isoFormat('hh:mm:ss A');
                                $formattedDateTimeStart = $formattedDateStart . ' at ' . $formattedTimeStart;
                                echo $formattedDateTimeStart;
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="" {{-- style="padding: 0.35rem 0.35rem;" --}}>
                            <strong>Closed Date:</strong><br>
                            @if ($loadDataWS->status_ws == 'OPEN')
                                -
                            @else
                                @php
                                    $closedDate = $loadDataWS->closed_at_ws;
                                    $dateClose = \Carbon\Carbon::parse($closedDate);
                                    \Carbon\Carbon::setLocale('in');
                                    $formattedDateClose = $dateClose->isoFormat('dddd, DD MMM YYYY');
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
                        <td colspan="5" class="text-center align-middle" {{-- style="padding: 0.35rem 0.35rem;" --}}>
                            <strong>Status</strong>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $isStatusOpen = $loadDataWS->status_ws == 'OPEN' ? true : false;
                        @endphp
                        <td colspan="5" {{-- style="padding: 0.35rem 0.35rem;" --}}
                            class="h-0 {{ $isStatusOpen ? 'bg-danger text-black' : 'bg-warning text-black' }}">
                            <div class="text-center page-label">
                                <h3 class="m-0 p-0">
                                    <strong>
                                        @if ($isStatusOpen)
                                            OPEN
                                        @else
                                            CLOSED
                                        @endif
                                    </strong>
                                </h3>
                            </div>

                        </td>
                    </tr>
                </tfoot>
            </table>



            <!-- Footer to display page number for each chunk -->
            <!-- Only show page number if there is more than one chunk -->
            <footer class="form-footer">
                <span>
                    Page {{ $index + 1 }} of {{ $totalChunks }} <!-- Page number based on chunk index -->
                </span>
            </footer>



        </div>
        {{-- <div style='page-break-after: always;'></div> <!-- Page break after each chunk --> --}}
        @if (count($chunk) > 0 && isset($taskChunks[$index + 1]))
            <!-- Only add page break if there's a next chunk -->
            <div style='page-break-after: always;'></div>
        @endif
    @endforeach





    {{-- </div> --}}



</body>

</html>
