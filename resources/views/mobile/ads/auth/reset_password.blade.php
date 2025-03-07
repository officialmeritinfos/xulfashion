@extends('mobile.layouts.base')
@section('content')
    @push('css')
        <style>
            #password-strength-status {
                padding: 5px 10px;
                border-radius: 4px;
                margin-top: 5px;
                margin-bottom: 2rem;
            }

            .medium-password {
                background-color: #fd0;
            }

            .weak-password {
                background-color: #f50a3b;
            }

            .strong-password {
                background-color: #D5F9D5;
            }
            [data-theme="dark"] #password-strength-status {
                padding: 5px 10px;
                border-radius: 4px;
                margin-top: 5px;
                margin-bottom: 2rem;
                color: #0b0b0b;
            }
        </style>
        <style>
            #password-strength-statuss {
                padding: 5px 10px;
                border-radius: 4px;
                margin-top: 5px;
                margin-bottom: 2rem;
            }

            .medium-passwords {
                background-color: #fd0;
            }

            .weak-passwords {
                background-color: #f50a3b;
            }

            .strong-passwords {
                background-color: #D5F9D5;
            }
            [data-theme="dark"] #password-strength-statuss {
                padding: 5px 10px;
                border-radius: 4px;
                margin-top: 5px;
                margin-bottom: 2rem;
                color: #0b0b0b;
            }
        </style>
    @endpush

    <div class="auth-img">
        <img class="img-fluid auth-bg" src="{{asset('mobile/images/onboarding/change.svg')}}" alt="auth_bg" />
        <div class="auth-content">
            <div>
                <h2>Reset Your Password</h2>
            </div>
        </div>
    </div>

    <form class="auth-form" id="recovery" method="post" action="{{route('mobile.auth.recovery')}}">
        <div class="custom-container row">
            <div class="form-group">
                <label for="inputusername" class="form-label">Code</label>
                <div class="form-input mb-4">
                    <input type="number" class="form-control" id="inputusername" placeholder="Enter verification Code" name="code"/>
                    <i class="iconsax icons" data-icon="mail"></i>
                </div>
            </div>

            <div class="form-group col-md-6 col-12">
                <label for="inputPassword" class="form-label">Password</label>
                <div class="form-input input-group">
                    <input type="password" class="form-control" id="password" onkeyup="checkPasswordStrength();"
                           placeholder="Enter Your Password"  name="password"/>
                    <span class="input-group-text" id="toggle-password-visibility"><i class="bx bx-show"></i></span>
                </div>
                <div id="password-strength-status"></div>
            </div>
            <div class="form-group col-md-6 col-12">
                <label for="inputPassword" class="form-label">Confirm Password</label>
                <div class="form-input input-group">
                    <input type="password" class="form-control" id="passwords" placeholder="Enter Your Password"
                           onkeyup="checkPasswordStrengths();"
                           name="password_confirmation"/>
                    <span class="input-group-text" id="toggle-password-visibility"><i class="bx bx-show"></i></span>
                </div>
                <div id="password-strength-statuss"></div>
            </div>

            <div class="submit-btn">
                <button class="btn auth-btn w-100 submit">Reset Password</button>
            </div>
        </div>
        <div class="col-12 mt-3 text-white mb-3">
            <p class="create">Did not receive the mail?
                <span data-url="{{ route('mobile.auth.passwordRecover.resend') }}" class="submitResend">Resend</span>
            </p>
        </div>
    </form>

    @push('js')
        <script src="{{asset('requests/auth/account_recovery.js')}}"></script>
        <script>
            function checkPasswordStrength() {
                var number = /([0-9])/;
                var alphabets = /([a-zA-Z])/;
                var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
                var password = $('#password').val().trim();
                if (password.length < 8) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('weak-password');
                    $('#password-strength-status').html("Weak (should be atleast 8 characters, alphabets, numbers and special characters )");
                } else {
                    if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
                        $('#password-strength-status').removeClass();
                        $('#password-strength-status').addClass('strong-password');
                        $('#password-strength-status').html("Strong password");
                    }
                    else {
                        $('#password-strength-status').removeClass();
                        $('#password-strength-status').addClass('medium-password');
                        $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
                    }
                }
            }

            function checkPasswordStrengths() {
                var number = /([0-9])/;
                var alphabets = /([a-zA-Z])/;
                var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
                var password = $('#passwords').val().trim();
                if (password.length < 8) {
                    $('#password-strength-statuss').removeClass();
                    $('#password-strength-statuss').addClass('weak-password');
                    $('#password-strength-statuss').html("Weak (should be atleast 8 characters, alphabets, numbers and special characters )");
                } else {
                    if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
                        $('#password-strength-statuss').removeClass();
                        $('#password-strength-statuss').addClass('strong-password');
                        $('#password-strength-statuss').html("Strong password");
                    }
                    else {
                        $('#password-strength-statuss').removeClass();
                        $('#password-strength-statuss').addClass('medium-password');
                        $('#password-strength-statuss').html("Medium (should include alphabets, numbers and special characters.)");
                    }
                }
            }
            $(document).ready(function () {
                $('#toggle-password-visibility').click(function () {
                    let passwordInput = $('#password');
                    let icon = $(this).find('i');
                    if (passwordInput.attr('type') === 'password') {
                        passwordInput.attr('type', 'text');
                        icon.removeClass('bx-show').addClass('bx-hide');
                    } else {
                        passwordInput.attr('type', 'password');
                        icon.removeClass('bx-hide').addClass('bx-show');
                    }
                });

                $('#toggle-passwords-visibility').click(function () {
                    let passwordInput = $('#passwords');
                    let icon = $(this).find('i');
                    if (passwordInput.attr('type') === 'password') {
                        passwordInput.attr('type', 'text');
                        icon.removeClass('bx-show').addClass('bx-hide');
                    } else {
                        passwordInput.attr('type', 'password');
                        icon.removeClass('bx-hide').addClass('bx-show');
                    }
                });
            });
        </script>
        <script>
            $(function(){
                $('.submitResend').click(function(){
                    let url = $(this).data('url');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        method: "POST",
                        dataType:"json",
                        beforeSend:function(){
                            $('.submit').attr('disabled', true);
                            $("#registration :input").prop("readonly", true);
                            $(".submit").LoadingOverlay("show",{
                                text        : "please wait ...",
                                size        : "20"
                            });
                            $(".submitResend").LoadingOverlay("show",{
                                text        : "....",
                                size        : "20"
                            });
                        },
                        success:function(data)
                        {
                            if(data.error === 'ok')
                            {
                                toastr.options = {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                                toastr.info(data.message);
                                $('.submit').attr('disabled', false);
                                $(".submit").LoadingOverlay("hide");
                                $("#registration :input").prop("readonly", false);
                                //return to natural stage
                                setTimeout(function(){
                                    $('.submitResend').attr('disabled', false);
                                    $(".submitResend").LoadingOverlay("hide");
                                    // window.location.replace(data.data.redirectTo)
                                }, 30000);
                            }
                        },
                        error:function (jqXHR, textStatus, errorThrown){
                            toastr.options = {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.error(jqXHR.responseJSON.data.error);

                            $("#registration :input").prop("readonly", false);
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                        },
                    });
                })
            })
        </script>
    @endpush
@endsection
