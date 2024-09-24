@extends('mobile.users.layout.plainBase')
@section('content')

    <section class="section-b-space pt-0">
        <div class="custom-container">
            <div class="empty-tab">
                <img class="img-fluid empty-img" src="{{asset("mobile/images/ads.svg")}}" alt="" style="width: 60%;"/>

                <h2>Continuously Building!</h2>
                <h5 class="mt-3">
                    <p>
                        This feature is only available on Web. Please login through the web to post an AD. Click the copy
                        button below to copy the link.
                    </p>
                </h5>

                <span  class="btn theme-btn w-100 mt-5 cpy-link" role="button"
                       data-clipboard-text="{{route('login')}}">
                    Copy
                </span>
            </div>
        </div>
    </section>

@endsection
