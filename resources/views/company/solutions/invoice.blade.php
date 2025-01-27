@extends('company.layout.base')
@section('content')

    <!--
		=============================================
			Hero Banner
		==============================================
		-->
    <div class="hero-banner-one bg-one border-30 z-1 pt-120 lg-pt-80 pb-100 lg-pb-70 lg-mt-20 position-relative">
        <div class="container position-relative  mt-30">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <p class="fs-24 fw-500 text-dark mb-10 wow fadeInUp">Send & Manage Invoices Effortlessly</p>
                    <h1 class="hero-heading wow fadeInUp">SIMPLE  <img src="{{asset('home/mobile/images/shape/shape_01.svg')}}" alt="" class="d-inline-block"> <span class="d-inline-block position-relative">FAST <img src="{{asset('home/mobile/images/shape/shape_01.svg')}}" alt="" class="d-inline-block"></span> EFFICIENT</h1>
                    <div class="row">
                        <div class="col-xxl-8 col-lg-10">
                            <p class="fs-24 text-dark pt-25 pb-30 lg-pb-20 xs-pb-10 wow fadeInUp" data-wow-delay="0.1s">
                                {{$siteName}} empowers fashion & beauty businesses to create, send, and track invoices seamlessly.
                                Manage your payments, stay organized, and maintain a professional image with ease.
                            </p>
                        </div>
                    </div>
                    <ul class="style-none d-flex align-items-center flex-wrap">
                        <li class="mt-10"><a href="{{ route('home.download') }}" class="btn-one me-4">Install App</a></li>
                        <li class="mt-10"><a href="{{ route('mobile.app.base') }}" class="btn-two xl">Use on Web</a></li>
                    </ul>
                    <p class="fs-22 pt-100 md-pt-50 md-pb-20">
                        <span class="fw-500 text-dark text-decoration-underline">Join thousands</span> of businesses who’re sending invoices
                        seamlessly and getting paid.
                    </p>
                </div>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/assets/ils_01.png')}}" alt="" class="shapes illustration">
    </div>
    <!-- /.hero-banner-one -->



    <!--
		=====================================================
			BLock Feature Three
		=====================================================
		-->
    <div class="block-feature-three border-30 bg-two pt-130 lg-pt-80 md-pt-30 pb-150 lg-pb-80 mb-30 lg-mb-20 mt-30">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 wow fadeInLeft">
                    <div class="title-one mb-30 mt-50">
                        <h2>Create Invoices  <span class="d-inline-block position-relative">& <img src="{{asset('home/mobile/images/shape/shape_03.svg')}}" alt="" class="d-inline-block"></span> <br> Track Payments</h2>
                    </div>
                    <p class="fs-24 fw-500 text-dark">
                        With {{$siteName}}, you can effortlessly create and send invoices directly from your dashboard. Monitor
                        payments, send reminders, and ensure timely transactions — all without the hassle. Enjoy peace of
                        mind while focusing on growing your fashion business.
                    </p>
                </div>
                <div class="col-lg-6 col-md-8 m-auto text-end wow fadeInRight">
                    <div class="img-holder-one position-relative d-inline-block z-1 md-mt-40">
                        <img src="{{asset('home/mobile/images/create-invoice.png')}}" alt="">
                        <img src="{{asset('home/mobile/images/shape/shape_04.svg')}}" alt="" class="shapes shape_01">
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-100 md-mt-30">
                <div class="col-lg-6 wow fadeInRight order-lg-last">
                    <div class="ps-xl-5">
                        <div class="title-one mb-30 mt-50">
                            <h2>Manage Clients <span class="d-inline-block position-relative">payments  like a Pro
                                    <img src="{{asset('home/mobile/images/shape/shape_03.svg')}}" alt="" class="d-inline-block"></span></h2>
                        </div>
                        <p class="fs-24 fw-500 text-dark">
                            Our platform empowers you to keep track of who has paid, who hasn’t, and generate detailed reports.
                            Whether you're dealing with one-time orders or recurring payments, {{$siteName}} keeps your cash flow steady and organized.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 m-auto wow fadeInLeft order-lg-first">
                    <div class="img-holder-two position-relative d-inline-block z-1 md-mt-20">
                        <img src="{{asset('home/mobile/images/manage-invoice.png')}}" alt="">
                        <img src="{{asset('home/mobile/images/shape/shape_05.svg')}}" alt="" class="shapes shape_01">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-three -->


    <!--
		=====================================================
			BLock Feature One
		=====================================================
		-->
    <div class="block-feature-one border-30 bg-three mt-30 lg-mt-20 pt-150 lg-pt-80 pb-200 lg-pb-140">
        <div class="container">
            <div class="row">
                <div class="col-xxl-7 col-lg-6 order-lg-last">
                    <div class="ps-lg-5 ms-xxl-4 md-mb-60">
                        <div class="title-one">
                            <h2>Secured Invoice with Escrow</h2>
                        </div>
                        <p class="fs-28 text-dark fw-500 mt-40 md-mt-20">
                            Create both offline, online and Escrow-secured invoices to safeguard your business and ensure
                            you always get paid. Pay on Delivery just got better with our escrow-powered transaction system.
                        </p>
                        <div class="counter-wrapper mt-25 mb-70 lg-mb-50">
                            <div class="row">
                                <div class="col-7">
                                    <div class="counter-block-one mt-20">
                                        <div class="main-count fw-500 color-dark">Secure Transactions</div>
                                        <span class="fs-22">Always Covered</span>
                                    </div>
                                    <!-- /.counter-block-one -->
                                </div>
                                <div class="col-5">
                                    <div class="counter-block-one mt-20">
                                        <div class="main-count fw-500 color-dark">Satisfied Merchants</div>
                                        <span class="fs-22"></span>
                                    </div>
                                    <!-- /.counter-block-one -->
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('home.download') }}" class="btn-two xl">Download Now!</a>
                    </div>
                </div>
                <div class="col-xxl-5 col-lg-6 col-md-7 m-auto text-end order-lg-first">
                    <div class="img-holder z-1 d-inline-block position-relative">
                        <img src="{{asset('home/mobile/images/secured-escrow.png')}}" alt="">
                        <img src="{{asset('home/mobile/images/shape/shape_02.svg')}}" alt="" class="shapes shape_01 wow fadeInLeft" data-wow-delay="0.3s">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.block-feature-one -->

    <!--
	=====================================================
		FAQ Section One
	=====================================================
