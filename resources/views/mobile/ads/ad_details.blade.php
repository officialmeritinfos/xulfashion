@extends('mobile.ads.layout.innerBaseProductDetail')
@section('content')
    @inject('injected','App\Custom\Regular')
    @push('css')
        <link rel="stylesheet" type="text/css" href="{{asset('mobile/css/vendors/swiper-bundle.min.css')}}" />
    @endpush

    <!-- product-image section start -->
    <section class="product2-image-section">
        <div class="custom-container">
            <div class="product2-img-slider">
                <img class="img-fluid product2-bg" src="{{asset('mobile/images/background/product-img-bg.png')}}" alt="product-bg" />
                <div class="swiper product-2">
                    <div class="swiper-wrapper">
                        @foreach($photos as $photo)
                        <div class="swiper-slide">
                            <img class="img-fluid product-img" src="{{$photo->photo}}" alt="p26" />
                        </div>
                        @endforeach
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
                        {{$ad->title}}
                    </h2>
                    <h6>
                        {{serviceTypeById($ad->serviceType)->name}}
                    </h6>
                </div>
                <p class="mt-1">
                    @php
                        $cates = explode(',',$ad->tags)
                    @endphp
                    @foreach($cates as $cate)
                        <span class="badge bg-primary text-white">
                            {{$cate}}
                        </span>
                    @endforeach
                </p>

                <div class="product-price">
                    <h3>
                        @empty($ad->amount)
                            Contact for Price
                        @else
                            {{currencySign($ad->currency)}} {{number_format($ad->amount,2)}}
                        @endempty
                    </h3>

                </div>
                <div class="d-flex justify-content-between gap-3">
                    <div class="dimensions-box">
                        <div class="d-block">
                            <h6>{{$ad->companyName}}</h6>
                        </div>
                    </div>
                    <div class="dimensions-box">
                        <div class="d-block">
                            <h6>Number of Views</h6>
                            <h6>
                                {{$ad->numberOfViews}}
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box">
                        <div class="d-block">
                            <h6>
                                {{$injected->fetchState($ad->country,$ad->state)->name}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- delivery section start -->
    <section>
        <div class="title">
            <h2>Fashion Designer</h2>
        </div>
        <div class="delivery-sec">

            <div class="d-flex justify-content-between gap-3">
                <div class="dimensions-box delivery-box">
                    <div class="d-block">
                        <h6>Contact</h6>
                        <h6 id="contact-number" style="cursor: pointer;">
                            Click to reveal
                        </h6>
                    </div>
                </div>
                <div class="dimensions-box delivery-box">
                    <div class="d-block">
                        <h6>Display Name</h6>
                        <h6><a href="{{route('mobile.marketplace.merchant',['id'=>$merchant->reference])}}">
                            {{$merchant->displayName??$merchant->username}}
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- delivery section end -->

    <!-- details section starts -->
    <section class="mb-4">
        <div class="custom-container">
            <h4 class="theme-color fw-semibold">Details :</h4>
            <p class="theme-color fw-normal mt-1">
                {!! $ad->description !!}
            </p>
        </div>
    </section>
    <!-- details section end -->

    @if(!empty($store))
        <section class="mb-4">
            <div class="title">
                <h2>Store</h2>
            </div>
            <div class="delivery-sec">

                <div class="d-flex justify-content-between gap-3">
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Logo</h6>
                            <h6>
                                <img  src="{{$store->logo}}" style="width: 150px;" alt="Image">
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Address</h6>
                            <h6>{{$store->address}}</h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Visit Store</h6>
                            <h6>

                                <a href="{{route('mobile.marketplace.store.detail',['id'=>$store->reference])}}">
                                    <img src="https://glenthemes.github.io/iconsax/icons/external-square.svg" style="font-size: 12px;"/>
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    <!-- similar product section starts -->
    <section class="similer-product">
        <div class="custom-container">
            <div class="title">
                <h2>Similar Ads</h2>
            </div>

            <div class="swiper similer-product">
                <div class="swiper-wrapper">
                    @foreach($ads as $ad)
                        <div class="swiper-slide">
                            <div class="product-box">
                                <div class="product-box-img">
                                    <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}">
                                        <img class="img" src="{{$ad->featuredImage}}" alt="p1" /></a>

                                    <div class="cart-box">
                                        <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($ad->title),'id'=>$ad->reference])}}" class="cart-bag">
                                            <i class="iconsax bag" data-icon="basket-2"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-box-detail">
                                    <h4>{{$ad->title}}</h4>
                                    <h5>{{serviceTypeById($ad->serviceType)->name}}</h5>
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
                                        <div class="rating">
                                            <img src="{{asset('mobile/images/svg/Star.svg')}}" alt="star" />
                                            <h6>4.5</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>
    <!-- similar product section end -->

    @push('js')
        <!-- range-slider js -->
        <script src="{{asset('mobile/js/range-slider.js')}}"></script>
        <script>
            $(document).ready(function(){
                var phoneNumber = '{{$merchant->phone}}';

                $('#contact-number').on('click', function(){
                    $(this).text(phoneNumber);
                });
            });
        </script>
    @endpush
@endsection
