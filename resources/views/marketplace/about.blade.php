@extends('marketplace.layout.base')
@section('content')
    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Breadcrumb start -->
        <div class="breadcrumb-wrap bg-f br-bg-1">
            <div class="overlay op-5 bg-black"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-10 offset-md-1">
                        <div class="breadcrumb-title">
                            <h2>{{$pageName}}</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="{{route('marketplace.index',['country'=>$iso3])}}">Home </a></li>
                                <li>{{$pageName}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bredcrumb end -->
        <section class="faq-wrap ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="faq-content">
                            <!-- About section start -->
                            <section class="about-wrap ptb-100 bg-wood">
                                <span class="section_subtext style1">ABOUT US</span>
                                <div class="about-shape-1 md-none">
                                    <img src="{{asset('marketplace/img/about/about-shape-2.png')}}" alt="Image">
                                </div>
                                <div class="container">
                                    <div class="row gx-5 align-items-center">
                                        <div class="col-xl-6 col-lg-5">
                                            <div class="about-img-wrap">
                                                <div class="about-img-one bg-f about-bg-1"></div>
                                                <div class="about-img-two bg-f about-bg-2">
                                                    <div class="about-shape-2 sm-none">
                                                        <img src="{{asset('marketplace/img/about/line-shape-1.png')}}" alt="Image">
                                                    </div>
                                                    <div class="experience-box">
                                                        {{--                                <h4><span>35</span>Years <br>Experience</h4>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-7">
                                            <div class="about-content">
                                                <div class="content-title style1">
                                                    <span>About Us</span>
                                                    <h2>Your Gateway to Global Fashion Connections</h2>
                                                    <h6>We are determined to provide the best fashion designer experience for you. Customer satisfaction is our main goals.</h6>
                                                    <p>
                                                        At {{$siteName}}, we believe in the power of creativity and the magic of connection. Our platform is
                                                        designed to bring together the world's most talented fashion designers and style-savvy clients,
                                                        creating a vibrant community where fashion knows no boundaries.
                                                    </p>
                                                    <p>
                                                        {{$siteName}} is more than just a marketplace; it's a movement. We provide an innovative platform
                                                        where fashion designers can showcase their work, connect with global clients, and receive bookings
                                                        from local fashion enthusiasts. Whether you're a designer looking to expand your reach or a client
                                                        seeking unique, high-quality fashion, {{$siteName}} is your go-to destination.
                                                    </p>
                                                    <ul class="feature-list list-style">
                                                        <li><span><i class="flaticon-checkmark"></i></span>Fair Pricing</li>
                                                        <li><span><i class="flaticon-checkmark"></i></span>Global Outreach</li>
                                                        <li><span><i class="flaticon-checkmark"></i></span>Store-front support</li>
                                                        <li><span><i class="flaticon-checkmark"></i></span>24/7 Support Provided</li>
                                                    </ul>
                                                    <a href="{{route('company.about')}}" class="btn style1">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- About section end -->

                            <!-- Why Choose us section start -->
                            <div class="why-choose-wrap choose-bg-1 bg-f pt-100 pb-75 pos-rel">
                                <div class="overlay op-6 bg-black"></div>
                                <div class="container pos-rel">
                                    <div class="section-title style1 text-center mb-40">
                                        <span class="text-white">Why Choose us</span>
                                        <h2 class="text-white">Why we are the best</h2>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="promo-item style2">
                                                <a href="!"></a>
                                                <div class="promo-icon">
                                                    <i class="flaticon-dress"></i>
                                                </div>
                                                <div class="promo-text">
                                                    <h4>Tailored for Fashion</h4>
                                                    <p>
                                                        Unlike generic marketplaces, {{$siteName}} is built exclusively for the fashion industry.
                                                        This means every feature, from our customizable storefronts to our booking system, is
                                                        designed with fashion designers and sellers in mind. You won’t have to wade through irrelevant
                                                        tools or categories; everything here is geared toward showcasing and selling fashion.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="promo-item style2">
                                                <a href="#"></a>
                                                <div class="promo-icon">
                                                    <i class="flaticon-hand"></i>
                                                </div>
                                                <div class="promo-text">
                                                    <h4>Global and Local Reach</h4>
                                                    <p>
                                                        {{$siteName}} provides the best of both worlds. Our platform allows you to reach an international
                                                        audience, opening up new markets and opportunities. At the same time, we enable you to connect
                                                        with local clients for bookings and personal services. This dual approach helps you build a robust,
                                                        versatile business that can thrive both online and offline.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="promo-item style2">
                                                <a href="#"></a>
                                                <div class="promo-icon">
                                                    <i class="flaticon-placeholder"></i>
                                                </div>
                                                <div class="promo-text">
                                                    <h4>Community and Support</h4>
                                                    <p>
                                                        Joining {{$siteName}} means becoming part of a vibrant, supportive community of fashion professionals.
                                                        We offer a space where designers and sellers can share insights, collaborate, and inspire
                                                        each other. Plus, our dedicated support team is always ready to assist you, ensuring that
                                                        your experience on the platform is smooth and successful.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6">
                                            <div class="promo-item style2">
                                                <a href="#"></a>
                                                <div class="promo-icon">
                                                    <i class="flaticon-money"></i>
                                                </div>
                                                <div class="promo-text">
                                                    <h4>Seamless E-commerce Experience</h4>
                                                    <p>
                                                        Setting up and managing an online store can be daunting, but not with {{$siteName}}. Our platform
                                                        offers an intuitive, user-friendly interface that makes creating and maintaining your store a
                                                        breeze. Secure payment gateways, easy inventory management, and comprehensive sales analytics
                                                        are all integrated, so you can focus on what you do best – designing and selling amazing fashion.
                                                        And the perk, we do not charge you like others do.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Why Choose us section end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
