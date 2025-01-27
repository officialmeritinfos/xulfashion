@extends('company.layout.base')
@section('content')

    <!--
=============================================
    Hero Banner
=============================================
-->
    <div class="hero-banner-three z-1 position-relative pt-200 lg-pt-150">
        <div class="container position-relative">
            <div class="row">
                <div class="col-xl-10 col-lg-10 m-auto text-center">
                    <h1 class="hero-heading wow fadeInUp">Reach Retailers & Expand Your Manufacturing Business</h1>
                    <p class="fs-28 text-dark pt-40 lg-pt-30 pb-35 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        Connect with retailers, showcase your products, and simplify order management through {{$siteName}}. From shoes to clothing and baby products, we help manufacturers grow their reach effortlessly.
                    </p>
                    <form action="#" class="m-auto position-relative">
                        <a href="{{ route('home.download') }}" class="btn-three wow fadeInUp" data-wow-delay="0.2s">
                            Get Started Today
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="media d-flex justify-content-center mt-100 lg-mt-60">
            <div class="position-relative">
                <img src="{{asset('home/mobile/images/manufacturer-hero.png')}}" alt="Manufacturers Hero Illustration">
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_29.png')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_30.png')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.hero-banner-three -->


    <div class="block-feature-eight pt-250 xl-pt-200 md-pt-150 sm-pt-100 pb-180 xl-pb-150 lg-pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="title-four md-mb-20">
                        <h2 class="text-white">Trusted by Manufacturers Worldwide</h2>
                    </div>
                </div>
                <div class="col-xxl-5 col-lg-6 ms-auto">
                    <p class="font-manrope fs-24 pb-25 text-white">{{$siteName}} empowers manufacturers to connect with retailers, showcase products, and streamline order management. Build partnerships and grow your reach effortlessly.</p>
                </div>
            </div>
            <div class="wrapper mt-100 lg-mt-40">
                <div class="counter-slider-one">
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_02.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_09.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_31.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">5.2</span>K+</div>
                            <p class="font-manrope fs-24 text-dark">Retailers Connected</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_03.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_10.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_32.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">8.5</span>K+</div>
                            <p class="font-manrope fs-24 text-dark">Products Listed</p>
                        </div>
                    </div>
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_04.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_11.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_33.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">96</span>%</div>
                            <p class="font-manrope fs-24 text-dark">Customer Satisfaction</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block-feature-nine pt-180 xl-pt-150 lg-pt-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Effortless Product Listings</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                            Easily showcase your products on {{$siteName}}. Create detailed listings with images, descriptions, and pricing to attract retailers globally.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/effortless-product-listing.png')}}" alt="Effortless Product Listings">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Order Management Tools</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                            Track orders from retailers, manage shipping, and monitor inventory—all from one intuitive dashboard.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/order-management.png')}}" alt="Order Management Tools">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Seamless Retailer Connections</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                            Build lasting partnerships with retailers. Communicate directly through {{$siteName}} to ensure smooth transactions and a growing network.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/retailer-connection.png')}}" alt="Seamless Retailer Connections">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="block-feature-ten position-relative z-2 pt-150 lg-pt-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 m-auto">
                    <div class="title-four text-center mb-35 lg-mb-30">
                        <h2>What Makes Us Stand Out?</h2>
                    </div>
                </div>
            </div>
            <p class="fs-24 text-dark text-center font-manrope pb-70 lg-pb-40">
                {{$siteName}} connects manufacturers with retailers and offers tools to manage, promote, and grow your business effectively.
            </p>

            <div class="row justify-content-between">
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                            <img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt="">
                        </div>
                        <span>Streamlined Listings</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">
                            Create detailed product listings with customizable descriptions, images, and pricing to attract the right retailers.
                        </p>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                            <img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt="">
                        </div>
                        <span>Retailer Connections</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">
                            Build strong relationships with retailers through direct communication and order management tools.
                        </p>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                            <img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt="">
                        </div>
                        <span>Global Reach</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">
                            Expand your market reach by showcasing your products to a global audience of retailers and businesses.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="faq-section-three position-relative mt-150 lg-mt-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="title-four">
                        <div class="text-uppercase mb-10">FAQ</div>
                        <h2 class="fw-bold">Questions & Answers</h2>
                    </div>
                    <p class="fs-22 text-dark pe-xxl-5 mt-40 md-mt-10 mb-40">
                        Find your answers here. If you don’t find what you’re looking for, please don’t hesitate to contact us.
                    </p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    How can I list my products on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        You can easily list your products by signing up, creating detailed descriptions, uploading images, and setting pricing directly on {{$siteName}}.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    Can I connect with retailers on the platform?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, {{$siteName}} enables direct communication with retailers, allowing you to build strong partnerships and ensure smooth transactions.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Are there fees for listing products?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Listing products is free. {{$siteName}} charges a small commission on successful transactions to ensure transparent and affordable pricing.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Can I manage orders and inventory through {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Absolutely! {{$siteName}} provides order and inventory management tools to help you streamline operations and meet demand effectively.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    Is the platform suitable for international retailers?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, {{$siteName}} connects you with both local and international retailers, giving you access to a global market.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="fancy-banner-three pt-150 lg-pt-80 pb-150 lg-pb-80 position-relative z-1">
        <div class="container">
            <img src="{{asset($web->logo)}}" style="width: 150px;" alt="" class="m-auto">
            <div class="row">
                <div class="col-xl-8 m-auto text-center">
                    <h2 class="mt-30 mb-40 lg-mb-30">Connect Your Manufacturing Business to the Right Retailers</h2>
                    <p class="fs-28 mb-50 lg-mb-30">Sign up today and start building lasting partnerships.</p>
                    <a href="{{ route('home.download') }}" class="btn-eleven">Join Now</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_39.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_40.svg')}}" alt="" class="shapes shape_02">
    </div>



@endsection
