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
                    <h1 class="hero-heading wow fadeInUp font-manrope">
                        Empowering Fashion Designers with Seamless Solutions
                    </h1>
                    <p class="fs-28 font-manrope text-dark pt-5 pb-30 lg-pb-20 wow fadeInUp" data-wow-delay="0.1s">
                        Transform your fashion business with {{$siteName}}'s tools. From managing custom orders and bookings to
                        promoting your designs in our marketplace, we provide the ultimate platform to grow your brand and connect with clients.
                    </p>
                    <a href="{{ route('mobile.app.base') }}" class="btn-three wow fadeInUp" data-wow-delay="0.2s">Get Started Now</a>
                </div>
            </div>
            <img src="{{asset('home/mobile/images/fashion-designers.png')}}" alt="" class="w-100 mt-70 lg-mt-50 wow fadeInUp" data-wow-delay="0.3s">
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
    Block Feature Four
=====================================================
-->
    <div class="block-feature-four pt-150 lg-pt-80">
        <div class="container">
            <div class="title-two text-center mb-100 xl-mb-70 lg-mb-50">
                <h2>Empower Your Fashion Design Business with {{$siteName}}</h2>
            </div>
            <div class="row gx-xl-5">
                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Seamless Online Storefront</h3>
                                <img src="{{asset('home/mobile/images/shape/shape_08.svg')}}" alt="" class="shapes pointer">
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt="">
                                </div>
                            </div>
                            <p class="font-manrope tran3s mt-auto">
                                Showcase your latest collections and sell directly from your customizable online storefront.
                                Reach a global audience with ease.
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Effortless Booking Management</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt="">
                                </div>
                            </div>
                            <p class="font-manrope tran3s">
                                Allow clients to schedule appointments or consultations directly from your profile, making
                                it easier to manage your time and connect with customers.
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Tailored Marketing Tools</h3>
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt="">
                                </div>
                            </div>
                            <p class="font-manrope tran3s">
                                Promote your brand and latest collections with targeted marketing tools, helping you
                                reach the right audience and drive sales.
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-flex mb-40 md-mb-20">
                    <div class="card-style-two tran3s w-100">
                        <div class="wrapper tran3s d-flex flex-column h-100 position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-160 xl-mb-120 lg-mb-80 position-relative z-1">
                                <h3 class="tran3s">Secure Payment Solutions</h3>
                                <img src="{{asset('home/mobile/images/shape/shape_09.svg')}}" alt="" class="shapes pointer">
                                <div class="icon tran3s rounded-circle d-flex align-items-center justify-content-center">
                                    <img src="{{asset('home/mobile/images/icon/icon_07.svg')}}" alt="">
                                </div>
                            </div>
                            <p class="font-manrope tran3s">
                                Offer multiple payment options, including secure escrow services, ensuring a safe
                                and trusted transaction experience for you and your clients.
                            </p>
                            <a href="#" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-four -->


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
                                    <p class="fs-22 mb-50">
                                        Generate and send professional invoices effortlessly. With Xulfashion's integrated
                                        payment solutions, your clients can securely make payments with just a few clicks.
                                        Keep track of all transactions and maintain accurate financial records without the hassle.
                                    </p>
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
                                    <p class="fs-22 mb-50">
                                        Transform your fashion business with seamless in-store checkout options. Our POS
                                        system lets you accept payments via cards and mobile wallets while automatically
                                        updating your inventory. Manage transactions and boost efficiency with ease.
                                    </p>
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
                                    <p class="fs-22 mb-50">
                                        Reach customers anywhere with Xulfashion’s online payment gateway. Sell your products
                                        or services online and ensure secure, reliable transactions. Escrow features give you
                                        and your customers peace of mind while handling payments.
                                    </p>
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
                                    <p class="fs-22 mb-50">
                                        Designed specifically for Nigerian businesses, our dedicated merchant accounts let you
                                        receive payments instantly. Track funds, withdraw earnings effortlessly, and enjoy
                                        the simplicity of managing your finances from one platform.
                                    </p>
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
                                    How can Xulfashion benefit fashion designers?
                                </button>
                            </h2>
                            <div id="collapseOneA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Xulfashion offers tools like storefront creation, booking management, inventory tracking, and online payment solutions tailored to help fashion designers streamline their business operations.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoA" aria-expanded="false" aria-controls="collapseTwoA">
                                    Can I showcase my portfolio on Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseTwoA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, you can create a professional portfolio to showcase your designs, attracting potential clients and customers within the Xulfashion community.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThreeA" aria-expanded="true" aria-controls="collapseThreeA">
                                    Does Xulfashion support custom bookings for designers?
                                </button>
                            </h2>
                            <div id="collapseThreeA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Absolutely! Xulfashion allows designers to manage custom bookings for fittings, consultations, and other services directly through the platform.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourA" aria-expanded="true" aria-controls="collapseFourA">
                                    Can I sell custom-made designs on Xulfashion?
                                </button>
                            </h2>
                            <div id="collapseFourA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, you can list and sell custom-made designs or ready-to-wear collections through your online storefront on Xulfashion.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFiveA" aria-expanded="true" aria-controls="collapseFiveA">
                                    What payment options are available for my clients?
                                </button>
                            </h2>
                            <div id="collapseFiveA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Xulfashion supports a variety of payment methods, including card payments, bank transfers, and mobile wallets, ensuring convenience for your clients.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSixA" aria-expanded="true" aria-controls="collapseSixA">
                                    Can I track my earnings and sales performance?
                                </button>
                            </h2>
                            <div id="collapseSixA" class="accordion-collapse collapse" data-bs-parent="#accordionFour">
                                <div class="accordion-body">
                                    <p class="fs-22">Yes, with Xulfashion’s advanced analytics, you can monitor your earnings, sales performance, and customer trends all in one dashboard.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
                                <h2>1k+ fashion designers are using {{$siteName}}. Try it Now!</h2>
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
