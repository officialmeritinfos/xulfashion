@extends('mobile.layouts.base')
@section('content')

    <div class="auth-img">
        <img class="img-fluid auth-bg" src="{{asset('mobile/images/onboarding/login.svg')}}" alt="auth_bg" />
        <div class="auth-content">
            <div>
                <h2>Hello Again!</h2>
                <h4 class="p-0">Welcome back, sign-in to continue your adventure on {{$siteName}}</h4>
            </div>
        </div>
    </div>

    <form class="auth-form" id="login" method="post" action="{{route('mobile.login.process')}}">
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
                    <i class="iconsax icons" data-icon="key"></i>
                </div>
            </div>
            <div class="option mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="remember" value="1"/>
                    <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                </div>
                <a class="forgot" href="{{route('mobile.recoverPassword')}}">Forgot password?</a>
            </div>

            <div class="submit-btn">
                <button class="btn auth-btn w-100 submit">Sign In</button>
            </div>
            <div class="division">
                <span>OR</span>
            </div>

            <h4 class="signup">Don’t have an account ?<a href="{{route('mobile.register')}}"> Sign up</a></h4>
        </div>
    </form>

    @push('js')

        <script src="{{asset('requests/auth/login.js')}}"></script>
    @endpush
@endsection
