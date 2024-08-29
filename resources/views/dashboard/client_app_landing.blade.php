
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset($web->favicon)}}">
    <!-- Bootstrap CSS -->
    <link href="{{asset('home/main/vendors/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/themify-icon/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/icomoon/style.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/slick/slick.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/slick/slick-theme.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/vendors/magnify-pop/magnific-popup.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('home/main/css/responsive.css')}}" rel="stylesheet">
    <title>{{$siteName}}</title>
    @include('genericCss')
</head>

<body>
<!-- Start Preloader Area -->
<div class="loader-wrapper">
    <span class="loader"></span>
</div>
<div class="body_wrapper">
    <section class="qu_features_area sec_padding">
        <div class="container text-center">
            <h2 class="display-4 mb-4">Download the {{$siteName}} App</h2>
            <p class="lead mb-5">Experience the best of fashion at your fingertips. Discover the latest trends, shop your favorite styles, and connect with top designers - all from your phone.</p>
            <div class="d-flex justify-content-center">
                <span  target="_blank">
                    <img src="{{asset('Google_Play_Store_badge_EN.svg')}}" alt="Download on Google Play" class="img-fluid mx-2" style="max-width: 180px;">
                </span>
                <span>
                    <img src="{{asset('home/image/apple-coming-soon.png')}}" alt="Download on the App Store" class="img-fluid mx-2" style="max-width: 180px;">
                </span>
            </div>
        </div>
    </section>



</div>

<!-- Optional JavaScript; choose one of the two! -->
<script src="{{asset('home/main/js/jquery-3.6.0.min.js')}}"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->

<script src="{{asset('home/main/vendors/bootstrap/js/popper.min.js')}}"></script>
<script src="{{asset('home/main/vendors/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('home/main/vendors/slick/slick.min.js')}}"></script>
<script src="{{asset('home/main/vendors/parallax/jquery.parallax-scroll.js')}}"></script>
<script src="{{asset('home/main/vendors/magnify-pop/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('home/main/js/custom.js')}}"></script>
@include('basicInclude')
</body>
</html>
