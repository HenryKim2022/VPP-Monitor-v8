{{-- ////////////////////////////////////////////////////////////////////// TOAST //////////////////////////////////////////////////////////////////////  --}}
{{-- TOAST: VALIDATION ERROR/FAILED --}}
@if ($errors->any())
    @php
        $errorMessages = $errors->all();
    @endphp

    @foreach ($errorMessages as $index => $message)
        @if ($index == 0)
            <input type="hidden" class="error-message" data-delay="{{ ($index + 1) * 0 }}" value="{{ $message }}">
        @else
            <input type="hidden" class="error-message" data-delay="{{ ($index + 1) * 1000 }}" value="{{ $message }}">
        @endif
    @endforeach
@endif
<script>
    $(document).ready(function() {
        @if ($errors->any())
            @php
                $errorMessages = $errors->all();
            @endphp

            @foreach ($errorMessages as $index => $message)
                var toastErrorMsg_{{ $index }} = "{{ $message }}";
                var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                setTimeout(function() {
                    toastr.error(toastErrorMsg_{{ $index }}, '', {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: '300',
                        hideDuration: '1000',
                        timeOut: '5000',
                        extendedTimeOut: '1000',
                        showEasing: 'swing',
                        hideEasing: 'linear',
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut'
                    });
                }, delay_{{ $index }});
            @endforeach
        @endif
    });
</script>





{{-- TOAST: SUCCESS --}}
@if (Session::has('success'))
    @foreach (Session::get('success') as $index => $message)
        @if ($index == 1)
            <input type="hidden" class="success-message" data-delay="{{ ($index + 1) * 0 }}"
                value="{{ $message }}">
        @else
            <input type="hidden" class="success-message" data-delay="{{ ($index + 1) * 1000 }}"
                value="{{ $message }}">
        @endif
    @endforeach
@endif

<script>
    $(document).ready(function() {
        @if (Session::has('success'))
            @foreach (Session::get('success') as $index => $message)
                var toastSuccessMsg_{{ $index }} = "{{ $message }}";
                var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                setTimeout(function() {
                    toastr.success(toastSuccessMsg_{{ $index }}, '', {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: '300',
                        hideDuration: '1000',
                        timeOut: '5000',
                        extendedTimeOut: '1000',
                        showEasing: 'swing',
                        hideEasing: 'linear',
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut'
                    });
                }, delay_{{ $index }});
            @endforeach
        @endif
    });
</script>





{{-- TOAST: NORMAL ERROR MESSAGE --}}
@if (Session::has('n_errors'))
    @foreach (Session::get('n_errors') as $index => $message)
        @if ($index == 1)
            <input type="hidden" class="n-error-message" data-delay="{{ ($index + 1) * 0 }}"
                value="{{ $message }}">
        @else
            <input type="hidden" class="n-error-message" data-delay="{{ ($index + 1) * 1000 }}"
                value="{{ $message }}">
        @endif
    @endforeach
@endif
<script>
    $(document).ready(function() {
        @if (Session::has('n_errors'))
            @foreach (Session::get('n_errors') as $index => $message)
                var toastNErrorMsg_{{ $index }} = "{{ $message }}";
                var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                setTimeout(function() {
                    toastr.error(toastNErrorMsg_{{ $index }}, '', {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: '300',
                        hideDuration: '1000',
                        timeOut: '5000',
                        extendedTimeOut: '1000',
                        showEasing: 'swing',
                        hideEasing: 'linear',
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut'
                    });
                }, delay_{{ $index }});
            @endforeach
        @endif
    });
</script>



{{-- TOAST: NORMAL WARNING MESSAGE --}}
@if (Session::has('n_warnings'))
    @foreach (Session::get('n_warnings') as $index => $message)
        @if ($index == 1)
            <input type="hidden" class="n-warning-message" data-delay="{{ ($index + 1) * 0 }}"
                value="{{ $message }}">
        @else
            <input type="hidden" class="n-warning-message" data-delay="{{ ($index + 1) * 1000 }}"
                value="{{ $message }}">
        @endif
    @endforeach
@endif
<script>
    $(document).ready(function() {
        @if (Session::has('n_warnings'))
            @foreach (Session::get('n_warnings') as $index => $message)
                var toastNWarningMsg_{{ $index }} = "{{ $message }}";
                var delay_{{ $index }} = {{ ($index + 1) * 1000 }};

                setTimeout(function() {
                    toastr.warn(toastNWarningMsg_{{ $index }}, '', {
                        closeButton: false,
                        debug: false,
                        newestOnTop: false,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        preventDuplicates: false,
                        onclick: null,
                        showDuration: '300',
                        hideDuration: '1000',
                        timeOut: '5000',
                        extendedTimeOut: '1000',
                        showEasing: 'swing',
                        hideEasing: 'linear',
                        showMethod: 'fadeIn',
                        hideMethod: 'fadeOut'
                    });
                }, delay_{{ $index }});
            @endforeach
        @endif
    });
</script>




{{-- TOAST JSON: NORMAL SUCCESS & ERROR MESSAGE --}}
<!-- NOTE:
success: function(response) {
    console.log(response.message);
    if (response.message) {
        jsonToastReceiver(response.message);    <-- Caller
    }
},
-->
<script>
    function showToast(modifier, messages) {
        const toastrOptions = {
            closeButton: false,
            debug: false,
            newestOnTop: false,
            progressBar: true,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null,
            showDuration: '300',
            hideDuration: '1000',
            timeOut: '5000',
            extendedTimeOut: '1000',
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };

        if (modifier === 'error' || modifier === 'success') {
            if (Array.isArray(messages)) {
                messages.forEach((msg, index) => {
                    // Calculate the delay based on the index
                    const delay = index * 1000; // 1000 ms = 1 second
                    setTimeout(() => {
                        modifier === 'error' ?
                            toastr.error(msg, '', toastrOptions) :
                            toastr.success(msg, '', toastrOptions);
                    }, delay);
                });
            } else if (typeof messages === 'string') {
                // If it's a single message, show it immediately
                toastr[modifier](messages, '', toastrOptions);
            }
        }
    }

    function jsonToastReceiver(messageObj) {
        console.log('Message object:', messageObj); // For debugging

        // Check for error messages
        if (messageObj.err_json) {
            if (Array.isArray(messageObj.err_json) && messageObj.err_json.length > 0) {
                showToast('error', messageObj.err_json);
            } else if (typeof messageObj.err_json === 'string') {
                showToast('error', [messageObj.err_json]);
            }
        }

        // Check for success messages
        if (messageObj.success_json) {
            if (Array.isArray(messageObj.success_json) && messageObj.success_json.length > 0) {
                showToast('success', messageObj.success_json);
            } else if (typeof messageObj.success_json === 'string') {
                showToast('success', [messageObj.success_json]);
            }
        }
    }
</script>
{{-- ////////////////////////////////////////////////////////////////////// ./TOAST //////////////////////////////////////////////////////////////////////  --}}
