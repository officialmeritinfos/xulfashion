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
                            <img class="hero-image" src="{{asset('home/image/appmockup4.png')}}" alt="hero image" />
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
                                        Growing
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
                                @if(getMobileType()->isiOS())
                                    <p>
                                        To install this app on your iPhone or iPad:
                                        <ol>
                                            <li>Tap the <strong>Share</strong> button at the bottom of the Safari browser.</li>
                                            <li>Select <strong>Add to Home Screen</strong>.</li>
                                            <li>Confirm by tapping <strong>Add</strong> on the top-right corner.</li>
                                        </ol>
                                    </p>
                                @endif
                            @else
                                <div class="btn-group android-download-section">
                                    <button class="btn btn-primary btn-sm btn-masco btn-primary-l05 download-btn" type="button" id="install-client-btn">
                                        Download Now
                                    </button>
                                </div>
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
                        <h2 class="section-heading__title heading-md text-black">What can you do with the app?</h2>
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
                            <h3 class="feature-widget__title ">Anywhere you go</h3>
                            <p>
                                With the {{$siteName}} marketplace app, you can always find the Best tailors, models and beauty
                                spas in your area on the go.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="600">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h03-feature-2.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Easily Review Businesses</h3>
                            <p>
                                While this option is currently under development, it will be accessible first on the mobile.
                                You can easily drop a review for a merchant.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="500">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h03-feature-3.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">All-in-one tool</h3>
                            <p>
                               With the {{$siteName}} marketplace app, you will have an all-in-one tool to manage your
                                fashion business. We are slowly deploying more features from the web to the app,
                                and you will see the changes in real-time, only on the app.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-home-3">
        <div class="container">
            <div class="cta-home-3__inner">
                <div class="cta-home-3__image-block">
                    <div class="cta-home-3__image">
                        <img src="{{asset('home/image/appmockup4.webp')}}" alt="image alt">
                        <div class="cta-home-3__image-shape">
                            <img src="{{asset('home/image/cta/cta-3-shape.png')}}" alt="image alt">
                        </div>
                    </div>
                </div>
                <div class="cta-home-3__content-block">
                    <div class="cta-text-block">
                        <h2 class="cta-title heading-md text-black">Download now and start buying and selling online. </h2>
                        <p>
                            Our goal is simple - connect you to the right audience, the right customers. Instead of jumping from
                            one section to the other looking for the perfect fashion retailer, tailor/seamstress or designers,
                            we have made it a whole lot easier.
                        </p>
                    </div>
                    <div class="cta-button-group">
                        @if(getMobileType()->isPhone() && getMobileType()->isAndroidOS())
                            <span class="download-btn">
                                <img src="{{asset('home/image/common/play-store.png')}}" alt="image alt">
                            </span>
                        @else
                            <a href="#">
                                <img src="{{asset('home/image/apple-coming-soon.png')}}" alt="image alt" style="width: 150px;">
                            </a>
                            <a href="#">
                                <img src="{{asset('home/image/coming-soon-google.png')}}" alt="image alt" style="width: 150px;">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
