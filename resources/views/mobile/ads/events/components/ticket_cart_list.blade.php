@if(count($cartItems) > 0)
    <div class="custom-container">
        <div class="total-detail">
            @foreach($cartItems as $item)
                @php
                    $ticket = $item->userEventTicket;
                    $event = $ticket->event;
                @endphp
                <div class="sub-total mt-3 d-flex justify-content-between">
                    <div>
                        <h5 class="fw-medium light-text">{{ $ticket->name }}</h5>
                        <p class="small light-text">Event: {{ $event->title }}</p>
                        <p class="small light-text">Quantity: {{ $item->quantity }}</p>
                    </div>
                    <div>
                        <h4 class="fw-medium light-text">
                            {{ $currency . number_format(calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity, 2) }}
                        </h4>
                    </div>
                </div>
            @endforeach

            <div class="grand-total pt-3 d-flex justify-content-between">
                <h5 class="fw-medium light-text">Grand Total</h5>
                <h4 class="fw-semibold amount light-text">{{ $currency . $grandTotal }}</h4>
            </div>
        </div>

    </div>
@endif
