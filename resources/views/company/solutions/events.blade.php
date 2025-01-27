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
                    <h1 class="hero-heading wow fadeInUp">Host Memorable Fashion & Beauty Events</h1>
                    <p class="fs-28 text-dark pt-40 lg-pt-30 pb-35 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        Plan, manage, and sell tickets for your events seamlessly. No subscription fees—just simple, transparent pricing.
                    </p>
                    <form action="#" class="m-auto position-relative">
                        <a href="{{ route('home.download') }}" class="btn-three wow fadeInUp" data-wow-delay="0.2s">
                            Download App
                        </a>
                    </form>
                </div>
            </div>
        </div>
        <div class="media d-flex justify-content-center mt-100 lg-mt-60">
            <div class="position-relative">
                <img src="{{asset('home/mobile/images/event-hero.png')}}" alt="">
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_29.png')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_30.png')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.hero-banner-three -->

    <!--
		=====================================================
			BLock Feature Eight
		=====================================================
-->
    <div class="block-feature-eight pt-250 xl-pt-200 md-pt-150 sm-pt-100 pb-180 xl-pb-150 lg-pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="title-four md-mb-20">
                        <h2 class="text-white">Trusted by Event Organizers Worldwide</h2>
                    </div>
                </div>
                <div class="col-xxl-5 col-lg-6 ms-auto">
                    <p class="font-manrope fs-24 pb-25 text-white">Easily create, manage, and promote your fashion or beauty events. With {{$siteName}}, streamline ticket sales and maximize your event's reach effortlessly.</p>
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
                            <div class="main-count">$<span class="counter">9.8</span>k+</div>
                            <p class="font-manrope fs-24 text-dark">Tickets Sold</p>
                        </div>
                        <!-- /.card-style-four -->
                    </div>
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_03.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_10.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_32.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">58</span>+</div>
                            <p class="font-manrope fs-24 text-dark">Events Managed</p>
                        </div>
                        <!-- /.card-style-four -->
                    </div>
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_04.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_11.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_33.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">98</span>%</div>
                            <p class="font-manrope fs-24 text-dark">Customer Satisfaction</p>
                        </div>
                        <!-- /.card-style-four -->
                    </div>
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_05.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_10.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_33.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">1.5</span>x</div>
                            <p class="font-manrope fs-24 text-dark">Revenue Growth</p>
                        </div>
                        <!-- /.card-style-four -->
                    </div>
                    <div class="item">
                        <div class="card-style-four position-relative" style="background-image: url({{asset('home/mobile/images/assets/bg_04.png')}});">
                            <div class="d-flex justify-content-between align-items-center">
                                <img src="{{asset('home/mobile/images/logo/p_logo_11.png')}}" alt="">
                                <img src="{{asset('home/mobile/images/shape/shape_33.svg')}}" alt="">
                            </div>
                            <div class="main-count"><span class="counter">30</span>+</div>
                            <p class="font-manrope fs-24 text-dark">Countries Served</p>
                        </div>
                        <!-- /.card-style-four -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-eight -->


    <!--
		=====================================================
			BLock Feature Nine
		=====================================================
-->
    <div class="block-feature-nine pt-180 xl-pt-150 lg-pt-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Effortless Event Creation</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">Easily create and manage fashion or beauty events with {{$siteName}}. From ticket sales to attendee management, handle everything in one place.</p>
                         </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/event-creation.png')}}" alt="Effortless Event Creation">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Real-Time Ticket Sales Insights</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">Monitor your event’s success with live tracking of ticket sales and attendee engagement. Make informed decisions with accurate data at your fingertips.</p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/ticket-sale.png')}}" alt="Real-Time Ticket Sales Insights">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Secure Online Ticket Payments</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">Offer your attendees a seamless and secure way to purchase tickets online. Our system supports multiple payment options, ensuring flexibility for your audience.</p>
                   </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/ticket-purchase.png')}}" alt="Secure Online Ticket Payments">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-nine -->


    <!--
		=====================================================
			BLock Feature Ten
		=====================================================
-->
    <div class="block-feature-ten position-relative z-2 pt-150 lg-pt-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 m-auto">
                    <div class="title-four text-center mb-35 lg-mb-30">
                        <h2>What Makes Us Stand Out?</h2>
                    </div>
                </div>
            </div>
            <p class="fs-24 text-dark text-center font-manrope pb-70 lg-pb-40">{{$siteName}} empowers fashion and beauty businesses with tools to create, manage, and grow effortlessly.</p>

            <div class="row justify-content-between">
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt=""></div>
                        <span>Intuitive Interface</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">Our platform offers a seamless experience with tools that are easy to navigate and use.</p>
                    </div>
                    <!-- /.card-style-five -->
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt=""></div>
                        <span>Zero Subscription Fees</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">No hidden costs—only a small commission on successful transactions.</p>
                    </div>
                    <!-- /.card-style-five -->
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt=""></div>
                        <span>Comprehensive Solutions</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">From event management to invoicing, we cover every aspect of your business.</p>
                    </div>
                    <!-- /.card-style-five -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-ten -->


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
                        Find your answers here. If you don’t find what you’re looking for, please don’t hesitate to contact us.
                    </p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What is {{$siteName}}'s Event Management Solution?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        {{$siteName}}’s Event Management Solution allows businesses and individuals in the fashion and beauty industry to create, manage, and promote events like fashion shows and exhibitions. You can sell tickets and manage attendee entries seamlessly.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    How does ticket selling work?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        You can sell tickets for your events directly through the {{$siteName}} platform. Customers can purchase tickets online, and you can manage their access digitally. All funds are deposited into your account, and you can withdraw them without restrictions.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Is there a subscription fee for event management?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        No, there are no subscription fees. {{$siteName}} only charges a small percentage based on our pricing structure for each ticket sold.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Can I withdraw my event earnings anytime?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, you can withdraw your event earnings at any time. {{$siteName}} ensures you have full access to your funds.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    How can I promote my event?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        You can create event ads and promotional posts within the {{$siteName}} marketplace to reach a larger audience. Additionally, {{$siteName}}’s analytics tools help you track engagement and optimize your promotions.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixA" aria-expanded="true" aria-controls="collapseSixA">
                                    Can I manage attendee entries with {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseSixA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, {{$siteName}} offers tools for managing attendee entries, including QR code scanning and real-time attendance tracking.
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
			Fancy Banner Three
		=====================================================
		-->
    <div class="fancy-banner-three pt-150 lg-pt-80 pb-150 lg-pb-80 position-relative z-1">
        <div class="container">
            <img src="{{asset($web->logo)}}" style="width: 150px;" alt="" class="m-auto">
            <div class="row">
                <div class="col-xl-8 m-auto text-center">
                    <h2 class="mt-30 mb-40 lg-mb-30">Unlock the power of your event Try it now!</h2>
                    <p class="fs-28 mb-50 lg-mb-30">Try it risk free</p>
                    <a href="{{ route('home.download') }}" class="btn-eleven">Get the App!</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_39.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_40.svg')}}" alt="" class="shapes shape_02">
    </div>


@endsection
