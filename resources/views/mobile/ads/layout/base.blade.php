
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="description" content="{{$siteName}}" />
    <meta name="keywords" content="{{$siteName}}" />
    <meta name="author" content="{{$siteName}}" />
    <link rel="manifest" href="{{asset($web->favicon)}}" />
    <link rel="icon" href="{{asset($web->favicon)}}" type="image/x-icon" />
    <title>{{$pageName}} || {{$siteName}}</title>
    <link rel="apple-touch-icon" href="{{asset($web->favicon)}}" />
    <meta name="theme-color" content="#122636" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content="fuzzy" />
    <meta name="msapplication-TileImage" content="{{asset($web->favicon)}}" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @stack('css')

    <!--Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com/" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />

    <!-- iconsax css -->
    <link rel="stylesheet" type="text/css" href="{{asset('mobile/css/vendors/iconsax.css')}}" />

    <!-- bootstrap css -->
    <link rel="stylesheet" id="rtl-link" type="text/css" href="{{asset('mobile/css/vendors/bootstrap.min.css')}}" />

    <!-- swiper css -->
    <link rel="stylesheet" type="text/css" href="{{asset('mobile/css/vendors/swiper-bundle.min.css')}}" />

    <!-- Theme css -->
    <link rel="stylesheet" id="change-link" type="text/css" href="{{asset('mobile/css/style.css')}}" />
    @livewireStyles

</head>

<body>
<div class="loader-wrapper">
    <span class="loader"></span>
</div>

@include('mobile.ads.layout.topSection')

@yield('content')

<section class="panel-space"></section>

@include('mobile.ads.layout.footerSection')

<!-- swiper js -->
<script src="{{asset('mobile/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('mobile/js/custom-swiper.js')}}"></script>

<!-- iconsax js -->
<script src="{{asset('mobile/js/iconsax.js')}}"></script>

<!-- bootstrap js -->
<script src="{{asset('mobile/js/bootstrap.bundle.min.js')}}"></script>

<!-- homescreen popup js -->
<script src="{{asset('mobile/js/homescreen-popup.js')}}"></script>

<!-- PWA offcanvas popup js -->
<script src="{{asset('mobile/js/offcanvas-popup.js')}}"></script>

<!-- script js -->
<script src="{{asset('mobile/js/script.js')}}"></script>
@stack('js')
@livewireScripts
<script>
    $(function (){
        $('.stateAds').on('change',function (){

        })
    });
</script>
</body>
</html>
