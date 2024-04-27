@extends('dashboard.layout.base')
@section('content')
    <div class="container-fluid">
        <div class="ui-kit-cards grid mb-24">
            <div class="col-12">
                <label for="inputEmail4" class="form-label">Choose Account Type</label>
                <div class="boxed-check-group boxed-check-primary row">
                    <label class="boxed-check col-md-6">
                        <input class="boxed-check-input" type="radio" name="accountType" value="1">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Merchant</h2>
                            <span>You intend to use {{$siteName}} to reach a wide audience as a tailor/seamstress/entrpreneur or model. </span>
                        </div>
                    </label>
                    <label class="boxed-check col-md-6">
                        <input class="boxed-check-input" type="radio" name="accountType" value="2">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>User</h2>
                            <span>You just want to browse for clothes or buy from our verified businesses</span>
                        </div>
                    </label>
                </div>
            </div>
            @include('dashboard.components.completeProfile.user_complete_profile')
            @include('dashboard.components.completeProfile.business_complete_profile')
        </div>

    </div>
    @push('js')
        <script>
            //display form content on account  type selection
            $('input[name="accountType"]').on('click', function () {
                var value = Number($(this).val());

                if (value === 1) {
                    setTimeout(() => {
                        $('#tutorData').slideToggle();
                        $('#schoolData').fadeOut();
                    }, 100)
                } else {
                    $('#tutorData').fadeOut();
                    $('#schoolData').slideToggle();
                }
            });
        </script>

        <script src="{{asset('requests/auth/completeProfile.js')}}"></script>
    @endpush
@endsection
