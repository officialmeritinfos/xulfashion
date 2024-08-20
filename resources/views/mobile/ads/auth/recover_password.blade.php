@extends('mobile.layouts.base')
@section('content')

    <!-- forgot password section start -->
    <div class="auth-img">
        <img class="img-fluid auth-bg" src="{{asset('mobile/images/onboarding/forgotpassword.svg')}}" alt="auth_bg" />
        <div class="auth-content">
            <div>
                <h2>Forgot Password?</h2>
            </div>
        </div>
    </div>

    <form class="auth-form" id="recovery" method="post" action="{{route('mobile.recover.process')}}">
        <div class="custom-container">
            <div class="form-group">
                <label for="inputusername" class="form-label">Email id</label>
                <div class="form-input mb-4">
                    <input type="text" class="form-control" id="inputusername" placeholder="Enter Your Email" name="email"/>
                    <i class="iconsax icons" data-icon="mail"></i>
                </div>
            </div>

            <div class="submit-btn">
                <button  class="btn auth-btn w-100 submit">Send OTP</button>
            </div>
        </div>
    </form>
    <!-- forgot password section end-->

    @push('js')

        @include('basicInclude')
        <script src="{{asset('requests/auth/account_recovery.js')}}"></script>
    @endpush

@endsection
