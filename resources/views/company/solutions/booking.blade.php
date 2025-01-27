@extends('company.layout.base')
@section('content')


    <!--
		=============================================
			Hero Banner
		==============================================
		-->
    <div class="hero-banner-nine z-1 position-relative pt-225 md-pt-150 pb-225 xl-pb-200 md-pb-120 mt-80">
        <div class="container lg">
            <div class="row">
                <div class="col-lg-6 col-md-8">
                    <h1 class="hero-heading font-Playfair wow fadeInUp">Effortless Booking Management for Fashion & Beauty</h1>
                    <p class="fs-24 text-dark pt-35 lg-pt-30 pb-30 pe-xxl-5 wow fadeInUp" data-wow-delay="0.1s">
                        Simplify your business operations with {{$siteName}}'s seamless booking solution. Manage appointments,
                        schedule offline bookings, and accept marketplace reservations all from one place.
                    </p>
                    <a href="{{ route('mobile.register') }}" class="btn-eighteen">Start Now</a>
                </div>
            </div>

            <div class="illustration">
                <img src="{{asset('home/mobile/images/assets/ils_24.svg')}}" alt="">
            </div>
        </div>
    </div>
    <!-- /.hero-banner-nine -->




    <!--
    =====================================================
        Block Feature Twenty Four
    =====================================================
    -->
    <div class="block-feature-twentyFour pb-80 lg-pb-40">
        <div class="container lg">
            <div class="row gx-xxl-5">
                <div class="col-lg-4">
                    <div class="card-style-eleven">
                        <img src="{{asset('home/mobile/images/icon/icon_46.svg')}}" alt="">
                        <h4>Instant booking confirmations.</h4>

                    </div>
                    <!-- /.card-style-eleven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-eleven md-mt-30">
                        <img src="{{asset('home/mobile/images/icon/icon_47.svg')}}" alt="">
                        <h4>Comprehensive scheduling tools.</h4>
                    </div>
                    <!-- /.card-style-eleven -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-eleven md-mt-30">
                        <img src="{{asset('home/mobile/images/icon/icon_48.svg')}}" alt="">
                        <h4>Integration with payments and inventory systems.</h4>
                    </div>
                    <!-- /.card-style-eleven -->
                </div>
            </div>

        </div>
    </div>
    <!-- /.block-feature-twentyFour -->



    <!--
    =====================================================
        Block Feature Twenty Five
    =====================================================
    -->
    <div class="block-feature-twentyFive mt-180 lg-mt-80">
        <div class="container lg">
            <div class="border-top border-bottom border-dark border-2 pt-90 lg-pt-40 pb-90 lg-pb-40">


                <div class="row gx-xxl-5">
                    <div class="col-lg-4">
                        <div class="card-style-twelve text-center mt-20">
                            <img src="{{asset('home/mobile/images/icon/icon_50.svg')}}" alt="" class="m-auto">
                            <h4>24/7 Booking Support</h4>
                            <p class="pe-xxl-4 ps-xxl-4">
                                Our dedicated support team is available around the clock to assist you with managing bookings,
                                resolving scheduling conflicts, and answering any questions promptly.
                            </p>
                        </div>
                        <!-- /.card-style-twelve -->
                    </div>
                    <div class="col-lg-4">
                        <div class="card-style-twelve text-center mt-20">
                            <img src="{{asset('home/mobile/images/icon/icon_51.svg')}}" alt="" class="m-auto">
                            <h4>Seamless Integration with Inventory</h4>
                            <p class="pe-xxl-4 ps-xxl-4">
                                Automatically sync all your bookings with your inventory, ensuring accurate stock management
                                for services, products, and appointments.
                            </p>
                        </div>
                        <!-- /.card-style-twelve -->
                    </div>
                    <div class="col-lg-4">
                        <div class="card-style-twelve text-center mt-20">
                            <img src="{{asset('home/mobile/images/icon/icon_52.svg')}}" alt="" class="m-auto">
                            <h4>Secure and Reliable Payments</h4>
                            <p class="pe-xxl-4 ps-xxl-4">
                                Receive payments securely with {{$siteName}}’s integrated system, offering robust encryption
                                and instant transaction confirmations for both online and offline bookings.
                            </p>
                        </div>
                        <!-- /.card-style-twelve -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-twentyFive -->



    <!--
    =====================================================
        Block Feature Twenty Six
    =====================================================
    -->
    <div class="block-feature-twentySix mt-180 xl-mt-150 lg-mt-80">
        <div class="container lg">
            <div class="row">
                <div class="col-xl-7 col-lg-7 m-auto">
                    <div class="title-eleven text-center mb-30 lg-mb-10">
                        <h2>Why it's right for you to stay with {{$siteName}}</h2>
                    </div>
                </div>
            </div>
            <div class="row gx-xxl-5">
                <div class="col-lg-4 d-flex">
                    <div class="block-one d-flex flex-column justify-content-center w-100 mt-50 lg-mt-30">
                        <div>
                            <img src="{{asset('home/mobile/images/icon/icon_53.svg')}}" alt="">
                            <h3>Seamless Booking Integration</h3>
                        </div>
                    </div>
                    <!-- /.block-one -->
                </div>
                <div class="col-lg-8 d-flex">
                    <div class="block-two w-100 mt-50 lg-mt-30">
                        <div class="row">
                            <div class="col-xl-8 col-lg-7">
                                <h3 class="md-mt-20">Automated Scheduling Tools</h3>
                            </div>
                        </div>
                        <img src="{{asset('home/mobile/images/bookings.png')}}" alt="">
                    </div>
                </div>
                <div class="col-lg-8 d-flex">
                    <div class="block-three w-100 mt-50 lg-mt-30">
                        <div class="row">
                            <div class="col-md-8 ms-auto text-end">
                                <div class="icon d-flex align-items-center justify-content-center rounded-circle">
                                    <img src="{{asset('home/mobile/images/icon/icon_54.svg')}}" alt=""></div>
                                <blockquote>“{{$siteName}}’s booking feature transformed how I handle client appointments. Simple, efficient, and stress-free!”</blockquote>
                                <div class="name fs-20"><span class="fw-500 text-dark">Musa Jamy.</span> CEO babun</div>
                            </div>
                        </div>
                        <img src="{{asset('home/mobile/images/assets/avatar_4.png')}}" alt="" class="shapes shape_01">
                        <img src="{{asset('home/mobile/images/shape/shape_80.svg')}}" alt="" class="shapes shape_02">

                    </div>
                </div>
                <div class="col-lg-4 d-flex">
                    <div class="block-four d-flex flex-column justify-content-center w-100 mt-50 lg-mt-30">
                        <div>
                            <h3>Peak Performance & Accuracy</h3>
                            <img src="{{asset('home/mobile/images/icon/icon_55.svg')}}" alt="">
                        </div>
                    </div>
                    <!-- /.block-one -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-twentySix -->

    <!-- =====================================================
     Fancy Banner Ten
     =====================================================
 -->
    <div class="fancy-banner-ten mt-250 xl-mt-200 md-mt-130">
        <div class="container lg">
            <div class="wrapper">
                <img src="{{asset('home/mobile/images/assets/ils_25.svg')}}" alt="Booking Illustration" class="illustration">

                <div class="row">
                    <div class="col-xl-7 col-lg-6">
                        <div class="d-flex flex-wrap align-items-center">
                            <a class="video-btn tran3s rounded-circle d-flex align-items-center justify-content-center" data-fancybox=""
                               href="{{ config('app.how-xulfashion-booking-works-video') }}">
                                <i class="fa-sharp fa-solid fa-play"></i>
                            </a>
                            <h2>Effortless Booking Management with {{$siteName}}</h2>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <p class="fs-24 text-dark md-mt-30">Streamline bookings for your fashion and beauty business with {{$siteName}}’s integrated solution. Manage online, offline, and marketplace appointments effortlessly!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--
