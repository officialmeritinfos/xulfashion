@foreach($products as $product)
    <div class="col-md-6 col-6">
        <div class="product-box">
            <div class="product-box-img">
                <a href="{{route('mobile.marketplace.store.product.detail',['store'=>$store->reference,'product'=>$product->reference])}}">
                    <img class="img" src="{{$product->featuredImage}}" alt="p1" /></a>

                <div class="cart-box">
                    <a href="{{route('mobile.marketplace.store.product.detail',['store'=>$store->reference,'product'=>$product->reference])}}" class="cart-bag">

                        <img src="https://glenthemes.github.io/iconsax/icons/arrow-right.svg" style="font-size: 12px;"/>
                    </a>
                </div>
            </div>
            <div class="product-box-detail">
                <h4>{{$product->name}}</h4>
                <h5>{{storeCategoryById($product->category)->categoryName}}</h5>
                <div class="bottom-panel">
                    <div class="price">
                        <h4>{{currencySign($product->currency)}}{{shorten_number($product->amount)}} </h4>
                    </div>
                    <div class="rating">
                        <h6>Stock: </h6>
                        <h6>{{$product->quantity}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
