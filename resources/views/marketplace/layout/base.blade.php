<!DOCTYPE html>
<html lang="zxx">
<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--====== Title ======-->
    <title>
        {{$siteName}} - {{$pageName}}
    </title>
    <!--====== Google Fonts ======-->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
    <!--====== Bootstrap css ======-->
    <link href="{{asset('marketplace/css/bootstrap.min.css')}}" rel="stylesheet">
    <!--====== Jquery UI css ======-->
    <link href="{{asset('marketplace/css/jquery-ui-min.css')}}" rel="stylesheet">
    <!--====== icon css ======-->
    <link href="{{asset('marketplace/css/line-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('marketplace/css/flaticon.css')}}" rel="stylesheet">
    <!--====== Animate  css ======-->
    <link href="{{asset('marketplace/css/animate.min.css')}}" rel="stylesheet">
    <!--====== Swiper css ======-->
    <link href="{{asset('marketplace/css/swiper-min.css')}}" rel="stylesheet">
    <!--====== Magnific Popup css ======-->
    <link href="{{asset('marketplace/css/magnific-popup.css')}}" rel="stylesheet">
    <!--====== Style css ======-->
    <link href="{{asset('marketplace/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('marketplace/css/dark-theme.css')}}" rel="stylesheet">
</head>

<body>
<!--Preloader starts-->
<div class="preloader js-preloader">
    <img src="{{asset($web->loader)}}" alt="Image" style="width: 500px;">
</div>
<!--Preloader ends-->

<!-- Theme Switcher Start -->
<div class="switch-theme-mode">
    <label id="switch" class="switch">
        <input type="checkbox" onchange="toggleTheme()" id="slider">
        <span class="slider round"></span>
    </label>
</div>
<!-- Theme Switcher End -->

