@extends('mobile.layouts.base')
@section('content')

    <div class="auth-img">
        <img class="img-fluid auth-bg" src="{{asset('mobile/images/onboarding/authentication.svg')}}" alt="auth_bg" />
        <div class="auth-content">
            <div>
                <h2>Two Factor Authentication</h2>
            </div>
        </div>
    </div>

    <div class="custom-container">
        <div class="otp-verification">
            <h4>We have sent a verification code to</h4>
            <h4 class="otp-number mt-2">{{$user->email}}</h4>
        </div>
        <form class="auth-form" id="login" method="post" action="{{route('mobile.auth.twoFactor')}}">
            @csrf
            <div class="form-group col-md-12 col-12">
                <label for="inputPassword" class="form-label">Verification OTP</label>
                <div class="form-input input-group">
                    <input type="password" class="form-control" id="password"
                           placeholder="Enter Code"  name="code"/>
                    <span class="input-group-text" id="toggle-password-visibility"><i class="bx bx-show"></i></span>
                </div>
                <div id="password-strength-status"></div>
            </div>
            <button class="btn auth-btn w-100 submit" role="button">Verify</button>
        </form>
        <div class="col-12 d-flex justify-content-between align-items-center text-white mb-4 mt-4">
            <p class="create mb-0">No email? <span data-url="{{ route('mobile.auth.twoFactor.resend') }}" class="submitResend">Resend</span></p>
            <p class="back-to-login mb-0">Back to  <a href="{{ route('mobile.login') }}">Login</a></p>
        </div>

    </div>
    <!-- otp section end -->

    @push('js')
        <script src="{{asset('mobile/js/otp.js')}}"></script>
        @include('basicInclude')
        <script src="{{asset('requests/auth/login.js')}}"></script>
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
