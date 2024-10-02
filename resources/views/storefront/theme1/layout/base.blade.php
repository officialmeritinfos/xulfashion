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
    <title>{{$store->name}} - {{$pageName??'Your one stop fashion store'}}</title>
    @include('storeFrontGenericCss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="canonical" href="{{url('/')}}">
    <meta name="robots" content="index, follow">
    <meta property="og:locale" content="en_US">
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-navbutton-color" content="#000000">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="description" content="{{$store->description}}">
    <meta name="keywords" content="{{$web->keywords}}">
    <meta name="author" content="{{$store->name}}">
    <meta property="og:title" content="{{$siteName}} - {{$pageName}}">
    <meta property="og:description" content="{{$store->description}}">
    <meta property="og:image" content="{{asset($store->logo)}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{$store->name}}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$store->name}} - {{$pageName??'Your one stop fashion store'}}">
    <meta name="twitter:description" content="{{$store->description}}">
    <meta name="twitter:image" content="{{asset($store->logo)}}">
    <meta name="twitter:site" content="@ {{$store->name}}">
    <meta name="twitter:creator" content="@ {{$store->name}}">
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "WebSite",
          "name": "{{$store->name}}",
          "url": "{{url('/')}}",
          "description": "{{$store->description}}",
          "sameAs": [
            "https://www.facebook.com/xulfashion",
            "https://www.twitter.com/xulfashion",
            "https://www.instagram.com/getxulfashion"
          ],
          "publisher": {
            "@type": "Organization",
            "name": "{{$store->name}}",
            "logo": {
              "@type": "ImageObject",
              "url": "{{asset($store->logo)}}"
            }
          },
          "image": "{{asset($store->logo)}}"
        }
    </script>
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('merchant.store.catalog',['subdomain'=>$subdomain])}}">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('merchant.about',['subdomain'=>$subdomain])}}">About</a>
                    </li>
                    @if($storeSetting->allowSignups==1)

                        <li class="nav-item">
                            <a class="nav-link" href="{{(session()->has('loggedIn'))?route('merchant.store.user.index',['subdomain'=>$subdomain]):route('merchant.store.login',['subdomain'=>$subdomain])}}">
                                Account
                            </a>
                        </li>
                    @endif
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
            <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
                <a class="nav-link position-relative" href="javascript:;">
                    <div class="cart-badge" id="cartBadge">0</div>
                    <i class="bi bi-basket2"></i>
                </a>
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
                        <li><a href="{{route('merchant.contact',['subdomain'=>$subdomain])}}">Contact Us</a></li>
                        <li><a href="{{route('merchant.return',['subdomain'=>$subdomain])}}">Return Policy</a></li>
                        <li><a href="{{route('merchant.refund',['subdomain'=>$subdomain])}}">Refund Policy</a></li>
                        <li><a href="{{route('merchant.store.ticket.new',['subdomain'=>$subdomain])}}">Complaints</a></li>
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
        <h5 class="mb-0 fw-bold" id="offcanvasRightLabel">0 items in the cart</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="cart-list" id="cart-items-container">


        </div>
    </div>
    <div class="offcanvas-footer p-3 border-top">
        <div class="d-grid">
            <a href="{{route('merchant.store.cart',['subdomain'=>$subdomain])}}" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">View Cart</a>
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
{{--<script src="{{ asset('templates/' . $theme . '/assets/js/requests/cart.js')}}"></script>--}}

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

<script>
    $(document).ready(function() {
        $(document).on('submit', '#addToCartForms', function(e) {
            e.preventDefault();
            var baseURL = $('#addToCartForms').attr('action');

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:baseURL,
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $("#addToCartForm :input").prop("readonly", true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "processing...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#addToCartForm :input").prop("readonly", false);
                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        loadCartItems();
                        getCartItemCount();

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            $("#addToCartForm :input").prop("readonly", false);
                            // window.location.replace(data.data.redirectTo)
                            //close modal
                            $('#QuickViewModal').modal('hide');
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#addToCartForm :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
        // Function to load cart items
        function loadCartItems() {
            $.ajax({
                url: '{{ route("merchant.store.cart.items", ["subdomain" => $subdomain]) }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        let cartItemsContainer = $('#cart-items-container');
                        cartItemsContainer.html(response.html); // Load the HTML content
                        $('#offcanvasRightLabel').text(response.itemCount + ' items in the cart');

                    } else {
                        toastr.error('Failed to load cart items.');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while loading cart items.');
                }
            });
        }

        // Load cart items when the offcanvas is shown
        $('#offcanvasRight').on('show.bs.offcanvas', function () {
            loadCartItems();
        });

        // Event delegation for updating quantity
        $(document).on('change', '.update-quantity', function() {
            let productId = $(this).data('id');
            let quantity = $(this).val();
            $.ajax({
                url: '{{ route("merchant.store.update.cart", ["subdomain" => $subdomain]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if(response.success) {
                        loadCartItems();
                        toastr.success('Cart updated.');
                    } else {
                        toastr.error('Failed to update cart.');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while updating the cart.');
                }
            });
        });

        // Event delegation for removing cart items
        $(document).on('click', '.remove-item', function() {
            let url = $(this).data('url');
            let productId = $(this).data('product-id');
            let sizeId = $(this).data('size-id') || 'no-size';
            let colorId = $(this).data('color-id') || 'no-color';

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    size_id: sizeId,
                    color_id: colorId
                },
                success: function(response) {
                    if(response.success) {
                        loadCartItems();
                        getCartItemCount();
                        toastr.success('Item removed from cart.');
                    } else {
                        toastr.error('Failed to remove item from cart.');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while removing the item.');
                }
            });
        });
        // Function to update the cart badge
        function updateCartBadge(itemCount) {
            $('.cart-badge').text(itemCount); // Update the text content of the cart badge
        }

        // Function to fetch the cart item count from the server
        function getCartItemCount() {
            $.ajax({
                type: 'GET',
                url: '{{ route("get.cart.item.count",['subdomain'=>$subdomain]) }}',
                success: function(response) {
                    // Update the cart badge with the fetched item count
                    updateCartBadge(response.itemCount);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        getCartItemCount();
    });
</script>


@include('storeFrontBasicInclude')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stack('js')
</body>
</html>
