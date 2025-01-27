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
                        <div class="badge-tag mt-30">Expand your reach</div>
                        <h1 class="hero-heading wow fadeInUp">create <span>connect</span> sell</h1>
                        <p class="fs-28 font-manrope pt-35 pb-20 pe-xxl-5 wow fadeInUp" data-wow-delay="0.1s">
                            Your fashion, your rules – build your business with {{$siteName}}’s all-in-one platform.
                            Design storefronts, manage bookings, and collaborate with your team like never before.
                        </p>

                        <div class="d-flex align-items-center flex-wrap wow fadeInUp" data-wow-delay="0.2s">
                            <a href="#" class="btn-thirteen mt-10 me-3">Get Started</a>
                            <a class="btn-fourteen mt-10" data-fancybox href="{{ config('app.how-xulfashion-works-video') }}">Watch How We do it</a>
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{asset('home/mobile/images/sell-online-hero.png')}}" alt="" class="illustration wow fadeInRight">

            <div class="container">
                <div class="d-flex align-items-center justify-content-between flex-wrap mt-100 lg-mt-60 md-mt-40">
                    <div class="fact-feature mt-30 d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle" style="border-color: #00DBE4; color: #00DBE4;"><i class="bi bi-check-lg"></i></div>
                        <h3>Launch Your Storefront 60x Faster</h3>
                    </div>
                    <!-- /.fact-feature -->
                    <div class="fact-feature mt-30 d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle" style="border-color: #FFD542; color: #FFD542;"><i class="bi bi-check-lg"></i></div>
                        <h3>Experience a 70% Growth in Customer Engagement.</h3>
                    </div>
                    <!-- /.fact-feature -->
                    <div class="fact-feature mt-30 d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle" style="border-color: #EF62E9; color: #EF62E9;"><i class="bi bi-check-lg"></i></div>
                        <h3>Save 4,000+ Hours of Business Management Every Year.</h3>
                    </div>
                    <!-- /.fact-feature -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.hero-banner-five -->



    <div class="client-logo-wrapper border-bottom mt-80 lg-mt-40 pb-70 lg-pb-40">
        <div class="container">
            <p class="fs-24 text-dark fw-500 text-center mb-40">Over 1k+ merchants are using {{$siteName}} to sell online & faster.</p>
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
                            Streamline operations, boost sales, and manage your fashion business seamlessly with
                            {{$siteName}}.
                        </h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_28.svg')}}" alt="" class="icon m-auto">
                        <h4>Collaborate with Your <br>Team Easily. </h4>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_29.svg')}}" alt="" class="icon m-auto">
                        <h4>Organize Your Storefront  <br> Effortlessly</h4>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_30.svg')}}" alt="" class="icon m-auto">
                        <h4>Track Orders & Business Performance  <br> with Ease.</h4>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
            </div>



            <div class="pt-120 lg-pt-50">
                <div class="row">
                    <div class="col-lg-8 d-flex">
                        <div class="feature-block block-one w-100 mt-30" style="background: #FFEB80;">
                            <h3>Track Store Performance</h3>
                            <div class="row">
                                <div class="col-md-9">
                                    <p class="fs-24 text-dark">
                                        Stay on top of orders, inventory, and booking schedules to ensure a smooth business workflow.
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
                            <h3>Plan Marketing Campaigns</h3>
                            <div class="row">
                                <div class="col-12">
                                    <p class="fs-24 text-dark">
                                        Create and execute tailored marketing campaigns to increase visibility and attract more customers.
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
                                    <h3>Seamless Team Collaboration for Selling Fashion Online</h3>
                                    <div class="row">
                                        <div class="col-xxl-10">
                                            <p class="fs-24 text-dark">
                                                Collaborate with your team to manage your online storefront, list products on the marketplace,
                                                and coordinate efficiently to deliver top-notch services to your customers.
                                                {{$siteName}} makes it easy to manage operations for your fashion business, whether
                                                you’re running a boutique or a large-scale fashion brand.
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
                    <p class="fs-22 text-dark pe-xxl-5 mt-40 md-mt-10 mb-40">Find your answers here. If you don’t find it, please contact us.</p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What is {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}} is an all-in-one platform designed to help fashion businesses sell online, manage bookings, and connect with customers globally.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    How can I sell my products on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">You can sell products by creating your own online storefront or listing your items in the {{$siteName}} marketplace. The platform provides tools to manage inventory, track sales, and process payments easily.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Can I manage bookings and appointments on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}}’s integrated booking system allows customers to schedule appointments with fashion professionals such as tailors, designers, and models.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    How secure are transactions on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">All transactions are secured using our escrow system, ensuring funds are only released once both parties are satisfied with the transaction.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    Can I customize my online storefront?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}} offers customizable themes and tools to help you design a storefront that reflects your brand identity.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixA" aria-expanded="true" aria-controls="collapseSixA">
                                    Is there support for international payments?
                                </button>
                            </h2>
                            <div id="collapseSixA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}} supports various payment methods, including international payments, ensuring seamless transactions for customers worldwide.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSevenA" aria-expanded="true" aria-controls="collapseSevenA">
                                    Can I track my sales and performance?
                                </button>
                            </h2>
                            <div id="collapseSevenA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Absolutely. {{$siteName}} is working to provide as many analytics tools as possible that allows you to monitor sales, customer trends, and overall business performance.</p>
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
