const fundingRequest=function (){
    const initiateSubmission=function (){
        //process the form submission
        $('#fundMainBalance').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#fundMainBalance').attr('action');
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
                    $("#fundMainBalance :input").prop("readonly", true);
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
                            "positionClass": "toast-top-full-width",
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#fundMainBalance :input").prop("readonly", false);

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
                        console.log(data.data);-

                        $('.submit').attr('disabled', false);
                        $(".submit").LoadingOverlay("hide");
                        $("#fundMainBalance :input").prop("readonly", false);

                        $('.amount').val(data.data.amount);
                        $('.bank').val(data.data.bank);
                        $('.accNumber').val(data.data.accountNumber);
                        $('.ref').val(data.data.reference);

                        $('#paymentDetails').modal('show');

                        //return to natural stage
                        // setTimeout(function(){
                        //     $('.submit').attr('disabled', false);
                        //     $(".submit").LoadingOverlay("hide");
                        //     $("#fundMainBalance :input").prop("readonly", false);
                        //
                        //     $('.amount').val(data.amount);
                        //     $('.bank').val(data.bank);
                        //     $('.accNumber').val(data.accountNumber);
                        // }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true,
                        "positionClass": "toast-top-full-width",
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#fundMainBalance :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //convert Referral balance
    const convertReferralBalance=function (){
        //process the form submission
        $('#convertReferralBalance').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#convertReferralBalance').attr('action');
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
                    $("#convertReferralBalance :input").prop("readonly", true);
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
                            $("#convertReferralBalance :input").prop("readonly", false);

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

                        $('.submit').attr('disabled', false);
                        $(".submit").LoadingOverlay("hide");
                        $("#convertReferralBalance :input").prop("readonly", false);



                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#convertReferralBalance :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true,
                        "positionClass": "toast-top-full-width"
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#convertReferralBalance :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //withdraw from account balance
    const withdrawFromAccountBalance=function (){
        //process the form submission
        $('#withdrawMainBalance').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#withdrawMainBalance').attr('action');
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
                    $("#withdrawMainBalance :input").prop("readonly", true);
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
                            $("#withdrawMainBalance :input").prop("readonly", false);

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

                        $('.submit').attr('disabled', false);
                        $(".submit").LoadingOverlay("hide");
                        $("#withdrawMainBalance :input").prop("readonly", false);



                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#withdrawMainBalance :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true,
                        "positionClass": "toast-top-full-width"
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#withdrawMainBalance :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }

    return {
        init: function() {
            initiateSubmission();
            convertReferralBalance();
            withdrawFromAccountBalance();
        }
    };
}();

jQuery(document).ready(function() {
    fundingRequest.init();
});

