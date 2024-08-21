@foreach($ads as  $index => $ad)
    <div class="col-6">
        <div class="product-box">
            <div class="product-box-img">
                <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}">
                    <img class="img" src="{{$ad->featuredImage}}" alt="p1" /></a>

                <div class="cart-box">
                    <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}" class="cart-bag">
                        <i class="iconsax bag" data-icon="basket-2"></i>
                    </a>
                </div>
            </div>
            <div class="product-box-detail">
                <h4>{{$ad->title}}</h4>
                <h5>{{serviceTypeById($ad->serviceType)->name}}</h5>
                <div class="d-flex justify-content-between gap-3">
                    <h5>By: {{$ad->companyName}}</h5>
                    <h3 class="text-end">
                        {{getStateFromIso2($ad->state,$country->iso2)->name}}
                    </h3>
                </div>
                <div class="bottom-panel">
                    <div class="price">
                        <h4>
                            @empty($ad->amount)
                                Contact for Price
                            @else
                                {{currencySign($ad->currency)}} {{number_format($ad->amount,2)}}
                            @endempty
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
