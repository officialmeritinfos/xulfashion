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
    <meta name="twitter:site" content="@ {{$siteName}}">
    <meta name="twitter:creator" content="@ {{$siteName}}">
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
{{--    <script--}}
{{--        src='//uae.fw-cdn.com/40063761/21716.js'--}}
{{--        chat='true'>--}}
{{--    </script>--}}
    <title>
        {{$siteName}} | {{$pageName}}
    </title>
    <!-- Preload key images -->
    <link rel="preload" href="{{asset('home/image/11.webp')}}" as="image">
    <link rel="preload" href="{{asset('home/image/home-3/hero-shape.png')}}" as="image">
    <!-- Inline critical CSS -->
    <style>
        .home-3_hero-section {
            /* Add critical styles here */
            padding-top: 100px;
            padding-bottom: 40px;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .hero-content__title {
            /* Add critical styles here */
        }
        /* Add other critical CSS here */
    </style>
    <!-- Plugin'stylesheets -->
    <link rel="stylesheet" href="{{asset('home/fonts/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/plugins/aos/aos.min.css')}}" defer>
    <link rel="stylesheet" href="{{asset('home/plugins/fancybox/jquery.fancybox.min.css')}}" defer>
    <!-- Vendor stylesheets -->
    <link rel="stylesheet" href="{{asset('home/plugins/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('home/css/demo.css')}}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
    @stack('css')
</head>
<body>
<div class="page-wrapper overflow-hidden">
    <!-- Header Area -->
    <header class="site-header site-header--transparent site-header--absolute">
        <div class="container">
            <nav class="navbar site-navbar">
                <div class="brand-logo">
                    <a href="{{route('home.index')}}">
                        <img class="logo-light" src="{{asset($web->logo)}}" alt="brand logo">
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
                                <a href="{{route('home.about')}}" class="nav-link-item drop-trigger">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('marketplace.index')}}" class="nav-link-item drop-trigger">Directory</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('home.features')}}" class="nav-link-item drop-trigger">Features</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('register')}}" class="nav-link-item drop-trigger">Get Started</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-menu-trigger">
                    <span></span>
                </div>
                <div class="header-cta-btn-wrapper">
                    <a href="{{route('register')}}" class="btn-masco btn--header btn-primary-l03 btn-shadow rounded-pill">
                        <span>Get Started</span>
                    </a>
                </div>
            </nav>
        </div>
    </header>
    @yield('content')

    <div class="footer padding-top-100 footer--light footer-l03">
        <div class="container">
            <div class="row row--footer-main">
                <div class="col-md-8 col-lg-5 col-xl-5 col-xxl-4 col-12">
                    <div class="footer__content-block">
                        <div class="footer__content-text">
                            <div class="footer-brand">
                                <img src="{{asset($web->logo)}}" style="width: 120px;" alt="image alt">
                            </div>
                            <p>
                                We are No.1 fashion platform that connects fashion creators and retailers to shoppers globally.
                                {{$siteName}} stands as a dedicated platform tailored for the vibrant and diverse world of
                                fashion.
                            </p>
                            <p>
                                {!! $web->address !!}
                            </p>
                        </div>
                        <a href="{{$web->email}}" class="footer-link">{{$web->email}}</a>
                        <br>
                        <ul class="list-social list-social--hvr-primary-l3">
                            <li>
                                <a href="https://linkedin.com/company/xulfashion" target="_blank">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="http://twitter.com/xulfashion" target="_blank">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://instagram.com/getxulfashion" target="_blank">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class=" col-lg-7 col-xl-6 col-xxl-7 offset-xl-1 col-12">
                    <div class="row row--list-block">
                        <div class="col-auto col-md-4 col-lg-auto col-xl-auto col-xxl-auto col-6">
                            <h3 class="footer-title">Company</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{route('home.about')}}">About Us</a>
                                </li>
                                <li>
                                    <a href="{{route('home.pricing')}}">Pricing</a>
                                </li>
                                <li>
                                    <a href="{{route('home.contact')}}">Contact</a>
                                </li>
                                <li>
                                    <a href="{{route('home.download')}}">Download App</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-auto col-md-4 col-lg-auto col-xl-auto col-xxl-auto">
                            <h3 class="footer-title">Resources</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{$web->blogLink}}" target="_blank">Blog</a>
                                </li>
                                <li>
                                    <a href="{{route('home.faq')}}"> FAQs</a>
                                </li>
                                <li>
                                    <a href="{{$web->ticketHelpDesk}}" target="_blank"> Support</a>
                                </li>
                                <li>
                                    <a href="{{config('app.feature_request_url')}}" target="_blank"> Features Request</a>
                                </li>
                            </ul>
                        </div>

                        <div class="col-auto col-md-4 col-lg-auto col-xl-auto col-xxl-auto">
                            <h3 class="footer-title">Legal</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{route('home.terms-and-conditions')}}">General Terms of Use</a>
                                </li>
                                <li>
                                    <a href="{{route('home.privacy-policy')}}"> General Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="{{route('home.aml')}}"> Anti-money Laundering</a>
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
<script src="{{asset('home/plugins/jquery/jquery.min.js')}}"></script>
{{--<script src="{{asset('home/plugins/jquery/jquery-migrate.min.js')}}"></script>--}}
<script src="{{asset('home/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
@stack('js')
<!-- Plugin's Scripts -->
<script src="{{asset('home/plugins/inlineSvg/inlineSvg.min.js')}}" defer></script>
<script src="{{asset('home/plugins/fancybox/jquery.fancybox.min.js')}}" defer></script>
<script src="{{asset('home/plugins/aos/aos.min.js')}}" defer></script>
<script src="{{asset('home/plugins/isotope/isotope.pkgd.min.js')}}" defer></script>
<script src="{{asset('home/plugins/isotope/packery.pkgd.min.js')}}" defer></script>
<script src="{{asset('home/plugins/isotope/image.loaded.min.js')}}" defer></script>
<script src="{{asset('home/plugins/slick/slick.min.js')}}" defer></script>
<script src="{{asset('home/plugins/countdown/jquery.countdown.min.js')}}" defer></script>
<script src="{{asset('home/js/menu.js')}}" defer></script>
<script src="{{asset('home/js/custom.min.js')}}" defer></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
<x-livewire-alert::scripts />
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/669a2d06becc2fed69278138/1i353vojt';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
