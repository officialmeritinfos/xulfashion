<!doctype html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="{{$siteName}}"/>
    <meta name="description" content="{{$web->description}}"/>
    <meta name="keywords" content="{{$web->keywords}}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/bootstrap.min.css')}}">
    <!-- Owl Theme Default Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/owl.theme.default.min.css')}}">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/owl.carousel.min.css')}}">
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/animate.min.css')}}">
    <!-- Remixicon CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/remixicon.css')}}">
    <!-- boxicons CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/boxicons.min.css')}}">
    <!-- MetisMenu Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/metismenu.min.css')}}">
    <!-- Simplebar Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/simplebar.min.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/style.css')}}">
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/dark-mode.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/responsive.css')}}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
    <!-- Title -->
    <title>{{$siteName}} - {{$pageName}}</title>

    @include('genericCss')
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
</head>

<body class="body-bg-f5f5f5">
<!-- Start Preloader Area -->
<div class="preloader">
    <div class="content">
        <div class="box"></div>
    </div>
</div>
<!-- End Preloader Area -->

<!-- Start User Area -->
<section class="user-area">
    <div class="container">
        <div class="user-form-content">
            <h3>Register</h3>
            <p>Register in to continue to {{$siteName}}.</p>

            <form class="user-form" id="registration" method="post" action="{{route('auth.register')}}">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label>Name<sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" name="name"
                                   placeholder="Enter your legal name">
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Username<sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" name="username"
                                   placeholder="This is your username">
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Email<sup class="text-danger">*</sup></label>
                            <input class="form-control" type="email" name="email" placeholder="Enter your email">
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Country<sup class="text-danger">*</sup></label>
                            <select class="form-control selectize" name="country">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->iso3}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Phone<sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" name="phone"
                                   placeholder="This is your Contact number">
                        </div>
                    </div>

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label>Account Currency<sup class="text-danger">*</sup></label>
                            <select class="form-control selectize" name="currency">
                                <option value="">Select account Currency</option>
                                @foreach($fiats as $fiat)
                                    <option value="{{$fiat->code}}">{{$fiat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Password<sup class="text-danger">*</sup></label>
                            <input class="form-control" id="password" type="password" name="password" placeholder="Enter your password"
                            onkeyup="checkPasswordStrength();">
                        </div>
                        <div id="password-strength-status"></div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label>Repeat password<sup class="text-danger">*</sup></label>
                            <input class="form-control" type="password" name="password_confirmation"
                                   placeholder="Please repeat your password">
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label>Referral<sup>(optional)</sup></label>
                            <input class="form-control" type="text" name="referral" placeholder="Enter your referral"
                            value="{{$referral}}">
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="default-btn submit" type="submit">
                            Sign up
                        </button>
                    </div>


                    <div class="col-12">
                        <p class="create">Already have an account?
                            <a href="{{route('login')}}">Sign in</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- End User Area -->

<div class="dark-bar">
    <a href="#" class="d-flex align-items-center">
        <span class="dark-title">Enable Dark Theme</span>
    </a>

    <div class="form-check form-switch">
        <input type="checkbox" class="checkbox" id="darkSwitch">
    </div>
</div>

<!-- Start Go Top Area -->
<div class="go-top">
    <i class="ri-arrow-up-s-fill"></i>
    <i class="ri-arrow-up-s-fill"></i>
</div>
<!-- End Go Top Area -->

<!-- Jquery Min JS -->
<script src="{{asset('dashboard/js/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle Min JS -->
<script src="{{asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
<!-- Owl Carousel Min JS -->
<script src="{{asset('dashboard/js/owl.carousel.min.js')}}"></script>
<!-- Metismenu Min JS -->
<script src="{{asset('dashboard/js/metismenu.min.js')}}"></script>
<!-- Simplebar Min JS -->
<script src="{{asset('dashboard/js/simplebar.min.js')}}"></script>
<!-- mixitup Min JS -->
<script src="{{asset('dashboard/js/mixitup.min.js')}}"></script>
<!-- Dark Mode Switch Min JS -->
<script src="{{asset('dashboard/js/dark-mode-switch.min.js')}}"></script>
<!-- Form Validator Min JS -->
<script src="{{asset('dashboard/js/form-validator.min.js')}}"></script>
<!-- Contact JS -->
<script src="{{asset('dashboard/js/contact-form-script.js')}}"></script>
<!-- Ajaxchimp Min JS -->
<script src="{{asset('dashboard/js/ajaxchimp.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{asset('dashboard/js/custom.js')}}"></script>
@include('basicInclude')
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
</script>
</body>
</html>
