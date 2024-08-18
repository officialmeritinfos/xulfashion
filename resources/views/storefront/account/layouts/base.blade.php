
<!doctype html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Bootstrap Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/bootstrap.min.css')}}">
    <!-- Owl Theme Default Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/owl.theme.default.min.css')}}">
    <!-- Owl Carousel Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/owl.carousel.min.css')}}">
    <!-- Animate Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/animate.min.css')}}">
    <!-- Remixicon CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/remixicon.css')}}">
    <!-- boxicons CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/boxicons.min.css')}}">
    <!-- MetisMenu Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/metismenu.min.css')}}">
    <!-- Simplebar Min CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/simplebar.min.css')}}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/style.css')}}">
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/dark-mode.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/responsive.css')}}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{$store->logo}}">
    <!-- Title -->
    <title>{{$store->name}} - {{$pageName??'Your one stop fashion store'}}</title>
    @include('genericCss')
    @stack('css')
    <style>
        @media (max-width: 767.98px) {
            .sidebar-nav{
                display: none;
            }
            #mobile-collapse{
                display: none;
            }
            /* Style for mobile devices */
            .footer-bottom {
                position: fixed;
                width: 100%;
                z-index: 9;
                bottom: 0;
                left: 0;
                background: #fff;
                border-top: 1px solid #DCDCE9;
            }
            .footer-bottom ul {
                margin: 0;
                padding: 0;
            }
            .footer-bottom ul li {
                list-style: none;
                display: inline-block;
                margin: 0 8px;
                padding: 10px 0 8px 0;
                position: relative; /* Added */
            }
            .footer-bottom ul li p {
                margin-bottom: 0;
                font-size: 10px;
                -webkit-transition: 0.4s;
                -o-transition: 0.4s;
                transition: 0.4s;
            }
            .footer-bottom ul li a {
                -webkit-transition: 0.4s;
                -o-transition: 0.4s;
                transition: 0.4s;
            }
            .footer-bottom ul li a:hover {
                color: #6236ff;
            }
            .footer-bottom ul li a:hover p {
                color: #6236ff;
            }
            /* Added */
            .footer-bottom .submenu {
                display: none;
                position: absolute;
                left: 0;
                top: 100%;
                background-color: #fff;
                border: 1px solid #ddd;
                width: 100%;
            }
            .footer-bottom .submenu li {
                display: block;
            }
            .footer-bottom .submenu li a {
                display: block;
                padding: 10px;
                color: #333;
                text-decoration: none;
            }
            .footer-bottom .submenu li a:hover {
                background-color: #f5f5f5;
            }
        }

        @media (min-width: 768px) {
            /* Hide navbar on larger screens */
            .footer-bottom {
                display: none;
            }
        }
    </style>
</head>

<body class="body-bg-f5f5f5">
<!-- Start Preloader Area -->
<div class="preloader">
    <div class="content">
        <div class="box"></div>
    </div>
</div>
<!-- End Preloader Area -->

<!-- Start Sidebar Area -->
<div class="side-menu-area">
    <div class="side-menu-logo bg-linear">
        <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}" class="navbar-brand d-flex align-items-center">
            <img src="{{$store->logo}}" alt="image" style="width: 120px;">
        </a>

        <div class="burger-menu d-none d-lg-block">
            <span class="top-bar"></span>
            <span class="middle-bar"></span>
            <span class="bottom-bar"></span>
        </div>

        <div class="responsive-burger-menu d-block d-lg-none">
            <span class="top-bar"></span>
            <span class="middle-bar"></span>
            <span class="bottom-bar"></span>
        </div>
    </div>

    <nav class="sidebar-nav" data-simplebar>
        <ul id="sidebar-menu" class="sidebar-menu">
            <li class="nav-item-title">MENU</li>

            <li>
                <a href="{{route('merchant.store.user.index',['subdomain'=>$store->slug])}}" class="box-style">
                    <i class="ri-dashboard-2-line"></i>
                    <span class="menu-title">Overview</span>
                </a>
            </li>

            <li>
                <a href="{{route('merchant.store.user.orders',['subdomain'=>$store->slug])}}" class="box-style">
                    <i class="ri-shopping-cart-2-line"></i>
                    <span class="menu-title">My Orders</span>
                </a>
            </li>

            <li>
                <a href="{{route('merchant.store.user.profile',['subdomain'=>$store->slug])}}" class="box-style">
                    <i class="ri-user-3-line"></i>
                    <span class="menu-title">Profile</span>
                </a>
            </li>

            <li>
                <a href="{{route('merchant.store.user.settings',['subdomain'=>$store->slug])}}" class="box-style">
                    <i class="ri-user-settings-line"></i>
                    <span class="menu-title">Settings</span>
                </a>
            </li>

        </ul>


        <div class="dark-bar">
            <a href="#" class="d-flex align-items-center">
                <span class="dark-title">Enable Dark Theme</span>
            </a>

            <div class="form-check form-switch">
                <input type="checkbox" class="checkbox" id="darkSwitch">
            </div>
        </div>
    </nav>
