@extends('company.layout.base')
@section('content')

    <!--
=============================================
    Hero Banner
==============================================
-->
    <div class="hero-banner-two z-1 position-relative mt-200 lg-mt-150">
        <div class="container position-relative">
            <div class="row">
                <div class="col-xl-10 col-lg-8 m-auto text-center">
                    <h1 class="hero-heading wow fadeInUp font-manrope">Showcase Your Fashion & Beauty Business</h1>
                    <p class="fs-28 font-manrope text-dark pt-5 pb-30 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        List your store, promote your services, and attract customers through {{$siteName}}’s free marketplace.
                    </p>
                    <a href="{{ route('mobile.app.base') }}" class="btn-three wow fadeInUp" data-wow-delay="0.2s">Start Listing Now</a>
                </div>
            </div>
            <img src="{{asset('home/mobile/images/marketplace.png')}}" alt="" class="w-100 mt-70 lg-mt-50 wow fadeInUp" data-wow-delay="0.3s">
        </div>
        <div class="client-logo-wrapper mt-80 lg-mt-40">
            <div class="container">
                <p class="font-manrope fs-24 fw-500 text-center mb-40">
                    Trusted by <span class="fw-600 text-dark">120+</span> fashion and beauty businesses
                </p>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_11.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_12.svg')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.hero-banner-two -->


    <!--
=============================================
    BLock Feature Four
=============================================
-->
    <div class="block-feature-four pt-150 lg-pt-80">
        <div class="container">
            <div class="title-two text-center mb-100 xl-mb-70 lg-mb-50">
                <h2>Features of {{$siteName}}’s Business Listing</h2>
            </div>
            <div class="row gx-xl-5">
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Free Business Listing</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s mt-auto">List your store for free and showcase your fashion and beauty business to potential customers effortlessly.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Enhanced Visibility</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">Upgrade your listing for premium visibility and attract more customers to your store or services.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Create and Manage Ads</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">Easily create engaging posts to promote your products or services and reach the right audience.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Booking and Selling</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">Allow customers to book your services or purchase your products directly from the marketplace.</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-four -->


    <!--
=============================================
    BLock Feature Fourteen
=============================================
-->
    <div class="block-feature-fourteen position-relative z-1 mt-150 lg-mt-70">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-10 m-auto">
                    <div class="text-center mb-80 lg-mb-40">
                        <div class="title-six">
                            <h2>Empower Your Fashion Business with Smart Listing</h2>
                        </div>
                        <p class="fs-24">Showcase your store on {{$siteName}}'s marketplace, reach local customers, and grow your business effortlessly with free or upgraded listings.</p>
                    </div>
                </div>
            </div>
            <div class="feature-tab">
                <nav class="filter-nav">
                    <div class="nav nav-tabs align-items-center justify-content-center justify-content-xl-between border-0" role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#free-listing" type="button" role="tab" aria-controls="free-listing" aria-selected="true">
                            <img src="{{asset('home/mobile/images/icon/free_listing_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/free_listing_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Free Business Listing
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#ad-posting" type="button" role="tab" aria-controls="ad-posting" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/ad_posting_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/ad_posting_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Create Ads
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#visibility" type="button" role="tab" aria-controls="visibility" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/visibility_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/visibility_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Premium Visibility
                        </button>
                    </div>
                </nav>
                <div class="mt-80 lg-mt-40">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="free-listing" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Free Business Listing</h2>
                                    </div>
                                    <p class="fs-22 mb-50">List your fashion or beauty store for free on {{$siteName}}’s marketplace and connect with potential customers in your area.</p>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/free_listing.png')}}" alt="Free Business Listing" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ad-posting" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Create Engaging Ads</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Promote your products or services by creating custom ads that grab attention and drive bookings or purchases.</p>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/ad_posting.png')}}" alt="Create Ads" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="visibility" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Gain Premium Visibility</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Upgrade to premium listings to boost your store’s visibility and attract more customers to your offerings.</p>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/premium_visibility.png')}}" alt="Premium Visibility" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <!-- /.feature-tab -->
        </div>
    </div>
    <!-- /.block-feature-fourteen -->

    <!--
=====================================================
    FAQ Section Three
=====================================================
-->
    <div class="faq-section-three position-relative mt-150 lg-mt-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="title-four">
                        <div class="text-uppercase mb-10">FAQ</div>
                        <h2 class="fw-bold">Questions & Answers</h2>
                    </div>
                    <p class="fs-22 text-dark pe-xxl-5 mt-40 md-mt-10 mb-40">Find your answers here. If you don’t find it, please contact us.</p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What is {{$siteName}}'s Business Listing Solution?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}}'s Business Listing Solution allows fashion and beauty businesses to showcase their stores on a dynamic marketplace, reach local customers, and grow their brand online.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    How can I list my business on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">You can list your business for free by signing up on {{$siteName}}. Create your profile, add details about your store, and start showcasing your products and services.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Can I create ads to promote my business?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes! {{$siteName}} allows businesses to create ads to promote their products and services. These ads help attract more visibility and engage potential customers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Is the business listing service free?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, listing your business on {{$siteName}} is free. However, there are paid options for upgrading your listing to gain premium visibility and attract more customers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    What is the premium listing feature?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">The premium listing feature allows your business to appear at the top of search results and get featured on the homepage, ensuring more visibility and customer engagement.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixA" aria-expanded="true" aria-controls="collapseSixA">
                                    Can I post services and receive bookings?
                                </button>
                            </h2>
                            <div id="collapseSixA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes! You can post your services and allow customers to book appointments directly through the platform. This feature makes it easy to manage and grow your business.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSevenA" aria-expanded="true" aria-controls="collapseSevenA">
                                    Is the platform only for businesses in Nigeria?
                                </button>
                            </h2>
                            <div id="collapseSevenA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">No, {{$siteName}}'s marketplace is open to businesses globally. However, some features like dedicated merchant accounts are specifically tailored for Nigerian businesses.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.faq-section-three -->


    <!--
    =====================================================
        Fancy Banner Five
    =====================================================
    -->
    <div class="fancy-banner-five position-relative z-1 mt-150 lg-mt-80">
        <div class="wrapper position-relative z-1 pt-110 lg-pt-80 pb-120 lg-pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 col-lg-9 m-auto text-center">
                        <div class="title-eight">
                            <h2 class="text-white"><span>1k+ </span> merchants are already using {{$siteName}}.Try it now!</h2>
                        </div>
                        <!-- /.title-eight -->
                        <p class="text-white fs-28 font-manrope pe-xxl-4 mt-30 mb-55">Try it risk free.</p>
                        <a href="{{ route('home.download') }}" class="btn-thirteen">Download Now!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.fancy-banner-five -->
@endsection
