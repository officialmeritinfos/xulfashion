@extends('company.layouts.base')
@section('content')
    <section class="blog_single_breadcrumb_area dark_bg" data-bg-color="#FFF8FD">
        <ul class="list-unstyled testimonial_bg_shap job_b_shap">
            <li data-parallax='{"x": 0, "y": -100}'><img src="{{asset('home/main/img/home-three/round.png')}}" alt=""></li>
        </ul>
        <div class="container">
            <div class="breadcrumb_content text-center">
                <h1 class="blog_title_big">{{$pageName}}</h1>
            </div>
        </div>
    </section>

    <section class="related_job sec_padding">
        <ul class="list-unstyled subscribe_pattern_bg">
            <li><img src="{{asset('home/main/img/contact/line_two.png')}}" alt="round-big"></li>
        </ul>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-6 job_post_item">
                    <div class="job_post_content">
                        <a href="{{route('home.terms-and-conditions')}}">
                            <h3 class="job_name">General Terms & Conditions</h3>
                        </a>
                        <span class="job_time">Last Updated: September, 2024</span>
                        <p class="mt-4">The terms that govern the use of {{$siteName}} for everyone.</p>
                        <a href="{{route('home.terms-and-conditions')}}" class="theme_btn_two hover_effect mt-3">Read Now <i
                                class="ti-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 job_post_item">
                    <div class="job_post_content">
                        <a href="{{route('home.privacy-policy')}}">
                            <h3 class="job_name">General Privacy Policy</h3>
                        </a>
                        <span class="job_time">Last Updated: September, 2024</span>
                        <p class="mt-4">How we process & handle your data on {{$siteName}}</p>
                        <a href="{{route('home.privacy-policy')}}" class="theme_btn_two hover_effect mt-3">Read Now <i
                                class="ti-arrow-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="qu_schedule_area" data-bg-color="#F6F9FF">
        <img class="qu_shap_one" src="{{asset('home/main/img/home-three/subscribe/round_circle.png')}}" alt="">
        <div class="container">
            <div class="qu_schedule_content">
                <h2>Get the visibility your business needs. </h2>
                <div class="d-flex mt-5">
                    <a href="{{route('register')}}" class="theme_btn hover_effect">Try it for free </a>
                    <a href="{{route('marketplace.index')}}" class="theme_btn_two border_btn hover_effect">See how it looks <i
                            class="ti-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="qu_laptop_img">
            <img src="{{asset('home/main/img/dashboard2.png')}}" alt="">
            <img class="qu_shap_two" src="{{asset('home/main/img/home-three/subscribe/dot.png')}}" alt="">
            <img class="qu_shap_three" src="{{asset('home/main/img/home-three/subscribe/dot_round.png')}}" alt="">
        </div>
    </section>

@endsection
