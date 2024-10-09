@extends('mobile.users.layout.base')
@section('content')
<div class="main mt-2 mb-5">
    @if($ads->count()>0)
        <div class="container-fluid text-center">
            <a href="{{route('mobile.user.ads.new')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">Create Ad</a>
        </div>
    @endif
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Ads
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" title="Excludes ads which had expired or under review"></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{$totalAds}}</h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Views
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" title="Views and clicks recorded for active Ads."></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{$views}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($ads->count()<1)
        <!-- cart start -->
        <div class="custom-container">
            <div class="empty-tab">
                <img class="img-fluid empty-img" src="{{asset('mobile/images/gif/cart.gif')}}" alt="empty-cart" />

                <h2>Your Ad list is empty.</h2>
                <h5 class="mt-3">
                    You currently have not listed any ads. Click the button below to create an ad
                </h5>

                <a href="{{route('mobile.user.ads.new')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">Create Ad</a>
            </div>
        </div>
    @else
            <section class="section-b-space">
                <div class="custom-container">
                    <div class="row g-3">
                        @foreach($ads as $ad)
                            <div class="col-6">
                                <div class="product-box">
                                    <div class="product-box-img">
                                        <a href="{{route('mobile.marketplace.detail',[ 'slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}"> <img class="img" src="{{$ad->featuredImage}}" alt="p1" /></a>

                                        <div class="cart-box">
                                            <a href="{{route('mobile.user.ads.detail',['id'=>$ad->reference])}}" class="cart-bag">
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-box-detail">
                                        <h4>{{$ad->title}}</h4>
                                        <h5>
                                            {{$ad->service->name}}
                                        </h5>
                                        <div class="bottom-panel">
                                            <div class="price">
                                                <h4>
                                                    @if($ad->priceType==1)
                                                        Contact for price
                                                    @else
                                                        {{currencySign($ad->currency)}}{{shorten_number($ad->amount)}}
                                                    @endif
                                                </h4>
                                            </div>
                                            <div class="rating">
                                                <h6>Status: </h6>
                                                <h6>
                                                    @switch($ad->status)
                                                        @case(1)
                                                            <i class="fa fa-check-circle text-success" style="font-size: 14px;"
                                                            data-bs-toggle="tooltip" title="Active"></i>
                                                            @break
                                                        @case(2)
                                                           <i class="fa fa-rotate-270 fa-rotate text-primary" style="font-size: 14px;"
                                                              data-bs-toggle="tooltip" title="Review"></i>
                                                            @break
                                                        @case(3)
                                                           <i class="fa fa-ban text-danger" style="font-size: 14px;"
                                                              data-bs-toggle="tooltip" title="Cancelled"></i>
                                                            @break
                                                        @default
                                                            <i class="fa fa-warning text-danger" style="font-size: 14px;"
                                                               data-bs-toggle="tooltip" title="Rejected"></i>
                                                            @break
                                                    @endswitch
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
    @endif

</div>
@endsection
