@extends('mobile.users.layout.base')
@section('content')
    <div class="main mt-2 mb-5">
        <div class="container-fluid text-center">
            <a href="{{completedProfileMobile('mobile.user.payments.merchant.index')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                Merchant Dashboard
            </a>
        </div>
    </div>

    <section class="section-b-space">
        <div class="custom-container">

            <div class="card border-info shadow-sm">
                <div class="card-body d-flex align-items-start">
                    <div class="me-3">
                        <i class="bi bi-exclamation-circle-fill text-info fs-3"></i>
                    </div>
                    <div>
                        <h5 class="card-title fw-bold text-info">Heads Up!</h5>
                        <p class="card-text">
                            This is for <strong>Merchants only</strong>. If you have made payments on the platform, you can find your payments on their respective pages.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
