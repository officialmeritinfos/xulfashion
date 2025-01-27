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
                    <h1 class="hero-heading wow fadeInUp font-manrope">Streamline Your Inventory Like a Pro</h1>
                    <p class="fs-28 font-manrope text-dark pt-5 pb-30 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        Keep your fashion & beauty business running smoothly with real-time inventory management. Never miss a sale
                        or overstock again with tools that keep you in control.
                    </p>
                    <a href="{{ route('mobile.app.base') }}" class="btn-three wow fadeInUp" data-wow-delay="0.2s">Get Started Now</a>
                </div>
            </div>
            <img src="{{asset('home/mobile/images/inventory.png')}}" alt="" class="w-100 mt-70 lg-mt-50 wow fadeInUp" data-wow-delay="0.3s">
        </div>
        <div class="client-logo-wrapper mt-80 lg-mt-40">
            <div class="container">
                <p class="font-manrope fs-24 fw-500 text-center mb-40">
                    Optimize stock levels, minimize losses, and scale your business effortlessly with {{$siteName}}
                </p>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_11.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_12.svg')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.hero-banner-two -->


    <!--
		=====================================================
			BLock Feature Four
		=====================================================
		-->
    <div class="block-feature-four pt-150 lg-pt-80">
        <div class="container">
            <div class="title-two text-center mb-100 xl-mb-70 lg-mb-50">
                <h2>Features</h2>
            </div>
            <div class="row gx-xl-5">
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Real-Time Stock Updates</h3>
                                <img src="{{asset('home/mobile/images/shape/shape_08.svg')}}" alt="" class="shapes pointer">
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s mt-auto">
                                Effortlessly keep track of your inventory with automatic updates. Monitor product availability
                                in real-time to avoid overstocking or running out of stock.
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Low-Stock Alerts</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">
                                Never miss a restock opportunity! Receive timely notifications when items in your inventory are running low.
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Advanced Analytics </h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">
                                Gain insights into your sales trends and inventory performance with easy-to-read graphs and reports. Make data-driven decisions for your business.
                                "</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Multi-Location Support</h3>
                                <img src="{{asset('home/mobile/images/shape/shape_09.svg')}}" alt="" class="shapes pointer">
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">
                                Manage inventory across multiple locations or warehouses from a single dashboard, ensuring a streamlined experience.
                            </p>
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
       =====================================================
           BLock Feature Five
       =====================================================
       -->
    <div class="block-feature-five position-relative z-1 pt-150 lg-pt-80">
        <img src="{{asset('home/mobile/images/shape/shape_10.svg')}}" alt="" class="shapes shape_01">
        <div class="container">
            <div class="title-two text-center mb-100 xl-mb-70 lg-mb-50">
                <h2>What can you do with {{$siteName}} Inventory System?</h2>
            </div>
            <div class="feature-tab">
                <nav class="filter-nav">
                    <div class="nav nav-tabs align-items-center justify-content-center border-0" role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#construct" type="button" role="tab" aria-controls="construct" aria-selected="true">
                            <img src="{{asset('home/mobile/images/icon/icon_08.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_08_w.svg')}}" alt="" class="shapes icon icon_w">
                            Real-Time Stock Updates
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#quality" type="button" role="tab" aria-controls="quality" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_09.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_09_w.svg')}}" alt="" class="shapes icon icon_w">
                            Low-Stock Alerts
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#alternative" type="button" role="tab" aria-controls="alternative" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_10.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_10_w.svg')}}" alt="" class="shapes icon icon_w">
                            Inventory Analytics
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#enrich" type="button" role="tab" aria-controls="enrich" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_11.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_11_w.svg')}}" alt="" class="shapes icon icon_w">
                            Integrated Storefront
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#article" type="button" role="tab" aria-controls="article" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_12.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_12_w.svg')}}" alt="" class="shapes icon icon_w">
                            Multi-Location Management
                        </button>
                    </div>
                </nav>
                <div class="mt-70 xl-mt-50">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="construct" role="tabpanel" tabindex="0">
                            <img src="{{asset('home/mobile/images/live-analytics.png')}}" alt="" class="w-100">
                        </div>
                        <div class="tab-pane" id="quality" role="tabpanel" tabindex="0">
                            <img src="{{asset('home/mobile/images/lowstock.png')}}" alt="" class="w-100">
                        </div>
                        <div class="tab-pane" id="alternative" role="tabpanel" tabindex="0">
                            <img src="{{asset('home/mobile/images/inventory-analytics.png')}}" alt="" class="w-100">
                        </div>
                        <div class="tab-pane" id="enrich" role="tabpanel" tabindex="0">
                            <img src="{{asset('home/mobile/images/storefront-integration.png')}}" alt="" class="w-100">
                        </div>
                        <div class="tab-pane" id="article" role="tabpanel" tabindex="0">
                            <img src="{{asset('home/mobile/images/multi-location.png')}}" alt="" class="w-100">
                        </div>
                    </div>
                    <!-- /.tab-content -->

                </div>
            </div>
            <!-- /.feature-tab -->
        </div>
    </div>
    <!-- /.block-feature-five -->


    <!--
    =====================================================
        BLock Feature Six
    =====================================================
    -->
    <div class="block-feature-six position-relative z-2 pt-150 lg-pt-80">
        <div class="container">
            <div class="border-bottom mb-110 lg-mb-70 pb-60 lg-pb-30">
                <div class="row align-items-end">
                    <div class="col-xl-7 col-lg-6">
                        <div class="title-two text-center text-lg-start md-mb-30">
                            <h2 class="m0">Revolutionizing Inventory Management for Seamless Business Growth.</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-7 order-lg-last ms-auto">
                    <div class="ps-xxl-5">
                        <blockquote>With {{$siteName}}’s Inventory Solution, we’ve eliminated stockouts and improved customer satisfaction. Our sales increased by 40% in just three months."
                            <img src="{{asset('home/mobile/images/icon/icon_14.svg')}}" alt="" class="shapes icon"></blockquote>
                        <div class="media-block border-30 mt-70 lg-mt-30 d-flex align-items-end">
                            <div class="name-card w-100 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6>Paul Cole</h6>
                                    <span class="text-dark"> StyleEdge  inc</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-lg-first">
                    <div class="wrapper position-relative md-mt-40">
                        <div class="card-style-three position-relative z-1 mb-40 md-mb-20">
                            <div class="main-count fw-bold"><span class="counter">1,500</span>+</div>
                            <span class="fs-20">Businesses streamlined inventory operations.</span>
                            <img src="{{asset('home/mobile/images/shape/shape_14.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.card-style-three -->
                        <div class="card-style-three position-relative z-1 mb-40 md-mb-20">
                            <div class="main-count fw-bold"><span class="counter">3.2</span>X</div>
                            <span class="fs-20">Faster order processing with real-time tracking.</span>
                            <img src="{{asset('home/mobile/images/shape/shape_15.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.card-style-three -->
                        <div class="card-style-three position-relative z-1">
                            <div class="main-count fw-bold"><span class="counter">93</span>%</div>
                            <span class="fs-20">Accuracy in inventory forecasting and stock updates.</span>
                            <img src="{{asset('home/mobile/images/shape/shape_16.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.card-style-three -->
                        <img src="{{asset('home/mobile/images/shape/shape_13.svg')}}" alt="" class="shapes bg-shape">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-six -->


    <!--
    =====================================================
        FAQ Section Two
    =====================================================
