@extends('storefront.theme1.layout.base')
@section('content')
    @inject('options','App\Custom\Storefront')

    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('merchant.store',['subdomain'=>$subdomain])}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->


    <!--start product details-->
    <section class="section-padding">
        <div class="container">
            <div class="d-flex align-items-center px-3 py-2 border mb-4">
                <div class="text-start">
                    <h4 class="mb-0 h4 fw-bold">My Bag (<span class="cart-badge"></span> items)</h4>
                </div>
                <div class="ms-auto">
                    <a href="{{route('merchant.store.shop',['subdomain'=>$subdomain])}}" type="button" class="btn btn-light btn-ecomm">Continue Shopping</a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-12 col-xl-8" id="cartView">

                </div>
                <div class="col-12 col-xl-4" id="order-summary-container">

                </div>
            </div><!--end row-->

        </div>
    </section>
    <!--start product details-->

    @push('js')
        <script>
            $(document).ready(function() {
                // Function to load cart items
                function loadCartItemsCart() {
                    $.ajax({
                        url: '{{ route("merchant.store.cart.items.cart", ["subdomain" => $subdomain]) }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                let cartItemsContainer = $('#cartView');
                                cartItemsContainer.html(response.html); // Load the HTML content
                                loadOrderSummary();
                            } else {
                                toastr.error('Failed to load cart items.');
                            }
                        },
                        error: function () {
                            toastr.error('An error occurred while loading cart items.');
                        }
                    });
                }
                loadCartItemsCart();
                // Event delegation for removing cart items
                $(document).on('click', '.remove-item-cart', function() {
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
                                getCartItemCartCount();
                                loadCartItemsCart();
                                loadOrderSummary();

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
                function getCartItemCartCount() {
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
                function updateCartBadge(itemCount) {
                    $('.cart-badge').text(itemCount); // Update the text content of the cart badge
                }

                function loadOrderSummary() {
                    $.ajax({
                        url: '{{ route("merchant.store.cart.summary.cart",['subdomain'=>$subdomain]) }}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#order-summary-container').html(response.html);
                            }
                        },
                        error: function(error) {
                            console.log('Error fetching order summary:', error);
                        }
                    });
                }
                // Apply coupon
                $(document).on('click', '.submit', function() {
                    var couponCode = $(this).siblings('input').val();
                    var url = $(this).data('url');
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            coupon: couponCode
                        },
                        beforeSend:function(){
                            $('.submit').attr('disabled', true);
                            $(".submit").LoadingOverlay("show",{
                                text        : "applying...",
                                size        : "20"
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                // Refresh order summary
                                getCartItemCartCount();
                                loadCartItemsCart();
                                loadOrderSummary();
                            } else {
                                toastr.error(response.error);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(jqXHR.responseJSON.data.error);
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                        }
                    });
                });
                //remove coupon
                $(document).on('click', '.remove-coupon', function() {
                    var url = $(this).data('url');
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend:function(){
                            $('.submit').attr('disabled', true);
                            $(".submit").LoadingOverlay("show",{
                                text        : "removing...",
                                size        : "20"
                            });
                        },
                        success: function(response) {
                            if (response.success) {
                                // Refresh order summary
                                getCartItemCartCount();
                                loadCartItemsCart();
                                loadOrderSummary();
                            } else {
                                toastr.error(response.error);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(jqXHR.responseJSON.data.error);
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
