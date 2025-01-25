@extends('company.layout.base')
@section('content')
    <!--
		=====================================================
			BLock Feature Six
		=====================================================
		-->
    <div class="block-feature-six position-relative z-2 pt-225 lg-pt-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 me-auto">
                    <div class="pe-xxl-5">
                        <img src="{{asset('home/mobile/images/icon/icon_14.svg')}}" alt="" class="icon mb-35">
                        <blockquote class="p0">
                            {{$siteName}} is the leading directory and management platform for fashion and beauty businesses,
                            empowering brands to connect with customers and streamline operations effortlessly
                        </blockquote>
                        <div class="media-block border-30 mt-70 lg-mt-30 d-flex align-items-end">
                            <div class="name-card w-100 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6>Maria Gomez</h6>
                                    <span class="text-dark">CEO & Founder, Unique Fashions</span>
                                </div>
                                <img src="{{asset($web->logo)}}" alt="" style="width: 100px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="wrapper position-relative md-mt-40">
                        <div class="card-style-three position-relative z-1 mb-40 md-mb-20">
                            <img src="{{asset('home/mobile/images/logo/p_logo_09.png')}}" alt="" class="logo">
                            <div class="main-count fw-bold"><span class="counter">1,200</span>+</div>
                            <span class="fs-20">Businesses listed and thriving on {{$siteName}}.</span>
                            <img src="{{asset('home/mobile/images/shape/shape_14.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.card-style-three -->
                        <div class="card-style-three position-relative z-1 mb-40 md-mb-20">
                            <img src="{{asset('home/mobile/images/logo/p_logo_10.png')}}" alt="" class="logo">
                            <div class="main-count fw-bold"><span class="counter">3.2</span>X</div>
                            <span class="fs-20">Increase in customer engagement for merchants using our platform.</span>
                            <img src="{{asset('home/mobile/images/shape/shape_15.svg')}}" alt="" class="shapes shape_01">
                        </div>
                        <!-- /.card-style-three -->
                        <div class="card-style-three position-relative z-1">
                            <img src="{{asset('home/mobile/images/logo/p_logo_11.png')}}" alt="" class="logo">
                            <div class="main-count fw-bold"><span class="counter">800</span>%</div>
                            <span class="fs-20">Growth in bookings and sales for premium-listed businesses</span>
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
			BLock Feature Four
		=====================================================
		-->
    <div class="block-feature-four pt-180 xl-pt-150 lg-pt-80">
        <div class="container">
            <div class="title-two text-center mb-100 xl-mb-70 lg-mb-50">
                <h2>{{ $siteName }} Features</h2>
            </div>
            <div class="row gx-xl-5">
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Business Directory</h3>
                                <img src="{{asset('home/mobile/images/shape/shape_08.svg')}}" alt="" class="shapes pointer">
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s mt-auto">
                                List your business in the {{$siteName}} Directory and connect with thousands of potential
                                customers actively searching for fashion and beauty services.
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
                                <h3 class="tran3s">Bookings & Appointments</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">
                                Streamline your bookings and appointment management with {{$siteName}}’s integrated scheduling tools for a smoother customer experience.
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
                                <h3 class="tran3s">Analytics & Insights </h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center"><img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">
                                Leverage powerful analytics to track sales, monitor customer preferences, and make data-driven decisions to grow your business."</p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                    <!-- /.card-style-two -->
                </div>
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Payment Solutions</h3>
                                <img src="{{asset('home/mobile/images/shape/shape_09.svg')}}" alt="" class="shapes pointer">
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt=""></div>
                            </div>
                            <p class="font-manrope tran3s">
                                Accept local and international payments securely with {{$siteName}}’s escrow-backed payment system, ensuring safe and hassle-free transactions.
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
			Block Feature Seventeen
		=====================================================
		-->
    <div class="block-feature-seventeen position-relative z-1 mt-150 lg-mt-80">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-6 m-auto">
                    <div class="title-nine text-center mb-60 lg-mb-10">
                        <div class="upper-title">Why Choose us?</div>
                        <h2>Why {{$siteName}}?</h2>
                    </div>
                    <!-- /.title-nine -->
                </div>
            </div>

            <div class="row gx-xxl-5">
                <div class="col-lg-4">
                    <div class="card-style-eight text-center mt-35 wow fadeInUp">
                        <img src="{{asset('home/mobile/images/icon/icon_34.png')}}" alt="" class="icon m-auto">
                        <h5>24/7 Human Customer Support</h5>
                        <p class="ps-xxl-4 pe-xxl-4">
                            With a 24/7 human customer support, we’re always just a call, text, or email away to assist
                            with your questions or resolve any challenges you may face.
                        </p>
                    </div>
                    <!-- /.card-style-eight -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-eight text-center mt-35 wow fadeInUp" data-wow-delay="0.1s">
                        <img src="{{asset('home/mobile/images/icon/icon_35.png')}}" alt="" class="icon m-auto">
                        <h5>Ultimate Platform for Fashion & Beauty Businesses.</h5>
                        <p class="ps-xxl-4 pe-xxl-4">
                            We're the ultimate solution for the Fashion and Beauty Industry, providing you with solutions
                            that simplify business management with tools for payments, bookings, analytics, and customer engagement.
                            Automate processes and ensure your business runs smoothly.
                        </p>
                    </div>
                    <!-- /.card-style-eight -->
                </div>
                <div class="col-lg-4">
                    <div class="card-style-eight text-center mt-35 wow fadeInUp" data-wow-delay="0.2s">
                        <img src="{{asset('home/mobile/images/icon/icon_36.png')}}" alt="" class="icon m-auto">
                        <h5>Business Partner For Growth</h5>
                        <p class="ps-xxl-4 pe-xxl-4">
                            At {{$siteName}}, your success is our mission. We provide powerful tools and reliable support to
                            help your business thrive and stand out in the competitive market.
                        </p>
                    </div>
                    <!-- /.card-style-eight -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-seventeen -->

    <!--