</div>
<!-- End Sidebar Area -->

<div class="footer-bottom text-center">
    <ul>
        <li>
            <a href="{{route('merchant.store.user.index',['subdomain'=>$store->slug])}}">
                <i class="fa fa-home"></i>
                <p>Overview</p>
            </a>
        </li>
        <li>
            <a href="{{route('merchant.store.user.orders',['subdomain'=>$store->slug])}}">
                <i class="bx bx-cart"></i>
                <p>My Orders</p>
            </a>
        </li>
        <li>
            <a class="menu-bar" href="{{route('merchant.store.user.profile',['subdomain'=>$store->slug])}}">
                <i class="bx bxs-user"></i>
                <p>Profile</p>
            </a>
        </li>
        <li>
            <a class="menu-bar" href="{{route('merchant.store.user.settings',['subdomain'=>$store->slug])}}">
                <i class="ri-settings-2-line"></i>
                <p>Settings</p>
            </a>
        </li>
    </ul>
</div>

<!-- Start Main Content Area -->
<div class="main-content d-flex flex-column">
    <div class="container-fluid">
        <nav class="navbar main-top-navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="responsive-burger-menu d-block d-lg-none">
                    <span class="top-bar"></span>
                    <span class="middle-bar"></span>
                    <span class="bottom-bar"></span>
                </div>



                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link ri-fullscreen-btn" id="fullscreen-button">
                            <i class="ri-fullscreen-line"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown profile-nav-item">
                        <a class="nav-link dropdown-toggle avatar" href="#" id="navbarDropdown-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{'https://ui-avatars.com/api/?rounded=true&name='.$customer->name}}" alt="Images" style="width: 50px;">
                            <h3>{{$customer->name}}</h3>
                        </a>

                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    <img src="{{'https://ui-avatars.com/api/?rounded=true&name='.$customer->name}}" class="rounded-circle" alt="image">
                                </div>

                                <div class="info text-center">
                                    <span class="name">{{$customer->name}}</span>
                                    <p class="mb-3 email">
                                        {{$customer->reference}}
                                    </p>
                                </div>
                            </div>

                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <a href="{{route('merchant.store.user.profile',['subdomain'=>$store->slug])}}" class="nav-link">
                                            <i class="ri-user-line"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{route('merchant.store.user.settings',['subdomain'=>$store->slug])}}" class="nav-link">
                                            <i class="ri-settings-5-line"></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown-footer">
                                <ul class="profile-nav">
                                    <li class="nav-item">
                                        <a href="{{route('merchant.store.user.logout',['subdomain'=>$store->slug])}}" class="nav-link">
                                            <i class="ri-login-circle-line"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!--
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="ri-settings-5-line"></i>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
        </nav>
    </div>
    <div class="page-title-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h6>{{$pageName}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

   @yield('content')

    <div class="flex-grow-1"></div>

    <div class="footer-area">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="copy-right">
                        <p>Copyright @ {{date('Y')}} {{$store->name}}. Powered By <a href="{{route('home.about')}}" target="_blank">{{$siteName}}</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Main Content Area -->

<!-- Start Go Top Area -->
<div class="go-top">
    <i class="ri-arrow-up-s-fill"></i>
    <i class="ri-arrow-up-s-fill"></i>
</div>
<!-- End Go Top Area -->

<!-- Jquery Min JS -->
<script src="{{asset('dashboard/js/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle Min JS -->
<script src="{{asset('dashboard/js/bootstrap.bundle.min.js')}}"></script>
<!-- Owl Carousel Min JS -->
<script src="{{asset('dashboard/js/owl.carousel.min.js')}}"></script>
<!-- Metismenu Min JS -->
<script src="{{asset('dashboard/js/metismenu.min.js')}}"></script>
<!-- Simplebar Min JS -->
<script src="{{asset('dashboard/js/simplebar.min.js')}}"></script>
<!-- mixitup Min JS -->
<script src="{{asset('dashboard/js/mixitup.min.js')}}"></script>
<!-- Dark Mode Switch Min JS -->
<script src="{{asset('dashboard/js/dark-mode-switch.min.js')}}"></script>
<!-- Apexcharts Min JS -->
<script src="{{asset('dashboard/js/apexcharts/apexcharts.min.js')}}"></script>
<!-- Charts Custom Min JS -->
<script src="{{asset('dashboard/js/charts-custom.js')}}"></script>
<!-- Form Validator Min JS -->
<script src="{{asset('dashboard/js/form-validator.min.js')}}"></script>
<!-- Contact JS -->
<script src="{{asset('dashboard/js/contact-form-script.js')}}"></script>
<!-- Ajaxchimp Min JS -->
<script src="{{asset('dashboard/js/ajaxchimp.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{asset('dashboard/js/custom.js')}}"></script>
@stack('js')
@include('basicInclude')
</body>
</html>
