@extends('mobile.ads.layout.innerBaseProductDetail')
@section('content')
    @inject('injected','App\Custom\Regular')
    @push('css')
        <!-- Lightbox2 CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    @endpush

    <!-- product-image section start -->
    <section class="product2-image-section">
        <div class="custom-container">
            <div class="product2-img-slider">
                <img class="img-fluid product2-bg" src="{{asset('mobile/images/background/product-img-bg.png')}}" alt="product-bg" />
                <div class="swiper product-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="{{$store->logo}}" data-lightbox="image-1" class="back">
                                <img class="img-fluid product-img" src="{{$store->logo}}" alt="product-bg" />
                            </a>
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
                                <h6 id="contact-number" style="word-break: break-word;">
                                    Click to Reveal
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
                                <h6  style="cursor: pointer;word-break: break-word;">
                                    <a href="https://api.whatsapp.com/send?phone={{formatContactToWhatsapp($store->phone,$store->country)}}&text=Hi,%20I%20came%20from%20Xulfashion"
                                       target="_blank" class="back">
                                        <i class="fa fa-whatsapp" style="font-size: 50px;"></i>
                                    </a>
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
                                <h6  data-clipboard-text="">
                                    <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}" target="_blank" class="back">
                                        <i class="fa fa-external-link" style="font-size: 40px;"></i>
                                    </a>
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
                <a href="{{route('mobile.marketplace.catalog.index',['id'=>$store->reference])}}" style="cursor: pointer;">View All</a>
            </div>

            <div class="row g-4">
                @foreach($catalogs as $catalog)
                    <div class="col-6" style="cursor: pointer;">
                        <div class="product-box">
                            <div class="product-box-img">
                                <a href="{{route('mobile.marketplace.catalog.detail',['store'=>$store->reference,'catalog'=>$catalog->id])}}"
                                      > <img class="img" src="{{$catalog->photo??asset('customcategory.jpg')}}" alt="p10" /></a>

                                <div class="cart-box">
                                    <a  href="{{route('mobile.marketplace.catalog.detail',['store'=>$store->reference,'catalog'=>$catalog->id])}}"
                                           class="cart-bag ">
                                        <i class="iconsax bag" data-icon="basket-2"></i>
                                    </a>
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

    @if($ads->count()>0)
        <!-- shop section start -->
        <section class="section-b-space">
            <div class="custom-container">
                <div class="title">
                    <h2>Products &  Services by {{$store->name}}</h2>
                </div>
                <div class="row g-3">
                    @foreach($ads as  $index => $ad)
                        <div class="col-6">
                            <div class="product-box">
                                <div class="product-box-img">
                                    <a href=""{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}"> <img class="img" src="{{$ad->featuredImage}}" alt="p1" /></a>

                                    <div class="cart-box">
                                        <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}" class="cart-bag">
                                            <i class="iconsax bag" data-icon="basket-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-box-detail">
                                    <h4>{{$ad->title}}</h4>
                                    <h5>{{$ad->service->name}}</h5>
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

                    <div class="page-navigation">
                        <div class="row">
                            <div class="col-lg-12 ">

                                {{$ads->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @push('js')
        <!-- range-slider js -->
        <script src="{{asset('mobile/js/range-slider.js')}}"></script>
        <script>
            $(document).ready(function(){
                var phoneNumber = '{{$store->email}}';

                $('#contact-number').on('click', function(){
                    $(this).text(phoneNumber);
                });
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <script>
            $(document).ready(function() {
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true
                })
            });
        </script>
    @endpush
@endsection
