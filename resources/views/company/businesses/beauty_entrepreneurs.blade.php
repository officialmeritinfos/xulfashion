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
                    <h1 class="hero-heading wow fadeInUp font-manrope">Empower Your Beauty Business Online</h1>
                    <p class="fs-28 font-manrope text-dark pt-5 pb-30 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        Showcase your beauty brand, connect with customers, sell products, and manage bookings effortlessly through {{$siteName}}’s all-in-one platform.
                    </p>
                    <a href="{{ route('mobile.app.base') }}" class="btn-three wow fadeInUp" data-wow-delay="0.2s">Join Now</a>
                </div>
            </div>
            <img src="{{asset('home/mobile/images/beauty-entrepreneur.png')}}" alt="" class="w-100 mt-70 lg-mt-50 wow fadeInUp" data-wow-delay="0.3s">
        </div>
        <div class="client-logo-wrapper mt-80 lg-mt-40">
            <div class="container">
                <p class="font-manrope fs-24 fw-500 text-center mb-40">
                    Trusted by <span class="fw-600 text-dark">1k+</span> beauty entrepreneurs worldwide.
                </p>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_11.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_12.svg')}}" alt="" class="shapes shape_02">
    </div>
    <!-- /.hero-banner-two -->


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
                            <h2>Effortless Appointment Management</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                            With {{$siteName}}, beauty entrepreneurs can streamline their appointment bookings. Manage client schedules, send automated reminders, and ensure a seamless customer experience all in one place.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/beauty-appointment.png')}}" alt="Effortless Appointment Management">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Boost Visibility with Customizable Ads</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                            Reach more clients by creating tailored ads for your beauty services. {{$siteName}} offers tools to promote your business on our platform, helping you stand out in a competitive market.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/beauty-ad.png')}}" alt="Boost Visibility with Customizable Ads">
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-150 xl-mt-100 lg-mt-60">
                <div class="col-xl-5 col-lg-6 order-lg-last">
                    <div class="ps-xl-5 ms-xxl-3">
                        <div class="title-four">
                            <h2>Secure Online Payment Options</h2>
                        </div>
                        <p class="fs-24 font-manrope mt-45 lg-mt-30 mb-45 lg-mb-30">
                            Provide your clients with a secure way to pay for your services online. {{$siteName}} supports multiple payment methods, ensuring convenience and trust for your customers.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-10 m-auto">
                    <div class="img-holder d-flex align-items-center justify-content-center md-mt-40">
                        <img src="{{asset('home/mobile/images/beauty-payment.png')}}" alt="Secure Online Payment Options">
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
                        <h2>Why Beauty Entrepreneurs Choose Us</h2>
                    </div>
                </div>
            </div>
            <p class="fs-24 text-dark text-center font-manrope pb-70 lg-pb-40">
                {{$siteName}} empowers beauty entrepreneurs with tools designed to grow their businesses, streamline operations, and connect with more clients.
            </p>

            <div class="row justify-content-between">
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                            <img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt="">
                        </div>
                        <span>All-in-One Platform</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">
                            Manage bookings, sell products, and promote services—all from a single dashboard.
                        </p>
                    </div>
                    <!-- /.card-style-five -->
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                            <img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt="">
                        </div>
                        <span>No Subscription Fees</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">
                            Enjoy our platform for free. Only pay a small commission when you make a sale.
                        </p>
                    </div>
                    <!-- /.card-style-five -->
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="card-style-five text-center mb-25">
                        <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                            <img src="{{asset('home/mobile/images/icon/icon_20.svg')}}" alt="">
                        </div>
                        <span>Secure Payment Solutions</span>
                        <p class="font-manrope fw-600 lh-base fs-24 text-dark">
                            Offer your clients multiple secure payment options, including cards and mobile wallets.
                        </p>
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
                        Find answers to common questions about {{$siteName}} and how it can transform your beauty business.
                    </p>
                    <a href="{{ route('home.contact') }}" class="btn-eleven">Contact us</a>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    How can I use {{$siteName}} to grow my beauty business?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        {{$siteName}} provides tools to manage bookings, showcase services, and sell products online, helping you attract more clients and grow your brand.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    Can I use {{$siteName}} to promote my services?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, you can create ads and promotional campaigns within the {{$siteName}} platform to reach more potential customers.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Is it free to list my business on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, it’s completely free to list your business on {{$siteName}}. You’ll only be charged a small commission on successful transactions.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    How does {{$siteName}} handle payments?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        {{$siteName}} processes payments securely, offering multiple payment options such as cards, bank transfers, and mobile wallets.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    Can I manage my bookings on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Absolutely. {{$siteName}} includes a comprehensive booking system that allows you to schedule and manage appointments with ease.
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
                    <h2 class="mt-30 mb-40 lg-mb-30">Unlock the power of your beauty business -  Try it now!</h2>
                    <p class="fs-28 mb-50 lg-mb-30">Try it risk free</p>
                    <a href="{{ route('home.download') }}" class="btn-eleven">Get the App!</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_39.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_40.svg')}}" alt="" class="shapes shape_02">
    </div>


@endsection
