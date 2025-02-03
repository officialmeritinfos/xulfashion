@extends('company.layout.base')
@section('content')

    <!--
		=============================================
			Hero Banner
		==============================================
		-->
    <div class="hero-banner-six z-1 position-relative">
        <div class="wrapper position-relative z-1 pt-250 xl-pt-200 md-pt-150 pb-180 xl-pb-100 lg-pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <h1 class="hero-heading wow fadeInUp pe-xxl-5">Designed for  <span>Fashion,</span> Built for You</h1>
                        <p class="fs-24 pt-35 pb-20 pe-xxl-5 wow fadeInUp" data-wow-delay="0.1s">
                            The {{$siteName}} app gives you the power to grow your business, connect with customers, and
                            create your unique fashion journey—all from your fingertips.
                        </p>

                        <div class="d-flex align-items-center flex-wrap wow fadeInUp" data-wow-delay="0.2s">
                            <button href="#" class="btn-seven color-two mt-10 me-3 install-client-btn">Install - It’s free</button>
                            <a class="btn-sixteen mt-10" href="{{ route('mobile.app.base') }}" target="_blank">Use Web</a>
                        </div>

                        <div class="d-flex align-items-center mt-75 md-mt-40">
                            <img src="{{asset('home/mobile/images/assets/avatar.png')}}" alt="">
                            <div class="rating">
                                <div class="fw-500 text-dark fs-20">Rated 4.8 on Trustpilot</div>
                                <ul class="style-none d-flex">
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                    <li><i class="bi bi-star-fill"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="illustration">
                <img src="{{asset('home/mobile/images/download.png')}}" alt="" class="w-100">
            </div>
            <img src="{{asset('home/mobile/images/assets/bg_09.png')}}" alt="" class="shapes bg-shape">
        </div>
    </div>
    <!-- /.hero-banner-six -->





    <!--
    =====================================================
        Fancy Banner Six
    =====================================================
    -->
    <div class="fancy-banner-six position-relative z-1 mt-60 lg-mt-30">
        <div class="wrapper position-relative">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <h2>We've revolutionized fashion and beauty retail</h2>
                    </div>
                    <div class="col-xl-5 col-lg-6 ms-auto">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="counter-block-two">
                                    <div class="main-count fw-500 color-dark">$<span class="counter">100</span>k+</div>
                                    <p class="fs-22">Processed Transactions</p>
                                </div>
                                <!-- /.counter-block-two -->
                            </div>
                            <div class="col-sm-5">
                                <div class="counter-block-two">
                                    <div class="main-count fw-500 color-dark"><span class="counter">1</span>k+</div>
                                    <p class="fs-22">Merchants Onboarded</p>
                                </div>
                                <!-- /.counter-block-two -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_51.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_52.svg')}}" alt="" class="shapes shape_02">
        <img src="{{asset('home/mobile/images/shape/shape_53.svg')}}" alt="" class="shapes shape_03">
    </div>
    <!-- /.fancy-banner-six -->






    <!--
    =====================================================
        Block Feature Seventeen
    =====================================================
    -->
    <div class="block-feature-seventeen position-relative z-1 mt-150 lg-mt-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-6 m-auto">
                    <div class="title-nine text-center mb-60 lg-mb-10">
                        <div class="upper-title">Main Features</div>
                        <h2>Awesome features that will interest you</h2>
                    </div>
                    <!-- /.title-nine -->
                </div>
            </div>

            <div class="row gx-xxl-5">
                <div class="col-lg-4">
                    <div class="card-style-eight text-center mt-35 wow fadeInUp">
                        <img src="{{asset('home/mobile/images/icon/icon_34.png')}}" alt="" class="icon m-auto">
                        <h5>Custom Storefront</h5>
                        <p class="ps-xxl-4 pe-xxl-4">
                            Create your unique online store with themes, branding, and a smooth shopping experience.
                        </p>
                    </div>
                    <!-- /.card-style-eight -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-eight text-center mt-35 wow fadeInUp" data-wow-delay="0.1s">
                        <img src="{{asset('home/mobile/images/icon/icon_35.png')}}" alt="" class="icon m-auto">
                        <h5>Advanced Analytics</h5>
                        <p class="ps-xxl-4 pe-xxl-4">
                            Gain insights into sales, customer trends, and performance with our intuitive dashboards
                        </p>
                    </div>
                    <!-- /.card-style-eight -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-eight text-center mt-35 wow fadeInUp" data-wow-delay="0.2s">
                        <img src="{{asset('home/mobile/images/icon/icon_36.png')}}" alt="" class="icon m-auto">
                        <h5>Expert Support</h5>
                        <p class="ps-xxl-4 pe-xxl-4">
                            Dedicated support for merchants to help you grow and maintain your business efficiently.
                        </p>
                    </div>
                    <!-- /.card-style-eight -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-seventeen -->





@endsection
