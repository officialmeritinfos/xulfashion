@extends('company.layout.base')
@section('content')
    @push('css')
        @include('storeFrontGenericCss')
    @endpush

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
                            <p>
                                @if(getMobileType()->isPhone() && getMobileType()->isAndroidOS())
                                    Our APK is available for Android users while we continuously work to get the official
                                    listing on PlayStore. It has already been vetted and confirmed safe by malware scanners.
                                @endif
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
                            @if(getMobileType()->isPhone() && getMobileType()->isAndroidOS())
                                <button class="btn btn-primary btn-sm  btn-masco btn-primary-l05 download-btn" type="button" id="download-btn">
                                    Download Marketplace app
                                </button>
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



    @push('js')
        @include('storeFrontBasicInclude')
        <script>
            $(document).ready(function() {
                $('.download-btn').click(function() {
                    // Display a message to the user
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true,
                        "positionClass": "toast-top-full-width",
                    }
                    toastr.success('Your download is starting in the background. Please wait.');

                    // Make an asynchronous request using AJAX
                    $.ajax({
                        url: '{{ route("home.download-page.marketplace") }}',
                        method: 'GET',
                        xhrFields: {
                            responseType: 'blob' // Set the response type to blob
                        },
                        success: function(data, status, xhr) {
                            // Get the file name from the Content-Disposition header
                            var disposition = xhr.getResponseHeader('Content-Disposition');
                            var matches = /filename="([^"]*)"/.exec(disposition);
                            var fileName = (matches != null && matches[1]) ? matches[1] : 'xulfashion.apk';

                            // Create a link element to download the file
                            var link = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            link.href = url;
                            link.download = fileName;
                            document.body.appendChild(link);
                            link.click();
                            window.URL.revokeObjectURL(url);
                            link.remove(); // Clean up the link
                        },
                        error: function() {
                            toastr.options = {
                                "closeButton" : true,
                                "progressBar" : true,
                                "positionClass": "toast-top-full-width",
                            }
                            toastr.error('There was an error downloading the file. Please try again.');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
