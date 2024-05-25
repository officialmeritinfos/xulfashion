@extends('marketplace.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

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
                                <li><a href="#"> Listing</a></li>
                                <li>{{$pageName}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Breadcrumb end -->

        <!-- Agent Details section start -->
        <section class="agent-details-wrap ptb-100 bg-selago">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="agent-details-wrapper">
                            <div class="row">
                                <div class="col-lg-5 col-md-6">
                                    <img src="{{$merchant->photo}}" alt="Image">
                                </div>
                                <div class="col-lg-7 col-md-6 ">
                                    <div class="agent-details">
                                        <h3>{{$merchant->name}}</h3>
                                        <ul class="address-list list-style">
                                            <li>
                                                        <span>
                                                            Company:
                                                        </span>
                                                {{$store->name??$merchant->displayName}}
                                            </li>
                                            <li>
                                                        <span>
                                                            Title:
                                                        </span>
                                                Owner
                                            </li>
                                            <li>
                                                        <span>
                                                            Office:
                                                        </span>
                                                <a href="tel:{{$store->phone??$merchant->phone}}">{{$store->phone??$merchant->phone}}</a>
                                            </li>
                                            <li>
                                                        <span>
                                                            Office:
                                                        </span>
                                                {{$store->address??$merchant->address}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="agent-bio mt-25">
                                        <h5>About Me</h5>
                                        <p>
                                            {!! $merchant->bio??$store->description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="sidebar">
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
        </section>
        <!-- Agent Details section end -->

        <!-- Car Listing section start -->
        <div class="car-listing-section ptb-100 bg-selago">
            <div class="container">
                <div class="section-title style1 text-center mb-40">
                    <span>Ads by Designer</span>
                    <h2>Explore Ads owned by Designer</h2>
                </div>
                <div class="row justify-content-center ">
                    @foreach($ads as  $index => $ad)
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4">
                            <div class="top-deal-card style1">
                                <a href="{{route('marketplace.detail',['slug'=>\Illuminate\Support\Str::slug($ad->title),'id'=>$ad->reference])}}" class="top-deal-img bg-f car-bg-6"
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
                                        <p><i class="flaticon-user-4"></i><a href="{{route('marketplace.merchant',['id'=>$injected->userById($ad->user)->reference])}}">{{$injected->userById($ad->user)->name}}</a></p>
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
                <div class="page-navigation">
                    <div class="row">
                        <div class="col-lg-12 ">

                            {{$ads->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Car Listing section end -->

    </div>
    <!-- Content wrapper end -->

    </div>
    <!-- Content wrapper end -->

@endsection
