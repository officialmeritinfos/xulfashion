@extends('mobile.ads.layout.innerBaseProductDetail')
@section('content')

    <!-- product-image section start -->
    <section class="product2-image-section">
        <div class="custom-container">
            <div class="product2-img-slider">
                <img class="img-fluid product2-bg" src="{{asset('mobile/images/background/product-img-bg.png')}}" alt="product-bg" />
                <div class="swiper product-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide swiper-slide-active">
                            <img class="img-fluid product-img active" src="{{$product->featuredImage}}" alt="{{$product->name}}" />
                        </div>
                        @foreach($photos as $photo)
                            <div class="swiper-slide">
                                <img class="img-fluid product-img" src="{{$photo->image}}" alt="p26" />
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
    <!-- product-image section end -->

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
                    <h2 class="theme-color">{{$product->name}}</h2>
                    <h6>{{storeCategoryById($product->category)->categoryName}}</h6>
                </div>
                <p class="mt-1">
                    {!! $product->description !!}
                </p>

                <div class="product-price">
                    <h3>{{currencySign($product->currency)}}{{number_format($product->amount,2)}} <del>{{currencySign($product->currency)}}{{number_format($product->amount+$product->amount*mt_rand(5,100)/100,2)}}</del></h3>
                    <div class="plus-minus">
                        <h6>Stock: {{$product->quantity}}</h6>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- delivery section start -->

    <!-- product-details section start -->
    <section class="position-relative">
        <div class="custom-container">
            <div class="product-details">
                <div class="delivery-sec">

                    <div class="d-flex justify-content-between gap-3">
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Store</h6>
                                <h6 style="word-break: break-word;">
                                    {{$store->name??$store->legalName}}
                                </h6>
                            </div>
                        </div>
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

                    </div>
                </div>
                <div class="delivery-sec">

                    <div class="d-flex justify-content-between gap-3">
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Contact</h6>
                                <h6  style="cursor: pointer;word-break: break-word;">
                                    <a href="https://api.whatsapp.com/send?phone={{formatContactToWhatsapp($store->phone,$store->country)}}&text=I%20came%20from%20Xulfashion,%20and%20I%20want%20to%20buy%20{{$product->name}}"
                                       target="_blank" class="back">
                                        <i class="fa fa-whatsapp" style="font-size: 50px;"></i>
                                    </a>
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Email</h6>
                                <h6 style="word-break: break-word;" id="contact-number">
                                    Click to Reveal
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box delivery-box">
                            <div class="d-block">
                                <h6>Buy online </h6>
                                <h6 >

                                    <a href="{{route('merchant.store.product.detail',['subdomain'=>$store->slug,'id'=>$product->reference])}}"
                                    target="_blank" class="back">
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
    @endpush
@endsection
