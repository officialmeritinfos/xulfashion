@extends('mobile.users.layout.mainDetailBase')
@section('content')

    <!-- Search Section Start -->
    <section>
        <div class="custom-container">
            <form class="theme-form search-head">
                <div class="form-group">
                    <div class="form-input">
                        <input type="text" class="form-control search" id="guestSearch" placeholder="Enter your Ticket Code" />
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
                            </div>
                            <div class="product-box-detail">
                                <h4>{{$guest->guest->name}}</h4>
                                <h5>{{ $guest->guest->ticketCode }}</h5>
                                <div class="bottom-panel">
                                    <div class="price">
                                        <h6>
                                            <span class="badge {{ $guest->checkin_time ? 'bg-success' : 'bg-primary' }}">
                                                {{ $guest->checkin_time ?? 'Pending' }}
                                            </span>
                                        </h6>
                                    </div>
                                    <div class="rating">
                                        <h6>
                                            <strong>Check Out:</strong>
                                            <span class="badge {{ $guest->checkout_time ? 'bg-info' : 'bg-success' }}">
                                                {{ $guest->checkout_time ?? 'Checked in' }}
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


    @push('js')
        <script>
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
                        url: '{{ route("mobile.user.events.attendees.checkin.search", ["event" => $event->reference]) }}',
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
                                    const badgeClassOut = guest.checked_out_time ? 'bg-info' : 'bg-success';

                                    guestHtml += `
                        <div class="col-12 col-md-6">
                            <div class="product-box">
                                <div class="product-box-img">
                                    <span><img class="img" src="{{asset('mobile/images/placeholder-avatar.png')}}" alt="Guest Avatar" /></span>
                                </div>
                                <div class="product-box-detail">
                                    <h4>${guest.name}</h4>
                                    <h5>${guest.ticketCode}</h5>
                                    <div class="bottom-panel">
                                        <div class="price">
                                           <h6>
                                                <span class="badge ${badgeClass}">
                                                    ${guest.checked_in_time || 'Pending'}
                                                </span>
                                            </h6>
                                        </div>
                                        <div class="rating">
                                            <h6>
                                                <strong>Check Out:</strong>
                                                <span class="badge ${badgeClassOut}">
                                                    ${guest.checked_out_time || 'Checked In'}
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
