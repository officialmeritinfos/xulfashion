@extends('company.layout.base')
@section('content')

    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3 : Hero Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_hero-section">
        <div class="home-3_hero-shape">
            <img src="{{asset('home/image/home-3/hero-shape.png')}}" alt="image alt" />
        </div>
        <div class="container">
            <div class="row row--custom">
                <div class="col-lg-4 offset-lg-1 col-sm-4 col-5" >
                    <div class="home-3_hero-image-block">
                        <div class="home-3_hero-image">
                            <img class="hero-image" src="{{asset('home/image/appmockup4.webp')}}" alt="hero image"  loading="lazy" />
                            <div class="home-3_hero-image-shape-1">
                                <img src="{{asset('home/image/home-3/hero-image-shape-1.svg')}}" alt="image shape" />
                            </div>
                            <div class="home-3_hero-image-shape-2">
                                <img src="{{asset('home/image/home-3/hero-image-shape-2.svg')}}" alt="image shape" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-10" >
                    <div class="home-3_hero-content">
                        <div class="home-3_hero-content-text">
                            <h3 class="hero-content__title heading-lg text-black">
                                Connecting Fashion Creators & Shoppers
                            </h3>
                            <p>
                                {{$siteName}} bridges the gap between fashion creators and shoppers globally. Our platform
                                empowers designers, tailors, and retailers to showcase unique creations and offers an engaging
                                shopping experience. Whether you're seeking the latest trends or aiming to reach a wider audience,
                                {{$siteName}} provides the tools and community for your success.
                            </p>
                        </div>
                        <div class="home-3_hero-content-stat-wrapper">
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{route('register')}}" class="btn-masco btn-primary-l02 btn-sm">
                                    <span>Get Started</span>
                                </a>
                                <a href="{{route('login')}}" class="btn-masco btn-primary-l08 btn-sm">
                                    <span>Login</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Feature Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_feature-section section-padding-100">
        <div class="container">
            <div class="row justify-content-center gutter-y-default">
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="700">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h02-feature-2.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Seamless Online Booking</h3>
                            <p>
                                {{$siteName}} provides a seamless online booking system that allows shoppers to book
                                appointments with designers, tailors, and fashion consultants directly through the platform
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="600">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/icon-service-2.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Dedicated Online Storefronts</h3>
                            <p>
                                With {{$siteName}}, fashion creators can set up dedicated online storefronts to showcase and sell their products.
                                Each storefront is customizable, allowing creators to reflect their brand's identity and offer a personalized shopping experience.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="500">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/home-5/feature-3.png')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">24/7 Customer Support</h3>
                            <p>
                                {{$siteName}} offers 24/7 customer support to ensure that both creators and shoppers have
                                assistance whenever they need it. Whether it’s resolving issues, answering questions, or
                                providing guidance, our support team is always available to help.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Content Section 1
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_content-section-1 padding-top-120 padding-bottom-150 bg-light-2"  id="features">
        <div class="container">
            <div class="row row--custom ">
                <div class="offset-lg-1 col-xxl-auto col-md-3  col-xs-4 col-5" data-aos-duration="1000" data-aos="fade-right">
                    <div class="home-3_content-image-1-block ">
                        <div class="home-3_content-image-1">
                            <img src="{{asset('home/image/8.webp')}}" alt="alternative text">
                        </div>
                        <div class="home-3_content-image-1-shape absolute-center">
                            <img src="{{asset('home/image/home-3/content-1-shape.svg')}}" alt="image shape" class="">
                        </div>
                    </div>
                </div>
                <div class="offset-xl-1 col-xl-6 col-lg-7 col-md-10 col-auto" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">
                                Do more with {{$siteName}} for your fashion business
                            </h2>
                            <p>
                                With {{$siteName}}, you can easily create an online store, collect booking, list your services
                                in our marketplace and get visibility, issue invoices to your staff, collect payments etc
                            </p>
                            <p>
                                {{$siteName}} is built with one focus - to help connect your business to those who need - source
                                for new clients in our Store pool, compete and expand your reach.
                            </p>
                        </div>
                        <div class="content-button-block">
                            <a href="{{route('register')}}" class="btn-masco btn-primary-l03 btn-shadow rounded-pill"><span>
                                Get Started
                                </span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Content Section 2
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_content-section-2 padding-bottom-120 bg-light-2">
        <div class="container">
            <div class="row row--custom ">
                <div class="col-xl-4 offset-lg-1 col-md-3 col-xs-4 col-5" data-aos-duration="1000" data-aos="fade-left">
                    <div class="home-3_content-image-2-block content-image--mobile-width">
                        <div class="home-3_content-image-2">
                            <img src="{{asset('home/image/9.webp')}}" alt="alternative text">
                        </div>
                        <div class="home-3_content-image-2-shape absolute-center">
                            <img src="{{asset('home/image/home-3/content-2-shape.svg')}}" alt="image shape" class="">
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10  " data-aos-duration="1000" data-aos="fade-right">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">
                                Easily track your sales & organize your store
                            </h2>
                            <p>
                                {{$siteName}} offers you the right tools you need to track your sales all in one place,
                                and organize your store to your own taste.
                            </p>
                        </div>
                        <div class="content-list-block">
                            <ul class="content-list">
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Customizable Store-front themes
                                </li>
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Store Catalog - showcase your products and categories
                                </li>
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Store Invoice - easily send invoice to your customers
                                </li>
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Store Newsletter - collect subscriptions and mail your customers with ease
                                </li>
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Store Coupon - easily manage promos on your store.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ticker-01_section">
        <div class="ticker-01_wrapper">
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start selling online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Receive booking online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Reach a global audience with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
                <div class="ticker-item">
                    <p>Get hired by agencies with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start selling online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Receive booking online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Reach a global audience with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
                <div class="ticker-item">
                    <p>Get hired by agencies with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start selling online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Receive booking online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Reach a global audience with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
                <div class="ticker-item">
                    <p>Get hired by agencies with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start selling online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Receive booking online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Reach a global audience with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
                <div class="ticker-item">
                    <p>Get hired by agencies with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start selling online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Receive booking online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Reach a global audience with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
                <div class="ticker-item">
                    <p>Get hired by agencies with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start selling online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Receive booking online with {{$siteName}}</p>
                    <p>💸</p>
                </div>
                <div class="ticker-item">
                    <p>Reach a global audience with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
                <div class="ticker-item">
                    <p>Get hired by agencies with {{$siteName}}</p>
                    <p>🌐</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Video Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_video-section section-padding">
        <div class="home-3_video-shape">
            <img src="{{asset('home/image/home-3/video-shape.svg')}}" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="  col-xl-7 col-lg-8 col-md-10  ">
                    <div class="section-heading">
                        <h2 class="section-heading__title heading-md text-black">Discover what you can do with {{$siteName}}</h2>
                    </div>
                </div>
            </div>
            <div class="row gutter-y-40 justify-content-center">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="video-widget">
                        <div class="video-widget__thumbnail-wrapper">
                            <div class="video-widget__thumbnail">
                                <img src="{{asset('home/image/booking.svg')}}" alt="image alt" style="height: 325px;">
                            </div>
                        </div>
                        <h3 class="video-widget__title">Manage Seamless Bookings</h3>
                        <p>
                            {{$siteName}} allows fashion creators, models, and tailors to easily manage appointments with
                            clients. Whether it’s a fitting, consultation, or photoshoot, clients can book your services
                            directly through the platform. Automated reminders and real-time availability ensure you never
                            miss a booking, streamlining your entire scheduling process.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="video-widget">
                        <div class="video-widget__thumbnail-wrapper">
                            <div class="video-widget__thumbnail">
                                <img src="{{asset('home/image/storefront.svg')}}" alt="image alt" style="height: 325px;">
                            </div>
                        </div>
                        <h3 class="video-widget__title">Sell Online with Your Custom Storefront</h3>
                        <p>
                            Take your business global with  {{$siteName}}’s personalized storefront. Showcase your products
                            and designs with a professional, custom-branded online store, designed to reflect your brand’s
                            unique identity. With a user-friendly interface, you can easily manage products, categories,
                            and customers, while delivering a world-class shopping experience for your clients.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="video-widget">
                        <div class="video-widget__thumbnail-wrapper">
                            <div class="video-widget__thumbnail">
                                <img src="{{asset('home/image/invoice.webp')}}" alt="image alt" style="height: 325px;">
                            </div>
                        </div>
                        <h3 class="video-widget__title">Send Professional Invoices with Ease</h3>
                        <p>
                            {{$siteName}} gives you the power to issue customized invoices directly from your dashboard.
                            Whether you’re closing a sale or billing for a service, our invoice feature helps you maintain
                            professionalism while keeping track of all transactions. It's simple, secure, and helps you
                            stay on top of your finances.
                        </p>
                    </div>
                </div>
                <div class="section-button">
                    <a href="{{route('register')}}" class="btn-masco btn-primary-l06 rounded-pill btn-shadow">
                        <span>Create an Account</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

{{--    <livewire:company.home/>--}}
    <!--~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3 : CTA
~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="cta-home-3">
        <div class="container">
            <div class="cta-home-3__inner">
                <div class="cta-home-3__image-block">
                    <div class="cta-home-3__image">
                        <img src="{{asset('home/image/appmockup4.webp')}}" alt="image alt">
                        <div class="cta-home-3__image-shape">
                            <img src="{{asset('home/image/cta/cta-3-shape.png')}}" alt="image alt">
                        </div>
                    </div>
                </div>
                <div class="cta-home-3__content-block">
                    <div class="cta-text-block">
                        <h2 class="cta-title heading-md text-black">List your business today and start receiving calls.</h2>
                        <p>By joining {{$siteName}}, you're opening your business up to the global fashion market. It is completely free to join
                            and start receiving bookings.</p>
                    </div>
                    <div class="cta-button-group">
                        <a href="#">
                            <img src="{{asset('home/image/apple-coming-soon.png')}}" alt="image alt" style="width: 150px;">
                        </a>
                        <a href="#">
                            <img src="{{asset('home/image/coming-soon-google.png')}}" alt="image alt" style="width: 150px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
