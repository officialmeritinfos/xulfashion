@extends('mobile.users.layout.plainBase')
@section('content')

    <section class="section-b-space pt-0">
        <div class="custom-container">
            <div class="empty-tab">
                <img class="img-fluid empty-img" src="{{asset("mobile/images/coming_soon.svg")}}" alt="" />

                <h2>Continuously Building!</h2>
                <h5 class="mt-3">
                    This tool will be available very soon, please stay tuned.
                </h5>

                <span onclick="history.back()"  class="btn theme-btn w-100 mt-5 back" role="button">Go Back</span>
            </div>
        </div>
    </section>

@endsection