=====================================================
    FAQ Section Three
=====================================================
-->
    <div class="faq-section-three position-relative mt-180 lg-mt-80 mb-180 lg-mb-80">
        <div class="container lg">
            <div class="row">
                <div class="col-lg-5">
                    <div class="title-eleven">
                        <div class="text-uppercase mb-25">FAQ</div>
                        <h2>Frequently Asked Questions</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="accordion accordion-style-two style-two p0 shadow-none ms-xxl-4 md-mt-40" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    How does {{$siteName}}'s booking system work?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}}'s booking system enables businesses to accept bookings online, in-store, and through the marketplace. It integrates seamlessly with the calendar, allowing businesses to manage appointments and schedules efficiently.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    Can I customize booking slots and availability?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, the booking system allows you to customize your availability, set specific booking slots, and define buffer times between appointments to ensure a smooth workflow.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Can I accept payments for bookings?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Absolutely! {{$siteName}}'s booking solution supports integrated payments, allowing clients to pay upfront or after booking, ensuring secure and hassle-free transactions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Can I manage offline bookings with {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}} supports offline bookings, allowing businesses to log and track appointments made in person or over the phone, keeping all bookings in one place.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    Does the booking system send reminders to customers?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, automated reminders are sent via email or SMS to ensure customers don’t miss their appointments. This helps improve attendance rates and reduces no-shows.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.faq-section-three -->
    <div class="footer-three dark-version">

        <div class="container lg">
            <div class="address-wrapper">
                <h2>Need Some Help?</h2>

                <div class="row gx-xxl-5">
                    <div class="col-lg-4 d-flex">
                        <div class="block d-flex w-100 align-items-center mt-25">
                            <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_57.svg')}}" alt=""></div>
                            <div class="text">
                                <div class="title">We’re always happy to help</div>
                                <span class="fs-20">{{ $web->email }}</span>
                            </div>
                        </div>
                        <!-- /.block -->
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="block d-flex w-100 align-items-center mt-25">
                            <div class="d-flex align-items-center">
                                <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_58.svg')}}" alt=""></div>
                                <div class="text">
                                    <div class="title">Our Hotline Number</div>
                                    <span class="fs-20">{{ $web->phone }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- /.block -->
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="block d-flex w-100 align-items-center mt-25">
                            <div class="icon d-flex align-items-center justify-content-center rounded-circle"><img src="{{asset('home/mobile/images/icon/icon_59.svg')}}" alt=""></div>
                            <div class="text">
                                <div class="title">Live chat</div>
                                <span class="fs-20">
                                     <a class="startChat" >
                                        Chat Us <i class="fa-light fa-arrow-up-right"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <!-- /.block -->
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
