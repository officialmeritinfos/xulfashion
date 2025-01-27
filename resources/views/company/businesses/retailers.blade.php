@extends('company.layout.base')
@section('content')

    <!--
=============================================
    Hero Banner
==============================================
-->
    <div class="hero-banner-five z-1 position-relative">
        <div class="wrapper position-relative z-1 pt-200 md-pt-150 pb-130 lg-pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-8">
                        <div class="badge-tag mt-30">Empower Your Retail Business</div>
                        <h1 class="hero-heading wow fadeInUp">Stock <span>Showcase</span> Sell</h1>
                        <p class="fs-28 font-manrope pt-35 pb-20 pe-xxl-5 wow fadeInUp" data-wow-delay="0.1s">
                            Your store, your style – grow your retail business with {{$siteName}}’s tools. Create storefronts, manage stock, and connect with fashion and beauty suppliers all in one place.
                        </p>

                        <div class="d-flex align-items-center flex-wrap wow fadeInUp" data-wow-delay="0.2s">
                            <a href="#" class="btn-thirteen mt-10 me-3">Start Selling Today</a>
                            <a class="btn-fourteen mt-10" data-fancybox href="{{ config('app.how-xulfashion-works-video') }}">Watch How It Works</a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{asset('home/mobile/images/retailer-hero.png')}}" alt="" class="illustration wow fadeInRight">

            <div class="container">
                <div class="d-flex align-items-center justify-content-between flex-wrap mt-100 lg-mt-60 md-mt-40">
                    <div class="fact-feature mt-30 d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle" style="border-color: #00DBE4; color: #00DBE4;"><i class="bi bi-check-lg"></i></div>
                        <h3>Open Your Storefront 60x Faster</h3>
                    </div>
                    <!-- /.fact-feature -->
                    <div class="fact-feature mt-30 d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle" style="border-color: #FFD542; color: #FFD542;"><i class="bi bi-check-lg"></i></div>
                        <h3>Boost Customer Engagement by 70%</h3>
                    </div>
                    <!-- /.fact-feature -->
                    <div class="fact-feature mt-30 d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle" style="border-color: #EF62E9; color: #EF62E9;"><i class="bi bi-check-lg"></i></div>
                        <h3>Save 4,000+ Hours Managing Inventory</h3>
                    </div>
                    <!-- /.fact-feature -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.hero-banner-five -->


    <div class="client-logo-wrapper border-bottom mt-80 lg-mt-40 pb-70 lg-pb-40">
        <div class="container">
            <p class="fs-24 text-dark fw-500 text-center mb-40">
                Over 1k+ retailers are growing their businesses with {{$siteName}}, connecting with customers, and selling faster.
            </p>
        </div>
    </div>


    <!--
    =====================================================
        BLock Feature Sixteen
    =====================================================
