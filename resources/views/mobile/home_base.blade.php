@extends('mobile.layouts.base')
@section('content')


    <form class="auth-form" target="_blank" style="margin-top: 10rem;">
        <div class="custom-container">

            <div class="submit-btn">
                <a href="{{route('login')}}" class="btn auth-btn w-100">Sign In</a>
            </div>
            <div class="division">
                <span>OR</span>
            </div>

            <div class="submit-btn">
                <a href="{{route('register')}}" class="btn auth-btn w-100">Sign Up</a>
            </div>
        </div>
    </form>
    <!-- login section end-->

@endsection
