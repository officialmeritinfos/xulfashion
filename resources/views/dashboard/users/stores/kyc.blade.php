@extends('dashboard.layout.base')
@section('content')

    <div class="container-fluid">

        @if($store->isVerified==1)
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
        @elseif($store->isVerified==4)
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
                                Once verified, your business will be able to receive payments online.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-5 mb-24">
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
                               @if($user->isVerified==4)
                                    Your personal KYC has been received and is currently being reviewed.
                                @elseif($user->isVerified!=1)
                                    You need to verify your Identity first before you can submit verification for your
                                   store.
                                @else
                                   Personal KYC has been verified - proceed to verify your store.
                               @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui-kit-cards grid mb-24">

                @include('dashboard.users.stores.kyc_form')
            </div>

        @endif

    </div>


    @push('js')
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush

@endsection
