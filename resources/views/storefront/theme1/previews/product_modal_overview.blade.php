@inject('injected','App\Custom\Regular')
<div class="col-12 col-xl-6">

    <div class="wrap-modal-slider">

        <div class="slider-for">

            <div>
                <img src="{{ $product->featuredImage  }}" alt="" class="img-fluid">
            </div>
        </div>

    </div>

</div>
<div class="col-12 col-xl-6">
    <div class="product-info">
        <h4 class="product-title fw-bold mb-1">{{$product->name}}</h4>
        <p class="mb-0">{!! $product->description !!}</p>
        <div class="product-rating">
            <div class="hstack gap-2 border p-1 mt-3 width-content">
                <div><span class="rating-number">{{ number_format($averageRating, 1) }}</span><i class="bi bi-star-fill ms-1 text-success"></i></div>
                <div class="vr"></div>
                <div>{{ $totalRatings }} Ratings</div>
            </div>
        </div>
        <hr>
        <div class="product-price d-flex align-items-center gap-3">
            <div class="h4 fw-bold">{{$product->currency}}{{$product->amount}}</div>
        </div>
        <p class="fw-bold mb-0 mt-1 text-success">exclusive of all taxes</p>
        <form>
            @if($sizes->count()>0)
                <div class="size-chart mt-3">
                    <h6 class="fw-bold mb-3">Select Size</h6>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @foreach($sizes as $size)
                            <div class="">
                                <input type="radio" name="size" class="rounded-0">{{$size->name}}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if($colors->count()>0)
                    <div class="size-chart mt-3">
                        <h6 class="fw-bold mb-3">Select Color</h6>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @foreach($colors as $color)
                                <div class="">
                                    <input type="radio" name="color" class="rounded-0">{{$color->name}}
                                </div>
                            @endforeach

                        </div>
                    </div>
            @endif
            <div class="cart-buttons mt-3">
                <div class="buttons d-flex flex-column gap-3 mt-4">
                    <a href="javascript:;" class="btn btn-lg btn-dark btn-ecomm px-5 py-3 flex-grow-1"><i
                            class="bi bi-basket2 me-2"></i>Add to Bag</a>
                </div>
            </div>
        </form>
    </div>
</div>
