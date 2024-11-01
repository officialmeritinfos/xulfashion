@extends('mobile.ads.events.components.cartBase')
@section('content')
@push('css')
    <style>
        .modal-content {
            border-radius: 10px;
            padding: 20px;
        }

        .modal-header h5 {
            font-weight: 700;
            font-size: 18px;
        }

        .modal-body p {
            font-size: 16px;
            color: #333;
        }

        .modal-footer .btn {
            width: 130px;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .modal-footer .btn-light {
            background-color: #f8d7da;
            color: #dc3545;
            font-weight: bold;
        }

        .modal-footer .btn-warning {
            background-color: #dc3545;
            color: #fff;
            font-weight: bold;
        }

        .spinner-border {
            margin-left: 5px;
        }

    </style>
@endpush
    <section class="mt-4">
        <div class="custom-container">
            @if($tickets->count()>0)
                <ul class="horizontal-product-list">
                    @foreach($tickets as $ticket)
                        <li class="cart-product-box" data-ticket="{{$ticket->id}}" data-purchaseLimit="{{$ticket->purchaseLimit}}"
                        data-price="{{calculateTotalCostOnTicket($ticket->id)}}">
                            <div class="horizontal-product-box">
                                <div class="horizontal-product-img">
                                    @if($ticket->kindOfTicket==1)
                                        <img class="img-fluid img" src="https://glenthemes.github.io/iconsax/icons/ticket-1.svg" alt="p11" />
                                    @else
                                        <img class="img-fluid img" src="https://glenthemes.github.io/iconsax/icons/ticket-2.svg" alt="p11" />
                                    @endif
                                </div>
                                <div class="horizontal-product-details">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4>{{$ticket->name}} <sup>({{ucfirst($ticket->ticketType)}})</sup></h4>
                                    </div>
                                    <ul class="product-info fw-bold">
                                        <span>
                                            {{$ticket->isFree() ? '' : currencySign($ticket->currency)}}{{$ticket->isFree() ? 'Free' : calculateTotalCostOnTicket($ticket->id)}}
                                            <small class="fw-light">
                                                {{displayChargeOnTicketIfAny($ticket->id)}}
                                            </small>
                                        </span>
                                    </ul>

                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <div class="d-flex align-items-center gap-2 text-start">
                                            <h3 class="fw-bold">
                                                <li>Qty : {{$ticket->quantity}}</li>
                                            </h3>
                                        </div>
                                        <div class="plus-minus">
                                            <button class="sub plus-minus-button">
                                                <i class="iconsax" data-icon="minus"></i>
                                            </button>
                                            <input type="number" value="0" min="0" max="{{$ticket->purchaseLimit}}" readonly/>
                                            <button class="add plus-minus-button">
                                                <i class="iconsax" data-icon="add"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <h3 class="fw-semibold see-more-toggle" style="cursor: pointer;">
                                            See more
                                        </h3>
                                        <div class="toggle-content" style="display: none;">
                                            {{$ticket->description}}<br/>
                                            <strong>Perks:</strong><br/> @php $text = implode('|',$ticket->perks) @endphp
                                            <span class="badge bg-primary" style="word-break: break-word;">{{$text}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-3">
                    <div class="pay-popup-loader" style="display: none; text-align: center;">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </div>
                </div>
            @else
                <div class="card justify-content-center">
                    <div class="card-body text-center">
                        Ticket not found for this event
                    </div>
                </div>
            @endif

        </div>
    </section>
    <!-- cart section end -->
    <!-- Ticket Cart List Component -->
    <section class="bill-details section-b-space cart-list">
        <div class=""></div>
    </section>

    @if($tickets->count() >0)

        @push('js')

            <!-- Custom Confirmation Modal -->
            <div id="reload-confirm-modal" class="modal" tabindex="-1" role="dialog" style="display: none;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title font-weight-bold">Release tickets</h5>
                        </div>
                        <div class="modal-body text-center">
                            <p>Are you sure you want to cancel? This will cancel the order and release your tickets.</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-center border-0">
                            <button type="button" class="btn btn-light text-danger" data-dismiss="modal" style="border: 1px solid #f8d7da;">
                                Cancel
                            </button>
                            <button type="button" id="confirm-reload" class="btn btn-warning text-white ml-2">
                                <span class="button-text">Proceed</span>
                                <span class="spinner-border spinner-border-sm" id="loading-spinner" role="status" style="display: none;"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- cart bottom start -->
            <div class="pay-popup">
                <div class="price-items">
                    <h6>Total Cart</h6>
                    <h2><span id="currency"></span><span id="total-price">0.00</span></h2>
                </div>
                <a href="#" class="btn btn-lg theme-btn pay-btn mt-0">Checkout</a>
            </div>
            <!-- // Fetch the cart on page load -->
            <script>
                $(document).ready(function() {
                    // Fetch current ticket amount on page load
                    fetchCartTotal();

                    function fetchCartTotal() {
                        $('.pay-popup-loader').show();
                        $('.pay-popup').hide();

                        $.ajax({
                            url: "{{ route('mobile.marketplace.events.cart.total') }}",
                            method: "GET",
                            success: function(response) {
                                $('.pay-popup-loader').hide();
                                $('.pay-popup').show();
                                $('#total-price').text(response.totalPrice.toFixed(2));
                                $('#currency').text(response.currency);
                            },
                            error: function() {
                                toastr.error("Failed to load cart total.");
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
                });
            </script>
            <!-- cart bottom end -->
            <!--// Update cart -->
            <script>
                $(document).ready(function() {
                    // Handle plus button click
                    $('.add').on('click', function() {
                        const ticketEl = $(this).closest('.cart-product-box');
                        updateTicketQuantity(ticketEl, 0);
                    });

                    // Handle minus button click
                    $('.sub').on('click', function() {
                        const ticketEl = $(this).closest('.cart-product-box');
                        updateTicketQuantity(ticketEl, -0);
                    });

                    function updateTicketQuantity(ticketEl, change) {
                        const ticketId = ticketEl.data('ticket');
                        const price = parseFloat(ticketEl.data('price'));
                        const purchaseLimit = parseInt(ticketEl.data('purchaselimit'));
                        const inputEl = ticketEl.find("input[type='number']");
                        let quantity = parseInt(inputEl.val());

                        // If quantity is 0 and the user is adding, set initial quantity to 1
                        if (quantity === 0 && change > 0) {
                            quantity = 1;
                        } else {
                            quantity += change;
                        }

                        // Ensure quantity does not exceed purchase limit or go below 0
                        if (quantity > purchaseLimit) {
                            toastr.error("You have reached the purchase limit for this ticket.");
                            quantity = purchaseLimit; // Set quantity to max if it exceeds limit
                            inputEl.val(quantity);
                            return;
                        } else if (quantity < 0) {
                            quantity = 0;
                        }

                        // Update input value
                        inputEl.val(quantity);

                        // Only proceed with AJAX if quantity is greater than 0
                        if (quantity >= 0) {
                            $('.pay-popup').hide();
                            $('.cart-list').hide();
                            $('.pay-popup-loader').show();
                            // AJAX request to update cart on backend
                            $.ajax({
                                url: "{{ route('mobile.marketplace.events.cart.manager') }}",
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    user_event_ticket_id: ticketId,
                                    quantity: quantity
                                },
                                success: function(response) {
                                    if (response.success) {
                                        // Update total price in the DOM
                                        $('#total-price').text(response.totalPrice.toFixed(2));
                                        $('#currency').text(response.currency);
                                        // Replace .cart-list content with the updated component
                                        updateCartComponent();
                                        if (quantity === 0) {
                                            // Remove item from cart display if quantity is zero
                                            ticketEl.val(0);
                                        }
                                    } else {
                                        toastr.error(response.message);
                                    }
                                },
                                error: function(xhr) {
                                    toastr.error(xhr.responseJSON.message || "An error occurred while updating the cart.");
                                    $('.pay-popup-loader').hide();
                                    $('.cart-list').show();
                                    $('.pay-popup').show();
                                },
                                complete: function() {
                                    // Hide loader and show the pay-popup div again
                                    $('.pay-popup-loader').hide();
                                    $('.pay-popup').show();
                                    $('.cart-list').show();
                                }
                            });
                        }
                    }
                    // Function to update cart component
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
                });
            </script>
            <!--   // Release Tickets -->
            <script>
                $(document).ready(function() {
                    let reloadConfirmed = false;

                    // Show custom modal when reload is attempted
                    function showReloadConfirmation(event) {
                        event.preventDefault();
                        $('#reload-confirm-modal').modal('show');
                    }

                    // Intercept clicks or key presses for reload
                    $(document).on('keydown', function(event) {
                        if ((event.which === 116) || (event.which === 82 && event.ctrlKey)) {
                            event.preventDefault();
                            showReloadConfirmation(event);
                        }
                    });

                    // Handle confirmation button click
                    $('#confirm-reload').on('click', function() {
                        reloadConfirmed = true;

                        // Show the loading spinner
                        $('#loading-spinner').show();
                        $('.button-text').text("Processing...");

                        // AJAX request to delete the cart
                        $.ajax({
                            url: "{{ route('mobile.marketplace.events.cart.delete') }}",
                            method: "GET",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                } else {
                                    toastr.error(response.message || "Failed to delete cart.");
                                }
                            },
                            error: function() {
                                toastr.error("An error occurred while deleting the cart.");
                            }
                        });
                    });

                    // Handle cancel button click
                    $('#reload-confirm-modal .btn-light').on('click', function() {
                        reloadConfirmed = false;
                        $('#reload-confirm-modal').modal('hide');
                    });
                });
            </script>
            <!-- TOggle See More -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Select all the see more toggles
                    const seeMoreToggles = document.querySelectorAll(".see-more-toggle");

                    seeMoreToggles.forEach(toggle => {
                        toggle.addEventListener("click", function() {
                            // Find the proceeding <p> tag for this "See more" link
                            const content = this.nextElementSibling;

                            if (content.style.display === "none" || content.style.display === "") {
                                content.style.display = "block";
                                this.textContent = "See less";
                            } else {
                                content.style.display = "none";
                                this.textContent = "See more";
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endif
    <div class="panel-space"></div>

@endsection
