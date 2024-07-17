
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="color-scheme" content="dark light">
    <link rel="canonical" href="{{url('/')}}">
    <meta name="robots" content="index, follow">
    <meta property="og:locale" content="en_US">
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-navbutton-color" content="#000000">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="description" content="{{$pageName}}">
    <meta name="keywords" content="{{$web->keywords}}">
    <meta name="author" content="{{$siteName}}">
    <meta property="og:title" content="{{$siteName}} - {{$pageName}}">
    <meta property="og:description" content="{{$pageName}}">
    <meta property="og:image" content="{{asset($web->favicon)}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{$siteName}}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$siteName}} - {{$pageName}}">
    <meta name="twitter:description" content="{{$pageName}}">
    <meta name="twitter:image" content="{{asset($web->favicon)}}">
    <meta name="twitter:site" content="@{{$siteName}}">
    <meta name="twitter:creator" content="@{{$siteName}}">
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebSite",
          "name": "{{$siteName}}",
          "url": "{{url('/')}}",
          "description": "{{$pageName}}",
          "sameAs": [
            "https://www.facebook.com/{{$siteName}}",
            "https://www.twitter.com/{{$siteName}}",
            "https://www.instagram.com/get{{$siteName}}"
          ],
          "publisher": {
            "@type": "Organization",
            "name": "{{$siteName}}",
            "logo": {
              "@type": "ImageObject",
              "url": "{{asset($web->favicon)}}"
            }
          },
          "image": "{{asset($web->logo)}}"
        }
    </script>
    <!--====== Title ======-->
    <title>
        {{$siteName}} | {{$pageName}}
    </title>
    <!-- Plugin'stylesheets  -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/fonts/typography/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('home/fonts/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/plugins//aos/aos.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/plugins//fancybox/jquery.fancybox.min.css')}}">
    <!-- Vendor stylesheets  -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/plugins//bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/demo.css')}}">
    <style>
        @import url('https://fonts.cdnfonts.com/css/clash-display');
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@500;600;700&amp;display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600;700;800;900&amp;display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cabin:wght@500;600;700&amp;display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&amp;display=swap');
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;display=swap');
        @import url('https://fonts.cdnfonts.com/ss/clash-display');
    </style>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
</head>

