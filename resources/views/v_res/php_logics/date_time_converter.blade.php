@php
    $cust_date_format = 'dddd, DD MMM YYYY';
    $cust_time_format = 'hh:mm:ss A';

    if (!function_exists('convertDateOnly')) {
        function convertDateOnly($workingDate, $defaultLocaleDate = 'id')
        {
            \Carbon\Carbon::setLocale($defaultLocaleDate);
            $date = \Carbon\Carbon::parse($workingDate);
            $isoDate = $date->isoFormat('DD MMM YYYY');

            $formattedDate = $isoDate;
            return $formattedDate;
        }
    }
    if (!function_exists('convertDate')) {
        function convertDate($workingDate, $defaultLocaleDay = 'id')
        {
            // Format the dayname in Indo
            \Carbon\Carbon::setLocale($defaultLocaleDay);
            $date = \Carbon\Carbon::parse($workingDate);
            $dayName = $date->isoFormat('dddd');

            // Format the date in English
            $formattedDate = $dayName . ', ' . $date->isoFormat('DD MMM YYYY');
            return $formattedDate;
        }
    }
    if (!function_exists('convertTime')) {
        function convertTime($workingTime)
        {
            // 21:00:05 PM
            \Carbon\Carbon::setLocale('en');
            $time = \Carbon\Carbon::parse($workingTime);
            $formattedTime = $time->isoFormat('hh:mm:ss A');
            return $formattedTime;
        }
        function convertTimeV2($workingTime)
        {
            // 21:00 PM
            \Carbon\Carbon::setLocale('en');
            $time = \Carbon\Carbon::parse($workingTime);
            $formattedTime = $time->isoFormat('hh:mm A');
            return $formattedTime;
        }
    }
    if (!function_exists('convertDateTime')) {
        function convertDateTime($dateTime, $defaultLocaleDate = 'in', $defaultLocaleTime = 'en')
        {
            // Check if $dateTime is already a Carbon instance
            if (!($dateTime instanceof \Carbon\Carbon)) {
                $dateTime = \Carbon\Carbon::parse($dateTime);
            }

            \Carbon\Carbon::setLocale($defaultLocaleDate);
            $formattedDate = $dateTime->isoFormat('dddd, DD MMM YYYY');
            \Carbon\Carbon::setLocale($defaultLocaleTime);
            $formattedTime = $dateTime->isoFormat('hh:mm:ss A');
            $formattedDateTime = $formattedDate . ' at ' . $formattedTime;

            return $formattedDateTime;
        }
    }
@endphp
