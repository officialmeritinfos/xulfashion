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
                        <h1>
                            Discover Top Fashion Designers Near You
                        </h1>
                        <span></span>
                        <p>
                            Tired of searching for trusted fashion designers in your area? Find the best right here, effortlessly.
                        </p>
                        <div class="redirate-btn">
                            <a  class="next-arrow" href="{{route('mobile.marketplace.index',['country'=>$country->iso3])}}">
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

                        <img class="img-fluid slider-img2" src="{{asset('mobile/images/onboarding/shopping.png')}}" alt="slider-2" />

                        <img class="img-fluid vector1" src="{{asset('mobile/images/onboarding/vector1.png')}}" alt="v1" />
                        <img class="img-fluid vector2" src="{{asset('mobile/images/onboarding/vector2.png')}}" alt="v2" />
                        <img class="img-fluid vector3" src="{{asset('mobile/images/onboarding/vector3.png')}}" alt="v3" />
                    </div>
                    <div class="product-details">
                        <h1>Upgrade Your Style with the Best Fashion & Accessories</h1>
                        <span></span>
                        <p>
                            Ready to refresh your wardrobe? Shop from top local stores and have your favorites delivered to your doorstep.
                        </p>
                        <div class="redirate-btn">
                            <a href="{{route('mobile.marketplace.index',['country'=>$country->iso3])}}" class="next-arrow">
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

                        <img class="img-fluid slider-img3" src="{{asset('mobile/images/onboarding/model.png')}}" alt="slider-3" />

                        <img class="img-fluid vector1" src="{{asset('mobile/images/onboarding/vector1.png')}}" alt="v1" />
                        <img class="img-fluid vector2" src="{{asset('mobile/images/onboarding/vector2.png')}}" alt="v2" />
                        <img class="img-fluid vector3" src="{{asset('mobile/images/onboarding/vector3.png')}}" alt="v3" />
                        <div class="product-details">
                            <h1>
                                Connect with Top Models in Your Area
                            </h1>
                            <span></span>
                            <p>
                                Need a model for your brand or agency? Easily find the perfect talent for your project, right here.
                            </p>
                            <div class="redirate-btn">
                                <a href="{{route('mobile.marketplace.index',['country'=>$country->iso3])}}" class="next-arrow">
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