<body>
<div class="preloader-wrapper">
    <div class="lds-ellipsis">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div class="page-wrapper overflow-hidden">
    <!--~~~~~~~~~~~~~~~~~~~~~~~~
     Header Area
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <header class="site-header site-header--transparent site-header--absolute">
        <div class="container">
            <nav class="navbar site-navbar">
                <!--~~~~~~~~~~~~~~~~~~~~~~~~
                  Brand Logo
              ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="brand-logo">
                    <a href="{{route('home.index')}}">
                        <!-- light version logo (logo must be black)-->
                        <img class="logo-light" src="{{asset($web->logo)}}" alt="brand logo">
                        <!-- Dark version logo (logo must be White)-->
                    </a>
                </div>
                <div class="menu-block-wrapper ">
                    <div class="menu-overlay"></div>
                    <nav class="menu-block" id="append-menu-header">
                        <div class="mobile-menu-head">
                            <a href="{{route('home.index')}}">
                                <img src="{{asset($web->logo2)}}" alt="brand logo" style="width: 100px;">
                            </a>
                            <div class="current-menu-title"></div>
                            <div class="mobile-menu-close">&times;</div>
                        </div>
                        <ul class="site-menu-main">
                            <li class="nav-item">
                                <a href="{{route('home.index')}}" class="nav-link-item drop-trigger">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('home.index')}}#about-us" class="nav-link-item drop-trigger">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('home.index')}}#features" class="nav-link-item drop-trigger">Features</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('home.index')}}#join-waitlist" class="nav-link-item drop-trigger">Join Wait-list</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~
                mobile menu trigger
               ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="mobile-menu-trigger">
                    <span></span>
                </div>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~
                  Mobile Menu Hamburger Ends
                ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <div class="header-cta-btn-wrapper">
                    <a href="{{route('home.index')}}#join-waitlist" class="btn-masco btn--header btn-primary-l03 btn-shadow rounded-pill">
                        <span>Join wait-list</span></a>
                </div>
            </nav>
        </div>
    </header>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~
     navbar-
    ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3 : Hero Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_hero-section">
        <div class="home-3_hero-shape">
            <img src="{{asset('home/image/home-3/hero-shape.png')}}" alt="image alt" />
        </div>
        <div class="container">
            <div class="row row--custom">
                <div class="col-lg-4 offset-lg-1 col-sm-4 col-5" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="300">
                    <div class="home-3_hero-image-block">
                        <div class="home-3_hero-image">
                            <img class="hero-image" src="{{asset('home/image/home-3/hero-mobile.png')}}" alt="hero image" />
                            <div class="home-3_hero-image-shape-1">
                                <img src="{{asset('home/image/home-3/hero-image-shape-1.svg')}}" alt="image shape" />
                            </div>
                            <div class="home-3_hero-image-shape-2">
                                <img src="{{asset('home/image/home-3/hero-image-shape-2.svg')}}" alt="image shape" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-10" data-aos-duration="1000" data-aos="fade-right" data-aos-delay="300">
                    <div class="home-3_hero-content">
                        <div class="home-3_hero-content-text">
                            <h3 class="hero-content__title heading-lg text-black">
                                Connecting Fashion Creators & Shoppers
                            </h3>
                            <p>
                                {{$siteName}} bridges the gap between fashion creators and shoppers globally. Our platform
                                empowers designers, tailors, and retailers to showcase unique creations and offers an engaging
                                shopping experience. Whether you're seeking the latest trends or aiming to reach a wider audience,
                                {{$siteName}} provides the tools and community for your success.
                            </p>
                        </div>
                        <div class="home-3_hero-content-stat-wrapper">
                            <a href="{{route('home.index')}}#join-waitlist" class="btn-masco btn-primary-l03 btn-shadow rounded-pill">
                                <span>Join Wait-list</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Feature Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_feature-section section-padding-100">
        <div class="container">
            <div class="row justify-content-center gutter-y-default">
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="700">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/h02-feature-2.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Seamless Online Booking</h3>
                            <p>
                                Xulfashion provides a seamless online booking system that allows shoppers to book
                                appointments with designers, tailors, and fashion consultants directly through the platform
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="600">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/icons/icon-service-2.svg')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">Dedicated Online Storefronts</h3>
                            <p>
                                With Xulfashion, fashion creators can set up dedicated online storefronts to showcase and sell their products.
                                Each storefront is customizable, allowing creators to reflect their brand's identity and offer a personalized shopping experience.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-xs-10" data-aos-duration="1000" data-aos="fade-left" data-aos-delay="500">
                    <div class="feature-widget">
                        <div class="feature-widget__icon">
                            <img src="{{asset('home/image/home-5/feature-3.png')}}" alt="image alt">
                        </div>
                        <div class="feature-widget__body">
                            <h3 class="feature-widget__title ">24/7 Customer Support</h3>
                            <p>
                                Xulfashion offers 24/7 customer support to ensure that both creators and shoppers have
                                assistance whenever they need it. Whether it’s resolving issues, answering questions, or
                                providing guidance, our support team is always available to help.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Content Section 1
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_content-section-1 padding-top-120 padding-bottom-150 bg-light-2">
        <div class="container">
            <div class="row row--custom ">
                <div class="offset-lg-1 col-xxl-auto col-md-3  col-xs-4 col-5" data-aos-duration="1000" data-aos="fade-right">
                    <div class="home-3_content-image-1-block ">
                        <div class="home-3_content-image-1">
                            <img src="{{asset('home/image/home-3/content-1.png')}}" alt="alternative text">
                        </div>
                        <div class="home-3_content-image-1-shape absolute-center">
                            <img src="{{asset('home/image/home-3/content-1-shape.svg')}}" alt="image shape" class="">
                        </div>
                    </div>
                </div>
                <div class="offset-xl-1 col-xl-6 col-lg-7 col-md-10 col-auto" data-aos-duration="1000" data-aos="fade-left">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">
                                Keep your body and mind healthy in a modern way
                            </h2>
                            <p>It allows users to track data, such as volume, time, weight, and goals, to compare their progress. Acting as a type of digital workout journal, this app helps you log workouts and utilize helpful graphs.</p>
                            <p>The app also allows users to create their own custom workout plans, down to the number of sets & reps for everyone, from beginner level.</p>
                        </div>
                        <div class="content-button-block">
                            <a href="about" class="btn-masco btn-primary-l03 btn-shadow rounded-pill"><span>Discover More</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Content Section 2
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_content-section-2 padding-bottom-120 bg-light-2">
        <div class="container">
            <div class="row row--custom ">
                <div class="col-xl-4 offset-lg-1 col-md-3 col-xs-4 col-5" data-aos-duration="1000" data-aos="fade-left">
                    <div class="home-3_content-image-2-block content-image--mobile-width">
                        <div class="home-3_content-image-2">
                            <img src="{{asset('home/image/home-3/content-2.png')}}" alt="alternative text">
                        </div>
                        <div class="home-3_content-image-2-shape absolute-center">
                            <img src="{{asset('home/image/home-3/content-2-shape.svg')}}" alt="image shape" class="">
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10  " data-aos-duration="1000" data-aos="fade-right">
                    <div class="content">
                        <div class="content-text-block">
                            <h2 class="content-title heading-md text-black">
                                Fitness tracker that can help you reach your goals
                            </h2>
                            <p>Strong workout tracker is for those who mean business and have been working out long enough to know exactly what they want</p>
                        </div>
                        <div class="content-list-block">
                            <ul class="content-list">
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Free version can save unlimited workouts &amp; custom routines
                                </li>
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Track progress with graphs and automatically back up data
                                </li>
                                <li class="content-list-item">
                                    <img src="{{asset('home/image/icons/icon-check-black.svg')}}" alt="alternative text">
                                    Connect easily with instructor for tips, feedback and support
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ticker-01_section">
        <div class="ticker-01_wrapper">
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
            </div>
            <div class="ticker-01_content">
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
                <div class="ticker-item">
                    <p>Start keeping your body and mind healthy</p>
                    <p>💪</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Video Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_video-section section-padding">
        <div class="home-3_video-shape">
            <img src="{{asset('home/image/home-3/video-shape.svg')}}" alt="">
        </div>
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="  col-xl-7 col-lg-8 col-md-10  ">
                    <div class="section-heading">
                        <h2 class="section-heading__title heading-md text-black">Discover classes and guides based on your interests</h2>
                    </div>
                </div>
            </div>
            <div class="row gutter-y-40 justify-content-center">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="video-widget">
                        <div class="video-widget__thumbnail-wrapper">
                            <div class="video-widget__thumbnail">
                                <img src="{{asset('home/image/home-3/video-thumbnail-1.png')}}" alt="image alt">
                                <a href="https://www.youtube.com/watch?v=zo9dJFo8H8g" data-fancybox class="btn-play absolute-center btn-play--outline btn-play--70">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                        <h3 class="video-widget__title">Custom workout plans</h3>
                        <p>Snaga is fully customizable workout app. Whether you do weightlifting, physical etc.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="video-widget">
                        <div class="video-widget__thumbnail-wrapper">
                            <div class="video-widget__thumbnail">
                                <img src="{{asset('home/image/home-3/video-thumbnail-2.png')}}" alt="image alt">
                                <a href="https://www.youtube.com/watch?v=zo9dJFo8H8g" data-fancybox class="btn-play absolute-center btn-play--outline btn-play--70">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                        <h3 class="video-widget__title">Clearing meditation</h3>
                        <p>A highly accessible meditation that will create more clarity &amp; space in the body.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="video-widget">
                        <div class="video-widget__thumbnail-wrapper">
                            <div class="video-widget__thumbnail">
                                <img src="{{asset('home/image/home-3/video-thumbnail-3.png')}}" alt="image alt">
                                <a href="https://www.youtube.com/watch?v=zo9dJFo8H8g" data-fancybox class="btn-play absolute-center btn-play--outline btn-play--70">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                        <h3 class="video-widget__title">Daily fitness challenges</h3>
                        <p>Snaga gives you achieve a specific goal with a specific exercise for daily activities.</p>
                    </div>
                </div>
                <div class="section-button">
                    <a href="#" class="btn-masco btn-primary-l03 rounded-pill btn-shadow">
                        <span>View All Classes</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3  : Testimonial Section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="home-3_testimonial section-padding-120">
        <div class="container">
            <div class="section-heading section-heading--row">
                <div class="row text-center text-lg-initial justify-content-center justify-content-lg-between">
                    <div class="col-xxl-6 col-lg-7 col-md-9 col-11">
                        <h2 class="section-heading__title heading-md text-black">People all over the world use snaga for their fitness</h2>
                    </div>
                    <div class="col-xl-3 col-md-4">
                        <div class="section-heading__button">
                            <a href="#" class="btn-masco btn-primary-l03 btn-shadow rounded-pill">
                                <span>View All Reviews</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-masonry">
                <div class="testimonial-masonry-item">
                    <div class="testimonial-card" data-aos="fade-left" data-aos-delay="100">
                        <img src="{{asset('home/image/icons/star-five.svg')}}" class="testimonial-card__star" alt="image alt">
                        <h3 class="testimonial-card__title">
                            Great value home exercise 💪🏼
                        </h3>
                        <p>
                            I was recommended masco from a dear friend and WOW!!! Gives energy, strength &amp; mostly your motivation and you helped me grow beyond my expectations.
                        </p>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__author-image">
                                <img src="{{asset('home/image/home-3/testimonial-authour-1.png')}}" alt="image alt">
                            </div>
                            <div class="testimonial-card__author-info">
                                <h4>Karen Lynn</h4>
                                <span>Founder @ Company</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-masonry-item">
                    <div class="testimonial-card" data-aos="fade-left" data-aos-delay="200">
                        <img src="{{asset('home/image/icons/star-five.svg')}}" class="testimonial-card__star" alt="image alt">
                        <h3 class="testimonial-card__title">
                            Such a wonderful fitness app ❤
                        </h3>
                        <p>
                            After a hiatus from the gym I needed some encouragement to help me get my confidence back😍
                        </p>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__author-image">
                                <img src="{{asset('home/image/home-3/testimonial-authour-2.png')}}" alt="image alt">
                            </div>
                            <div class="testimonial-card__author-info">
                                <h4>Dianne Russell</h4>
                                <span>Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-masonry-item">
                    <div class="testimonial-card" data-aos="fade-left" data-aos-delay="300">
                        <img src="{{asset('home/image/icons/star-five.svg')}}" class="testimonial-card__star" alt="image alt">
                        <h3 class="testimonial-card__title">
                            Love the home fitness tips
                        </h3>
                        <p>
                            Such a wonderful fitness plan! Someone who trains regularly but does not have any access to equipment, this plan has been a lifesaver. You don’t need anything but still get a great workout. The recipes are great and I love the guidance about when to eat what.
                        </p>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__author-image">
                                <img src="{{asset('home/image/home-3/testimonial-authour-3.png')}}" alt="image alt">
                            </div>
                            <div class="testimonial-card__author-info">
                                <h4>Marvin McKinney</h4>
                                <span>College Student</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-masonry-item">
                    <div class="testimonial-card" data-aos="fade-left" data-aos-delay="400">
                        <img src="{{asset('home/image/icons/star-five.svg')}}" class="testimonial-card__star" alt="image alt">
                        <h3 class="testimonial-card__title">
                            I can honestly say that I’ve enjoyed
                        </h3>
                        <p>
                            oth the workouts and the delicious receipts are easy to follow and to finish.It’s great to be part of a community.These times when so much has changed❤
                        </p>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__author-image">
                                <img src="{{asset('home/image/home-3/testimonial-authour-4.png')}}" alt="image alt">
                            </div>
                            <div class="testimonial-card__author-info">
                                <h4>Ronald Richards</h4>
                                <span>Businessman</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-masonry-item">
                    <div class="testimonial-card" data-aos="fade-left" data-aos-delay="500">
                        <img src="{{asset('home/image/icons/star-five.svg')}}" class="testimonial-card__star" alt="image alt">
                        <h3 class="testimonial-card__title">
                            10/10 would recommend👌🏼
                        </h3>
                        <p>
                            The workouts are fun to do but still make you sweat! I’m so grateful for the two of you for starting this amazing app️
                        </p>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__author-image">
                                <img src="{{asset('home/image/home-3/testimonial-authour-5.png')}}" alt="image alt">
                            </div>
                            <div class="testimonial-card__author-info">
                                <h4>Kristin Watson</h4>
                                <span>Social Influencer</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-masonry-item">
                    <div class="testimonial-card" data-aos="fade-left" data-aos-delay="600">
                        <img src="{{asset('home/image/icons/star-five.svg')}}" class="testimonial-card__star" alt="image alt">
                        <h3 class="testimonial-card__title">
                            Just completed week 3 and love the app
                        </h3>
                        <p>
                            As someone who has not exercised for a few years, it is great to be getting back into it with such accessible exercises and daily tips. Would recommend to anyone whatever fitness level, The workouts are really fun and my family are loving it too! Wonderful job guys 😍
                        </p>
                        <div class="testimonial-card__author">
                            <div class="testimonial-card__author-image">
                                <img src="{{asset('home/image/home-3/testimonial-authour-6.png')}}" alt="image alt">
                            </div>
                            <div class="testimonial-card__author-info">
                                <h4>Guy Hawkins</h4>
                                <span>Web Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--~~~~~~~~~~~~~~~~~~~~~~~~
    Home 3 : CTA
