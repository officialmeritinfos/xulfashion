@foreach($ads as $ad)
    <div class="col-6">
        <div class="product-box">
            <div class="product-box-img">
                <a href="{{route('mobile.user.ads.detail',['id'=>$ad->reference])}}"> <img class="img" src="{{$ad->featuredImage}}" alt="p1" /></a>

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
