const loginRequest=function (){
    const initiateSubmission=function (){
        //process the form submission
        $('#login').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#login').attr('action');
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
                    $("#login :input").prop("readonly", true);
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
                            $("#login :input").prop("readonly", false);
                            $("#login")[0].reset();
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
                            $("login :input").prop("readonly", false);
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
                        // If it's a validation error
                        if (jqXHR.responseJSON.errors) {
                            errorMessage = Object.values(jqXHR.responseJSON.errors).flat().join('<br>'); // Convert object to readable string
                        }
                        // If it's a general API error response
                        else if (jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        }
                        // If your API uses `data.error`
                        else if (jqXHR.responseJSON.data && jqXHR.responseJSON.data.error) {
                            errorMessage = jqXHR.responseJSON.data.error;
                        }
                    }
                    // Handle non-JSON responses (e.g., HTML error pages)
                    else if (jqXHR.responseText) {
                        errorMessage = jqXHR.responseText;
                    }

                    // Display error message in Toastr
                    toastr.error(errorMessage);

                    // Re-enable form inputs and hide loading overlay
                    $("#login :input").prop("readonly", false);
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
    loginRequest.init();
});

