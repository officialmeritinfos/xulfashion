<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
    <!-- Bootstrap CSS -->
    <link href="{{asset('home/main/vendors/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/themify-icon/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/icomoon/style.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/slick/slick.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/slick/slick-theme.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/animation/animate.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/css/responsive.css')}}" rel="stylesheet">
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
    <title>
        {{$siteName}} | {{$pageName}}
    </title>
    @include('genericCss')
</head>

<body data-scroll-animation="true">

<div class="body_wrapper">
    <!-- start header  -->
    <nav class="navbar navbar-expand-lg sticky_nav">
        <div class="container">
            <a class="navbar-brand" href="{{route('home.index')}}">
                <img src="{{asset($web->logo)}}" alt="logo" style="width: 70px;">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav menu me-lg-auto">
                    <li class="nav-item dropdown submenu {{(route('home.index')==url()->current())?'active':''}}">
                        <a class="nav-link" href="{{route('home.index')}}" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            Home
                        </a>
                    </li>
                    <li class="nav-item dropdown submenu">
                        <a class="nav-link" href="{{route('home.about')}}" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            About Us
                        </a>
                    </li>
                </ul>
                <div class="nav_right">
                    <a href="{{route('mobile.login')}}" class="login_btn">Login</a>
                    <a href="{{route('mobile.register')}}" class="signup_btn hover_effect">Sign up for free</a>
                </div>
            </div>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </button>
        </div>
    </nav>
    <!-- End header  -->

    @yield('content')

    <footer class="footer_area sec_padding_two">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-5">
                    <div class="f_widget f_about_widget dark_text wow fadeInUp">
                        <a href="{{route('home.index')}}" class="f_logo mb-3">
                            <img src="{{asset($web->logo)}}" style="width: 150px;" alt="">
                        </a>
                        <p class="mb-5">
                            We are you all-in-one marketplace for fashion and fashion accessories.<br/>
                            Find the Best in the Fashion Industry - from Designers, Tailors/Seamstress, Models,
                            Manufacturers etc.
                        </p>
                        <p class="copy_text mt-5">© {{date('Y')}} {{$siteName}}. Powered By XulTech</p>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 offset-xl-1 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="f_list_inner f_border">
                        <div class="f_widget f_link_widget">
                            <h3 class="f_title f_title_dark">Resources</h3>
                            <ul class="list-unstyled link_widget dark_link">
                                <li><a href="{{$web->blogLink}}">Blog</a></li>
                                <li><a href="{{$web->ticketHelpDesk}}">Help Center</a></li>
                                <li><a href="{{route('home.legal')}}">Legal</a></li>
                                <li><a href="{{route('home.pricing')}}">Pricing</a></li>
                            </ul>
                        </div>
                        <div class="f_widget f_link_widget">
                            <h3 class="f_title f_title_dark">Company</h3>
                            <ul class="list-unstyled link_widget dark_link">
                                <li><a href="{{route('home.about')}}">About</a></li>
                                <li><a href="{{$web->ticketHelpDesk}}">Support</a></li>
                            </ul>
                        </div>
                        <div class="f_widget f_link_widget">
                            <h3 class="f_title f_title_dark">Solution</h3>
                            <ul class="list-unstyled link_widget dark_link">
                                <li><a href="{{route('home.solutions.sell-online')}}">Store-front</a></li>
                                <li><a href="{{route('home.solutions.booking')}}">Booking</a></li>
                                <li><a href="{{route('home.solutions.pos')}}">Offline Sales</a></li>
                            </ul>
                        </div>
                        <div class="f_widget f_link_widget">
                            <h3 class="f_title f_title_dark">Customer</h3>
                            <ul class="list-unstyled link_widget dark_link">
                                <li><a href="{{route('home.terms-and-conditions')}}">Terms & Conditions</a></li>
                                <li><a href="{{route('mobile.legal.privacy-policy')}}">Privacy Policy</a></li>
                                <li><a href="{{route('home.ads-posting-policy')}}">Ads Posting Policy</a></li>
                            </ul>
                        </div>
                        <div class="f_widget f_social_widget">
                            <h3 class="f_title f_title_dark">Follow us</h3>
                            <ul class="list-unstyled f_social_link_widget dark_link">
                                <li><a href="#https://www.x.com/xulfashion"><i class="ti-twitter-alt"></i>Twitter</a>
                                </li>
                                <li><a href="https://www.linkdin.com/company/xulfashion"><i class="ti-linkedin"></i>Linkedin</a></li>
                                <li><a href="https://www.instagram.com/getxulfashion"><i class="ti-instagram"></i>Instagram</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Optional JavaScript; choose one of the two! -->
<script src="{{asset('home/main/js/jquery-3.6.0.min.js')}}"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->

<script src="{{asset('home/main/vendors/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('home/main/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('home/main/vendors/slick/slick.min.js')}}"></script>
<script src="{{asset('home/main/vendors/parallax/jquery.parallax-scroll.js')}}"></script>
<script src="{{asset('home/main/vendors/wow/wow.min.js')}}"></script>
<script src="{{asset('home/main/js/custom.js')}}"></script>
@include('basicInclude')
</body>
</html>
