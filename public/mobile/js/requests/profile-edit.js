const registerRequest=function (){
    const initiatebasicSettings=function (){
        //process the form submission
        $('#basicSettings').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#basicSettings').attr('action');
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
                    $("#basicSettings :input").prop("readonly", true);
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
                            $("#basicSettings :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);

                    // Re-enable form inputs and hide loading overlay
                    $("#basicSettings :input").prop("readonly", false);

                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");

                    grecaptcha.reset();
                }

            });
        });
    }



    return {
        init: function() {
            initiatebasicSettings();
        }
    };
}();

jQuery(document).ready(function() {
    registerRequest.init();
});
