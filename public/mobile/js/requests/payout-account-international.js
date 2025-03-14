const internationalPayoutAccountRequests =function (){
    const otpFunctionalities = function () {
        $(document).ready(function () {
            let otpVerified = false;
            // Send OTP
            $(document).on('click', '.sendOtp', function () {
                const otpButton = $(this);
                const otpInput = $('input[name="otp"]');
                const verifyOtpButton = $('.verifyOtp');
                const resendOtpButton = $('.resendOTP');
                const otpUrl = otpButton.data('otp'); // URL to send OTP

                // Send OTP via AJAX
                $.ajax({
                    url: otpUrl,
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Include CSRF token
                    },
                    beforeSend: function () {
                        otpButton.attr('disabled', true).text('Sending...');
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success('OTP sent successfully. Please enter it to verify.');
                            otpInput.val(''); // Clear previous OTP input
                            otpButton.hide(); // Hide the Send OTP button
                            verifyOtpButton.show(); // Show the Verify OTP button
                            resendOtpButton.show(); // Show the Resend OTP button
                        } else {
                            toastr.error(response.message || 'Failed to send OTP.');
                        }
                        otpButton.attr('disabled', false).text('Send OTP');
                    },
                    error: function (jqXHR) {
                        toastr.error(jqXHR.responseJSON?.message || 'An error occurred while sending OTP.');
                        otpButton.attr('disabled', false).text('Send OTP');
                    }
                });
            });

            // Verify OTP
            $(document).on('click', '.verifyOtp', function () {
                const verifyOtpButton = $(this);
                const otpInputValue = $('input[name="otp"]').val(); // Get OTP value
                const otpVerifyUrl = verifyOtpButton.data('otp-verify'); // URL to verify OTP
                const resendOtpButton = $('.resendOTP');
                const otpInput = $('input[name="otp"]');

                if (!otpInputValue) {
                    toastr.error('Please enter the OTP to verify.');
                    return;
                }

                // Verify OTP via AJAX
                $.ajax({
                    url: otpVerifyUrl,
                    method: 'POST',
                    data: { otp: otpInputValue },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Include CSRF token
                    },
                    beforeSend: function () {
                        verifyOtpButton.attr('disabled', true).text('Verifying...');
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success('OTP verified successfully.');
                            verifyOtpButton.hide();
                            // resendOtpButton.hide();
                            // otpInput.hide();
                            otpVerified = true;
                            $('.submit-btn').show();
                        } else {
                            toastr.error(response.message || 'Failed to verify OTP.');
                        }
                        verifyOtpButton.attr('disabled', false).text('Verify OTP');
                    },
                    error: function (jqXHR) {
                        toastr.error(jqXHR.responseJSON?.message || 'An error occurred while verifying OTP.');
                        verifyOtpButton.attr('disabled', false).text('Verify OTP');
                    }
                });
            });

            // Resend OTP
            $(document).on('click', '.resendOTP', function () {
                const resendOtpButton = $(this);
                const otpUrl = resendOtpButton.data('otp-resend'); // URL to resend OTP
                const otpInput = $('input[name="otp"]');
                const verifyOtpButton = $('.verifyOtp');
                const sendOtpButton = $('.sendOtp');

                // Resend OTP via AJAX
                $.ajax({
                    url: otpUrl,
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Include CSRF token
                    },
                    beforeSend: function () {
                        resendOtpButton.attr('disabled', true).text('Resending...');
                    },
                    success: function (response) {
                        if (response.status) {
                            toastr.success('OTP resent successfully. Please enter it to verify.');
                            otpInput.val(''); // Clear previous OTP input
                            verifyOtpButton.show(); // Ensure the Verify OTP button is visible
                            sendOtpButton.hide(); // Hide the Send OTP button
                        } else {
                            toastr.error(response.message || 'Failed to resend OTP.');
                        }
                        resendOtpButton.attr('disabled', false).text('Resend OTP');
                    },
                    error: function (jqXHR) {
                        toastr.error(jqXHR.responseJSON?.message || 'An error occurred while resending OTP.');
                        resendOtpButton.attr('disabled', false).text('Resend OTP');
                    }
                });
            });

        });
    }
    const processPayoutForm = function () {
        $('#addInternationalSettlementAccount').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#addInternationalSettlementAccount').attr('action');
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
                    $("#addInternationalSettlementAccount :input").prop("readonly", true);
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
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#addInternationalSettlementAccount :input").prop("readonly", false);

                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        $('.submit').attr('disabled', false);
                        $(".submit").LoadingOverlay("hide");
                        $("#addInternationalSettlementAccount :input").prop("readonly", false);



                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#addInternationalSettlementAccount :input").prop("readonly", false);
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#addInternationalSettlementAccount :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    return {
        init: function() {
            otpFunctionalities();
            processPayoutForm();
        }
    };
}();

jQuery(document).ready(function() {
    internationalPayoutAccountRequests.init();
});
