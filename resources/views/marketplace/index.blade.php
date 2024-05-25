@extends('marketplace.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')



    <!-- Hero section start -->
    <section class="hero-wrap style2 bg-f hero-bg-1">
        <div class="overlay op-7 bg-black"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="hero-title">Find the Perfect Fashion Designer & Model in your city</h1>
                    <div class="hero-filter style1">
                        <ul class="nav nav-tabs filter-tablist" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab_10" type="button" role="tab">Fashion Designer</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link " data-bs-toggle="tab" data-bs-target="#tab_20" type="button" role="tab">Model</button>
                            </li>
                        </ul>
                        <div class="tab-content filter-tab-content">
                            <div class="tab-pane fade show active" id="tab_10" role="tabpanel">
                                <form action="{{route('marketplace.search')}}">
                                    <div class="filter-box-wrap">
                                        <div class="filter-box">
                                            <label>State/Region</label>
                                            <select name="state">
                                                <option>Select State</option>
                                                @if($hasCountry==1)
                                                    @foreach($states as $state)
                                                        <option value="{{$state->iso2}}">{{$state->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="filter-box">
                                            <label>Min Price</label>
                                            <input name="minPrice" type="number"/>
                                        </div>
                                        <div class="filter-box">
                                            <label>Max Price</label>
                                            <input name="maxPrice" type="number"/>
                                        </div>
                                        <div class="filter-box">
                                            <label>Type</label>
                                            <select name="serviceType">
                                                <option>Select Service Type</option>
                                                @foreach($serviceTypes as $type)
                                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="filter-box">
                                            <button class="filter-btn" type="submit">Search Listings</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tab_20" role="tabpanel">
                                <div class="filter-box-wrap">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero section end -->

    <!-- Dealer Section start -->
    <section class="dealer-wrap pt-100 pb-75 pos-rel">
        <span class="section_subtext style1">TOP DEALS</span>
        <div class="container">
            <div class="section-title style1 text-center mb-40">
                <span>Top Dealers</span>
                <h2>Explore Our Top Designers</h2>
            </div>
            <div class="tab-content deals-tab-content">
                <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                    <div class="row justify-content-center">
                        @foreach($ads as  $index => $ad)
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                <div class="top-deal-card style4">
                                    <a href="{{route('marketplace.detail',['slug'=>\Illuminate\Support\Str::slug($ad->title),'id'=>$ad->reference])}}"
                                       class="top-deal-img bg-f car-bg-6"
                                       style="background-image:url('{{$ad->featuredImage}}');">
                                    </a>
                                    <div class="top-deal-info">
                                        <div class="top-deal-price">
                                            <h6>
                                                @empty($ad->amount)
                                                    Contact for Price
                                                @else
                                                    {{$ad->currency}}{{$ad->amount}}
                                                @endempty
                                            </h6>
                                        </div>
                                        <h4 class="top-deal-title"><a href="{{route('marketplace.detail',['slug'=>\Illuminate\Support\Str::slug($ad->title),'id'=>$ad->reference])}}">{{$ad->title}}</a></h4>
                                        <div class="top-dealer-info">
                                            <p><i class="flaticon-user-4"></i><a href="{{route('marketplace.merchant',['id'=>$injected->userById($ad->user)->reference])}}">
                                                    {{$injected->userById($ad->user)->name}}</a></p>
                                            <p>Published: {{$injected->getTimeAgo($ad->updated_at)}}</p>
                                        </div>
                                    </div>
                                    <ul class="deals-metainfo  list-style">
                                        <li><a href="{{route('marketplace.state',['id'=>$ad->state])}}"><i class="flaticon-speedometer"></i>{{$ad->state}}</a></li>
                                        <li><i class="flaticon-gear"></i>{{$ad->companyName}}</li>
                                        <li><a href="{{route('marketplace.service',['id'=>$ad->serviceType])}}"><i class="flaticon-road-with-broken-line"></i>{{$injected->serviceTypeById($ad->serviceType)->name}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Dealer Section end -->

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

    <!-- Deal Section start -->
    <section class="deals-wrap pt-100 pb-75">
        <div class="container">
            <div class="row align-items-end  mb-40">
                <div class="col-xl-6  col-lg-6">
                    <div class="section-title style1 text-left">
                        <span>Recently Added</span>
                        <h2>Recently Added Designers</h2>
                    </div>
                </div>
            </div>
            <div class="tab-content deals-tab-content">
                <div class="tab-pane fade show active" id="tab_11" role="tabpanel">
                    <div class="row justify-content-center ">
                        @foreach($recentAds as  $recentAd)
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                                <div class="top-deal-card style2">
                                    <a href="{{route('marketplace.detail',['slug'=>\Illuminate\Support\Str::slug($recentAd->title),'id'=>$recentAd->reference])}}"
                                       class="top-deal-img bg-f car-bg-6"
                                       style="background-image:url('{{$recentAd->featuredImage}}');">
                                    </a>
                                    <div class="top-deal-info">
                                        <div class="top-deal-price">
                                            <h6>
                                                @empty($recentAd->amount)
                                                    Contact for Price
                                                @else
                                                    {{$recentAd->currency}}{{$recentAd->amount}}
                                                @endempty
                                            </h6>
                                        </div>
                                        <h4 class="top-deal-title"><a href="{{route('marketplace.detail',['slug'=>\Illuminate\Support\Str::slug($recentAd->title),'id'=>$recentAd->reference])}}">
                                                {{$recentAd->title}}</a></h4>
                                        <div class="top-dealer-info">
                                            <p><i class="flaticon-user-4"></i><a href="{{route('marketplace.merchant',['id'=>$injected->userById($recentAd->user)->reference])}}">
                                                    {{$injected->userById($recentAd->user)->name}}</a></p>
                                            <p>Published: {{$injected->getTimeAgo($recentAd->updated_at)}}</p>
                                        </div>
                                    </div>
                                    <ul class="deals-metainfo  list-style">
                                        <li><a href="{{route('marketplace.state',['id'=>$recentAd->state])}}"><i class="flaticon-speedometer"></i>{{$recentAd->state}}</a></li>
                                        <li><i class="flaticon-gear"></i>{{$recentAd->companyName}}</li>
                                        <li><a href="{{route('marketplace.service',['id'=>$recentAd->serviceType])}}"><i class="flaticon-road-with-broken-line"></i>{{$injected->serviceTypeById($recentAd->serviceType)->name}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Deal Section end -->

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

    <!-- Team section start -->
    <section class="team-wrap pt-100 pb-75">
        <div class="container">
            <div class="section-title style1 mb-40 text-center">
                <span>Fashion Designers </span>
                <h2>Best Selling Designers</h2>
            </div>
            <div class="row justify-content-center">
                @foreach($injected->topUsersByView() as $topUser)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="team-member-card style1">
                            <div class="member-img">
                                <img src="{{$topUser->photo}}" alt="Image">
                            </div>
                            <div class="member-info">
                                <h4><a href="{{route('marketplace.merchant',['id'=>$topUser->reference])}}">{{$topUser->name}}</a></h4>
                                <p>{{$topUser->displayName}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Team section end -->

    @if($testimonials->count()>0)
        <!-- Testimonial section start -->
        <section class="testimonial-wrap ptb-100 bg-wood">
            <div class="container pos-rel">
                <div class="section-title style1 text-center mb-30">
                    <span>Testimonials</span>
                    <h2>Trust From Our Clients</h2>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="testimonial-slider-one swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($testimonials as $testimony)
                                    <div class="swiper-slide">
                                        <div class="testimonial-item style1">
                                            <ul class="ratings   style1 list-style">
                                                <li><i class="flaticon-star"></i></li>
                                                <li><i class="flaticon-star"></i></li>
                                                <li><i class="flaticon-star"></i></li>
                                                <li><i class="flaticon-star"></i></li>
                                                <li><i class="flaticon-star"></i></li>
                                            </ul>
                                            <div class="client-quote">
                                                <p>{{$testimony->comment}}</p>
                                            </div>
                                            <div class="client-info-wrap">
                                                <div class="client-info">
                                                    <div class="client-img">
                                                        <img src="{{$testimony->photo}}" alt="Image">
                                                    </div>
                                                    <div class="client-name">
                                                        <h6>{{$testimony->name}}</h6>
                                                        <p>{{$testimony->position}}</p>
                                                    </div>
                                                </div>
                                                <div class="quote-icon">
                                                    <i class="flaticon-straight-quotes"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="testimonial-one-pagination slider-pagination style1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial section end -->
    @endif

    <!-- Partner section start -->
    <section class="partner-wrap bg-hint ptb-100">
        <div class="container pos-rel">
            <div class="section-title style1 text-center mb-40">
                <h2>Powered By Amazing Partners</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="partner-slider swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="partner-img">
                                    <img src="{{asset('partners/favicon.png')}}" alt="Image" data-bs-toggle="tooltip"
                                    title="Kopium-Net">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Partner section end -->

    @if($hasCountry!=1)
        @push('js')
            <!-- Modal -->
            <div class="modal fade" id="selectCountry" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Select Country</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                @foreach($country as $county)
                                    <div class="col-md-2 mt-1 col-4">
                                       <a href="{{route('marketplace.index',['country'=>$county->iso3])}}">
                                           <div class="card">
                                                <div class="card-body">
                                                    <img src="{{asset('country/'.strtolower($county->iso2).'.png')}}" style="width: 40px;"/>
                                                </div>
                                            </div>
                                       </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function(){
                    $("#selectCountry").modal('show');
                });
            </script>
        @endpush
    @endif


@endsection
