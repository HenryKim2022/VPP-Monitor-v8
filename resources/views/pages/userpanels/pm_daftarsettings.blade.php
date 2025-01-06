@php
    $page = Session::get('page');
    $page_title = $page['page_title'];
    $cust_date_format = $page['custom_date_format'];
    $reset_btn = false;
    // $authenticated_user_data = Session::get('authenticated_user_data');

    // dd($authenticated_user_data);
@endphp

@extends('layouts.userpanels.v_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
    <div class="row match-height">
        <!-- QRCodeCheck-out Card -->
        <div class="col-lg-4 col-md-6 col-12">
        </div>
        <!--/ QRCodeCheck-out Card -->

        <!-- TableAbsen Card -->
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card card-developer-meetup">

                <!-- Accordion with hover start -->
                <section id="accordion-hover">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card collapse-icon">
                                <div class="card-body" style="min-height: 62vh;">
                                    {{-- <p class="card-text"></p> --}}
                                    <div class="accordion" id="accordionExample3" data-toggle="true">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div class="card-header" id="heading300" data-toggle="collapse"
                                                    role="button" data-target="#collapse300" aria-expanded="true"
                                                    aria-controls="collapse300">
                                                    <span class="lead collapse-title collapse-hover-title">
                                                        <h4 class="card-title h4-dark">Authentication
                                                            Register Settings</h4>
                                                    </span>
                                                </div>
                                                <div id="collapse300" class="collapse collapse-margin show"
                                                    aria-labelledby="heading300" data-parent="#accordionExample3">
                                                    <div class="card-body">
                                                        @if (isset($filtered_settings) && $filtered_settings->isNotEmpty())
                                                            <table style="border-collapse: collapse; width: 100%;">
                                                                @foreach ($filtered_settings as $setting)
                                                                    <tr>
                                                                        <td style="padding: 10px; border: none;">
                                                                            {{ $setting['lbl_sett'] . ' Menu' }}
                                                                        </td>
                                                                        <td style="padding: 10px; border: none;">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    id="{{ $setting['na_sett'] }}-on"
                                                                                    name="{{ $setting['na_sett'] }}"
                                                                                    value="1"
                                                                                    class="custom-control-input"
                                                                                    {{ $setting['val_sett'] == 1 ? 'checked' : '' }}>
                                                                                <label class="custom-control-label"
                                                                                    for="{{ $setting['na_sett'] }}-on">Show</label>
                                                                            </div>
                                                                        </td>
                                                                        <td style="padding: 10px; border: none;">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio"
                                                                                    id="{{ $setting['na_sett'] }}-off"
                                                                                    name="{{ $setting['na_sett'] }}"
                                                                                    value="0"
                                                                                    class="custom-control-input"
                                                                                    {{ $setting['val_sett'] == 0 ? 'checked' : '' }}>
                                                                                <label class="custom-control-label"
                                                                                    for="{{ $setting['na_sett'] }}-off">Hide</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        @else
                                                            <p>No filtered system settings available.</p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                            {{--
                                                <div class="card">
                                                </div>
                                             --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Accordion with hover end -->

            </div>
        </div>
        <!--/ TableAbsen Card -->



    </div>
@endsection


@section('footer_page_js')
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-modals.js') }}"></script>
    <script src="{{ asset('public/theme/vuexy/app-assets/js/scripts/components/components-collapse.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listener for radio button changes
            $('input[type="radio"]').change(function() {
                const settingName = $(this).attr('name'); // Get the setting name
                const settingValue = $(this).val(); // Get the value of the selected radio button

                // Check if the setting name is one of the specific settings
                if (settingName === 'client_reg_menu' || settingName === 'employee_reg_menu') {
                    // $.ajax({
                    //     url: '{{ route('m.sys.sh.chg.valreg') }}',
                    //     method: 'POST',
                    //     data: {
                    //         setting_name: settingName,
                    //         setting_value: settingValue,
                    //         _token: '{{ csrf_token() }}' // CSRF token for security
                    //     },
                    //     success: function(response) {
                    //         if (response != null && response.message) {
                    //             jsonToastReceiver(response.message); // Display success message
                    //         }
                    //         console.log('Update successful:', response);
                    //     },
                    //     error: function(xhr, status, error) {
                    //         if (xhr.responseJSON != null && xhr.responseJSON.message) {
                    //             jsonToastReceiver(xhr.responseJSON
                    //             .message); // Display error message
                    //         }
                    //         console.error('Update failed:', error);
                    //     }
                    // });

                    makeRequest('{{ route('m.sys.sh.chg.valreg') }}', {
                        method: 'POST',
                        body: JSON.stringify({
                            setting_name: settingName,
                            setting_value: settingValue
                        }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response != null && response.message) {
                            jsonToastReceiver(response.message); // Display success message
                        }
                        console.log('Update successful:', response);
                    })
                    .catch(error => {
                        console.error('Update failed:', error);
                        // Handle error response
                        if (error.message) {
                            jsonToastReceiver(error.message); // Display error message
                        }
                    });
                }
            });
        });
    </script>
@endsection
