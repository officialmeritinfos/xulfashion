@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')


    <!--start carousel-->
    <section class="slider-section">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @if($sliders->count()>0)
                    @foreach($sliders as $index =>$slider)
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$index}}" class="active"
                                aria-current="true"></button>
                    @endforeach
                @else
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"></button>
                @endif
            </div>
            <div class="carousel-inner">
                @if($sliders->count()>0)
                    @foreach($sliders as $slider)
                        <div class="carousel-item active bg-primary">
                            <div class="row d-flex align-items-center">
                                <div class="col d-none d-lg-flex justify-content-center">
                                    <div class="">
                                        <h3 class="h3 fw-light text-white fw-bold">{{$options->fetchStoreCategoryById($slider->category)->categoryName}}</h3>
                                        <h1 class="h1 text-white fw-bold">{{$slider->name}}</h1>
                                        <p class="text-white fw-bold"><i class="text-white">{!! \Illuminate\Support\Str::words($slider->description,30) !!}</i></p>
                                        <div class=""><a class="btn btn-dark btn-ecomm" href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <img src="{{ $slider->featuredImage}}" class="img-fluid" alt="...">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item bg-red">
                        <div class="row d-flex align-items-center">
                            <div class="col d-none d-lg-flex justify-content-center">
                                <div class="">
                                    <h3 class="h3 fw-light text-white fw-bold">Latest Trending</h3>
                                    <h1 class="h1 text-white fw-bold">Fashion Wear</h1>
                                    <p class="text-white fw-bold"><i>Best Fashion wears</i></p>
                                    <div class=""> <a class="btn btn-dark btn-ecomm" href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <img src="{{ asset('templates/' . $theme . '/assets/images/sliders/s_2.webp')}}" class="img-fluid" alt="...">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item bg-purple">
                        <div class="row d-flex align-items-center">
                            <div class="col d-none d-lg-flex justify-content-center">
                                <div class="">
                                    <h3 class="h3 fw-light text-white fw-bold">New Trending</h3>
                                    <h1 class="h1 text-white fw-bold">Kids Fashion</h1>
                                    <p class="text-white fw-bold"><i>Best Kids wears</i></p>
                                    <div class=""><a class="btn btn-dark btn-ecomm" href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <img src="{{ asset('templates/' . $theme . '/assets/images/sliders/s_3.webp')}}" class="img-fluid" alt="...">
                            </div>
                        </div>
                    </div>

                @endif


            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!--end carousel-->


    <!--start Featured Products slider-->
    <section class="section-padding">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Featured Products</h3>
                <p class="mb-0 text-capitalize"></p>
            </div>
            <div class="product-thumbs">
                @foreach($featureds as $featured)
                    <div class="card">
                        <div class="position-relative overflow-hidden">
                            <div
                                class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"
                                   data-reference="{{$featured->reference}}"
                                   data-action="{{route('merchant.store.product.quick-view',['subdomain'=>$subdomain,'id'=>$featured->reference])}}"><i
                                        class="bi bi-zoom-in"></i></a>
                            </div>
                            <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$featured->reference])}}">
                                <img src="{{$featured->featuredImage}}" class="card-img-top" alt="...">
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="product-info text-center">
                                <h6 class="mb-1 fw-bold product-name">{{$featured->name}}</h6>
                                <div class="ratings mb-1 h6">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>
                                <p class="mb-0 h6 fw-bold product-price">{{$featured->currency}}{{$featured->amount}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--end Featured Products slider-->


    <!--start tabular product-->
    <section class="product-tab-section section-padding bg-light">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Latest Products</h3>
                <p class="mb-0 text-capitalize"></p>
            </div>
            <div class="row">
                <div class="col-auto mx-auto">
                    <div class="product-tab-menu table-responsive">
                        <ul class="nav nav-pills flex-nowrap" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#new-arrival" type="button">New
                                    Arrival</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#trending-product"
                                        type="button">Trending</button>
                            </li>

                            @if(count($options->mostOrderProducts($store->id))>0)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#best-sellar" type="button">Best
                                        Selling</button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="tab-content tabular-product">
                <div class="tab-pane fade show active" id="new-arrival">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4 justify-content-center">
                        @foreach($latests as $latest)
                            <div class="col">
                                <div class="card">
                                    <div class="position-relative overflow-hidden">
                                        <div
                                            class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                            <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"
                                               data-reference="{{$latest->reference}}"
                                               data-action="{{route('merchant.store.product.quick-view',['subdomain'=>$subdomain,'id'=>$latest->reference])}}"><i
                                                    class="bi bi-zoom-in"></i></a>
                                        </div>
                                        <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$latest->reference])}}">
                                            <img src="{{$latest->featuredImage}}" class="card-img-top" alt="...">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="product-info text-center">
                                            <h6 class="mb-1 fw-bold product-name">{{$latest->name}}</h6>
                                            <div class="ratings mb-1 h6">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </div>
                                            <p class="mb-0 h6 fw-bold product-price">{{$latest->currency}}{{$latest->amount}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach


                    </div>
                </div>
                <div class="tab-pane fade" id="best-sellar">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">

                        @if(count($options->mostOrderProducts($store->id))>0)
                            @foreach($options->mostOrderProducts($store->id) as $best)
                                <div class="col">
                                    <div class="card">
                                        <div class="position-relative overflow-hidden">
                                            <div
                                                class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                                <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"
                                                   data-reference="{{$best['reference']}}"
                                                   data-action="{{route('merchant.store.product.quick-view',['subdomain'=>$subdomain,'id'=>$best['reference']])}}"><i
                                                        class="bi bi-zoom-in"></i></a>
                                            </div>
                                            <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$best['reference']])}}">
                                                <img src="{{$best['featuredImage']}}" class="card-img-top" alt="...">
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="product-info text-center">
                                                <h6 class="mb-1 fw-bold product-name">{{$best['product']}}</h6>
                                                <div class="ratings mb-1 h6">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </div>
                                                <p class="mb-0 h6 fw-bold product-price">{{$best['currency']}}{{$best['amount']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="trending-product">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">

                        @foreach($trendings as $trending)
                            <div class="col">
                                <div class="card">
                                    <div class="position-relative overflow-hidden">
                                        <div
                                            class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                            <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal"
                                               data-reference="{{$trending->reference}}"
                                               data-action="{{route('merchant.store.product.quick-view',['subdomain'=>$subdomain,'id'=>$trending->reference])}}"><i
                                                    class="bi bi-zoom-in"></i></a>
                                        </div>
                                        <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$trending->reference])}}">
                                            <img src="{{$trending->featuredImage}}" class="card-img-top" alt="...">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="product-info text-center">
                                            <h6 class="mb-1 fw-bold product-name">{{$trending->name}}</h6>
                                            <div class="ratings mb-1 h6">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </div>
                                            <p class="mb-0 h6 fw-bold product-price">{{$trending->currency}}{{$trending->amount}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--end tabular product-->


    @if(count($setting->perkTitle)>0)
        <!--start features-->
        <section class="product-thumb-slider section-padding">
            <div class="container">
                <div class="text-center pb-3">
                    <h3 class="mb-0 h3 fw-bold">What We Offer!</h3>
                </div>

                <div class="row row-cols-1 row-cols-lg-3 g-4 justify-content-center">

                    @foreach($setting->perkTitle as $index=>$perk)
                        <div class="col d-flex">
                            <div class="card depth border-0 rounded-0 border-bottom border-primary border-3 w-100">
                                <div class="card-body text-center">
                                    <div class="h1 fw-bold my-2 text-primary">
                                        <i class="{{$setting->perkIcon[$index]}}"></i>
                                    </div>
                                    <h5 class="fw-bold">{{$perk}}</h5>
                                    <p class="mb-0">{!! $setting->perkContent[$index] !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <!--end row-->
            </div>
        </section>
        <!--end features-->
    @endif


    @if(!empty($highlighted))

        <!--start special product-->
        <section class="section-padding bg-section-2">
            <div class="container">
                <div class="card border-0 rounded-0 p-3 depth">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6 text-center">
                            <img src="{{ $highlighted->featuredImage}}" class="img-fluid rounded-0" alt="...">
                        </div>
                        <div class="col-lg-6">
                            <div class="card-body">
                                <h3 class="fw-bold">Highlighted Product</h3>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-transparent px-0">
                                        {!! $highlighted->name !!}
                                    </li>
                                    <li class="list-group-item bg-transparent px-0">
                                        {!! $highlighted->description !!}
                                    </li>
                                    {!! $highlighted->keyFeatures !!}
                                </ul>
                                <div class="buttons mt-4 d-flex flex-column flex-lg-row gap-3">
                                    <a href="javascript:;" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">Buy Now</a>
                                    <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$highlighted->reference])}}"
                                       class="btn btn-lg btn-outline-dark btn-ecomm px-5 py-3">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--start special product-->
    @endif

    @if($categories->count()>0)
    <!--start cartegory slider-->
    <section class="cartegory-slider section-padding bg-section-2">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Store Categories</h3>
                <p class="mb-0 text-capitalize">Select your favorite categories and purchase</p>
            </div>
            <div class="cartegory-box">
                @foreach($categories as $category)
                    <a href="{{route('merchant.store.category',['subdomain'=>$subdomain,'id'=>$category->id])}}">
                        <div class="card">
                            <div class="card-body">
                                <div class="overflow-hidden">
                                    <img src="{{$category->photo??asset('customcategory.jpg')}}" class="card-img-top rounded-0" alt="..."
                                    style="height: 200px; ">
                                </div>
                                <div class="text-center">
                                    <h5 class="mb-1 cartegory-name mt-3 fw-bold">{{$category->phoyo}}</h5>
                                    <h6 class="mb-0 product-number fw-bold">{{$options->numberOfProductsInCategory($category->id)}} Products</h6>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </section>
    <!--end cartegory slider-->
    @endif


    <!--subscribe banner-->
    <section class="product-thumb-slider subscribe-banner p-5">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">
                <div class="text-center">
                    <h3 class="mb-0 fw-bold text-white">Get Latest Update by <br> Subscribing to Our Newslater</h3>
                    <div class="mt-3">
                        <input type="text" class="form-control form-control-lg bubscribe-control rounded-0 px-5 py-3"
                               placeholder="Enter your email">
                    </div>
                    <div class="mt-3 d-grid">
                        <button type="button" class="btn btn-lg btn-ecomm bubscribe-button px-5 py-3">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--subscribe banner-->





@endsection
