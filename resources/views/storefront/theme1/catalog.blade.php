@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')
    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$pageName}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->


    <section class="py-4">
        <div class="container">

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="shop-right-sidebar">

                        <div class="product-grid mt-4">
                            <div id="product-list" class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
                                @foreach($categories as $category)
                                    <div class="col">
                                        <div class="card border shadow-none">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{route('merchant.store.category',['subdomain'=>$subdomain,'id'=>$category->id])}}">
                                                    <img src="{{$category->photo??asset('customcategory.jpg')}}" class="card-img-top" alt="..."
                                                         style=" height: 250px; ">
                                                </a>
                                            </div>
                                            <div class="card-body border-top">
                                                <h5 class="mb-0 fw-bold product-short-title">{{$category->categoryName}}</h5>
                                                <p class="mb-0 product-short-name">{{$options->numberOfProductsInCategory($category->id)}} Products</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