=====================================================
Block Feature Fourteen for {{$siteName}}
=====================================================
-->
    <div class="block-feature-fourteen position-relative z-1 mt-150 lg-mt-70">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-10 m-auto">
                    <div class="text-center mb-80 lg-mb-40">
                        <div class="title-six">
                            <h2>Empower Your Fashion & Beauty Business</h2>
                        </div>
                        <p class="fs-24">{{$siteName}} provides tools to simplify operations, grow your customer base, and elevate your brand effortlessly.</p>
                    </div>
                </div>
            </div>
            <div class="feature-tab">
                <nav class="filter-nav">
                    <div class="nav nav-tabs align-items-center justify-content-center justify-content-xl-between border-0" role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#discover" type="button" role="tab" aria-controls="discover" aria-selected="true">
                            <img src="{{asset('home/mobile/images/icon/icon_23.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_23_w.svg')}}" alt="" class="shapes icon icon_w">
                            Get Discovered
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#manage" type="button" role="tab" aria-controls="manage" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_24.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_24_w.svg')}}" alt="" class="shapes icon icon_w">
                            Simplify Management
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#grow" type="button" role="tab" aria-controls="grow" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_25.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_25_w.svg')}}" alt="" class="shapes icon icon_w">
                            Grow with Insights
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/icon_23.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/icon_23_w.svg')}}" alt="" class="shapes icon icon_w">
                            Secure Payments
                        </button>
                    </div>
                </nav>
                <div class="mt-80 lg-mt-40">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="discover" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Get Your Business Discovered</h2>
                                    </div>
                                    <p class="fs-22 mb-50">List your business on the {{$siteName}} Directory to connect with thousands of customers actively seeking fashion and beauty services.</p>
                                    <a href="{{route('home.solutions.listing')}}" class="btn-twelve"><span>Explore More</span> <i class="fa-sharp fa-regular fa-arrow-right-long"></i></a>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/discovered.png')}}" alt="" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="manage" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Simplify Business Operations</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Manage bookings, payments, inventory, and customer relationships seamlessly from one platform.</p>
                                    <a href="#" class="btn-twelve"><span>Explore More</span> <i class="fa-sharp fa-regular fa-arrow-right-long"></i></a>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/simplify-business.png')}}" alt="" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="grow" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Grow with Data-Driven Insights</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Use {{$siteName}}’s analytics to monitor sales, understand customer behavior, and make informed business decisions.</p>
                                    <a href="#" class="btn-twelve"><span>Explore More</span> <i class="fa-sharp fa-regular fa-arrow-right-long"></i></a>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/grow-data.png')}}" alt="" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="payments" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Secure Payments, Simplified</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Receive local and international payments securely through {{$siteName}}’s escrow-backed payment system.</p>
                                    <a href="#" class="btn-twelve"><span>Explore More</span> <i class="fa-sharp fa-regular fa-arrow-right-long"></i></a>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/payment-card.png')}}" alt="" class="ms-auto md-mt-40">
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
        Team Section One
    =====================================================
    -->
    <div class="team-section-one position-relative z-1 mt-180 xl-mt-150 lg-mt-80 pb-180 xl-pb-150 lg-pb-80">
        <div class="container">
            <div class="position-relative">
                <div class="title-two">
                    <h2>Our Team</h2>
                </div>
                <p class="fs-24 mb-30 md-mb-10">
                    Meet the dedicated professionals driving innovation and growth for fashion and beauty businesses.
                </p>

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="team-block mt-35">
                            <img src="{{asset('home/mobile/team/coo2.jpeg')}}" alt="" class="w-100">
                            <div class="text">
                                <span>CTO</span>
                                <h5>Stanley Ibe</h5>
                                <a href="#" class="stretched-link"></a>
                            </div>
                        </div>
                        <!-- /.team-block -->
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-block mt-35">
                            <img src="{{asset('home/mobile/team/chijiokeemmanuel.jpeg')}}" alt="" class="w-100">
                            <div class="text">
                                <span>CAO</span>
                                <h5>Chijioke Emmanuel</h5>
                                <a href="#" class="stretched-link"></a>
                            </div>
                        </div>
                        <!-- /.team-block -->
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-block mt-35">
                            <img src="{{asset('home/mobile/team/cfo2.jpeg')}}" alt="" class="w-100">
                            <div class="text">
                                <span>CCO</span>
                                <h5>Ohaeri Lilian</h5>
                                <a href="#" class="stretched-link"></a>
                            </div>
                        </div>
                        <!-- /.team-block -->
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="team-block mt-35">
                            <img src="{{asset('home/mobile/team/uchez.png')}}" alt="" class="w-100">
                            <div class="text">
                                <span>CMO</span>
                                <h5>Uchenna John</h5>
                                <a href="#" class="stretched-link"></a>
                            </div>
                        </div>
                        <!-- /.team-block -->
                    </div>
                </div>
                <div class="section-btn text-center md-mt-60">
                    <a href="https://xultechng.com/company/our-team" target="_blank" class="btn-twenty">See All Members</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_84.svg')}}" alt="" class="shapes shape_01">
    </div>
    <!-- /.team-section-one -->




    <!--
    =====================================================
        Fancy Banner Two
    =====================================================
    -->
    <div class="fancy-banner-two pt-120 lg-pt-80 pb-150 xl-pb-120 lg-pb-80 position-relative z-1">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-7 m-auto text-center">
                    <h2>Thousands of Fashion & Beauty Businesses Trust {{$siteName}}. Join Them Today!</h2>
                    <a href="{{ route('mobile.register') }}" class="btn-six">Start Your Journey Now!</a>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_20.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_21.svg')}}" alt="" class="shapes shape_02">
    </div>



@endsection
