
<!doctype html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

            <li>
                <a href="{{route('merchant.store.ticket.index',['subdomain'=>$store->slug])}}" class="box-style">
                    <i class="ri-headphone-line"></i>
                    <span class="menu-title">Support</span>
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
                            <img src="{{asset('dashboard/images/avatar.png')}}" alt="Images">
                            <h3>Emelli Watson</h3>
                            <span>Super Admin</span>
                        </a>

                        <div class="dropdown-menu">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    <img src="{{asset('dashboard/images/avatar.png')}}" class="rounded-circle" alt="image">
                                </div>

                                <div class="info text-center">
                                    <span class="name">Emelli Watson</span>
                                    <p class="mb-3 email">
                                        <a href="https://templates.envytheme.com/cdn-cgi/l/email-protection#90f8f5fcfcffd0f5fdf5fcfcf9e7f1e4e3fffebef3fffd"><span class="__cf_email__" data-cfemail="a5cdc0c9c9cae5c0c8c0c9c9ccd2c4d1d6cacb8bc6cac8">[email&#160;protected]</span></a>
                                    </p>
                                </div>
                            </div>

                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <a href="profile" class="nav-link">
                                            <i class="ri-user-line"></i>
                                            <span>Profile</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="inbox" class="nav-link">
                                            <i class="ri-mail-send-line"></i>
                                            <span>My Inbox</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="edit-profile" class="nav-link">
                                            <i class="ri-edit-box-line"></i>
                                            <span>Edit Profile</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="settings" class="nav-link">
                                            <i class="ri-settings-5-line"></i>
                                            <span>Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown-footer">
                                <ul class="profile-nav">
                                    <li class="nav-item">
                                        <a href="log-in" class="nav-link">
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

   @yield('content')

    <div class="flex-grow-1"></div>

    <div class="footer-area">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="copy-right">
                        <p>Copyright @ {{date('Y')}} {{$store->name}}. Powered By <a href="{{route('company.about')}}" target="_blank">{{$siteName}}</a></p>
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
</body>
</html>
