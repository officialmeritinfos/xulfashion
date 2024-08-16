@extends('mobile.layouts.base')
@section('content')

    <!-- onboarding section start -->
    <section class="section-b-space">
        <div class="swiper intro slider-1">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="theme-logo pb-3">
                        <img class="img-fluid logo-img" src="{{asset($web->logo2)}}" alt="logo" style="width: 150px;"/>
                    </div>
                    <div class="onboarding-design">
                        <img class="img-fluid design-img" src="{{asset('mobile/images/onboarding/design1.png')}}" alt="bg-design" />

                        <img class="img-fluid slider-img1" src="{{asset('mobile/images/onboarding/fashion-design.png')}}" alt="slider-1"
                             style="width: 2000px;"/>

                        <img class="img-fluid vector1" src="{{asset('mobile/images/onboarding/vector1.png')}}" alt="v1" />
                        <img class="img-fluid vector2" src="{{asset('mobile/images/onboarding/vector2.png')}}" alt="v2" />
                        <img class="img-fluid vector3" src="{{asset('mobile/images/onboarding/vector3.png')}}" alt="v3" />
                    </div>
                    <div class="product-details">
                        <h1>Fashion Designer</h1>
                        <span></span>
                        <p>
                            Increase your visibility and attract new customers on {{$siteName}}
                        </p>
                        <div class="redirate-btn">
                            <a  class="next-arrow" href="{{route('mobile.base')}}">
                                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="theme-logo pb-3">
                        <img class="img-fluid logo-img" src="{{asset($web->logo2)}}" alt="logo" style="width: 150px;"/>
                    </div>
                    <div class="onboarding-design">
                        <img class="img-fluid design-img" src="{{asset('mobile/images/onboarding/design1.png')}}" alt="bg-design" />

                        <img class="img-fluid slider-img2" src="{{asset('mobile/images/onboarding/catalogue.webp')}}" alt="slider-2" />

                        <img class="img-fluid vector1" src="{{asset('mobile/images/onboarding/vector1.png')}}" alt="v1" />
                        <img class="img-fluid vector2" src="{{asset('mobile/images/onboarding/vector2.png')}}" alt="v2" />
                        <img class="img-fluid vector3" src="{{asset('mobile/images/onboarding/vector3.png')}}" alt="v3" />
                    </div>
                    <div class="product-details">
                        <h1>Store Catalogue</h1>
                        <span></span>
                        <p>
                            Manage your catalogue, and sell your fashion & fashion accessories online faster and better with
                            {{$siteName}}
                        </p>
                        <div class="redirate-btn">
                            <a href="{{route('mobile.base')}}" class="next-arrow">
                                <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="theme-logo pb-3">
                        <img class="img-fluid logo-img" src="{{asset($web->logo2)}}" alt="logo" style="width: 150px;"/>
                    </div>
                    <div class="onboarding-design">
                        <img class="img-fluid design-img" src="{{asset('mobile/images/onboarding/design1.png')}}" alt="bg-design" />

                        <img class="img-fluid slider-img3" src="{{asset('mobile/images/onboarding/analytics.png')}}" alt="slider-3" />

                        <img class="img-fluid vector1" src="{{asset('mobile/images/onboarding/vector1.png')}}" alt="v1" />
                        <img class="img-fluid vector2" src="{{asset('mobile/images/onboarding/vector2.png')}}" alt="v2" />
                        <img class="img-fluid vector3" src="{{asset('mobile/images/onboarding/vector3.png')}}" alt="v3" />
                        <div class="product-details">
                            <h1>Store Analytics</h1>
                            <span></span>
                            <p>
                                Get an indepth analysis of your store performance right in your account - seamlessly manage your
                                inventory and sales.
                            </p>
                            <div class="redirate-btn">
                                <a href="{{route('mobile.base')}}" class="next-arrow">
                                    <i class="iconsax right-arrow" data-icon="arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- onboarding section end -->


@endsection
