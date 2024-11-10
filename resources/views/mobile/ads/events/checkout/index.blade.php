@extends('mobile.ads.events.components.cartBase')
@section('content')

    <!-- Payment Method Section Start -->
    <section class="payment-method section-lg-b-space">

        <div class="custom-container">
            <h2 class="fw-semibold theme-color section-t-space">Select Payment Method</h2>
            <div class="payment-list">
                <ul class="cart-add-box payment-card-box gap-0 mt-3">
                    <li class="w-100" data-paymentmethod="card">
                        <div class="payment-detail">
                            <label class="form-label" for="card">
                                <img class="img-fluid img" src="{{ asset('mobile/images/svg/card.png') }}" alt="Card Payment" style="width: 50px;" />
                                <span>
                                <span class="fw-normal theme-color">Card Payment</span>
                            </span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" id="card" type="radio" name="payment_method" value="card" />
                            </div>
                        </div>
                    </li>
                    @if($event->currency == 'NGN')
                        <li class="w-100" data-paymentmethod="transfer">
                            <div class="payment-detail border-bottom-0">
                                <label class="form-label" for="transfer">
                                    <img class="img-fluid img" src="{{ asset('mobile/images/svg/bank-transfer.png') }}" alt="Bank Transfer" style="width: 50px;" />
                                    <span>
                                <span class="fw-normal theme-color">Bank Transfer</span>
                            </span>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" id="transfer" type="radio" name="payment_method" value="transfer" />
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
    <!-- Payment Method Section End -->
    <section class="payment-method section-lg-b-space">
        <div class="custom-container">
            <h2 class="fw-semibold theme-color section-t-space">Ticket Cart</h2>
        </div>
    </section>
    <section class="bill-details section-b-space cart-list"></section>

    <div class="mt-3">
        <div class="pay-popup-loader" style="display: none; text-align: center;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </div>
    </div>


    <!-- Pay Popup Start -->
    <div class="pay-popup">
        <div class="price-items">
            <h6>Total cart</h6>
            <h2 data-amount="{{ calculateTicketCart() }}">{{ currencySign($event->currency) }}{{ calculateTicketCart() }}</h2>
        </div>
        <button id="pay-now" class="btn btn-lg theme-btn pay-btn mt-0">Pay Now</button>
    </div>
    <!-- Pay Popup End -->

    @push('js')
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "5000"
                };

                // Handle Pay Now button click
                $('.pay-btn').on('click', function(e) {
                    e.preventDefault();

                    // Get selected payment method
                    const selectedMethod = $('input[name="payment_method"]:checked').closest('li').data('paymentmethod');
                    if (!selectedMethod) {
                        toastr.error('Please select a payment method.');
                        return;
                    }

                    // Get total amount
                    const totalAmount = parseFloat($('.price-items h2').data('amount'));
                    if (isNaN(totalAmount) || totalAmount <= 0) {
                        toastr.error('Invalid total amount.');
                        return;
                    }

                    // Disable the Pay Now button to prevent multiple submissions
                    $(this).prop('disabled', true).text('Processing...');

                    // Send AJAX request to process the payment
                    $.ajax({
                        url: "{{ route('mobile.marketplace.events.cart.process.checkout',['event'=>$event->reference]) }}",
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            payment_method: selectedMethod,
                            amount: totalAmount
                        },
                        success: function(response) {
                            if (response.success) {
                                // Redirect to the payment URL
                                if (response.payment_url) {
                                    toastr.success(response.message || 'Payment initialized successfully.');
                                    window.location.href = response.payment_url;
                                } else {
                                    toastr.error('Payment URL not found. Please contact support.');
                                }
                            } else {
                                toastr.error(response.message || 'Checkout failed. Please try again.');
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'An error occurred while processing the payment.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                                // Handle validation errors
                                errorMessage = 'Validation errors occurred:';
                                $.each(xhr.responseJSON.errors, function(key, value) {
                                    errorMessage += '\n' + value[0];
                                });
                            }
                            toastr.error(errorMessage);
                        },
                        complete: function() {
                            // Re-enable the Pay Now button
                            $('.pay-btn').prop('disabled', false).text('Pay Now');
                        }
                    });
                });
            });
        </script>
        <script>
            function updateCartComponent() {
                $('.pay-popup-loader').show();
                $('.pay-popup').hide();

                $.ajax({
                    url: "{{ route('mobile.marketplace.events.cart.list') }}"+"?ref={{$event->reference}}",
                    method: "GET",
                    success: function(response) {
                        $('.cart-list').html(response.cartComponent);
                        $('.pay-popup-loader').hide();
                        $('.pay-popup').show();
                    },
                    error: function() {
                        toastr.error("An error occurred while updating the cart list.");
                        $('.pay-popup-loader').hide();
                        $('.pay-popup').show();
                    },
                    complete: function() {
                        // Hide loader and show the pay-popup div again
                        $('.pay-popup-loader').hide();
                        $('.pay-popup').show();
                    }
                });
            }
            // Load cart component on page load if items are in cart
            updateCartComponent();
        </script>

    @endpush

@endsection
