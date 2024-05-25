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
                        <form action="{{route('marketplace.store.search')}}">
                            <div class="filter-box-wrap">
                                <div class="filter-box">
                                    <label>State/Region</label>
                                    <select name="state">
                                        @if($hasCountry==1)
                                            @foreach($states as $state)
                                                <option value="{{$state->iso2}}">{{$state->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="filter-box">
                                    <label>Name</label>
                                    <input name="name" type="text"/>
                                </div>
                                <div class="filter-box">
                                    <label>City</label>
                                    <input name="city" type="text"/>
                                </div>
                                <div class="filter-box">
                                    <label>Service</label>
                                    <select name="serviceType">
                                        @foreach($serviceTypes as $type)
                                            <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter-box">
                                    <button class="filter-btn" type="submit">Filter </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row gx-5">
                    <div class="col-xl-12 col-lg-12">
                        <div class="row justify-content-center ">
                            @foreach($stores as $store)
                                <div class="col-lg-4 col-md-4">
                                    <div class="top-deal-card style1">
                                        <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}" class="top-deal-img bg-f car-bg-1"
                                           style="background-image:url('{{$store->logo}}');">
                                        </a>
                                        <div class="top-deal-info">
                                            <h4 class="top-deal-title"><a href="{{route('merchant.store',['subdomain'=>$store->slug])}}">{{$store->name}}</a></h4>
                                            <div class="top-dealer-info">
                                                <p><i class="flaticon-user-4"></i>
                                                    <a href="{{route('marketplace.merchant',['id'=>$injected->userById($store->user)->reference])}}">
                                                        {{$injected->userById($store->user)->name}}
                                                    </a>
                                                </p>
                                                <p>Published: {{$injected->getTimeAgo($store->updated_at)}}</p>
                                            </div>
                                        </div>
                                        <ul class="deals-metainfo  list-style">
                                            <li><a href="{{route('marketplace.state',['id'=>$store->state])}}"><i class="flaticon-speedometer"></i>{{$store->state}}</a></li>
                                            <li><i class="flaticon-gear"></i>{{$store->legalName}}</li>
                                            <li><a href="{{route('marketplace.service',['id'=>$store->service])}}">
                                                    <i class="flaticon-road-with-broken-line"></i>{{$injected->serviceTypeById($store->service)->name}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="page-navigation">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    {{$stores->links()}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Car Listing section end -->

    </div>
    <!-- Content wrapper end -->

@endsection