-->
    <div class="faq-section-two position-relative mt-250 xl-mt-200 lg-mt-80 mb-200 xl-mb-150 lg-mb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="title-two mb-40">
                        <div class="pointer" style="background: #FFCE52;">Inventory Management <img src="{{asset('home/mobile/images/shape/shape_25.svg')}}" alt=""></div>
                        <h2>Questions & Answers</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two ms-xxl-4" id="accordionThree">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    What is {{$siteName}}'s Inventory Management Solution?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}}’s Inventory Management Solution is a powerful tool designed to help businesses in the fashion industry monitor stock levels, streamline order fulfillment, and forecast demand in real-time.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How does it help reduce inventory errors?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    <p class="fs-22">By using automated tracking and real-time updates, {{$siteName}}'s system minimizes human error, ensuring you always have accurate stock data.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Can I track inventory across multiple stores?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}} allows you to manage inventory for multiple storefronts and locations through a centralized platform, giving you full visibility of your stock.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-90 lg-mt-60">
                <div class="col-lg-5">
                    <div class="title-two mb-40">
                        <div class="pointer" style="background: #FF4BD8;">Features & Benefits <img src="{{asset('home/mobile/images/shape/shape_26.svg')}}" alt=""></div>
                        <h2>Core Capabilities</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two ms-xxl-4" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What features does the solution include?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Features include inventory tracking, real-time stock updates, demand forecasting, order management, and detailed analytics to ensure you stay ahead of your business needs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    Can I integrate it with my existing systems?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}}’s Inventory Management integrates seamlessly with popular e-commerce platforms, payment gateways, and accounting tools.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    How does it handle demand forecasting?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Using AI-powered analytics, the system predicts future demand based on historical sales data, seasonal trends, and other key metrics.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-90 lg-mt-60">
                <div class="col-lg-5">
                    <div class="title-two mb-40">
                        <div class="pointer" style="background: #00D9B2;">Support <img src="{{asset('home/mobile/images/shape/shape_27.svg')}}" alt=""></div>
                        <h2>Assistance & Security</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two ms-xxl-4" id="accordionFive">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneB" aria-expanded="false" aria-controls="collapseOneB">
                                    What kind of support is available?
                                </button>
                            </h2>
                            <div id="collapseOneB" class="accordion-collapse collapse" data-bs-parent="#accordionFive">
                                <div class="accordion-body">
                                    <p class="fs-22">Our team offers 24/7 support to address technical issues, onboarding guidance, and customization requests for your inventory needs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoB" aria-expanded="false" aria-controls="collapseTwoB">
                                    Is my inventory data secure?
                                </button>
                            </h2>
                            <div id="collapseTwoB" class="accordion-collapse collapse" data-bs-parent="#accordionFive">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, we use advanced encryption and cloud storage solutions to ensure your data is protected and only accessible by authorized personnel.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeB" aria-expanded="true" aria-controls="collapseThreeB">
                                    How do I get started with the solution?
                                </button>
                            </h2>
                            <div id="collapseThreeB" class="accordion-collapse collapse" data-bs-parent="#accordionFive">
                                <div class="accordion-body">
                                    <p class="fs-22">You can sign up for our Inventory Management Solution by contacting our sales team or starting for free through the {{$siteName}} platform.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_28.svg')}}" alt="" class="shapes shape_01">
    </div>
    <!-- /.faq-section-two -->


    <!--
		=====================================================
			Fancy Banner Two
		=====================================================
		-->
    <div class="fancy-banner-two pt-120 lg-pt-80 pb-150 xl-pb-120 lg-pb-80 position-relative z-1">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-7 m-auto text-center">
                    <h2>Thousands of Businesses are already using {{$siteName}}</h2>
                    <a href="{{ route('mobile.register') }}" class="btn-six">Join Now!</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_20.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_21.svg')}}" alt="" class="shapes shape_02">

    </div>
@endsection