<!-- page wrapper Start -->
<div class="page-wrapper">

    <!-- Header Start -->
    <header class="header-wrap style1">
        <div class="header-top bg-orange">
            <div class="close-header-top xl-none">
                <button type="button"><i class="las la-times"></i></button>
            </div>
            <div class="container-fluid container-full">
                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="header-top-left">
                            <div class="contact-item style1">
                                <div class="contact-icon">
                                    <i class="flaticon-phone-call"></i>
                                </div>
                                <div class="contact-info">
                                    <a href="tel:{{$web->phone}}">{{$web->phone}}</a>
                                </div>
                            </div>
                            <div class="contact-item style1">
                                <div class="contact-icon">
                                    <i class="flaticon-email"></i>
                                </div>
                                <div class="contact-info">
                                    <a href="{{$web->email}}">{{$web->email}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="header-top-right">
                            <a href="{{route('login')}}" class="user-login">
                                <span><i class="flaticon-user-4"></i></span>
                                Log In/Register
                            </a>
                            <ul class="social-profile style2 list-style">
                                <li><a target="_blank" href="https://facebook.com/"><i class="lab la-facebook-f"></i> </a></li>
                                <li><a target="_blank" href="https://linkedin.com/"> <i class="lab la-linkedin-in"></i> </a></li>
                                <li><a target="_blank" href="https://twitter.com/"> <i class="lab la-twitter"></i> </a></li>
                                <li><a target="_blank" href="https://instagram.com/"> <i class="lab la-instagram"></i> </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12 xl-none">
                        <div class="select_lang">
                            <div class="navbar-option-item navbar-language dropdown language-option">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="las la-globe"></i>
                                    <span class="lang-name"></span>
                                </button>
                                <div class="dropdown-menu language-dropdown-menu">
                                    <a class="dropdown-item" href="#">
                                        <img src="{{asset('marketplace/img/uk.png')}}" alt="flag">
                                        Eng
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img src="{{asset('marketplace/img/china.png')}}" alt="flag">
                                        简体中文
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <img src="{{asset('marketplace/img/uae.png')}}" alt="flag">
                                        العربيّة
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="quote-btn">
                            <a href="{{route('register')}}" class="btn style1">List your Business</a>
                        </div>
                        <ul class="social-profile style2 list-style">
                            <li><a target="_blank" href="https://facebook.com/"><i class="lab la-facebook-f"></i> </a></li>
                            <li><a target="_blank" href="https://linkedin.com/"> <i class="lab la-linkedin-in"></i> </a></li>
                            <li><a target="_blank" href="https://twitter.com/"> <i class="lab la-twitter"></i> </a></li>
                            <li><a target="_blank" href="https://instagram.com/"> <i class="lab la-instagram"></i> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container-fluid container-full">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-5">
                        <div class="logo">
                            <a class="logo-light" href="{{route('marketplace.index')}}"><img src="{{asset($web->logo)}}" alt="Image"
                                style="width: 100px;"></a>
                            <a class="logo-dark" href="{{route('marketplace.index')}}"><img src="{{asset($web->logo2)}}" alt="Image"
                                style="width:100px;"></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8 col-md-8 col-7">
                        <div class="main-menu-wrap">
                            <div class="menu-close xl-none">
                                <a href="javascript:void(0)"><i class="las la-times"></i></a>
                            </div>
                            <div id="menu">
                                <ul class="main-menu list-style">
                                    <li><a href="{{route('marketplace.index')}}">HOME</a></li>
                                    <li><a href="#">SHOPS</a></li>
                                    <li><a href="#">MODELS</a></li>
                                    <li><a href="#">CONTACT</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mobile-bar-wrap">
                            <div class="mobile-top-bar xl-none">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div class="mobile-menu xl-none">
                                <a href="javascript:void(0)"><i class="las la-bars"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 lg-none">
                        <div class="header-bottom-right">
                            <div class="select_lang">
                                <div class="navbar-option-item navbar-language dropdown language-option">
                                </div>
                            </div>
                            <div class="quote-btn">
                                <a href="{{route('register')}}" class="btn">List your Business</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header  end -->

@yield('content')
    <!-- Footer  start -->
    <footer class="footer-wrap style3 bg-orange ">
        <div class="footer-top pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="footer-widget">
                            <h5 class="footer-widget-title">
                                Information
                            </h5>
                            <div class="contact-item style2">
                                <div class="contact-icon">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="contact-info">
                                    <p>Phone Number</p>
                                    <a href="tel:8245678924">+8245678924</a>
                                </div>
                            </div>
                            <div class="contact-item style2">
                                <div class="contact-icon">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="contact-info">
                                    <p>Email</p>
                                    <a href="https://templates.envytheme.com/cdn-cgi/l/email-protection#224a474e4e4d6256434e4d4c0c414d4f"><span class="__cf_email__" data-cfemail="79111c151516390d18151617571a1614">[email&#160;protected]</span></a>
                                </div>
                            </div>
                            <div class="contact-item style2">
                                <div class="contact-icon">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="contact-info">
                                    <p>Address</p>
                                    <span>50 Binary, stamford south, Northambia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <h5 class="footer-widget-title  sm-title">
                                Useful Links
                            </h5>
                            <ul class="footer-menu  list-style">
                                <li><a href="about">About Us</a></li>
                                <li><a href="faq">FAQ's</a></li>
                                <li><a href="shop-left-sidebar">Our Shop</a></li>
                                <li><a href="blog-left-sidebar">Blog</a></li>
                                <li><a href="contact">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 offset-xl-1 col-lg-3 col-md-6">
                        <div class="footer-widget ">
                            <h5 class="footer-widget-title sm-title">
                                Our Info
                            </h5>
                            <ul class="footer-menu list-style">
                                <li><a href="car-listings-grid">Car Gallery</a></li>
                                <li><a href="car-listings-list">Best Dealers</a></li>
                                <li><a href="car-listings-list">Top Dealers</a></li>
                                <li><a href="privacy-policy">Privacy Policy</a></li>
                                <li><a href="terms-conditions">Terms &amp; Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h5 class="footer-widget-title">
                                Subscribe Us
                            </h5>
                            <form action="#" class="newsletter-form">
                                <div class="form-group">
                                    <input type="email" placeholder="Your mail">
                                    <button type="submit" class="btn style1">Subscribe</button>
                                </div>
                            </form>
                            <ul class="social-profile style1 list-style">
                                <li><a target="_blank" href="https://facebook.com/"><i class="lab la-facebook-f"></i> </a></li>
                                <li><a target="_blank" href="https://linkedin.com/"> <i class="lab la-linkedin-in"></i> </a></li>
                                <li><a target="_blank" href="https://twitter.com/"> <i class="lab la-twitter"></i> </a></li>
                                <li><a target="_blank" href="https://instagram.com/"> <i class="lab la-instagram"></i> </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p><span class="las la-copyright"></span><script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script><script>document.write(new Date().getFullYear())</script> Talon. All Rights Reserved By <a href="https://envytheme.com/">EnvyTheme</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer  end -->

</div>
<!-- Page wrapper end -->

<!-- Back-to-top button start -->
<a href="#" class="back-to-top bounce"><i class="las la-arrow-up"></i></a>
<!-- Back-to-top button end -->

<!--====== jquery js ======-->
<script src="{{asset('marketplace/js/jquery.min.js')}}"></script>
<!--====== jquery UI js ======-->

<script src="{{asset('marketplace/js/jquery-ui.min.js')}}"></script>
<!--====== Bootstrap js ======-->
<script src="{{asset('marketplace/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('marketplace/js/bootstrap-validator.js')}}"></script>
<script src="{{asset('marketplace/js/form-validation.js')}}"></script>
<!--====== Swiper js ======-->
<script src="{{asset('marketplace/js/swiper-min.js')}}"></script>
<!--====== Appear js ======-->
<script src="{{asset('marketplace/js/jquery-appear.js')}}"></script>
<!--====== jQuery Counter js ======-->
<script src="{{asset('marketplace/js/jquery-counter.js')}}"></script>
<!--====== Main js ======-->
<script src="{{asset('marketplace/js/main.js')}}"></script>
@include('basicInclude')
</body>
</html>
