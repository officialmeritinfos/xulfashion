
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
    <link rel="stylesheet" type="text/css" href="{{asset('home/plugins/aos/aos.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/plugins/fancybox/jquery.fancybox.min.css')}}">
    <!-- Vendor stylesheets  -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/plugins/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/css/style.min.css')}}">
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
{{--<div class="preloader-wrapper">--}}
{{--    <div class="lds-ellipsis">--}}
{{--        <div></div>--}}
{{--        <div></div>--}}
{{--        <div></div>--}}
{{--        <div></div>--}}
{{--    </div>--}}
{{--</div>--}}
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
                                <a href="{{route('home.about')}}" class="nav-link-item drop-trigger">About Us</a>
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
    @yield('content')

    <div class="footer padding-top-100 footer--light footer-l03">
        <div class="container">
            <div class="row row--footer-main">
                <div class="col-md-12 col-lg-12 col-xl-12 col-12 col-xxl-12">
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
<!-- Plugin's Scripts -->
<script src="{{asset('home/plugins/inlineSvg/inlineSvg.min.js')}}"></script>
<script src="{{asset('home/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('home/plugins/aos/aos.min.js')}}"></script>
<script src="{{asset('home/plugins/isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('home/plugins/isotope/packery.pkgd.min.js')}}"></script>
<script src="{{asset('home/plugins/isotope/image.loaded.min.js')}}"></script>
<script src="{{asset('home/plugins/slick/slick.min.js')}}"></script>
<script src="{{asset('home/plugins/countdown/jquery.countdown.min.js')}}" defer></script>
<script src="{{asset('home/js/menu.js')}}"></script>
<script src="{{asset('home/js/custom.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
</body>
</html>
