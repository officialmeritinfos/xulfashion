@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')
    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$pageName}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--start product details-->
    <section class="section-padding">
        <div class="container">

            <div class="separator my-3">
                <div class="line"></div>
                <h3 class="mb-0 h3 fw-bold">Easily Contact Us</h3>
                <div class="line"></div>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-xl-7">
                    <div class="p-3 border">
                        <div class="address mb-3">
                            <h5 class="mb-0 fw-bold">Address</h5>
                            <p class="mb-0 font-12">{!! $store->address !!}</p>
                        </div>
                        <hr>
                        <div class="phone mb-3">
                            <h5 class="mb-0 fw-bold">Phone</h5>
                            <p class="mb-0 font-13">{{$store->phone}}</p>
                        </div>
                        <hr>
                        <div class="email mb-3">
                            <h5 class="mb-0 fw-bold">Email</h5>
                            <p class="mb-0 font-13">{{$store->email}}</p>
                        </div>
                        <hr>
                        <div class="working-days mb-0">
                            <h5 class="mb-0 fw-bold">Working Days</h5>
                            <p class="mb-0 font-13">{!! $setting->workingDay !!}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!--start product details-->

@endsection
