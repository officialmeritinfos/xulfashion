
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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
<!-- header start -->
<header class="section-t-space">
    <div class="custom-container">
        <div class="header-panel">
            <a onclick="history.back()" class="back">
                <i class="iconsax back-btn" data-icon="arrow-left"></i>
            </a>
            <h3>{{$pageName}}</h3>
        </div>
    </div>
</header>
<section>
    <div class="custom-container">
        <form class="theme-form search-head" id="search-form" action="{{route('mobile.marketplace.store.search.result')}}">
            <div class="form-group">
                <div class="form-input">
                    <select class="form-control form-control-lg stateAds" id="state-select" aria-label="Default select example" name="state">
                        <option value="" data-value="{{route('mobile.marketplace.index')}}">All of {{$country->name}}</option>
                        @foreach($states as $state)
                            <option value="{{$state->iso2}}" {{(isset($params['state']) && $params['state']==$state->iso2)?'selected':''}} >{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-input">
                    <input type="text" class="form-control search" id="search-input" placeholder="Search here..." name="search"/>
                    <div id="suggestions-box" class="suggestions-box"></div>
                </div>
            </div>
        </form>
    </div>
</section>


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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stack('js')
@livewireScripts
<script>
    $(function (){
        $('.stateAds').on('change',function (){

        })
    });
</script>
@include('mobile.general_notifications')

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_ID') }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ env('GOOGLE_ANALYTICS_ID') }}');
</script>
</body>
</html>