~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <div class="cta-home-3">
        <div class="container">
            <div class="cta-home-3__inner">
                <div class="cta-home-3__image-block">
                    <div class="cta-home-3__image">
                        <img src="{{asset('home/image/cta/cta-3.png')}}" alt="image alt">
                        <div class="cta-home-3__image-shape">
                            <img src="{{asset('home/image/cta/cta-3-shape.png')}}" alt="image alt">
                        </div>
                    </div>
                </div>
                <div class="cta-home-3__content-block">
                    <div class="cta-text-block">
                        <h2 class="cta-title heading-md text-black">Download now and start keeping yourself healthy</h2>
                        <p>The fitness builder app lets you create your own workouts based on your goals. Download on any device and keep yourself healthy.</p>
                    </div>
                    <div class="cta-button-group">
                        <a href="#">
                            <img src="{{asset('home/image/common/app-store.png')}}" alt="image alt">
                        </a>
                        <a href="#">
                            <img src="{{asset('home/image/common/play-store.png')}}" alt="image alt">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer padding-top-100 footer--light footer-l03">
        <div class="container">
            <div class="row row--footer-main">
                <div class="col-md-8 col-lg-5 col-xl-5 col-xxl-4">
                    <div class="footer__content-block">
                        <div class="footer__content-text">
                            <div class="footer-brand">
                                <img src="{{asset('home/image/logo-3.png')}}" alt="image alt">
                            </div>
                            <p>
                                We are strategic & creative digital agency who are focused on user experience, mobile, social, data gathering and promotional offerings.
                            </p>
                        </div>
                        <a href="#" class="footer-link">mascoexample@gmail.com</a>
                        <br>
                        <ul class="list-social list-social--hvr-primary-l3">
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-github"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class=" col-lg-7 col-xl-6 col-xxl-7 offset-xl-1">
                    <div class="row row--list-block">
                        <div class="col-auto col-md-4 col-lg-auto col-xl-auto col-xxl-auto">
                            <h3 class="footer-title">Primary Pages</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="#">Demos</a>
                                </li>
                                <li>
                                    <a href="#">About Us</a>
                                </li>
                                <li>
                                    <a href="#">Services</a>
                                </li>
                                <li>
                                    <a href="#">Pages</a>
                                </li>
                                <li>
                                    <a href="#">Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-auto col-md-4 col-lg-auto col-xl-auto col-xxl-auto">
                            <h3 class="footer-title">Utility pages</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="#">Instructions</a>
                                </li>
                                <li>
                                    <a href="#"> Style guide</a>
                                </li>
                                <li>
                                    <a href="#"> Licenses</a>
                                </li>
                                <li>
                                    <a href="#"> 404 Not found</a>
                                </li>
                                <li>
                                    <a href="#"> Password protected</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-auto col-md-4 col-lg-auto col-xl-auto col-xxl-auto">
                            <h3 class="footer-title">Resources</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="#">Support</a>
                                </li>
                                <li>
                                    <a href="#"> Privacy policy</a>
                                </li>
                                <li>
                                    <a href="#"> Terms & Conditions</a>
                                </li>
                                <li>
                                    <a href="#"> Strategic finance</a>
                                </li>
                                <li>
                                    <a href="#"> Video guide</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-block">
            <div class="container">
                <div class="copyright-inner text-center  copyright-border">
                    <p>© Copyright {{date('Y')}}, All Rights Reserved by {{$siteName}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor Scripts -->
<script src="{{asset('home/plugins//jquery/jquery.min.js')}}"></script>
<script src="{{asset('home/plugins//jquery/jquery-migrate.min.js')}}"></script>
<script src="{{asset('home/plugins//bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- Plugin's Scripts -->
<script src="{{asset('home/plugins//inlineSvg/inlineSvg.min.js')}}"></script>
<script src="{{asset('home/plugins//fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('home/plugins//aos/aos.min.js')}}"></script>
<script src="{{asset('home/plugins//isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('home/plugins//isotope/packery.pkgd.min.js')}}"></script>
<script src="{{asset('home/plugins//isotope/image.loaded.js')}}"></script>
<script src="{{asset('home/plugins//slick/slick.min.js')}}"></script>
<script src="{{asset('home/plugins//countdown/jquery.countdown.js')}}" defer></script>
<script src="{{asset('home/js/menu.js')}}"></script>
<script src="{{asset('home/js/custom.js')}}"></script>
</body>
</html>
