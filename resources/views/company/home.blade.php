@extends('company.layout.base')
@section('content')


    <!--
    =============================================
        Hero Banner
    ==============================================
    -->
    <div class="hero-banner-eight bg-twelve z-1 position-relative pt-250 xl-pt-200 md-pt-150 pb-160 xl-pb-140 md-p0">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7 col-md-10">
                    <h1 class="hero-heading wow fadeInUp">Click, Connect.  <span>Drive Sales</span>  with Ease..</h1>
                    <p class="fs-28 text-white font-manrope pt-35 lg-pt-20 pb-40 lg-pb-20 pe-xxl-5 wow fadeInUp" data-wow-delay="0.1s">
                        Seamlessly manage your storefront, bookings, and payments with {{$siteName}}—the ultimate all-in-one
                        platform for Fashion and Beauty Businesses.
                    </p>

                    <div class="wow fadeInUp" data-wow-delay="0.2s">
                        <form action="" class="d-flex align-items-center justify-content-between flex-wrap mb-15">
                            <a href="{{ route('home.download') }}" class="btn-five color-two tran3s">Download Now</a>
                        </form>
                        <ul class="style-none d-flex flex-wrap">
                            <li><i class="bi bi-check2"></i> No Card required</li>
                            <li><i class="bi bi-check2"></i> Free to list</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="illustration">
                <img src="{{asset('home/mobile/images/assets/bg_14.png')}}" alt="">
                <img src="{{asset('home/mobile/images/assets/person.png')}}" alt="" class="shapes person-img">
                <img src="{{asset('home/mobile/images/assets/card_20.png')}}" alt="" class="shapes shape_01">
            </div>
        </div>
    </div>
    <!-- /.hero-banner-eight -->



    <div class="client-logo-wrapper border-bottom mt-60 pb-70 lg-pb-50">
        <div class="container">
            <p class="fs-24 text-dark fw-500 text-center mb-40">
                Thousands of fashion and beauty businesses trust {{ $siteName }} to simplify their operations, sell seamlessly, and drive success.
            </p>
            <div class="partner-logo-one">
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_01.png')}}" alt="" class="m-auto"></div>
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_02.png')}}" alt="" class="m-auto"></div>
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_03.png')}}" alt="" class="m-auto"></div>
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_04.png')}}" alt="" class="m-auto"></div>
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_05.png')}}" alt="" class="m-auto"></div>
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_06.png')}}" alt="" class="m-auto"></div>
                <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_03.png')}}" alt="" class="m-auto"></div>
            </div>
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
                            Streamline Operations, Boost Sales with the Ultimate Fashion & Beauty Platform
                        </h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_28.svg')}}" alt="" class="icon m-auto">
                        <h4>Create Your Online Storefront & get <br>Found</h4>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_29.svg')}}" alt="" class="icon m-auto">
                        <h4>Receive Bookings and Manage Clients <br>  Effortlessly</h4>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-seven position-relative text-center mt-30 pb-45 lg-pb-30">
                        <img src="{{asset('home/mobile/images/icon/icon_30.svg')}}" alt="" class="icon m-auto">
                        <h4>Track Sales, Orders, and Business Growth <br> in Real-Time</h4>
                    </div>
                    <!-- /.card-style-seven -->
                </div>
            </div>



            <div class="pt-120 lg-pt-50">
                <div class="row">
                    <div class="col-lg-8 d-flex">
                        <div class="feature-block block-one w-100 mt-30" style="background: #FFEB80;">
                            <h3>Manage Storefront</h3>
                            <div class="row">
                                <div class="col-md-9">
                                    <p class="fs-24 text-dark">
                                        Create and customize your online storefront to showcase your products and services.
                                        Sell directly to your customers while enjoying the benefits of a marketplace that
                                        connects you with thousands of potential buyers.
                                    </p>
                                </div>
                            </div>
                            <img src="{{asset('home/mobile/images/dashboards.png')}}" alt="" class="w-100 mt-70 md-mt-40">
                            <img src="{{asset('home/mobile/images/shape/shape_43.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.feature-block -->
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="feature-block block-one w-100 mt-30" style="background: #76FFCE;">
                            <h3>Organize Events</h3>
                            <div class="row">
                                <div class="col-12">
                                    <p class="fs-24 text-dark">
                                        Plan and manage events like fashion shows, exhibitions, and training sessions with
                                        ease. Sell tickets directly through the platform and track registrations in real-time.
                                    </p>
                                </div>
                            </div>
                            <img src="{{asset('home/mobile/images/event-management.png')}}" alt="" class="w-100 mt-40">
                            <img src="{{asset('home/mobile/images/shape/shape_44.svg')}}" alt="" class="shapes shape_02">
                        </div>
                        <!-- /.feature-block -->
                    </div>
                    <div class="col-12 d-flex">
                        <div class="feature-block block-one w-100 mt-50 lg-mt-30 pe-0" style="background: #D3A7FF;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Issue Invoices & Get Paid</h3>
                                    <div class="row">
                                        <div class="col-xxl-10">
                                            <p class="fs-24 text-dark">
                                                Simplify payments with professional invoicing tools. Send invoices, track payments, and receive funds seamlessly through secure escrow payments.
                                            </p>
                                        </div>
                                    </div>
                                    <ul class="style-none list-item mt-50">
                                        <li>Generate and Send Invoices</li>
                                        <li>Track Payments in Real-Time</li>
                                        <li>Secure Escrow Payments</li>
                                        <li>Automate Financial Workflows</li>
                                        <li>And many more...</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <img src="{{asset('home/mobile/images/invoice.png')}}" alt="" class="ms-auto mt-20 md-mt-40 mb-60 md-mb-10">
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


    <!--    =====================================================
        Feedback Section Five
        =====================================================
        -->
    <div class="feedback-section-five position-relative z-1 mt-150 lg-mt-80">
        <div class="wrapper position-relative z-1 pt-150 lg-pt-80 pb-150 lg-pb-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="title-eight pe-xxl-3">
                            <h2 class="text-white">Everything You Need to Grow Your   <span>Fashion & Beauty </span> Business.</h2>
                        </div>
                        <!-- /.title-eight -->
                        <p class="text-white fs-28 font-manrope pe-xxl-4 mt-30 mb-55 md-mb-40">
                            Simplify your operations, expand your reach, and deliver exceptional service with
                            {{$siteName}}.
                            Whether you're running a boutique, salon, or fashion school, our platform offers tailored solutions
                            to manage payments, analytics, customer loyalty, and more—all in one place.
                        </p>
                        <a href="{{ route('home.download') }}" class="btn-thirteen">Join Now!</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.wrapper -->
        <img src="{{asset('home/mobile/images/shape/shape_46.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_47.svg')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.feedback-section-five -->

    <!--
    =====================================================
        Block Feature Twenty One
    =====================================================
    -->
    <div class="block-feature-twentyOne pt-150 lg-pt-80">
        <div class="container">
            <div class="row">
                <div class="col-xxl-10 col-xl-9 col-lg-8 m-auto">
                    <div class="title-ten text-center mb-90 lg-mb-40">
                        <h2>Effortlessly Accept Payments from Anywhere</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 order-lg-last d-flex flex-column">
                    <div class="feature-block block-one w-100">
                        <div class="row gx-0">
                            <div class="col-sm-6">
                                <div class="counter-block text-center border-style">
                                    <div class="main-count font-Montserrat"><span class="counter">98</span>%</div>
                                    <p class="fs-20 text-dark">98% Transaction Success Rate</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-block text-center">
                                    <div class="main-count font-Montserrat"><span class="counter">100</span>%</div>
                                    <p class="fs-20 text-dark">Escrow Security</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="feature-block block-two mt-50 lg-mt-30 w-100">
                        <div class="d-flex">
                            <img src="{{asset('home/mobile/team/chijiokeemmanuel.jpeg')}}" alt="" class="avatar rounded-circle">
                            <div class="name">
                                <h6>Chijioke Emmanuel,</h6>
                                <span class="f-20 text-dark">CAO, {{$siteName}}</span>
                            </div>
                        </div>
                        <blockquote>
                            With secure payments and seamless transactions, we’ve grown our global customer base significantly.
                        </blockquote>
                        <ul class="style-none d-flex flex-wrap justify-content-between">
                            <li><span><img src="{{asset('home/mobile/images/logo/p_logo_50.png')}}" alt=""></span></li>
                            <li><span><img src="{{asset('home/mobile/images/logo/p_logo_51.png')}}" alt=""></span></li>
                            <li><span><img src="{{asset('home/mobile/images/logo/p_logo_52.png')}}" alt=""></span></li>
                            <li><span><img src="{{asset('home/mobile/images/logo/p_logo_53.png')}}" alt=""></span></li>
                            <li><span><img src="{{asset('home/mobile/images/logo/p_logo_54.png')}}" alt=""></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 d-flex">
                    <div class="feature-block block-three w-100 d-flex align-items-end justify-content-center me-xxl-4 md-mt-40">
                        <img src="{{asset('home/mobile/images/checkout1.png')}}" alt="" class="screen">
                        <img src="{{asset('home/mobile/images/shape/shape_79.png')}}" alt="" class="shapes shape_01">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-twentyOne -->


    <!--
    =====================================================
        Counter Section One
    =====================================================
    -->
    {{--    <div class="counter-section-one mt-80 lg-mt-50">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row align-items-center">--}}
    {{--                <div class="col-lg-3 col-md-4">--}}
    {{--                    <div class="counter-block d-inline-block">--}}
    {{--                        <div class="main-count font-Montserrat"><span class="counter">13</span>k+</div>--}}
    {{--                        <p class="text-center fs-22 text-dark">Project Completed</p>--}}
    {{--                    </div>--}}
    {{--                    <!-- /.counter-block -->--}}
    {{--                </div>--}}
    {{--                <div class="col-lg-6 col-md-4">--}}
    {{--                    <div class="counter-block position-relative z-1 text-center pt-35 pb-35">--}}
    {{--                        <div class="main-count font-Montserrat"><span class="counter">200</span>k+</div>--}}
    {{--                        <p class="text-center fs-22">Worldwide Clients</p>--}}
    {{--                    </div>--}}
    {{--                    <!-- /.counter-block -->--}}
    {{--                </div>--}}
    {{--                <div class="col-lg-3 col-md-4 text-end">--}}
    {{--                    <div class="counter-block d-inline-block">--}}
    {{--                        <div class="main-count font-Montserrat"><span class="counter">720</span></div>--}}
    {{--                        <p class="text-center fs-22 text-dark">Experts</p>--}}
    {{--                    </div>--}}
    {{--                    <!-- /.counter-block -->--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- /.counter-section-one -->



    <!--
    =====================================================
        Block Feature Twenty Two
    =====================================================
    -->
    <div class="block-feature-twentyTwo bg-thirteen position-relative z-1 pt-180 xl-pt-130 lg-pt-80 pb-150 xl-pb-120 lg-pb-80 mt-150 lg-mt-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-7">
                    <div class="pe-xxl-5">
                        <div class="title-ten">
                            <div class="upper-title text-uppercase">Features</div>
                            <h2>Get <span class="position-relative z-1">Discovered <span class="line" style="background: #FF5B00;"></span></span> & Grow your business.</h2>
                        </div>
                        <p class="fs-28 text-dark pt-65 xl-pt-50 md-pt-30 pb-80 xl-pb-50 md-pb-30">
                            {{ $siteName }} connects your business to customers actively searching for fashion and beauty services.
                            From visibility to seamless management, we make growth easy.
                        </p>
                        <a href="{{ route('mobile.register') }}" class="btn-five color-two tran3s">Try It Now</a>
                    </div>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/directory.png')}}" alt="" class="shapes shape_01">
        <div class="container mt-100 md-mt-50">
            <div class="row gx-xxl-5">
                <div class="col-md-4">
                    <div class="feature mt-20">
                        <div class="num fw-500">01</div>
                        <p class="fw-500">Get Found by New Customers</p>
                    </div>
                    <!-- /.feature -->
                </div>
                <div class="col-md-4">
                    <div class="feature mt-20">
                        <div class="num fw-500">02</div>
                        <p class="fw-500">Simplify Business Operations</p>
                    </div>
                    <!-- /.feature -->
                </div>
                <div class="col-md-4">
                    <div class="feature mt-20">
                        <div class="num fw-500">03</div>
                        <p class="fw-500">Make Data-Driven Decisions</p>
                    </div>
                    <!-- /.feature -->
                </div>

            </div>
        </div>
    </div>
    <!-- /.block-feature-twentyTwo -->


    <!--
    =====================================================
        Block Feature Twenty Three
    =====================================================
    -->
    <div class="block-feature-twentyThree mt-180 xl-mt-150 lg-mt-100">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-lg-8 m-auto">
                    <div class="title-ten text-center mb-55 lg-mb-20">
                        <h2>Reasons Our <span class="position-relative z-1">Businesses<span class="line" style="background: #FFC92E;"></span></span> Love
                            {{ $siteName }}</h2>
                    </div>
                </div>
            </div>

            <div class="row gx-xxl-5">
                <div class="col-lg-4">
                    <div class="card-style-ten mt-35">
                        <div class="icon d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_40.png')}}" alt=""></div>
                        <h4>Effortless Payments</h4>
                    </div>
                    <!-- /.card-style-ten -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-ten mt-35">
                        <div class="icon d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_41.png')}}" alt=""></div>
                        <h4>Streamlined Operations</h4>
                    </div>
                    <!-- /.card-style-ten -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-ten mt-35">
                        <div class="icon d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_42.png')}}" alt=""></div>
                        <h4>Customer Growth & Loyalty</h4>
                    </div>
                    <!-- /.card-style-ten -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-twentyThree -->




    <!--
    =====================================================
        Feedback Section Eight
    =====================================================
    -->
    <div class="feedback-section-eight position-relative bg-twelve z-1 pt-150 lg-pt-80 pb-170 lg-pb-80 mt-180 xl-mt-150 lg-mt-80">
        <div class="container">
            <div class="wrapper">
                <div class="row align-items-center">
                    <div class="col-lg-7 order-lg-last">
                        <img src="{{asset('home/mobile/images/icon/icon_37.svg')}}" alt="">
                        <div class="feedback-slider-five">
                            <div class="item">
                                <blockquote class="font-Montserrat">"
                                    We are empowering fashion and beauty businesses to streamline operations and grow their customer base effortlessly
                                    "</blockquote>
                                <div class="name fs-24 text-dark">
                                    <h6>Michael Erastus, </h6>
                                    <span>CEO, {{$siteName}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.feedback-slider-five -->
                    </div>
                    <div class="col-lg-5">
                        <img src="{{asset('home/mobile/team/ceo.png')}}" alt="" class="m-auto ms-xl-0 md-mt-40">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.feedback-section-eight -->





    <!--
    =====================================================
        FAQ Section Three
    =====================================================
    -->
    <div class="faq-section-three bg-fourteen position-relative pt-150 lg-pt-80 pb-150 lg-pb-80">
        <div class="container">
            <div class="title-ten text-center mb-75 lg-mb-30">
                <h2><span class="position-relative z-1">Questions<span class="line" style="background: #FFC92E;"></span></span> & Answers</h2>
            </div>
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="accordion accordion-style-four" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What is {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}} is an all-in-one platform that connects fashion and beauty businesses to customers through a dynamic directory. It also offers tools for managing bookings, payments, events, and analytics to help businesses grow effortlessly.</p>
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
                                    <p class="fs-22">To list your business, sign up on the {{$siteName}} platform, complete your profile, and provide details about your services, products, or events. Once approved, your business will appear in the directory, making it discoverable to customers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    What does it cost to use {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}} offers flexible pricing plans tailored to your needs. You can choose between free and premium options, with additional features such as advanced analytics, priority listings, and more available at competitive rates.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Can I change my subscription plan?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, you can change your subscription plan anytime. However at the moment,  {{$siteName}} does not offer a subscription package</p>
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
        Contact Banner One
    =====================================================
    -->
    <div class="contact-banner-one mt-120 lg-mt-80">
        <div class="container">
            <h5 class="text-center font-Montserrat mb-80 lg-mb-40">Don’t find answer? Contact Us</h5>
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <div class="block d-flex align-items-center">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_43.svg')}}" alt=""></div>
                        <div class="text">
                            <div class="title">We’re happy to help</div>
                            <span class="fs-20">{{ $web->email }}</span>
                        </div>
                    </div>
                    <!-- /.block -->
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="block d-flex align-items-center justify-content-lg-center position-relative z-1 skew-line pt-5 pb-5 md-mt-20 md-mb-20">
                        <div class="d-flex align-items-center">
                            <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_44.svg')}}" alt=""></div>
                            <div class="text">
                                <div class="title">Hotline number</div>
                                <span class="fs-20">{{ $web->phone }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- /.block -->
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="block d-flex align-items-center ps-xl-5">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_45.svg')}}" alt=""></div>
                        <div class="text">
                            <div class="title">Live chat</div>
                            <span class="fs-20">{{ config('app.knowledge-base') }}</span>
                        </div>
                    </div>
                    <!-- /.block -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.contact-banner-one -->


@endsection
