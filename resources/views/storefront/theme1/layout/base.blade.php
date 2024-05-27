<!doctype html>
<html lang="en" class="light-theme">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{$store->logo}}" type="image/png" />
    <!-- CSS files -->
    <link href="{{ asset('templates/' . $theme . '/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;600&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Plugins -->
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/' . $theme . '/assets/plugins/slick/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('templates/' . $theme . '/assets/plugins/slick/slick-theme.css')}}" />

    <link href="{{ asset('templates/' . $theme . '/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('templates/' . $theme . '/assets/css/dark-theme.css')}}" rel="stylesheet">

    <style>
        {!! $setting->customCSS !!}
    </style>
    <title>{{$store->name}} - Your one stop fashion store</title>
    @include('genericCss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
@inject('options','App\Custom\Storefront')

<!--page loader-->
<div class="loader-wrapper">
    <div class="d-flex justify-content-center align-items-center position-absolute top-50 start-50 translate-middle">
        <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<!--end loader-->

<!--start top header-->
<header class="top-header">
    <nav class="navbar navbar-expand-xl w-100 navbar-dark container gap-3">
        <a class="navbar-brand d-none d-xl-inline" href="{{route('merchant.store',['subdomain'=>$subdomain])}}">
            <img src="{{$store->logo}}" class="logo-img" alt="" style="width: 100px;"></a>
        <a class="mobile-menu-btn d-inline d-xl-none" href="javascript:;" data-bs-toggle="offcanvas"
           data-bs-target="#offcanvasNavbar">
            <i class="bi bi-list"></i>
        </a>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header">
                <div class="offcanvas-logo"><img src="{{$store->logo}}" class="logo-img" alt="" style="width: 100px;">
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body primary-menu">
                <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="tv-shows"
                           data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <div class="dropdown-menu dropdown-large-menu">
                            <div class="row">
                                <div class="col-12 col-xl-4">
                                    <h6 class="large-menu-title">Fashion</h6>
                                    <ul class="list-unstyled">
                                        <li><a href="javascript:;">Casual T-Shirts</a>
                                        </li>
                                        <li><a href="javascript:;">Formal Shirts</a>
                                        </li>
                                        <li><a href="javascript:;">Jackets</a>
                                        </li>
                                        <li><a href="javascript:;">Jeans</a>
                                        </li>
                                        <li><a href="javascript:;">Dresses</a>
                                        </li>
                                        <li><a href="javascript:;">Sneakers</a>
                                        </li>
                                        <li><a href="javascript:;">Belts</a>
                                        </li>
                                        <li><a href="javascript:;">Sports Shoes</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end col-3 -->
                                <div class="col-12 col-xl-4">
                                    <h6 class="large-menu-title">Electronics</h6>
                                    <ul class="list-unstyled">
                                        <li><a href="javascript:;">Mobiles</a>
                                        </li>
                                        <li><a href="javascript:;">Laptops</a>
                                        </li>
                                        <li><a href="javascript:;">Macbook</a>
                                        </li>
                                        <li><a href="javascript:;">Televisions</a>
                                        </li>
                                        <li><a href="javascript:;">Lighting</a>
                                        </li>
                                        <li><a href="javascript:;">Smart Watch</a>
                                        </li>
                                        <li><a href="javascript:;">Galaxy Phones</a>
                                        </li>
                                        <li><a href="javascript:;">PC Monitors</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end col-3 -->
                                <div class="col-12 col-xl-4 d-none d-xl-block">
                                    <div class="pramotion-banner1">
                                        <img src="{{ asset('templates/' . $theme . '/assets/images/menu-img.webp')}}" class="img-fluid" alt="" />
                                    </div>
                                </div>
                                <!-- end col-3 -->
                            </div>
                            <!-- end row -->
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                            Shop
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="cart">Shop Cart</a></li>
                            <li><a class="dropdown-item" href="wishlist">Wishlist</a></li>
                            <li><a class="dropdown-item" href="product-details">Product Details</a></li>
                            <li><a class="dropdown-item" href="payment-method">Payment Method</a></li>
                            <li><a class="dropdown-item" href="billing-details">Billing Details</a></li>
                            <li><a class="dropdown-item" href="address">Addresses</a></li>
                            <li><a class="dropdown-item" href="shop-grid">Shop Grid</a></li>
                            <li><a class="dropdown-item" href="shop-grid-type-4">Shop Grid 4</a></li>
                            <li><a class="dropdown-item" href="shop-grid-type-5">Shop Grid 5</a></li>
                            <li><a class="dropdown-item" href="search">Search</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about-us">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="account-dashboard">Dashboard</a></li>
                            <li><a class="dropdown-item" href="account-orders">My Orders</a></li>
                            <li><a class="dropdown-item" href="account-profile">My Profile</a></li>
                            <li><a class="dropdown-item" href="account-edit-profile">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="account-saved-address">Addresses</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="authentication-login">Login</a></li>
                            <li><a class="dropdown-item" href="authentication-register">Register</a></li>
                            <li><a class="dropdown-item" href="authentication-reset-password">Password</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                            Blog
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="blog-post">Blog Post</a></li>
                            <li><a class="dropdown-item" href="blog-read">Blog Read</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <ul class="navbar-nav secondary-menu flex-row">
            <li class="nav-item">
                <a class="nav-link dark-mode-icon" href="javascript:;">
                    <div class="mode-icon">
                        <i class="bi bi-moon"></i>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="search"><i class="bi bi-search"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="wishlist"><i class="bi bi-suit-heart"></i></a>
            </li>
            <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                <a class="nav-link position-relative" href="javascript:;">
                    <div class="cart-badge">8</div>
                    <i class="bi bi-basket2"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="account-dashboard"><i class="bi bi-person-circle"></i></a>
            </li>
        </ul>
    </nav>
</header>
<!--end top header-->


<!--start page content-->
<div class="page-content">

@yield('content')

</div>


<!--start footer-->
<section class="footer-section bg-section-2 section-padding">
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-4 g-4">
            <div class="col">
                <div class="footer-widget-6">
                    <img src="{{$store->logo}}" class="logo-img mb-3" alt="">
                    <h5 class="mb-3 fw-bold">About Us</h5>
                    <p class="mb-2">
                        {!! \Illuminate\Support\Str::words($store->description,30) !!}
                    </p>
                </div>
            </div>
            <div class="col col-6">
                <div class="footer-widget-7">
                    <h5 class="mb-3 fw-bold">Explore</h5>
                    <ul class="widget-link list-unstyled">
                        @foreach($categories as $category)
                        <li><a href="{{route('merchant.store.category',['subdomain'=>$subdomain,'id'=>$category->id])}}">{{$category->categoryName}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col col-6">
                <div class="footer-widget-8">
                    <h5 class="mb-3 fw-bold">Company</h5>
                    <ul class="widget-link list-unstyled">
                        <li><a href="javascript:;">Contact Us</a></li>
                        <li><a href="javascript:;">Return Policy</a></li>
                        <li><a href="javascript:;">Refund Policy</a></li>
                        <li><a href="javascript:;">Complaints</a></li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="footer-widget-9">
                    <h5 class="mb-3 fw-bold">Follow Us</h5>
                    <div class="social-link d-flex align-items-center gap-2">
                        <a href="javascript:;"><i class="bi bi-facebook"></i></a>
                        <a href="javascript:;"><i class="bi bi-twitter"></i></a>
                        <a href="javascript:;"><i class="bi bi-linkedin"></i></a>
                        <a href="javascript:;"><i class="bi bi-youtube"></i></a>
                        <a href="javascript:;"><i class="bi bi-instagram"></i></a>
                    </div>
                    <div class="mb-3 mt-3">
                        <h5 class="mb-0 fw-bold">Support</h5>
                        <p class="mb-0 text-muted">{{$store->email}}</p>
                    </div>
                    <div class="">
                        <h5 class="mb-0 fw-bold">Phone</h5>
                        <p class="mb-0 text-muted">{{$store->phone}}</p>
                    </div>
                </div>
            </div>
        </div><!--end row-->
        <div class="my-5"></div>

    </div>
</section>
<!--end footer-->

<footer class="footer-strip text-center py-3 bg-section-2 border-top positon-absolute bottom-0">
    <p class="mb-0 text-muted">Copyright © {{date('Y')}}. All right reserved. Powered By {{$siteName}}</p>
</footer>


<!--start cart-->
<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasRight"
     aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-section-2">
        <h5 class="mb-0 fw-bold" id="offcanvasRightLabel">8 items in the cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="cart-list">

            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/01.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/02.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/03.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/04.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/05.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/06.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/07.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/08.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/09.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
            <hr>
            <div class="d-flex align-items-center gap-3">
                <div class="bottom-product-img">
                    <a href="product-details">
                        <img src="{{ asset('templates/' . $theme . '/assets/images/new-arrival/10.webp')}}" width="60" alt="">
                    </a>
                </div>
                <div class="">
                    <h6 class="mb-0 fw-light mb-1">Product Name</h6>
                    <p class="mb-0"><strong>1 X $59.00</strong>
                    </p>
                </div>
                <div class="ms-auto fs-5">
                    <a href="javascript:" class="link-dark"><i class="bi bi-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer p-3 border-top">
        <div class="d-grid">
            <button type="button" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">Checkout</button>
        </div>
    </div>

</div>
<!--end cat-->


<!--start quick view-->

<!-- Modal -->
<div class="modal fade" id="QuickViewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-0">

            <div class="modal-body row g-3" id="modal-content">

            </div>

        </div>
    </div>
</div>
<!--end quick view-->


<!--Start Back To Top Button-->
<a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
<!--End Back To Top Button-->


<!-- JavaScript files -->
<script src="{{ asset('templates/' . $theme . '/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('templates/' . $theme . '/assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('templates/' . $theme . '/assets/plugins/slick/slick.min.js')}}"></script>
<script src="{{ asset('templates/' . $theme . '/assets/js/main.js')}}"></script>
<script src="{{ asset('templates/' . $theme . '/assets/js/index.js')}}"></script>
<script src="{{ asset('templates/' . $theme . '/assets/js/loader.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#QuickViewModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var actionUrl = button.data('action'); // Extract action URL from data-* attributes

            // Clear previous content
            $('#modal-content').html('<p>Loading...</p>');

            // AJAX request to fetch product data
            $.ajax({
                url: actionUrl,
                method: 'GET',
                success: function(response) {
                    // Update modal content with the product data
                    $('#modal-content').html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error here
                    console.error(error);
                    $('#modal-content').html('<p>Failed to load product details. Please try again later.</p>');
                }
            });
        });
    });
</script>

@include('basicInclude')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
