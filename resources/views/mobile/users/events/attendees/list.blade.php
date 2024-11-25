@extends('mobile.users.layout.mainDetailBase')
@section('content')

    <!-- Search Section Start -->
    <section>
        <div class="custom-container">
            <form class="theme-form search-head">
                <div class="form-group">
                    <div class="form-input">
                        <input type="text" class="form-control search" id="guestSearch" placeholder="Enter Ticket Code" />
                        <i class="iconsax search-icon" data-icon="search-normal-2"></i>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Search Section End -->

    <!-- Guest List Section Start -->
    <section class="section-b-space">
        <div class="custom-container">
            <div class="row g-3 justify-content-center" id="guestList">
                @forelse($guests as $guest)
                    <div class="col-12 col-md-6">
                        <div class="product-box">
                            <div class="product-box-img">
                                <span> <img class="img" src="{{asset('mobile/images/placeholder-avatar.png')}}" alt="p2" /></span>

                                <div class="cart-box">
                                    <span class="cart-bag view-details"
                                          data-bs-toggle="modal"
                                          data-bs-target="#guestModal"
                                          data-guest="{{ json_encode($guest) }}"
                                          data-ticket-name="{{ $guest->ticket->ticket->name }}"
                                          data-ticket-type="{{ ucfirst($guest->ticket->ticket->ticketType) }}"
                                          data-price="{{ $currency->currency_symbol . ' ' . number_format($guest->ticket->price, 2) }}"
                                          data-checked-in="{{ optional($guest->checkinDetails)->checkin_time ?? 'Not Checked In' }}"
                                          data-url="{{ route('mobile.user.events.attendees.checkin', ['event' => $event->reference, 'guest' => $guest->id]) }}">
                                        <i class="fa fa-arrow-circle-o-right"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="product-box-detail">
                                <h4>{{$guest->name}}</h4>
                                <h5>{{ $guest->ticket->ticket->name }}</h5>
                                <h5>{{ $guest->ticketCode }}</h5>
                                <div class="bottom-panel">
                                    <div class="price">
                                        <h4> {{ $currency->currency_symbol . '' . number_format($guest->ticket->price, 2) }}</h4>
                                    </div>
                                    <div class="rating">
                                        <h6>
                                            <strong>Check In:</strong>
                                            <span class="badge {{ optional($guest->checkinDetails)->checkin_time ? 'bg-success' : 'bg-primary' }}">
                                                {{ optional($guest->checkinDetails)->checkin_time ?? 'Pending' }}
                                            </span>
                                        </h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">No guests have been added for this event yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-center">
            {{ $guests->links() }}
        </div>
    </section>
    <!-- Guest List Section End -->



    <!-- Guest Modal -->
    <div class="modal fade" id="guestModal" tabindex="-1" aria-labelledby="guestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="guestModalLabel">Guest Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <p><strong>Guest Name:</strong> <span id="modalGuestName"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Email:</strong> <span id="modalGuestEmail"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Email:</strong> <span id="modalGuestEmail"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Ticket Code:</strong> <span id="modalTicketCode"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Ticket Name:</strong> <span id="modalTicketName"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Ticket Type:</strong> <span id="modalTicketType"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Price Paid:</strong> <span id="modalPricePaid"></span></p>
                        </div>
                        <div class="col-md-6 col-6">
                            <p><strong>Checked In:</strong> <span id="modalCheckedIn"></span></p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <button type="button" class="btn theme-btn mt-5 w-100" id="checkInGuest" data-url="">Check In</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@push('js')
    <script>
        $(document).ready(function () {
            // Open modal and populate guest details
            $('#guestModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const guest = button.data('guest');

                // Populate modal fields
                $('#modalGuestName').text(guest.name);
                $('#modalGuestEmail').text(guest.email);
                $('#modalTicketCode').text(guest.ticketCode);
                $('#modalTicketName').text(button.data('ticket-name'));
                $('#modalTicketType').text(button.data('ticket-type'));
                $('#modalPricePaid').text(button.data('price'));
                $('#modalCheckedIn').text(button.data('checked-in'));

                // Set check-in button URL
                $('#checkInGuest').data('url', button.data('url'));
            });

            // Handle check-in button click
            $('#checkInGuest').click(function () {
                const checkinUrl = $(this).data('url');
                const $button = $(this); // Reference the button
                const originalText = $button.text(); // Store the original text

                // Change button text to indicate loading
                $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Checking In...');

                // Send AJAX request
                $.ajax({
                    url: checkinUrl,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#guestModal').modal('hide');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Failed to check in the guest.');
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = 'An error occurred while processing the request.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            // If the server returned a specific error message
                            errorMessage = xhr.responseJSON.error;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // If the server returned a general message
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 422 && xhr.responseJSON.errors) {
                            // If there are validation errors
                            errorMessage = 'Validation errors occurred:';
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errorMessage += '\n- ' + value[0];
                            });
                        }

                        toastr.error(errorMessage); // Display the error message
                    },
                    complete: function () {
                        // Restore the button text and re-enable it
                        $button.prop('disabled', false).html(originalText);
                    }
                });
            });
        });

        $(document).ready(function () {
            $('#guestSearch').on('input', function () {
                const searchTerm = $(this).val().trim();

                // If the search term is empty, reset the UI
                if (searchTerm === '') {
                    $('#guestList').html('');
                    fetchGuests(searchTerm);
                    $('.pagination').show(); // Show pagination if the search bar is cleared
                    return;
                }
                // Send an AJAX request to fetch matching guests
                fetchGuests(searchTerm);
            });

            function fetchGuests(searchTerm){
                $.ajax({
                    url: '{{ route("mobile.user.events.attendees.search", ["event" => $event->reference]) }}',
                    method: 'GET',
                    data: { query: searchTerm },
                    beforeSend: function () {
                        // Show a loading spinner or clear the list during the search
                        $('#guestList').html('<p class="text-center text-primary">Searching...</p>');
                        $('.pagination').hide(); // Hide pagination during search
                    },
                    success: function (response) {
                        if (response.data && response.data.length > 0) {
                            // Populate the list with matched guests
                            let guestHtml = '';
                            response.data.forEach(guest => {
                                // Determine the badge class based on the check-in status
                                const badgeClass = guest.checked_in_time ? 'bg-success' : 'bg-primary';

                                guestHtml += `
                        <div class="col-12 col-md-6">
                            <div class="product-box">
                                <div class="product-box-img">
                                    <span><img class="img" src="{{asset('mobile/images/placeholder-avatar.png')}}" alt="Guest Avatar" /></span>
                                    <div class="cart-box">
                                        <span class="cart-bag view-details"
                                              data-bs-toggle="modal"
                                              data-bs-target="#guestModal"
                                              data-guest='${JSON.stringify(guest)}'
                                              data-ticket-name="${guest.ticket.name}"
                                              data-ticket-type="${guest.ticket.ticketType}"
                                              data-price="${guest.ticket.currencySymbol}${guest.ticket.price}"
                                              data-checked-in="${guest.checked_in_time || 'Not Checked In'}"
                                              data-url="${guest.checkin_url}">
                                            <i class="fa fa-arrow-circle-o-right"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="product-box-detail">
                                    <h4>${guest.name}</h4>
                                    <h5>${guest.ticket.name}</h5>
                                    <h5>${guest.ticketCode}</h5>
                                    <div class="bottom-panel">
                                        <div class="price">
                                            <h4>${guest.ticket.currencySymbol}${guest.ticket.price}</h4>
                                        </div>
                                        <div class="rating">
                                            <h6>
                                                <strong>Check In:</strong>
                                                <span class="badge ${badgeClass}">
                                                    ${guest.checked_in_time || 'Pending'}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                            });
                            $('#guestList').html(guestHtml);
                        } else {
                            // Show the "No match found" UI if no results
                            $('#guestList').html(`
                    <div class="empty-tab text-center">
                        <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />
                        <h2>No Guest Match to Show</h2>
                        <h5 class="mt-3">No guests found.</h5>
                    </div>
                `);
                        }
                    },
                    error: function () {
                        // Handle errors
                        $('#guestList').html('<p class="text-danger text-center">An error occurred while searching. Please try again later.</p>');
                    }
                });
            }
        });


    </script>
@endpush
@endsection
