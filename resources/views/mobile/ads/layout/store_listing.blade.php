
@foreach($stores as $store)
    <div class="col-6">
        <div class="product-box">
            <div class="product-box-img">
                <a href="{{route('mobile.marketplace.store.detail',['id'=>$store->reference])}}">
                    <img class="img" src="{{ $store->logo??$store->users->photo }}" alt="" /></a>

                <div class="cart-box">
                    <a href="{{route('mobile.marketplace.store.detail',['id'=>$store->reference])}}" class="cart-bag">
                        <i class="iconsax bag" data-icon="basket-2"></i>
                    </a>
                </div>
            </div>

            <div class="product-box-detail">
                <h4>{{$store->name}}</h4>
                <div class="d-flex justify-content-between gap-3">
                    <h5>{{shortenText($store->description,5)}}</h5>
                    <h3 class="fw-semibold">
                        {{getStateFromIso2($store->state,$store->country)->name}}
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endforeach
