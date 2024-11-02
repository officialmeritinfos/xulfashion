
@if(count($cartItems) >0)

    <div class="custom-container">
        <div class="total-detail">
            @foreach($cartItems as $item)
                <div class="sub-total mt-3 d-flex justify-content-between">
                    <div>
                        <h5 class="fw-medium">{{ $item->userEventTicket->name }}</h5>
                        <p class="small light-text">Quantity: {{ $item->quantity }}</p>
                    </div>
                    <div>
                        <h4 class="fw-medium">
                            {{ $currency . number_format(calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity, 2) }}
                        </h4>
                    </div>
                </div>
            @endforeach

            <div class="grand-total pt-3 d-flex justify-content-between">
                <h5 class="fw-medium">Grand Total</h5>
                <h4 class="fw-semibold amount">{{ $currency . $grandTotal }}</h4>
            </div>
        </div>
        @if(!auth()->check())
            <a href="shipping-address.html" class="btn theme-btn w-100">Login/Register to Checkout</a>
        @else
            <a href="shipping-address.html" class="btn theme-btn w-100">Continue to Payment</a>
        @endif
    </div>
@endif
