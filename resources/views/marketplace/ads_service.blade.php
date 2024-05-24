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
        <!-- Bredcrumb end -->

        <!-- Car Listing section start -->
        <div class="car-listing-section ptb-100 bg-selago">
            <div class="container">
                <div class="row mb-30">
                    <div class="col-md-12">
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


@endsection
