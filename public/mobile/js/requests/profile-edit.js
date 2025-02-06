const settingsRequests=function (){
    const updateBasicSettings=function (){
        //process the form submission
        $('#basicSettings').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#basicSettings').attr('action');
            var baseURLs='';
            var formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url:baseURL,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
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

                }

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
