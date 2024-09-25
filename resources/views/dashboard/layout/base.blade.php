
<!doctype html>
<html lang="zxx">
<head>
    @include('dashboard.layout.header')
</head>

<body>
@if(checkIfAccessorIsMobile())
    <!-- Start Preloader Area -->
    <div class="loader-wrapper">
        <span class="loader"></span>
    </div>
    <!-- End Preloader Area -->
@else
    <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="content">
            <div class="box"></div>
        </div>
    </div>
    <!-- End Preloader Area -->
@endif

@include('dashboard.layout.menu')
<!-- Start Main Content Area -->
<div class="main-content d-flex flex-column">
    <div class="container-fluid">
        <nav class="navbar main-top-navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if(!checkIfAccessorIsMobile())
                    <div class="responsive-burger-menu d-block d-lg-none">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </div>
                @endif
                @include('dashboard.layout.topmenu')

            </div>
        </nav>
    </div>
    <div class="page-title-area" style="margin-bottom: 0rem;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-6">
                    <div class="page-title">
                        <h3>{{$pageName}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <div class="flex-grow-1"></div>

    <div class="footer-area">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="copy-right">
                        <p>&copy; 2023 - {{date('Y')}} {{$siteName}}<sup>&trade;</sup>. Under License from Kopium LLC</p>
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

@include('dashboard.layout.footer')
<script src="{{asset('sw-register.js')}}"></script>


</body>
</html>
