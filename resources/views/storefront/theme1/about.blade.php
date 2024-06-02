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

    <!--start product details-->
    <section class="section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-xl-12">
                    <h3 class="fw-bold">About Us</h3>
                    <p>
                        {!! $store->description !!}
                    </p>
                </div>
            </div><!--end row-->
            @if(count($setting->perkTitle)>0)
                <div class="separator section-padding">
                    <div class="line"></div>
                    <h3 class="mb-0 h3 fw-bold">Why Choose Us</h3>
                    <div class="line"></div>
                </div>

                <div class="row row-cols-1 row-cols-xl-3 g-4 why-choose">
                    @foreach($setting->perkTitle as $index=>$perk)
                    <div class="col d-flex">
                        <div class="card rounded-0 shadow-none w-100">
                            <div class="card-body">
                                <h5 class="my-3 fw-bold">{{$perk}}</h5>
                                <p class="mb-0">{!! $setting->perkContent[$index] !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif


        </div>
    </section>
    <!--start product details-->

    @if($categories->count()>0)
        <!--start cartegory slider-->
        <section class="cartegory-slider section-padding bg-section-2">
            <div class="container">
                <div class="text-center pb-3">
                    <h3 class="mb-0 h3 fw-bold">Store Catalog</h3>
                    <p class="mb-0 text-capitalize">Select your favorite categories and purchase</p>
                </div>
                <div class="cartegory-box">
                    @foreach($categories as $category)
                        <a href="{{route('merchant.store.category',['subdomain'=>$subdomain,'id'=>$category->id])}}">
                            <div class="card">
                                <div class="card-body">
                                    <div class="overflow-hidden">
                                        <img src="{{$category->photo??asset('customcategory.jpg')}}" class="card-img-top rounded-0" alt="..."
                                             style=" height: 200px; ">
                                    </div>
                                    <div class="text-center">
                                        <h5 class="mb-1 cartegory-name mt-3 fw-bold">{{$category->categoryName}}</h5>
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

@endsection
