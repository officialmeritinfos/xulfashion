@extends('dashboard.layout.base')
@section('content')

    <div class="container-fluid">

        @if($user->isVerified==1)
            <div class="row mt-5">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                <h5 class="display-7 text-center">
                                    Account Verified
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center">
                                <i class="bx bx-badge-check text-success"
                                   style="font-size: 5rem;"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($user->isVerified==4)
            <div class="row mt-5">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                <h5 class="display-7 text-center">
                                    Compliance Submitted
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center">
                                We are currently reviewing your compliance information.
                                Once verified, your account will be activated and you will be able to send applications.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-5">
                <div class="col-md-10 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="jumbotron">
                                <h5 class="display-7 text-center">
                                    Verification Pending
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center">
                                You need to verify your account first before you can start sending applications. This helps
                                us to keep our community safe from predators, and also to prevent ML.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui-kit-cards grid mb-24">

                @include('dashboard.users.settings.kyc')
            </div>

        @endif

    </div>


    @push('js')
        <script>
            $('select[name="docType"]').on('change',function (){

                var title = $(this).find(':selected').data('title');
                var hasBack = $(this).find(':selected').data('back');


                var value = $(this).val();

                if(value===''){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error('You must select an option.');

                    $('#idUploads').hide();
                    return;
                }

                if (Number(hasBack)===1){
                    $('.backImage').show()
                    $('.idNumber').removeClass('col-md-6').addClass('col-md-4');
                    $('.frontImage').removeClass('col-md-6').addClass('col-md-4');
                }else{
                    $('.backImage').hide()
                    $('.idNumber').removeClass('col-md-4').addClass('col-md-6');
                    $('.frontImage').removeClass('col-md-4').toggleClass('col-md-6');
                }
                $('.idName').html(title)

                $('.idUploads').show();

            });

            $('.country').selectize()
        </script>

        <script src="{{asset('requests/dashboard/tutor/settings.js')}}"></script>
    @endpush

@endsection
