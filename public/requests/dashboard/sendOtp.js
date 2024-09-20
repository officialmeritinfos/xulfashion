const otpRequests =function (){
    const sendOtp=function (){
        var link = $('.sendOtp').data('bs-otp');

        $('.sendOtp').on('click',function (){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: link,
                method: "POST",
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $(".sendOtp").LoadingOverlay("show",{
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
                            "positionClass": "toast-top-full-width",
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".sendOtp").LoadingOverlay("hide");

                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true,
                            "positionClass": "toast-top-full-width",
                        }
                        toastr.info(data.message);

                        $('.submit').attr('disabled', false);
                        $(".sendOtp").LoadingOverlay("hide");
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true,
                        "positionClass": "toast-top-full-width",
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $('.submit').attr('disabled', false);
                    $(".sendOtp").LoadingOverlay("hide");
                },
            });
        });
    }
    return {
        init: function() {
            sendOtp();
        }
    };
}();

jQuery(document).ready(function() {
    otpRequests.init();
});
