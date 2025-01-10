const payoutAccountRequests =function (){
    const fetchBank = function () {
        // Wait for the document to be fully loaded
        $(document).ready(function () {
            // Fetch the bank link and branch code requirement
            const modal = $('.modal'); // Get the modal element
            const links = modal.find('.bankLink').val(); // Fetch the bankLink URL
            const hasBranch = modal.find('.hasBranch').val(); // Fetch if the bank branch code is needed.

            if (!links) {
                console.error('Bank link is missing.');
                return;
            }
            $('.submit-btn').hide();

            // Set up AJAX headers
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Perform the AJAX request
            $.ajax({
                url: links,
                method: "GET",
                dataType: "json",
                beforeSend: function () {
                    // Disable the submit button and show a loading overlay
                    modal.find('.submit').attr('disabled', true);
                    modal.find('.bank').LoadingOverlay("show", {
                        text: "",
                        size: "40"
                    });
                },
                success: function (data) {
                    if (data.error === true) {
                        // Show an error toast message
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-full-width",
                        };
                        toastr.error(data.data.error);

                        // Restore the button to its natural state
                        setTimeout(function () {
                            modal.find('.submit').attr('disabled', false);
                            modal.find('.bank').LoadingOverlay("hide");
                        }, 3000);
                        $('.modal').modal("hide");
                        return;
                    }

                    if (data.error === 'ok') {
                        const selectInput = modal.find('select[name="account_bank"]'); // Target the dropdown

                        // Clear existing options
                        selectInput.empty();

                        selectInput.append(
                            '<option value="">Select Bank</option>'
                        );
                        // Populate the dropdown with new options
                        $.each(data.data.banks, function (index, option) {
                            selectInput.append(
                                '<option value="' + option.code + '" data-bank-url="' + option.url + '">' + option.name + '</option>'
                            );
                        });

                        // Log message
                        console.log(data.message);

                        if (Number(hasBranch) === 1) {
                            $('.destination-inputs').show();
                        }

                        // Restore the button state
                        modal.find('.submit').attr('disabled', false);
                        modal.find('.bank').LoadingOverlay("hide");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Show an error toast message
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-full-width",
                    };
                    toastr.error(jqXHR.responseJSON.data.error || "An error occurred while fetching banks.");

                    // Restore the button state
                    modal.find('.submit').attr('disabled', false);
                    modal.find('.bank').LoadingOverlay("hide");
                    $('.modal').modal("hide");
                }
            });
        });
    };

    const fetchBankBranch = function () {
        $(document).on('change', '#account_bank', function () {
            const hasBranch = $('.hasBranch').val();
            const selectedBankValue = $(this).val(); // Get the value of the selected bank
            const selectedBank = $(this).find(':selected'); // Get the selected bank option object
            const branchUrl = selectedBank.data('bank-url'); // Get the data-bank-url from the selected option

            // Hide other inputs if an empty field for the bank is selected
            if (!selectedBankValue || selectedBankValue === '') {
                $('.other-inputs').hide();
                $('.destination-inputs').hide();
                return;
            }
            // Check if the bank requires destination branch code
            if (hasBranch !== '1') {
                // Hide the branch code input and exit if not required
                $('.destination-inputs').hide();
                $('.other-inputs').show();
                return;
            }

            if (!branchUrl) {
                console.error('Branch URL is missing for the selected bank.');
                toastr.error('No branch URL available for this bank.');
                return;
            }
            $('.other-inputs').hide();
            // Fetch the destination branch codes
            $.ajax({
                url: branchUrl,
                method: "GET",
                dataType: "json",
                beforeSend: function () {
                    $('#destination_branch_code').empty().append('<option>Loading...</option>');
                },
                success: function (response) {
                    if (response.error===true) {
                        // Show an error message if the response indicates a failure
                        toastr.error(response.data.error || 'Failed to retrieve branch codes.');
                        $('#destination_branch_code').empty().append('<option>No branches available</option>');
                        return;
                    }

                    // Populate the destination branch code dropdown
                    const branchSelect = $('#destination_branch_code');
                    branchSelect.empty(); // Clear previous options
                    branchSelect.append(
                        `<option value="">Select a branch</option>`
                    );
                    $.each(response.data.branches, function (index, branch) {
                        branchSelect.append(
                            `<option value="${branch.branch_code}">${branch.branch_name}</option>`
                        );
                    });

                    // Show the destination branch code inputs
                    $('.destination-inputs').show();

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Failed to fetch branch codes:', textStatus, errorThrown);
                    toastr.error('Failed to fetch branch codes. Please try again later.');
                    $('#destination_branch_code').empty().append('<option>Bank does not have branches.</option>');
                },
            });
        });
        $(document).on('change', '#destination_branch_code', function () {
            $('.other-inputs').show();
        });
    };
    const validateAccountNumber = function () {
        $(document).on('change', '#account_number, #account_bank', function () {
            const validateAccount = $('.validateAccount').val(); // Check if account validation is required
            const accountBank = $('#account_bank').val(); // Get the selected bank value
            const accountNumber = $('#account_number').val(); // Get the entered account number
            const accountNameField = $('.accountName'); // Reference to the account name field
            const url = $('.validateAccount').data('url'); // Reference to the url

            // Check if account validation is enabled and required inputs are present
            if (validateAccount !== '1' || !accountBank || !accountNumber) {
                accountNameField.hide();
                $('#account_name').val('');
                return;
            }

            // Send AJAX request to retrieve the account name
            $.ajax({
                url: url+'/'+accountBank+'/'+accountNumber,
                method: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Include CSRF token
                },
                beforeSend: function () {
                    // Optionally show a loading indicator
                    accountNameField.show();
                    $('#account_name').val('Fetching...');
                },
                success: function (response) {
                    if (response.error===true) {
                        // Handle errors, such as invalid account details
                        toastr.error(response.data.error || 'Unable to validate account.');
                        accountNameField.hide();
                        $('#account_name').val('');
                        $('.submit-btn').hide();
                        return;
                    }
                    if (response.error === 'ok') {
                        console.log(response.data)
                        // Populate the account name field and display it
                        $('#account_name').val(response.data.account.account_name || '');
                        accountNameField.show();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle AJAX errors
                    console.error('Account validation failed:', errorThrown);
                    toastr.error('Failed to validate account. Please try again later.');
                    accountNameField.hide();
                    $('#account_name').val('');
                    $('.submit-btn').hide();
                },
            });
        });
    };
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
                            resendOtpButton.hide();
                            otpInput.hide();
                            $('.otpSection').hide();
                            otpVerified = true; // Mark OTP as verified
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

            //make the submit button visible
            const updateSubmitButtonVisibility = function () {
                const passwordInput = $('input[name="password"]').val().trim(); // Get password input value
                const submitBtnContainer = $('.submit-btn'); // Reference to the submit button container

                // Show the submit button only if OTP is verified and password is not empty
                if (otpVerified && passwordInput !== '') {
                    submitBtnContainer.show();
                } else {
                    submitBtnContainer.hide();
                }
            };


        });
    }
    const processPayoutForm = function () {
        $('#addLocalSettlementAccount').submit(function(e) {
            e.preventDefault();
            var baseURL = $('#addLocalSettlementAccount').attr('action');
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
                    $("#addLocalSettlementAccount :input").prop("readonly", true);
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
                            $("#addLocalSettlementAccount :input").prop("readonly", false);

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
                        $("#addLocalSettlementAccount :input").prop("readonly", false);



                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#addLocalSettlementAccount :input").prop("readonly", false);
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
                    $("#addLocalSettlementAccount :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    }
    return {
        init: function() {
            fetchBank();
            fetchBankBranch();
            validateAccountNumber();
            otpFunctionalities();
            processPayoutForm();
        }
    };
}();

jQuery(document).ready(function() {
    payoutAccountRequests.init();
});
