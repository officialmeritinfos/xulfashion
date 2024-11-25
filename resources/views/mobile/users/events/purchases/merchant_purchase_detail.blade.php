@extends('mobile.users.layout.base')
@section('content')

    <div class="custom-container mt-4">
        <!-- Event Details Section -->
        <div class="card shadow-sm p-4 mb-4">
            <div class="row">
                <div class="col-12">
                    <h2 class="fw-bold text-center theme-color">{{ $purchase->events->title }}</h2>
                </div>
            </div>
            <hr class="mb-2">
            <!-- Event Details -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <a href="{{route('mobile.user.events.detail',['event'=>$event->reference])}}" class="btn theme-btn mt-5 w-100">View Event Detail</a>
                </div>
            </div>

            <hr class="mb-4">

            <!-- Purchase Details -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="fw-bold">Purchase Details</h4>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6 mt-2">
                    <p><strong>Total Amount :</strong> <span class="text-info">{{ currencySign($purchase->purchaseCurrency) . number_format($purchase->price, 2) }}</span></p>
                </div>
                @if($purchase->paymentStatus==1)
                    <div class="col-md-6 mt-2">
                        <p><strong>Amount To Settle :</strong> <span class="text-info">{{ currencySign($purchase->purchaseCurrency) . number_format($purchase->totalPrice, 2) }}</span></p>
                    </div>
                    <div class="col-md-6 mt-2">
                        <p><strong>Total Charge :</strong> <span class="text-info">{{ currencySign($purchase->purchaseCurrency) . number_format($purchase->charge, 2) }}</span></p>
                    </div>
                @endif
                <div class="col-md-6 mt-2">
                    <p><strong>Payment Method:</strong> <span class="text-info">{{ ucfirst($purchase->paymentMethod) ?? 'Not Selected' }}</span></p>
                </div>
                @if($purchase->converted==1)
                    <div class="col-md-6 mt-2">
                        <p><strong>Amount Converted :</strong> <span class="text-info">{{ currencySign($user->mainCurrency) . number_format($purchase->conversionAmount, 2) }}</span></p>
                    </div>
                    <div class="col-md-6 mt-2">
                        <p><strong>Rate :</strong> <span class="text-info">{{ currencySign($user->mainCurrency) . number_format($purchase->conversionRate, 2) }}/{{currencySign($purchase->purchaseCurrency)}}</span></p>
                    </div>
                @endif
            </div>
        </div>

        @if($purchase->isPaid())
            <!-- Tickets Section -->
            <div class="card shadow-sm p-4 mb-4">
                <h3 class="fw-medium theme-color mb-4">Tickets</h3>
                @foreach($purchase->tickets as $ticket)
                    <div class="ticket-box border rounded p-4 mb-4">
                        <!-- Ticket Name -->
                        <div class="row align-items-center mb-2">
                            <div class="col-md-9">
                                <h5 class="fw-semibold theme-color mb-1">{{ $ticket->ticket->name }}</h5>
                            </div>
                        </div>

                        <!-- Ticket Details -->
                        <div class="row mb-3 g-2">
                            <div class="col-md-6 col-6">
                                <p><strong>Price:</strong> <span class="text-primary">{{ currencySign($ticket->currency) . number_format($ticket->price, 2) }}</span></p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p><strong>Total Price:</strong> <span class="text-primary">{{ currencySign($ticket->currency) . number_format($ticket->price*$ticket->quantity, 2) }}</span></p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p><strong>Quantity:</strong> <span class="text-primary">{{ $ticket->quantity }}</span></p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p><strong>Admissible Per Ticket:</strong> <span class="text-primary">{{ $ticket->number_admits }}</span></p>
                            </div>
                            <div class="col-md-6 col-6">
                                <p><strong>Guests Admissible:</strong> <span class="text-primary">{{ $ticket->number_admits * $ticket->quantity }}</span></p>
                            </div>
                        </div>

                        <!-- Guests Section -->
                        <div class="guests-section mt-2">
                            <h6 class="fw-bold mb-3">Guests:</h6>
                            @if($ticket->guests->count() > 0)
                                <ul class="list-unstyled">
                                    @foreach($ticket->guests as $guest)
                                        <li class="mb-2 d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="iconsax" data-icon="user"></i>
                                                <span class="fw-medium">{{ $guest->name }}</span>
                                                <span class="text-muted">({{ $guest->email }})</span>
                                            </div>
                                            <div class="actions">
                                                <!-- Send Mail Icon -->
                                                <span
                                                    class="text-primary me-2 send-mail" data-bs-toggle="tooltip"
                                                    title="Send Ticket"
                                                    data-url="{{ route('mobile.user.events.purchase.guest.send-ticket',['purchase'=>$purchase->reference,'purchaseTicket'=>$ticket->id,'guestId'=>$guest->id]) }}">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                                <!-- View Ticket Icon -->
                                                <a href="{{route('mobile.user.event.purchase.guest.ticket.view',['event'=>$purchase->events->reference,'ticket'=>$ticket->id,'guest'=>$guest->id])}}"
                                                   class="text-success view-ticket m-2 back" data-bs-toggle="tooltip"
                                                   title="View Ticket" target="_blank">
                                                    <i class="fa fa-ticket-alt"></i>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No guests added yet.</p>
                            @endif


                            <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
                                <a href="{{ route('mobile.user.event.purchase.guest.ticket.view.general',['event'=>$purchase->events->reference,'ticket'=>$ticket->id]) }}"
                                   class="btn btn-success btn-sm back" target="_blank">
                                    View Ticket
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif



    </div>


    @push('js')
        <script>
            $(document).ready(function () {
                // Handle send mail button click
                $('.send-mail').on('click', function (e) {
                    e.preventDefault();

                    const url = $(this).data('url'); // Get the URL from data-url attribute
                    const sendMailButton = $(this);

                    // Disable the button to prevent multiple clicks
                    sendMailButton.prop('disabled', true);

                    // Add a loading spinner or change icon to indicate progress
                    sendMailButton.find('i').removeClass('fa-envelope').addClass('fa-spinner fa-spin');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.error =='ok') {
                                toastr.success(response.message || 'Mail sent successfully to the guest.');
                            } else {
                                toastr.error(response.message || 'Failed to send the ticket.');
                            }
                        },
                        error: function (xhr) {
                            const errorMessage = xhr.responseJSON && xhr.responseJSON.error
                                ? xhr.responseJSON.error
                                : 'An error occurred while sending the ticket.';
                            toastr.error(errorMessage);
                        },
                        complete: function () {
                            // Re-enable the button and reset icon
                            sendMailButton.prop('disabled', false);
                            sendMailButton.find('i').removeClass('fa-spinner fa-spin').addClass('fa-envelope');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
