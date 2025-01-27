@extends('company.layout.base')
@section('content')

    <!--
		=============================================
			Hero Banner
		==============================================
		-->
    <div class="hero-banner-four p-30 z-1 position-relative">
        <div class="bg-eight wrapper position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-10">
                        <h1 class="hero-heading font-Playfair wow fadeInUp">Simplify Payments, Empower Your Business </h1>
                        <p class="fs-28 text-dark pt-15 pb-35 md-pb-20 pe-xxl-5 me-xxl-5 wow fadeInUp" data-wow-delay="0.1s">
                            Unlock seamless payment solutions tailored for the fashion and beauty industry. From invoices
                            to in-store POS, online bookings, and dedicated merchant accounts, {{$siteName}} ensures secure,
                            instant payments that keep your business running smoothly.
                        </p>
                        <form action="#" class="position-relative wow fadeInUp" data-wow-delay="0.2s">
                            <a href="{{ route('home.download') }}" class="tran3s btn-eight">Get Started</a>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <img src="{{asset('home/mobile/images/assets/ils_15.svg')}}" alt="" class="illustration wow fadeInRight">
                    </div>
                </div>

                <div class="client-logo-wrapper mt-100 lg-mt-50">
                    <div class="container">
                        <p class="fs-22 fw-500 text-dark mb-50 lg-mb-20">Trusted by over 1,000 businesses</p>
                        <div class="partner-logo-one">
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_01.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_02.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_03.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_04.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_05.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_06.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_03.png')}}" alt=""></div>
                            <div class="item"><img src="{{asset('home/mobile/images/logo/p_logo_04.png')}}" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.hero-banner-four -->






    <!--
    =====================================================
        BLock Feature Twelve
    =====================================================
    -->
    <div class="block-feature-twelve pt-130 lg-pt-80">
        <div class="container">
            <div class="text-center mb-85 lg-mb-40">
                <div class="title-six">
                    <h2>
                        Top Rated Payment Solution for Fashion & Beauty Businesses
                    </h2>
                </div>
                <p class="fs-24 mb-25">“{{$siteName}} has transformed the way I manage payments for my business – it’s seamless, secure, and tailored for the industry.”</p>
                <ul class="rating d-flex justify-content-center align-items-center flex-wrap style-none">
                    <li><i class="fa-sharp fa-solid fa-star-sharp"></i></li>
                    <li><i class="fa-sharp fa-solid fa-star-sharp"></i></li>
                    <li><i class="fa-sharp fa-solid fa-star-sharp"></i></li>
                    <li><i class="fa-sharp fa-solid fa-star-sharp"></i></li>
                    <li><i class="fa-sharp fa-solid fa-star-sharp"></i></li>
                    <li><span><strong>4.78</strong> (20 Reviews)</span></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-xxl-10 m-auto">
                    <div class="row justify-content-between">
                        <div class="col-xl-4 col-lg-5">
                            <div class="card-style-six text-center border-line">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/assets/ils_16.svg')}}" alt="">
                                </div>
                                <h4>All-in-One Payment Hub</h4>
                                <p class="fs-24">
                                    Easily manage payments for bookings, online sales, invoices, and POS transactions in one unified platform. Keep your cash flow organized and secure without breaking a sweat.
                                </p>
                            </div>
                            <!-- /.card-style-six -->
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card-style-six text-center md-mt-30">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/assets/ils_17.svg')}}" alt="">
                                </div>
                                <h4>Dedicated Merchant Accounts</h4>
                                <p class="fs-24">
                                    For Nigerian businesses, {{$siteName}} offers instant settlement with dedicated merchant
                                    accounts, ensuring your payments arrive in real-time without delays.
                                </p>
                            </div>
                            <!-- /.card-style-six -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-twelve -->


    <!--
		=====================================================
			BLock Feature Thirteen
		=====================================================
		-->
    <div class="block-feature-thirteen p-30 mt-150 xl-mt-120 lg-mt-60">
        <div class="bg-nine pt-130 lg-pt-80 pb-100 lg-pb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 order-lg-last">
                        <div class="ms-lg-5 ps-xxl-3">
                            <div class="title-six">
                                <h2>We’re the Leaders in Fashion Payments</h2>
                            </div>

                            <div class="accordion accordion-style-three mb-40" id="accordionThree">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="false" aria-controls="collapseOne">
                                            Seamless Account Creation
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionThree">
                                        <div class="accordion-body">
                                            <p class="fs-22">
                                                Get started in under 5 minutes. Setting up is easy and tailored to fit your
                                                unique business needs, ensuring you’re ready to accept payments instantly.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Competitive Pricing Plans
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                        <div class="accordion-body">
                                            <p class="fs-22">
                                                Enjoy affordable and transparent pricing with no hidden charges, designed for businesses in the fashion and beauty space.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                            Responsive Support
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionThree">
                                        <div class="accordion-body">
                                            <p class="fs-22">
                                                Our dedicated support team ensures quick resolution to queries, helping you stay focused on your business growth.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('mobile.register') }}" class="btn-seven">Get Started <i class="fa-sharp fa-regular fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-10 m-auto order-lg-first">
                        <div class="media position-relative mt-60">
                            <div class="counter-box text-center d-inline-block box-one">
                                <h2>100k+</h2>
                                <p class="fs-24 text-dark">Processed</p>
                            </div>
                            <div class="counter-box text-center d-inline-block box-two">
                                <h2>1000+</h2>
                                <p class="fs-24 text-dark">Clients</p>
                            </div>
                            <img src="{{asset('home/mobile/images/boss-in-market.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-thirteen -->



    <div class="block-feature-fourteen position-relative z-1 mt-150 lg-mt-70">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-10 m-auto">
                    <div class="text-center mb-80 lg-mb-40">
                        <div class="title-six">
                            <h2>Streamline Payment Solutions for Your Business</h2>
                        </div>
                        <p class="fs-24">{{$siteName}} simplifies how businesses in the fashion and beauty industry receive payments, from in-store to online, ensuring every transaction is seamless and secure.</p>
                    </div>
                </div>
            </div>
            <div class="feature-tab">
                <nav class="filter-nav">
                    <div class="nav nav-tabs align-items-center justify-content-center justify-content-xl-between border-0" role="tablist">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#invoice" type="button" role="tab" aria-controls="invoice" aria-selected="true">
                            <img src="{{asset('home/mobile/images/icon/invoice_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/invoice_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Invoice Payments
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pos" type="button" role="tab" aria-controls="pos" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/pos_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/pos_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Point of Sale (POS)
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#online" type="button" role="tab" aria-controls="online" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/online_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/online_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Online Payments
                        </button>
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#merchant" type="button" role="tab" aria-controls="merchant" aria-selected="false">
                            <img src="{{asset('home/mobile/images/icon/merchant_icon.svg')}}" alt="" class="shapes icon">
                            <img src="{{asset('home/mobile/images/icon/merchant_icon_w.svg')}}" alt="" class="shapes icon icon_w">
                            Merchant Accounts
                        </button>
                    </div>
                </nav>
                <div class="mt-80 lg-mt-40">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="invoice" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Invoice Payment Integration</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Easily create and send invoices, allowing your clients to make secure payments instantly. Keep your financial records accurate and up to date with integrated solutions.</p>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/invoice-payment.png')}}" alt="Invoice Payments Solution" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="pos" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Point of Sale (POS)</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Provide your clients with seamless in-store checkout options. Accept card payments and record transactions effortlessly with our POS integration tied to inventory management.</p>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/pos-payment.png')}}" alt="Point of Sale System" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="online" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Online Payment Gateway</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Expand your reach by accepting online payments through storefronts and bookings. Integrated with escrow features, every transaction is secure and reliable.</p>
                              </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/payment-gateway.png')}}" alt="Online Payment Gateway" class="ms-auto md-mt-40">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="merchant" role="tabpanel" tabindex="0">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="title-seven mb-30">
                                        <h2>Dedicated Merchant Accounts</h2>
                                    </div>
                                    <p class="fs-22 mb-50">Receive payments instantly with dedicated merchant accounts tailored for Nigerian businesses. Simplify your transactions and manage funds efficiently.</p>
                                </div>
                                <div class="col-lg-7">
                                    <img src="{{asset('home/mobile/images/dedicated-account.png')}}" alt="Merchant Account Integration" class="ms-auto md-mt-40">
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


    <div class="faq-section-three position-relative mt-150 xl-mt-120 lg-mt-80">
        <div class="container">
            <div class="title-six text-center mb-80 lg-mb-40">
                <h2>Questions & Answers</h2>
            </div>

            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="accordion accordion-style-two p0 shadow-none ms-xxl-4 me-xxl-4" id="accordionFour">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneA" aria-expanded="false" aria-controls="collapseOneA">
                                    What payment methods does {{$siteName}} support?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">{{$siteName}} supports multiple payment methods, including debit/credit cards, bank transfers, mobile wallets, and escrow payments, ensuring flexibility for both you and your customers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    Can I integrate online payments with my storefront?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, {{$siteName}} seamlessly integrates online payment gateways with your storefront, enabling secure transactions and instant updates to your inventory.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    How does the escrow payment system work?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Our escrow payment system ensures secure transactions by holding funds until both parties are satisfied. This builds trust between merchants and customers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Can I track payments across multiple channels?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, with {{$siteName}}’s unified dashboard, you can track payments across bookings, invoices, online sales, and POS systems, providing a comprehensive financial overview.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    How do I access my funds from the merchant account?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Funds from your dedicated merchant account are instantly available for withdrawal to your bank account, ensuring quick and efficient access to your earnings.</p>
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
        Fancy Banner Four
    =====================================================
    -->
    <div class="fancy-banner-four p-30 mt-110 lg-mt-60">
        <div class="bg-eight text-center pt-100 lg-pt-70 pb-250">
            <div class="container">
                <div class="position-relative z-1">
                    <div class="row">
                        <div class="col-xl-9 col-lg-8 m-auto">
                            <div class="title-six mb-40">
                                <h2>1k+ merchants are using {{$siteName}}. Try it Now!</h2>
                            </div>
                            <a href="{{ route('mobile.register') }}" class="btn-eleven">Get Started</a>
                        </div>
                    </div>
                    <img src="{{asset('home/mobile/images/shape/shape_41.svg')}}" alt="" class="shapes shape_01">
                    <img src="{{asset('home/mobile/images/shape/shape_42.svg')}}" alt="" class="shapes shape_02">
                </div>
            </div>

        </div>
        <img src="{{asset('home/mobile/images/assets/ils_23.png')}}" alt="" class="position-relative z-1 illustration">
    </div>
    <!-- /.fancy-banner-four -->


@endsection
