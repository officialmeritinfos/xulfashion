@extends('marketplace.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Breadcrumb start -->
        <div class="breadcrumb-wrap bg-f br-bg-1">
            <div class="overlay op-5 bg-black"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-10 offset-md-1">
                        <div class="breadcrumb-title">
                            <h2>{{$ad->title}}</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="{{route('marketplace.index',['country'=>$iso3])}}">Home </a></li>
                                <li><a href="#"> Listing</a></li>
                                <li>{{$ad->title}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bredcrumb end -->

        <!-- Car Details section start -->
        <div class="car-details-section ptb-100 bg-selago">
            <div class="container">
                <div class="row gx-5">
                    <div class="col-xl-8 col-lg-12">
                        <div class="single-car-slider">
                            <div class="swiper-container mySwiper2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{$ad->featuredImage}}" style="width: 300px;"/>
                                    </div>
                                    @foreach($photos as $photo)
                                        <div class="swiper-slide">
                                            <img src="{{$photo->photo}}" style="width: 300px;"/>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div thumbsSlider="" class="swiper-container mySwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{$ad->featuredImage}}" style="width: 150px;"/>
                                    </div>
                                    @foreach($photos as $photo)
                                    <div class="swiper-slide">
                                        <img src="{{$photo->photo}}" style="width: 150px;"/>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="single-car-description">
                            <div class="car-details-para">
                                <h4>Description</h4>
                                <p>
                                    {!! $ad->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="sidebar">
                            <div class="sidebar-widget car-desc-box">
                                <h1>{{$ad->title}}</h1>
                                <h3> @empty($ad->amount)
                                        Contact for Price
                                    @else
                                        {{$ad->currency}}{{$ad->amount}}
                                    @endempty
                                </h3>
                            </div>
                            <div class="sidebar-widget car-feature-box">
                                <h4>Contact Detail</h4>
                                <ul class="car-feature-list list-style">
                                    <li>
                                        <h6>Service Type</h6>
                                        <p>{{$injected->serviceTypeById($ad->serviceType)->name}}</p>
                                    </li>
                                    <li>
                                        <h6>Category</h6>
                                        <p> @php
                                                $cates = explode(',',$ad->tags)
                                            @endphp
                                            @foreach($cates as $cate)
                                                <span class="badge bg-primary text-white">
                                                {{$cate}}
                                            </span>
                                            @endforeach
                                        </p>
                                    </li>
                                    <li>
                                        <h6>Company Name</h6>
                                        <p>{{$ad->companyName}}</p>
                                    </li>
                                    <li>
                                        <h6>State</h6>
                                        <p>{{$injected->fetchState($ad->country,$ad->state)->name}}</p>
                                    </li>
                                    <li>
                                        <h6>Open To Negotiation</h6>
                                        <p>{{$injected->openToNegotiation($ad->openToNegotiation)}}</p>
                                    </li>
                                    <li>
                                        <h6>Address</h6>
                                        <p>{{$merchant->address}}</p>
                                    </li>
                                    <li>
                                        <h6><i class="fa fa-eye"></i> </h6>
                                        <p>{{$ad->numberOfViews}}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="sidebar-widget agent-box">
                                <div class="row">
                                    <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                                        <h4>Fashion Designer</h4>
                                        <div class="agent-img">
                                            <img  src="{{$merchant->photo}}" style="width: 150px;" alt="Image">
                                        </div>
                                        <div class="agent-info">
                                            <h5><a href="{{route('marketplace.merchant',['id'=>$merchant->reference])}}">{{$merchant->displayName}}</a></h5>
                                            <div class="contact-item">
                                                <div class="contact-icon">
                                                    <i class="flaticon-phone-call"></i>
                                                </div>
                                                <div class="contact-info">
                                                    <a href="tel:{{$merchant->phone}}">{{$merchant->phone}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($store))
                                <div class="sidebar-widget agent-box">
                                    <div class="row">
                                        <div class="col-xl-12 offset-xl-0 col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-12">
                                            <h4>Store Detail</h4>
                                            <div class="agent-img">
                                                <img  src="{{$store->logo}}" style="width: 150px;" alt="Image">
                                            </div>
                                            <div class="agent-info">
                                                <h5><a href="{{route('marketplace.merchant',['id'=>$merchant->reference])}}">{{$store->name}}</a></h5>
                                                <div class="contact-item">
                                                    <div class="contact-icon">
                                                        <i class="flaticon-phone-call"></i>
                                                    </div>
                                                    <div class="contact-info">
                                                        <a href="tel:{{$store->phone}}">{{$store->phone}}</a>
                                                    </div>
                                                </div>
                                                <div class="contact-item">
                                                    <div class="contact-icon">
                                                        <i class="fa fa-address-book"></i>
                                                    </div>
                                                    <div class="contact-info">
                                                        <a>{{$store->address}}</a>
                                                    </div>
                                                </div>
                                                <div class="contact-item">
                                                    <div class="contact-icon">
                                                        <i class="fa fa-link"></i>
                                                    </div>
                                                    <div class="contact-info">
                                                        <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}"
                                                           target="_blank">Visit Store</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Car Listing section end -->

        @if($ads->count()>0)
            <!-- Related car start -->
            <div class="bg-selago">
                <div class="container">
                    <div class="row pb-70">
                        <div class="col-md-12">
                            <div class="section-title style1 text-center mb-40">
                                <span>More Ads</span>
                                <h2>Explore Related Ads</h2>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="deals-slider-wrap">
                                <div class="deals-item-slider swiper-container">
                                    <div class="swiper-wrapper">

                                        @foreach($ads as $advert)
                                            <div class="swiper-slide">
                                                <div class="deals-card style1">
                                                    <div class="deals-img">
                                                        <img src="{{$advert->featuredImage}}" alt="Image" style="height: 300px;width: 350px;" class="lightboxed">
                                                    </div>
                                                    <div class="deals-info">
                                                        <h3 class="deals-title"><a href="{{route('marketplace.detail',['slug'=>\Illuminate\Support\Str::slug($advert->title),'id'=>$advert->reference])}}">
                                                                {{$advert->title}}
                                                            </a></h3>
                                                        <span class="deals-price">
                                                         @empty($advert->amount)
                                                                Contact for Price
                                                            @else
                                                                {{$advert->currency}}{{$advert->amount}}
                                                            @endempty
                                                    </span>
                                                        <ul class="deals-metainfo  list-style">
                                                            <li><a href="{{route('marketplace.state',['id'=>$advert->state])}}"><i class="flaticon-speedometer"></i>{{$advert->state}}</a></li>
                                                            <li><i class="flaticon-gear"></i>{{$advert->companyName}}</li>
                                                            <li><a href="{{route('marketplace.service',['id'=>$advert->serviceType])}}">
                                                                    <i class="flaticon-road-with-broken-line"></i>{{$injected->serviceTypeById($advert->serviceType)->name}}</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>
                                <div class="slider-btn style2 deals-prev"><i class="flaticon-left-arrow"></i></div>
                                <div class="slider-btn style2 deals-next"><i class="flaticon-right-arrow"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Related car end -->
        @endif

    </div>
    <!-- Content wrapper end -->

@endsection
