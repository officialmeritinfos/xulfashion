const settingsRequests = function () {

    // Process basic settings
    const updateBasicSettings = function () {
        // Process the form submission
        $('#basicSettings').submit(async function(e) {
            e.preventDefault();

            const baseURL = $('#basicSettings').attr('action');
            const formData = new FormData(this);

            // Set the CSRF token in the headers
            const headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };

            // Disable submit button and show loading
            $('.submit').attr('disabled', true);
            $("#basicSettings :input").prop("readonly", true);
            $(".submit").LoadingOverlay("show", {
                text: "processing...",
                size: "20"
            });

            try {
                const response = await fetch(baseURL, {
                    method: 'POST',
                    headers: headers,
                    body: formData,
                    cache: 'no-cache',
                    credentials: 'same-origin'
                });

                // Check if the response is not ok
                if (!response.ok) {
                    const errorData = await response.json();
                    // Try to capture any error messages sent from the server
                    throw new Error(errorData.data?.error || "An unexpected error occurred.");
                }

                const data = await response.json();

                if (data.error === true) {
                    // Handle error response
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-full-width"
                    };
                    toastr.error(data.data.error);
                } else if (data.error === 'ok') {
                    // Handle success response
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-full-width"
                    };
                    toastr.success(data.message);

                    // Update the profile picture if available in the response
                    if (data.data.photo) {
                        $('#profilePicture').attr('src', data.data.photo);
                    }

                    // Redirect if needed
                    if (data.data.redirects === true && data.data.redirectTo) {
                        setTimeout(() => {
                            window.location.replace(data.data.redirectTo);
                        }, 3000); // Adjust delay as needed
                    }
                }

            } catch (error) {
                // Handle all errors and display an appropriate message
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-full-width"
                };

                // Display a specific error message if available, otherwise a generic one
                toastr.error(error.message || "An error occurred. Please try again.");
            } finally {
                // Return to normal state
                setTimeout(() => {
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                    $("#basicSettings :input").prop("readonly", false);
                }, 3000);
            }
        });
    };

    return {
        init: function() {
            updateBasicSettings();
        }
    };
}();

jQuery(document).ready(function() {
    settingsRequests.init();
});
