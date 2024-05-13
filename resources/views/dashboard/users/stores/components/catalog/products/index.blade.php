@extends('dashboard.layout.base')
@section('content')

    <div class="product-area ">
        <div class="container-fluid">
            <div class="order-details-area row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <a href="{{route('user.stores.catalog.products.new')}}" class="new-orders">
                            Add New Product
                            <i class="ri-add-circle-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($products as $product)
                    <div class="col-xl-3 col-sm-6">
                        <div class="single-products">
                            <div class="products-img">
                                <img src="{{$product->featuredImage}}" alt="Images">

                                <div class="add-to-cart">
                                    <a href="cart.html" class="default-btn">
                                        Add To Cart
                                        <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="products-content d-flex">
                                <div class="product-title flex-grow-1">
                                    <h3>
                                        <a href="product-details.html">
                                            {{$product->name}}
                                        </a>
                                    </h3>
                                    <span class="price">{{$product->currency}}{{$product->amount}}</span>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <ul>
                                        <li>
                                            <i class="ri-star-s-fill"></i>
                                        </li>
                                        <li>
                                            <i class="ri-star-s-fill"></i>
                                        </li>
                                        <li>
                                            <i class="ri-star-s-fill"></i>
                                        </li>
                                        <li>
                                            <i class="ri-star-s-fill"></i>
                                        </li>
                                        <li>
                                            <i class="ri-star-s-fill"></i>
                                        </li>
                                    </ul>

                                    <span class="reviews">(100 Reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="mt-3">
                {{$products->links()}}
            </div>
        </div>
    </div>

@endsection
