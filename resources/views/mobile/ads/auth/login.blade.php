@extends('mobile.layouts.base')
@section('content')

    <div class="auth-img">
        <img class="img-fluid auth-bg" src="{{asset('mobile/images/onboarding/login.svg')}}" alt="auth_bg" />
        <div class="auth-content">
            <div>
                <h2>Hello Again!</h2>
                <h4 class="p-0" style="color: #9F2B68;">Welcome back, sign-in to continue your adventure on {{$siteName}}</h4>
            </div>
        </div>
    </div>

    <form class="auth-form" id="login" method="post" action="{{route('mobile.login.process')}}">
        @csrf
        <div class="custom-container">
            <div class="form-group">
                <label for="inputusername" class="form-label">Email</label>
                <div class="form-input mb-4">
                    <input type="email" class="form-control" id="inputusername" placeholder="Enter Your Email" name="email"/>
                    <i class="iconsax icons" data-icon="mail"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="form-label">Password</label>
                <div class="form-input">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter Your Password" name="password"/>
                    <i class="bx bx-show toggle-password-visibility"></i>
                </div>
            </div>
            <div class="option mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="remember" value="1"/>
                    <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                </div>
                <a class="forgot" href="{{route('mobile.recoverPassword')}}">Forgot password?</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">ReCaptcha:</label>
                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="submit-btn">
                <button class="btn auth-btn w-100 submit">Sign In</button>
            </div>
            <div class="division">
                <span>OR</span>
            </div>
            <ul class="social-media">
                <li>
                    <a href="{{ route('mobile.auth.google-authentication') }}">
                        <img class="img-fluid icons" src="{{asset('mobile/images/svg/google.svg')}}" alt="facebook" />
                    </a>
                </li>
            </ul>

            <h4 class="signup">Don’t have an account ?<a href="{{route('mobile.register')}}"> Sign up</a></h4>
        </div>
    </form>

    @push('js')
        <script src="{{asset('requests/auth/login.js')}}"></script>
        <script>
            $(document).ready(function () {
                $('.toggle-password-visibility').click(function () {
                    let passwordInput = $('#inputPassword');
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