-->
    <div class="faq-section-one bg-four position-relative z-1 pt-150 lg-pt-80 pb-120 lg-pb-80 border-30 mb-30 lg-mb-20 mt-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 m-auto">
                    <div class="title-one text-center mb-80 xl-mb-60 md-mb-40">
                        <h2>Frequently Asked Questions</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="accordion accordion-style-one" id="accordionOne">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    What is {{$siteName}}’s Escrow System?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        {{$siteName}}’s Escrow System ensures secure transactions by holding funds until both the buyer and seller confirm the deal is completed. It protects both parties from potential risks.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How do I generate invoices on {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        You can generate invoices directly from your merchant dashboard. Simply add the transaction details, and {{$siteName}} will generate a professional invoice for you.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Are there fees for using the Escrow service?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionOne">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes, a minimal fee is charged for each escrow transaction to cover operational costs and ensure service efficiency. The fee structure is transparent and shown before finalizing the transaction.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion accordion-style-one" id="accordionTwo">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAOne" aria-expanded="false" aria-controls="collapseAOne">
                                    How secure are payments made through {{$siteName}}?
                                </button>
                            </h2>
                            <div id="collapseAOne" class="accordion-collapse collapse" data-bs-parent="#accordionTwo">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Payments are extremely secure. Funds are held in a secure escrow account until both parties are satisfied, ensuring transparency and protection.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseATwo" aria-expanded="false" aria-controls="collapseATwo">
                                    Can I customize invoices for my brand?
                                </button>
                            </h2>
                            <div id="collapseATwo" class="accordion-collapse collapse" data-bs-parent="#accordionTwo">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        Yes! {{$siteName}} allows you to add your brand logo, contact information, and personalized notes to every invoice you generate.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAThree" aria-expanded="true" aria-controls="collapseAThree">
                                    What happens if there’s a dispute?
                                </button>
                            </h2>
                            <div id="collapseAThree" class="accordion-collapse collapse" data-bs-parent="#accordionTwo">
                                <div class="accordion-body">
                                    <p class="fs-22">
                                        If a dispute arises, our support team will assist both parties to resolve the issue. Funds will remain in escrow until the dispute is settled.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-60 lg-mt-40">
                <h4 class="mb-35">Don’t find your answer?</h4>
                <a href="{{ route('home.contact') }}" class="btn-two xl">Contact us</a>
            </div>
        </div>
        <img src="{{asset('home/mobile/images/shape/shape_06.svg')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/shape/shape_07.svg')}}" alt="" class="shapes shape_02">
    </div>



    <!--
		=====================================================
			Fancy Banner One
		=====================================================
		-->
    <div class="fancy-banner-one position-relative z-1 bg-one border-30 text-center pt-130 lg-pt-80 pb-130 lg-pb-80 mb-30 lg-mb-20">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7 m-auto">
                    <div class="title-one mb-35 lg-mb-30">
                        <h2>Start sending invoice with {{$siteName}}</h2>
                    </div>
                </div>
            </div>
            <p class="fs-28 mb-45 lg-mb-30">Send a free invoice today and never stop</p>
            <a href="{{ route('mobile.app.base') }}" class="btn-two xl">Let’s Get Started</a>
        </div>
        <img src="{{asset('home/mobile/images/assets/ils_02.png')}}" alt="" class="shapes shape_01">
        <img src="{{asset('home/mobile/images/assets/ils_03.png')}}" alt="" class="shapes shape_02">
    </div>

@endsection