-->
    <div class="block-feature-sixteen pt-130 lg-pt-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-11 m-auto">
                    <div class="title-four text-center mb-80 lg-mb-40 pe-xl-3 ps-xl-3">
                        <h2 class="fw-bold">
                            Empower your retail business with {{$siteName}} – connect with suppliers, attract customers, and grow sales effortlessly.
                        </h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_28.svg')}}" alt="" class="icon m-auto">
                        <h4>Effortlessly Manage Inventory</h4>
                        <p class="fs-20 text-dark">Keep track of your stock levels and never run out of best-sellers.</p>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_29.svg')}}" alt="" class="icon m-auto">
                        <h4>Create an Engaging Storefront</h4>
                        <p class="fs-20 text-dark">Showcase your products beautifully and attract more customers.</p>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_30.svg')}}" alt="" class="icon m-auto">
                        <h4>Grow Your Customer Base</h4>
                        <p class="fs-20 text-dark">Reach more shoppers and increase your sales effortlessly.</p>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
            </div>

            <div class="pt-120 lg-pt-50">
                <div class="row">
                    <div class="col-lg-8 d-flex">
                        <div class="feature-block block-one w-100 mt-30" style="background: #FFEB80;">
                            <h3>Monitor Your Store’s Performance</h3>
                            <div class="row">
                                <div class="col-md-9">
                                    <p class="fs-24 text-dark">
                                        Keep track of sales, orders, and customer preferences in real-time to make informed decisions.
                                    </p>
                                </div>
                            </div>
                            <img src="{{asset('home/mobile/images/analytics.png')}}" alt="" class="w-100 mt-70 md-mt-40">
                            <img src="{{asset('home/mobile/images/shape/shape_43.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.feature-block -->
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="feature-block block-one w-100 mt-30" style="background: #76FFCE;">
                            <h3>Enhance Your Marketing</h3>
                            <div class="row">
                                <div class="col-12">
                                    <p class="fs-24 text-dark">
                                        Run promotional campaigns to attract customers and grow your retail business.
                                    </p>
                                </div>
                            </div>
                            <img src="{{asset('home/mobile/images/digital-planning.png')}}" alt="" class="w-100 mt-40">
                            <img src="{{asset('home/mobile/images/shape/shape_44.svg')}}" alt="" class="shapes shape_02">
                        </div>
                        <!-- /.feature-block -->
                    </div>
                    <div class="col-12 d-flex">
                        <div class="feature-block block-one w-100 mt-50 lg-mt-30 pe-0" style="background: #D3A7FF;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Collaborate with Suppliers and Vendors</h3>
                                    <div class="row">
                                        <div class="col-xxl-10">
                                            <p class="fs-24 text-dark">
                                                Build strong relationships with manufacturers and wholesalers to keep your store stocked with the latest fashion trends and beauty products.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <img src="{{asset('home/mobile/images/collaboration.png')}}" alt="" class="ms-auto mt-20 md-mt-40 mb-60 md-mb-10">
                                </div>
                            </div>
                            <img src="{{asset('home/mobile/images/shape/shape_45.svg')}}" alt="" class="shapes shape_03">
                        </div>
                        <!-- /.feature-block -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-sixteen -->



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
                    <p class="fs-22 text-dark pe-xxl-5 mt-40 md-mt-10 mb-40">
                        Have questions about selling as a retailer? Find answers here or feel free to contact us for more information.
                    </p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What is {{$siteName}}’s solution for retailers?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        {{$siteName}} provides an all-in-one platform for fashion and beauty retailers to create online storefronts, manage inventory, and reach customers both locally and globally.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    How do I set up my online store with {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Setting up your store is easy. Simply sign up, upload your product details, customize your storefront with our user-friendly tools, and start selling.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Can I manage inventory and track sales in real-time?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, {{$siteName}} allows you to monitor stock levels, track sales, and analyze customer preferences in real-time, so you always stay ahead.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    How does the payment system work?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Our platform supports multiple payment methods, including credit/debit cards, mobile wallets, and bank transfers. Transactions are secure, and you can withdraw your earnings anytime.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    Can I offer discounts and promotions?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Absolutely! {{$siteName}} allows you to create promotional campaigns, offer discounts, and engage customers to boost sales.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixA" aria-expanded="true" aria-controls="collapseSixA">
                                    Is {{$siteName}} suitable for small retailers?
                                </button>
                            </h2>
                            <div id="collapseSixA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, our platform is designed for both small and large retailers, providing the tools you need to scale your business at your own pace.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSevenA" aria-expanded="true" aria-controls="collapseSevenA">
                                    How do I promote my products effectively?
                                </button>
                            </h2>
                            <div id="collapseSevenA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        {{$siteName}} offers marketing tools and analytics to help you create targeted campaigns, showcase your products, and reach your audience effectively.
                                    </p>
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
                            <h2 class="text-white"><span>1k+ </span> retailers trust {{$siteName}} to grow their businesses.</h2>
                        </div>
                        <!-- /.title-eight -->
                        <p class="text-white fs-28 font-manrope pe-xxl-4 mt-30 mb-55">Join the movement today!</p>
                        <a href="{{ route('home.download') }}" class="btn-thirteen">Get Started!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.fancy-banner-five -->


@endsection
