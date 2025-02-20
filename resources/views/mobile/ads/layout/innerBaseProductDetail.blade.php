
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="description" content="{{ $description??$siteName }}" />
    <meta name="keywords" content="{{$siteName}}" />
    <meta name="author" content="{{ $author??$siteName }}" />
    <link rel="manifest" href="{{ $image??asset($web->favicon) }}" />
    <link rel="icon" href="{{ $image??asset($web->favicon) }}" type="image/x-icon" />
    <title>{{ $title??$pageName }} on {{ $siteName }}</title>
    <link rel="apple-touch-icon" href="{{ $image??asset($web->favicon) }}" />
    <meta name="theme-color" content="#122636" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="apple-mobile-web-app-title" content=" {{ $title??$pageName }} " />
    <meta name="msapplication-TileImage" content="{{ $image??asset($web->favicon) }}" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @include('genericCss')
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

<body class="details-page details-page2">
<div class="loader-wrapper">
    <span class="loader"></span>
</div>
<!-- header start -->
<header class="product2-header">
    <div class="custom-container">
        <div class="header-panel">
            <a onclick="history.back()" class="back">
                <i class="iconsax back-btn" data-icon="arrow-left"></i>
            </a>
            <h3>{{ $title??$pageName }}</h3>
        </div>
    </div>
</header>

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
@include('basicInclude')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Hide the preloader when the DOM is fully loaded
        $('.loader-wrapper').fadeOut();
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Step 1: Convert `src` to `data-src` and add placeholders
        $('img.img').each(function () {
            const img = $(this);
            const originalSrc = img.attr('src'); // Get the current src
            const placeholder = "{{ asset('favicon.png') }}"; // Define your default placeholder

            // If the image already has a src and no data-src, update attributes
            if (originalSrc && !img.attr('data-src')) {
                img.attr('data-src', originalSrc); // Move src to data-src
                img.attr('src', placeholder); // Set placeholder as src
            }
        });

        // Step 2: Initialize jQuery Lazy
        $('img.img').Lazy({
            effect: "fadeIn", // Optional: Add a fade-in effect
            effectTime: 500, // Duration of the fade-in effect
            threshold: 0,    // Load images as soon as they are in the viewport
        });
    });

</script>

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
