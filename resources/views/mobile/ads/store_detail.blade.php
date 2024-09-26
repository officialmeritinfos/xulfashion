@extends('mobile.ads.layout.innerBaseProductDetail')
@section('content')
    @inject('injected','App\Custom\Regular')

    <!-- product-image section start -->
    <section class="product2-image-section">
        <div class="custom-container">
            <div class="product2-img-slider">
                <img class="img-fluid product2-bg" src="{{asset('mobile/images/background/product-img-bg.png')}}" alt="product-bg" />
                <div class="swiper product-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="img-fluid product-img" src="{{$store->logo}}" alt="" />
                        </div>
                    </div>
                    <div class="swiper-button-next">
                        <i class="iconsax arrow" data-icon="arrow-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="iconsax arrow" data-icon="arrow-left"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- product-details section start -->
    <section class="position-relative">
        <img src="{{asset('mobile/images/effect.png')}}" class="img-fluid product-details-effect" alt="effect" />
        <img class="img-fluid product-details-effect-dark" src="{{asset('mobile/images/effect-dark.png')}}" alt="effect-dark" />
        <ul class="color-option">
            <li class="product-color color1"></li>
            <li class="product-color color2"></li>
            <li class="product-color color3"></li>
            <li class="product-color color4"></li>
        </ul>
        <div class="custom-container">
            <div class="product-details">
                <div class="product-name">
                    <h2 class="theme-color">
                        {{$store->name}}
                    </h2>
                    <h6>
                        {{serviceTypeById($store->service)->name}}
                    </h6>
                </div>

                <div class="delivery-sec">

                    <div class="d-flex justify-content-between gap-3">
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Address</h6>
                                <h6 style="word-break: break-word;">
                                   {{$store->address}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>State</h6>
                                <h6 style="word-break: break-word;">
                                    {{getStateFromIso2($store->state,$store->country)->name}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Email</h6>
                                <h6 style="word-break: break-word;">
                                    {{$store->email}}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="delivery-sec">

                    <div class="d-flex justify-content-between gap-3">
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Contact</h6>
                                <h6 id="contact-number" style="cursor: pointer;word-break: break-word;">
                                    Click to reveal
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Number of Views</h6>
                                <h6 style="word-break: break-word; ">
                                    {{$store->numberOfViews}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Store-front</h6>
                                <h6 ><span class="cpy-link" data-clipboard-text="{{route('merchant.store',['subdomain'=>$store->slug])}}"
                                          style="cursor: pointer;">
                                        <img src="https://glenthemes.github.io/iconsax/icons/document-copy.svg" style="font-size: 12px;"/>
                                    </span>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- delivery section start -->

    <!-- other furniture section start -->
    <section class="section-t-space">
        <div class="custom-container">
            <div class="title">
                <h2>Store Catalogue</h2>
                <span class="cpy-link" data-clipboard-text="{{route('merchant.store.catalog',['subdomain'=>$store->slug])}}" style="cursor: pointer;">View All</span>
            </div>

            <div class="row g-4">
                @foreach($catalogs as $catalog)
                    <div class="col-6 cpy-link" data-clipboard-text="{{route('merchant.store.category',['subdomain'=>$store->slug,'id'=>$catalog->id])}}"
                    style="cursor: pointer;">
                        <div class="product-box">
                            <div class="product-box-img">
                                <span class="cpy-link" data-clipboard-text="{{route('merchant.store.category',['subdomain'=>$store->slug,'id'=>$catalog->id])}}"
                                      > <img class="img" src="{{$catalog->photo??asset('customcategory.jpg')}}" alt="p10" /></span>

                                <div class="cart-box">
                                    <span  data-clipboard-text="{{route('merchant.store.category',['subdomain'=>$store->slug,'id'=>$catalog->id])}}"
                                           class="cart-bag cpy-link">
                                        <i class="iconsax bag" data-icon="basket-2"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="product-box-detail">
                                <h4>{{ucfirst($catalog->categoryName)}}</h4>
                                <div class="d-flex justify-content-between gap-3">
                                    <h5>{{numberOfProductsInCategory($catalog->id)}} Products</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    @push('js')
        <!-- range-slider js -->
        <script src="{{asset('mobile/js/range-slider.js')}}"></script>
        <script>
            $(document).ready(function(){
                var phoneNumber = '{{$store->phone}}';

                $('#contact-number').on('click', function(){
                    $(this).text(phoneNumber);
                });
            });
        </script>
    @endpush
@endsection
