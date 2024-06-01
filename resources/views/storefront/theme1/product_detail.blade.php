@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')

    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$pageName}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--start product details-->
    <section class="py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-xl-7">
                    <div class="product-images">
                        <div class="product-zoom-images">
                            <div class="row row-cols-2 g-3">
                                <div class="col">
                                    <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{$product->featuredImage}}">
                                        <img src="{{$product->featuredImage}}" class="img-fluid" alt="">
                                    </div>
                                </div>
                                @foreach($images as $image)
                                    <div class="col">
                                        <div class="img-thumb-container overflow-hidden position-relative" data-fancybox="gallery" data-src="{{$image->image}}">
                                            <img src="{{$image->image}}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div><!--end row-->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-5">
                    <div class="product-info">
                        <h4 class="product-title fw-bold mb-1">{{$product->name}}</h4>
                        <p class="mb-0">{!! $product->description !!}</p>
                        <div class="product-rating">
                            <div class="hstack gap-2 border p-1 mt-3 width-content">
                                <div><span class="rating-number">{{ number_format($averageRating, 1) }}</span><i class="bi bi-star-fill ms-1 text-warning"></i></div>
                                <div class="vr"></div>
                                <div>{{ $totalRatings }} Ratings</div>
                            </div>
                        </div>
                        <hr>
                        <div class="product-price d-flex align-items-center gap-3">
                            <div class="h4 fw-bold">{{$product->currency}}{{$product->amount}}</div>
                        </div>
                        <p class="fw-bold mb-0 mt-1 text-success">exclusive of all taxes</p>

                        <form action="{{route('merchant.store.add.cart',['subdomain'=>$subdomain,'id'=>$product->reference])}}" method="post"
                              id="addToCartForms">
                            @csrf
                            @if($sizes->count()>0)
                                <div class="size-chart mt-3">
                                    <h6 class="fw-bold mb-3">Select Size</h6>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        @foreach($sizes as $size)
                                            <div class="">
                                                <input type="radio" name="size" class="rounded-0" value="{{$size->id}}"> {{$size->name}}
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
                                                <input type="radio" name="color" class="rounded-0" value="{{$color->id}}"> {{$color->name}}
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endif
                            <div class="quantity mt-3">
                                <h6 class="fw-bold mb-3">Quantity</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1">
                                </div>
                            </div>
                            <div class="cart-buttons mt-3">
                                <div class="buttons d-flex flex-column gap-3 mt-4">
                                    <button type="submit" class="btn btn-lg btn-dark btn-ecomm px-5 py-3 flex-grow-1 submit"><i
                                            class="bi bi-basket2 me-2"></i>Add to Bag</button>
                                </div>
                            </div>
                        </form>
                        <hr class="my-3">
                        <div class="product-info">
                            <h6 class="fw-bold mb-3">Product Features</h6>
                            {!! $product->keyFeatures !!}
                        </div>
                        @if(!empty($product->specifications))
                            <div class="product-info">
                                <h6 class="fw-bold mb-3">Product Specifications</h6>
                                {!! $product->specifications !!}
                            </div>
                        @endif
                        <hr class="my-3">
                        <div class="customer-ratings">
                            <h6 class="fw-bold mb-3">Customer Ratings</h6>
                            <div class="d-flex align-items-center gap-4 gap-lg-5 flex-wrap flex-lg-nowrap">
                                <div class="">
                                    <h1 class="mb-2 fw-bold">{{$averageRating}}<span class="fs-5 ms-2 text-warning"><i class="bi bi-star-fill"></i></span></h1>
                                    <p class="mb-0">{{$customers->count()}} Verified Buyers</p>
                                </div>
                                <div class="vr d-none d-lg-block"></div>
                                <div id="product-reviews"></div>
                            </div>
                        </div>

                        <hr class="my-3">
                        <div class="customer-reviews">
                            <h6 class="fw-bold mb-3">Customer Reviews ({{$totalRatings}})</h6>
                            <div class="reviews-wrapper">
                                @foreach($reviews as $review)
                                    <div class="d-flex flex-column flex-lg-row gap-3">
                                        <div class=""><span class="badge bg-green rounded-0">5<i class="bi bi-star-fill ms-1"></i></span></div>
                                        <div class="flex-grow-1">
                                            <p class="mb-2">
                                                {{$review->comment}}
                                            </p>
                                            <div class="d-flex flex-column flex-sm-row gap-3 mt-3">
                                                <div class="hstack flex-grow-1 gap-3">
                                                    <p class="mb-0">{{$options->fetchCustomerById($review->customer)->name??'N/A'}}</p>
                                                    <div class="vr"></div>
                                                    <div class="date-posted">{{date('d F Y',strtotime($review->created_at))}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                    <div class="text-center">
                                        {{$reviews->links()}}
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div>
    </section>
    <!--start product details-->


    <!--start product details-->
    <section class="section-padding">
        <div class="container">
            <div class="separator pb-3">
                <div class="line"></div>
                <h3 class="mb-0 h3 fw-bold">Similar Products</h3>
                <div class="line"></div>
            </div>
            <div class="similar-products">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-4 justify-content-center">
                    @foreach($similars as $similar)
                        <div class="col">
                            <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$similar->reference])}}">
                                <div class="card rounded-0">
                                    <img src="{{$similar->featuredImage}}" alt="" class="card-img-top rounded-0">
                                    <div class="card-body border-top">
                                        <h5 class="mb-0 fw-bold product-short-title">{{$similar->name}}</h5>
                                        <p class="mb-0 product-short-name">{{$options->fetchStoreCategoryById($similar->category)->categoryName??'Default'}}</p>
                                        <div class="product-price d-flex align-items-center gap-3 mt-2">
                                            <div class="h6 fw-bold">{{$similar->currency}}{{$similar->amount}}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach


                </div>
                <!--end row-->
            </div>
        </div>
    </section>
    <!--end product details-->


    @push('js')
        <script>
            $(document).ready(function() {
                var productId = '{{ $product->id }}';
                var url = '{{route('merchant.store.product.reviews',['subdomain'=>$subdomain,'id'=>$product->reference])}}'

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        $('#product-reviews').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching product reviews:', error);
                    }
                });
            });
        </script>
    @endpush
@endsection
