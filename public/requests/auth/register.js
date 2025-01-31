const registerRequest=function (){
    const initiateRegistration=function (){
        //process the form submission
        $('#registration').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#registration').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#registration :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "please wait ...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true,
                            "positionClass": "toast-top-full-width"
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#registration :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-full-width"
                    };

                    let errorMessage = "An unexpected error occurred. Please try again."; // Default error message

                    if (jqXHR.responseJSON) {
                        // If API returned `data.error`, extract it (fixes the issue)
                        if (jqXHR.responseJSON.data && jqXHR.responseJSON.data.error) {
                            errorMessage = jqXHR.responseJSON.data.error;
                        }
                        // If validation errors exist, format them correctly
                        else if (jqXHR.responseJSON.errors) {
                            errorMessage = Object.values(jqXHR.responseJSON.errors).flat().join('<br>');
                        }
                        // If a general error message exists in `message`, use it
                        else if (jqXHR.responseJSON.message && jqXHR.responseJSON.message !== "validation.error") {
                            errorMessage = jqXHR.responseJSON.message;
                        }
                    }
                    // Handle non-JSON responses (Avoids displaying raw HTML error pages)
                    else if (jqXHR.responseText && jqXHR.responseText.trim().startsWith("{")) {
                        try {
                            let errorResponse = JSON.parse(jqXHR.responseText);
                            if (errorResponse.message) {
                                errorMessage = errorResponse.message;
                            }
                        } catch (e) {
                            // Fallback if JSON parsing fails
                        }
                    }
                    // Display error message in Toastr
                    toastr.error(errorMessage);

                    // Re-enable form inputs and hide loading overlay
                    $("#registration :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                }

            });
        });
    }

    return {
        init: function() {
            initiateRegistration();
        }
    };
}();

jQuery(document).ready(function() {
    registerRequest.init();
});

