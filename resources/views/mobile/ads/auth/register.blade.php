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
        <img class="img-fluid auth-bg" src="{{asset('marketplace/img/hero/fashion.jpg')}}" alt="auth_bg"/>
        <div class="auth-content">
            <div>
                <h2>Join {{$siteName}}</h2>
                <h4 class="p-0">
                    Create an account to find more fashion designers in your city
                </h4>
            </div>
        </div>
    </div>

    <form class="auth-form" id="registration" method="post" action="{{route('mobile.register.process')}}">
        <div class="custom-container row">
            <div class="form-group col-md-6">
                <label for="inputusername" class="form-label">Full Name</label>
                <div class="form-input mb-4">
                    <input type="text" class="form-control" id="inputusername" placeholder="Enter Your Name"  name="name"/>
                    <i class="iconsax icons" data-icon="user-1"></i>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputemail" class="form-label">Username</label>
                <div class="form-input mb-4">
                    <input type="text" class="form-control" id="inputemail" placeholder="Enter Your username"  name="username" />
                    <i class="iconsax icons" data-icon="user-2"></i>
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inputemail" class="form-label">Email id</label>
                <div class="form-input mb-4">
                    <input type="email" class="form-control" id="inputemail" placeholder="Enter Your Email"  name="email"/>
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
                <button class="btn auth-btn w-100 submit">Sign UP</button>
            </div>
            <div class="division">
                <span>OR</span>
            </div>

            <h4 class="signup pt-0">Already have an account ?<a href="{{route('mobile.login')}}"> Sign in</a></h4>
        </div>
    </form>
    <!-- create account section end-->
@push('js')
    <script src="{{asset('requests/auth/register.js')}}"></script>
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
                $('.submit').attr('disabled', true);
            } else {
                if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('strong-password');
                    $('#password-strength-status').html("Strong password");
                    $('.submit').attr('disabled', false);
                }
                else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('medium-password');
                    $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
                    $('.submit').attr('disabled', true);
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
                $('.submit').attr('disabled', true);
            } else {
                if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
                    $('#password-strength-statuss').removeClass();
                    $('#password-strength-statuss').addClass('strong-password');
                    $('#password-strength-statuss').html("Strong password");
                    $('.submit').attr('disabled', false);
                }
                else {
                    $('#password-strength-statuss').removeClass();
                    $('#password-strength-statuss').addClass('medium-password');
                    $('#password-strength-statuss').html("Medium (should include alphabets, numbers and special characters.)");
                    $('.submit').attr('disabled', true);
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
@endpush
@endsection