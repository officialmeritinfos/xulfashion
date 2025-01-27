<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- For IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- For Resposive Device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- For Window Tab Color -->
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#0D1A1C">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#0D1A1C">
    <!-- iOS Safari -->
    <link rel="apple-touch-icon" href="{{asset($web->favicon)}}">
    <meta name="apple-mobile-web-app-title" content="{{$siteName}}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <meta name="apple-mobile-web-app-status-bar-style" content="#0D1A1C">
    <link rel="canonical" href="{{url('/')}}">
    <meta name="robots" content="index, follow">
    <meta property="og:locale" content="en_US">
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
    @include('genericCss')
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/mobile/css/bootstrap.min.css')}}" media="all">
    <!-- Main style sheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/mobile/css/style.min.css')}}" media="all">
    <!-- responsive style sheet -->
    <link rel="stylesheet" type="text/css" href="{{asset('home/mobile/css/responsive.css')}}" media="all">

    <!-- Fix Internet Explorer ______________________________________-->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <script src="{{asset('home/mobile/vendor/html5shiv.js')}}"></script>
    <script src="{{asset('home/mobile/vendor/respond.js')}}"></script>
    <![endif]-->
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
    @stack('css')
    <title>{{$pageName}} | {{$siteName}}</title>
</head>

<body>
<div class="main-page-wrapper">
    <!-- ===================================================
        Loading Transition
    ==================================================== -->
    <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="icon"><img src="{{asset($web->favicon)}}" style="width: 50px;" alt="" class="m-auto d-block"> <span></span></div>
            <div class="txt-loading">
               <span data-text-preloader="X" class="letters-loading">
                   X
               </span>
               <span data-text-preloader="U" class="letters-loading">
                   U
               </span>
               <span data-text-preloader="L" class="letters-loading">
                   L
               </span>
            </div>
        </div>
    </div>



    <!--
    =============================================
        Theme Main Menu
    ==============================================
    -->
    <header class="theme-main-menu menu-style-eight  sticky-menu menu-overlay">
        <div class="inner-content gap-one">
            <div class="top-header position-relative">
                <div class="d-flex align-items-center">
                    <div class="logo order-lg-0 me-auto me-xl-0">
                        <a href="{{ route('home.index') }}" class="d-flex align-items-center">
                            <img src="{{asset($web->logo)}}" alt="" style="width: 100px;">
                        </a>
                    </div>
                    <!-- logo -->
                    <div class="search-form me-auto ms-xxl-5 ps-lg-5 d-none d-xl-block">
                        <form action="#" class="position-relative">
                            <button><img src="{{asset('home/mobile/images/icon/icon_38.svg')}}" alt=""></button>

                        </form>
                    </div>
                    <div class="right-widget ms-lg-5 ps-xxl-5 me-3 me-lg-0 order-lg-3">
                        <ul class="d-flex align-items-center style-none">

                            @if(!checkIfAccessorIsMobile())
                                <li>
                                    <a href="{{ route('mobile.login') }}" class="login-btn-four fw-500 d-flex align-items-center tran3s">
                                        <img src="{{asset('home/mobile/images/icon/icon_39.svg')}}" alt="" class="me-2"> <span>Login</span>
                                    </a>
                                </li>
                                <li class="d-none d-md-inline-block ms-4">
                                    <a href="{{ route('mobile.register') }}" class="btn-five tran3s">Sign Up</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <nav class="navbar navbar-expand-lg p0 order-lg-2">
                        <button class="navbar-toggler d-block d-lg-none" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav align-items-lg-center">
                                <li class="d-block d-lg-none">
                                    <div class="logo">
                                        <a href="{{ route('home.index') }}" class="d-block"><img src="{{asset($web->logo)}}" alt="" style="width: 100px;"></a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                       data-bs-auto-close="outside" aria-expanded="false">Solutions
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('home.solutions.sell-online') }}" class="dropdown-item"><span>Sell Online</span></a></li>
                                        <li><a href="{{ route('home.solutions.invoice') }}" class="dropdown-item"><span>Invoice Management </span></a></li>
                                        <li><a href="{{ route('home.solutions.inventory') }}" class="dropdown-item"><span>Inventory Management</span></a></li>
                                        <li><a href="{{ route('home.solutions.pos') }}" class="dropdown-item"><span>Point-of-sale System</span></a></li>
                                        <li><a href="{{ route('home.solutions.payments') }}" class="dropdown-item"><span>Receive Payments</span></a></li>
                                        <li><a href="{{ route('home.solutions.booking') }}" class="dropdown-item"><span>Booking Solution</span></a></li>
                                        <li><a href="{{ route('home.solutions.listing') }}" class="dropdown-item"><span>Business Listing</span></a></li>
                                        <li><a href="{{ route('home.solutions.events') }}" class="dropdown-item"><span>Event Management</span></a></li>
                                        <li><a href="{{ route('home.solutions.academy') }}" class="dropdown-item"><span>Academy Solution</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('home.pricing') }}" role="button"
                                       data-bs-auto-close="outside" aria-expanded="false">Pricing
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                       data-bs-auto-close="outside" aria-expanded="false">Businesses
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('home.business.fashion-designer') }}" class="dropdown-item"><span>Fashion Designers</span></a></li>
                                        <li><a href="{{ route('home.business.beauty-entrepreneurs') }}" class="dropdown-item"><span>Beauty Entrepreneurs </span></a></li>
                                        <li><a href="{{ route('home.business.fashion-schools') }}" class="dropdown-item"><span>Fashion Schools</span></a></li>
                                        <li><a href="{{ route('home.business.manufacturers') }}" class="dropdown-item"><span>Manufacturers</span></a></li>
                                        <li><a href="{{ route('home.business.retailers') }}" class="dropdown-item"><span>Retailers</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                       data-bs-auto-close="outside" aria-expanded="false">Resources
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{$web->blogLink}}" class="dropdown-item" target="_blank"><span>Blogs</span></a></li>
                                        <li><a href="{{ route('home.faq') }}" class="dropdown-item"><span>FAQs</span></a></li>
                                        <li><a href="{{ config('app.knowledge-base') }}" class="dropdown-item" target="_blank"><span> Knowledge-base</span></a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                       data-bs-auto-close="outside" aria-expanded="false">Company
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('home.about') }}" class="dropdown-item"><span>About Us</span></a></li>
                                        <li><a href="{{ route('home.career') }}" class="dropdown-item"><span>Career</span></a></li>
                                        <li><a href="{{ route('home.contact') }}" class="dropdown-item"><span>Support Team</span></a></li>
                                    </ul>
                                </li>
                                <li class="d-md-none ps-3 pe-3 mt-20">
                                    <a href="{{ route('home.download') }}" class="btn-one tran3s w-100">
                                        Download
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div> <!--/.top-header-->
        </div> <!-- /.inner-content -->
    </header>
    <!-- /.theme-main-menu -->


    @yield('content')



    <!--
    =====================================================
        Footer Three
    =====================================================
    -->
    <div class="footer-three">
        <div class="container">
            <div class="position-relative">
                <div class="row justify-content-between">
                    <div class="col-lg-2 order-lg-0">
                        <div class="logo mt-15 mb-30">
                            <a href="{{route('home.index')}}">
                                <img src="{{asset($web->logo)}}" alt="" style="width: 100px;">
                            </a>
                        </div>
                        <!-- logo -->
                    </div>
                    <div class="col-lg-2 col-6 order-lg-1">
                        <div class="footer-nav">
                            <ul class="footer-nav-link style-none">
                                <li><a href="{{ route('home.about') }}">About </a></li>
                                <li><a href="{{ route('home.career') }}">Career</a></li>
                                <li><a href="{{route('home.pricing')}}">Pricing</a></li>
                                <li><a href="{{$web->blogLink}}" target="_blank">Blog</a></li>
                                <li><a href="{{ route('home.contact') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 order-lg-3">
                        <div class="footer-nav">
                            <ul class="footer-nav-link style-none">
                                <li><a href="{{ $web->ticketHelpDesk }}">Help Desk</a></li>
                                <li><a href="{{ config('app.knowledge-base') }}">Knowledge-base</a></li>
                                <li><a href="{{route('mobile.register')}}">Register</a></li>
                                <li><a href="{{route('mobile.login')}}">Login</a></li>
                                <li><a href="{{ route('mobile.ads.index') }}">Browse Directory</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 order-lg-2">
                        <div class="footer-nav mb-20">
                            <ul class="footer-nav-link style-none">
                                <li><a href="{{ route('home.faq') }}1">Faq’s</a></li>
                                <li><a href="{{ route('mobile.legal.privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('home.terms-and-conditions') }}">Terms</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 order-lg-4">
                        <div class="footer-nav mb-20">
                            <ul class="footer-nav-link style-none">
                                <li><a href="{{ route('home.solutions.sell-online') }}">Sell Online</a></li>
                                <li><a href="{{ route('home.solutions.invoice') }}">Invoice Management</a></li>
                                <li><a href="{{route('home.solutions.events')}}">Host Event</a></li>
                                <li><a href="{{route('home.solutions.academy')}}">Sell Form</a></li>
                                <li><a href="{{route('home.solutions.booking')}}">Receive Booking</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="bottom-footer border-dark">
                <div class="d-md-flex align-items-center justify-content-between">
                    <div class="d-flex justify-content-center align-items-center sm-mb-20">
                        <ul class="style-none d-flex justify-content-center">
                            <li><a href="{{config('app.feature_request_url')}}"> Request A Feature .</a></li>
                            <li><a href="{{$web->ticketHelpDesk}}">Support .</a></li>
                            <li><a href="{{ route('home.career') }}">Careers</a></li>
                        </ul>
                    </div>
                    <p class="copyright-text text-center m0"><span>© Copyright {{date('Y')}}, All Rights Reserved by {{$siteName}}</p>
                </div>
            </div>
        </div>
    </div> <!-- /.footer-three -->




    <button class="scroll-top">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <!-- jQuery first, then Bootstrap JS -->
    <!-- jQuery -->
    <script src="{{asset('home/mobile/vendor/jquery.min.js')}}"></script>
    <!-- Bootstrap JS -->
    <script src="{{asset('home/mobile/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- WOW js -->
    <script src="{{asset('home/mobile/vendor/wow/wow.min.js')}}"></script>
    <!-- Slick Slider -->
    <script src="{{asset('home/mobile/vendor/slick/slick.min.js')}}"></script>
    <!-- Fancybox -->
    <script src="{{asset('home/mobile/vendor/fancybox/fancybox.umd.js')}}"></script>
    <!-- Lazy -->
    <script src="{{asset('home/mobile/vendor/jquery.lazy.min.js')}}"></script>
    <!-- js Counter -->
    <script src="{{asset('home/mobile/vendor/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('home/mobile/vendor/jquery.waypoints.min.js')}}"></script>
    <!-- validator js -->
    <script src="{{asset('home/mobile/vendor/validator.js')}}"></script>
    <!-- Theme js -->
    <script src="{{asset('home/mobile/js/theme.js')}}"></script>
    @include('basicInclude')
    @stack('js')
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
    <script>
        $(function (){
            window.Tawk_API.onLoad = function() {
                window.Tawk_API.hideWidget();
            }
        });
        $('.startChat').on('click',function (){
            window.Tawk_API.popup();
        })
    </script>
    <!--End of Tawk.to Script-->
    @include('genericJs')
</div> <!-- /.main-page-wrapper -->
</body>
</html>
