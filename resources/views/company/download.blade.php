@extends('company.layout.base')
@section('content')

    <div class="home-3_hero-section">
        <div class="home-3_hero-shape">
            <img src="{{asset('home/image/home-3/hero-shape.png')}}" alt="image alt" />
        </div>
        <div class="container">
            <div class="row row--custom">
                <div class="col-lg-4 offset-lg-1 col-sm-4 col-5" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="300">
                    <div class="home-3_hero-image-block">
                        <div class="home-3_hero-image">
                            <img class="hero-image" src="{{asset('home/image/home-3/hero-mobile.png')}}" alt="hero image" />
                            <div class="home-3_hero-image-shape-1">
                                <img src="{{asset('home/image/home-3/hero-image-shape-1.svg')}}" alt="image shape" />
                            </div>
                            <div class="home-3_hero-image-shape-2">
                                <img src="{{asset('home/image/home-3/hero-image-shape-2.svg')}}" alt="image shape" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-10" data-aos-duration="1000" data-aos="fade-right" data-aos-delay="300">
                    <div class="home-3_hero-content">
                        <div class="home-3_hero-content-text">
                            <h1 class="hero-content__title heading-xl text-black">
                                Find the Best Fashion Dealers on the Go
                            </h1>
                            <p>
                                {{$siteName}} is better on the app with richer features to interact with merchants.
                                Book Merchants, rate and leave review when you use the {{$siteName}}, and more...
                            </p>
                        </div>
                        <div class="home-3_hero-content-stat-wrapper">
                            <div class="home-3_hero-content-stat">
                                <div class="home-3_hero-content__customer-count">
                                    <img src="{{asset('home/image/home-3/avatar.png')}}" alt="hero 3 avatar" />
                                    <p>
                                        64,739
                                        <span> Happy Customers </span>
                                    </p>
                                </div>
                                <div class="divider"></div>
                                <div class="home-3_hero-content__rating-count">
                                    <p>
                                        4.8/5
                                        <span>
                    <img src="{{asset('home/image/home-3/stars.png')}}" alt="hero 3 stars" />
                    Rating
                  </span>
                                    </p>
                                </div>
                            </div>
                            @if(getMobileType()->isPhone())
                                @if(getMobileType()->isAndroidOS())
                                    <a href="" class="btn-masco btn-primary-l03 btn-shadow rounded-pill"><span>
                                    Download On Android
                                </span></a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Feature Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_feature-section section-padding-100">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                    <div class="section-heading">
                        <h2 class="section-heading__title heading-md text-black">Ultimate method &amp; amazing features to change your life</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center gutter-y-default">
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="700">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h03-feature-1.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Monitor your diet easily</h3>
                            <p>Track the times you eat, the foods you eat, portion sizes, and notes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="600">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h03-feature-2.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Give health &amp; fitness tips</h3>
                            <p>Exercise is very important for us to be fit and healthy&amp; every tips.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="500">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h03-feature-3.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">All-in-one health tool</h3>
                            <p>It can help you set fitness goals, it with wearable fitness technology.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
