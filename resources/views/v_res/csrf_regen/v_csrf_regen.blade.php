{{-- ////////////////////////////////////////////////////////////////////// CSRF: AUTO REGEN //////////////////////////////////////////////////////////////////////  --}}
{{-- CSRF: AUTO REGEN --}}
<!-- AutoRegen CSRF Token -->
<script>
    // GLobal var js
    window.csrfToken = '{{ csrf_token() }}';
    window.csrfTokenUsed = false;

    function secondsToMilliseconds(seconds) {
        return seconds * 1000;
    }
</script>

<script>
    function refreshCsrfToken() {
        return fetch('/csrf-token')
            .then(response => response.json())
            .then(data => {
                // Update the CSRF token in the meta tag
                const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
                if (csrfMetaTag) {
                    csrfMetaTag.setAttribute('content', data.csrf_token);
                }

                // Update the CSRF token in all forms
                const csrfInputs = document.querySelectorAll('input[name="_token"]');
                if (csrfInputs.length > 0) {
                    csrfInputs.forEach(input => {
                        input.value = data.csrf_token;
                    });
                }

                // Update the CSRF token in global js var csrfToken
                window.csrfToken = data.csrf_token;
                window.csrfTokenUsed = false; // Reset the flag after refreshing
                // console.log('Updated CSRF Token:', window.csrfToken);
            })
            .catch(error => console.error('Error refreshing CSRF token:', error));
    }

    function makeRequest(url, options) {
        // Check if the token has been used
        if (window.csrfTokenUsed) {
            // console.warn('CSRF token has already been used. Refreshing token...');
            return refreshCsrfToken().then(() => {
                // Retry the request after refreshing the token
                return makeRequest(url, options);
            });
        }

        // Set the CSRF token in the headers
        options.headers = {
            ...options.headers,
            'X-CSRF-TOKEN': window.csrfToken
        };

        return fetch(url, options)
            .then(response => {
                if (!response.ok) {
                    if (response.status === 419) {
                        window.csrfTokenUsed = true;
                    }
                    return response.json().then(err => {
                        console.error('Error response:', err);
                        throw new Error('Network response was not ok.');
                    });
                }
                return response.json(); // Process the response if successful
            })
            .catch(error => console.error('Error making request:', error));
    }

    // Set an interval to refresh the CSRF token every 30 seconds (30000 milliseconds)
    setInterval(refreshCsrfToken, secondsToMilliseconds(300));

    // // Example usage of makeRequest
    // function exampleApiCall() {
    //     makeRequest('/api/some-endpoint', {
    //             method: 'POST',
    //             body: JSON.stringify({
    //                 data: 'example'
    //             }),
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             }
    //         })
    //         .then(data => {
    //             console.log('Response data:', data);
    //         });
    // }

    // // Call the example API function
    // exampleApiCall();
</script>

<script>
    // console.log('Initial CSRF Token:', window.csrfToken);
</script>
<!-- ./AutoRegen CSRF Token -->


{{-- ////////////////////////////////////////////////////////////////////// ./CSRF: AUTO REGEN //////////////////////////////////////////////////////////////////////  --}}
