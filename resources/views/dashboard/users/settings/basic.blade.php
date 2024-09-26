@extends('dashboard.layout.base')
@section('content')

    <div class="container-fluid">
        <form id="basicSettings" action="{{route('user.settings.basic.update')}}" method="post"
              enctype="multipart/form-data">
            @csrf

            <div class="submit-property-form product-upload mt-3">
                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-12 mt-3">
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="sales"
                                           name="emailNotification"
                                        {{($settings->emailNotification==1)?'checked':''}}>
                                    <label class="form-check-label" for="sales">
                                        Receive email notifications
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Receive notifications for activities on your account including logins etc.
                                           You will still get a login notification if you have two-factor authentication active on your account."></i>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="cancelledSub"
                                           name="newsletter"
                                        {{($settings->newsletters==1)?'checked':''}}>
                                    <label class="form-check-label" for="cancelledSub">
                                        Receive our newsletters
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Join our newsletter and receive tips on getting hired on {{$siteName}}"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="failedSubCharge"
                                           name="withdrawalNotification"
                                        {{($settings->withdrawalNotification==1)?'checked':''}}>
                                    <label class="form-check-label" for="failedSubCharge">
                                        Receive notification for debits
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Receive notifications when an account debiting takes place"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="productRating"
                                           name="depositNotification"
                                        {{($settings->depositNotification==1)?'checked':''}}>
                                    <label class="form-check-label" for="productRating">
                                        Receive notifications for account credits
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Get notified for every account crediting activity"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" value="1" type="checkbox" id="productRatings"
                                           name="collectPayment"
                                        {{($settings->collectPayment==1)?'checked':''}}>
                                    <label class="form-check-label" for="productRatings">
                                        Receive payments on {{$siteName}}
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="Your employers will have to pay you through this channel"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit"
                            class="btn btn-outline-success rounded submit">
                        Update settings
                    </button>
                </div>
            </div>

        </form>
    </div>

    @push('js')
        <script src="{{asset('requests/dashboard/tutor/settings.js')}}"></script>
    @endpush
@endsection
