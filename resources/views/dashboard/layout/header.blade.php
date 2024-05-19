<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="{{$siteName}}"/>
<meta name="description" content="{{$web->description}}"/>
<meta name="keywords" content="{{$web->keywords}}">
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
<link rel="stylesheet" href="{{asset('dashboard/css/boxed-check.min.css')}}">
<link rel="stylesheet" href="{{asset('dashboard/vendors/summernote/summernote-bs5.css')}}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{asset($web->favicon)}}">
<!-- Title -->
<title>{{$pageName}} - {{$siteName}}</title>
@include('genericCss')
@stack('css')
<style>
    .post {
        width: 220px;
        height: 80px;
    }
    .post .avatar {
        float: left;
        width: 52px;
        height: 52px;
        background-color: #ccc;
        border-radius: 25%;
        margin: 8px;
        background-image: linear-gradient(90deg, #ddd 0px, #e8e8e8 40px, #ddd 80px);
        background-size: 600px;
        animation: shine-avatar 1.6s infinite linear;
    }
    .post .line {
        float: left;
        width: 140px;
        height: 16px;
        margin-top: 12px;
        border-radius: 7px;
        background-image: linear-gradient(90deg, #ddd 0px, #e8e8e8 40px, #ddd 80px);
        background-size: 600px;
        animation: shine-lines 1.6s infinite linear;
    }
    .post .avatar + .line {
        margin-top: 11px;
        width: 100px;
    }
    .post .line ~ .line {
        background-color: #ddd;
    }


    @keyframes shine-lines {
        0% {
            background-position: -100px; }
        40%, 100% {
            background-position: 140px; } }

    @keyframes shine-avatar {
        0% {
            background-position: -32px; }
        40%, 100% {
            background-position: 208px; } }

</style>
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
