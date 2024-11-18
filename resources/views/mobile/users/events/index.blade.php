@extends('mobile.users.layout.base')
@section('content')
    <div class="main mt-2 mb-5">
        <div class="container-fluid text-center">
            <a href="{{completedProfileMobile('mobile.user.events.manage')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                Organizer Dashboard
            </a>
        </div>
    </div>
    <!-- shop section start -->
    <section class="section-b-space">
        <div class="custom-container">
            <div class="row g-3" id="purchase-list">
                @include('mobile.users.events.components.users_ticket_list')
            </div>
            @if($purchases->hasMorePages())
                <div class="text-center mt-4">
                    <button class="btn btn-primary load-more" data-next-page="{{ $purchases->nextPageUrl() }}">
                        Load More
                    </button>
                </div>
            @endif
        </div>
    </section>

    @push('js')
        <script>
            $(document).ready(function () {
                $('.load-more').on('click', function () {
                    let button = $(this);
                    let nextPageUrl = button.data('next-page');

                    // Disable button while loading
                    button.prop('disabled', true).text('Loading...');

                    $.ajax({
                        url: nextPageUrl,
                        method: 'GET',
                        success: function (response) {
                            // Append the new purchases to the list
                            $('#purchase-list').append(response.html);

                            // Check if more pages are available
                            if (response.nextPageUrl) {
                                button.data('next-page', response.nextPageUrl).text('Load More').prop('disabled', false);
                            } else {
                                button.remove(); // Remove the button if no more pages
                            }
                        },
                        error: function () {
                            toastr.error('Failed to load more purchases. Please try again.');
                            button.prop('disabled', false).text('Load More');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
