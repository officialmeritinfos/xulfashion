const recoveryRequest=function (){
    const initiateSubmission=function (){
        //process the form submission
        $('#recovery').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#recovery').attr('action');
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
                    $("#recovery :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "please wait ...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true,
                            "positionClass": "toast-top-full-width"
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#recovery :input").prop("readonly", false);
                            $("#recovery")[0].reset();
                        }, 3000);
                    }
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
                            $("#recovery :input").prop("readonly", false);
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
                        // If Laravel validation errors exist (422 Unprocessable Entity)
                        if (jqXHR.responseJSON.errors) {
                            errorMessage = Object.values(jqXHR.responseJSON.errors).flat().join('<br>'); // Convert object to readable string
                        }
                        // If a general error message
                        else if (jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        }
                        // If your API uses `data.error`
                        else if (jqXHR.responseJSON.data && jqXHR.responseJSON.data.error) {
                            errorMessage = jqXHR.responseJSON.data.error;
                        }
                    }
                    // Handle non-JSON responses (e.g., 500 Internal Server Error with HTML output)
                    else if (jqXHR.responseText) {
                        errorMessage = jqXHR.responseText;
                    }

                    // Display error message in Toastr
                    toastr.error(errorMessage);

                    // Re-enable form inputs and hide loading overlay
                    $("#recovery :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                }

            });
        });
    }

    return {
        init: function() {
            initiateSubmission();
        }
    };
}();

jQuery(document).ready(function() {
    recoveryRequest.init();
});

