const settingsRequests = function (){

    // Process basic settings
    const updateBasicSettings = function (){
        // Process the form submission
        $('#basicSettings').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#basicSettings').attr('action');

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: baseURL,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function(){
                    $('.submit').attr('disabled', true);
                    $("#basicSettings :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text: "processing...",
                        size: "20"
                    });
                },
                success: function(data) {
                    // Handle error response
                    if (data.error === true) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-full-width",
                        }
                        toastr.error(data.data.error);

                        // Return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#basicSettings :input").prop("readonly", false);
                        }, 3000);
                    }
                    // Handle success response
                    if (data.error === 'ok') {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-full-width",
                        }
                        toastr.success(data.message);

                        // Update the profile picture if available in the response
                        if (data.data.photo) {
                            $('#profilePicture').attr('src', data.data.photo); // Assuming the image has an ID of 'profilePicture'
                        }

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#basicSettings :input").prop("readonly", false);

                            // Redirect only if redirects is true
                            if (data.data.redirects === true && data.data.redirectTo) {
                                window.location.replace(data.data.redirectTo);
                            }
                        }, 3000); // Adjust the delay as needed
                    }
                },
                error: function (jqXHR){
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-full-width",
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#basicSettings :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }

    return {
        init: function() {
            updateBasicSettings();
        }
    };
}();

jQuery(document).ready(function() {
    settingsRequests.init();
});
