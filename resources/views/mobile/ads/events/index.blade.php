@extends('mobile.ads.layout.eventBase')
@section('content')
@push('css')
    <style>
        .suggestions-box {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            width: 100%;
            max-height: 300px; /* Adjust the height as needed */
            overflow-y: auto;
            z-index: 1000; /* Ensure the suggestions box is on top */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Optional: adds a subtle shadow */
        }

        .form-input {
            position: relative;
        }

        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }


    </style>
@endpush

<section class="section-t-space mt-3">
    <div class="custom-container">

        @if($events->count()>0)
            <div class="row g-3" id="product-list">
                @include('mobile.ads.events.components.event_lists')
            </div>
            <div class="text-center mt-4">
                <button id="load-more" class="btn btn-light" data-url="{{ url()->full() }}">Load More</button>
            </div>
        @else
            <div class="empty-tab">
                <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />

                <h2>No Events to Show</h2>
                <h5 class="mt-3">No events found. Browse another location perhaps</h5>
            </div>
        @endif
    </div>
</section>



    @push('js')
        <script>
            $(document).ready(function () {
                // CSRF token for Laravel AJAX requests
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                function fetchStates(countryIso) {
                    let stateSelect = $('select[name="state"]');

                    // Clear current states and show loading indicator
                    stateSelect.html('<option value="">Loading...</option>');

                    // Fetch states for the selected country
                    $.get("{{route('get.states.event')}}", { country: countryIso }, function (data) {
                        stateSelect.empty().append('<option value="">Select State</option>');
                        $.each(data.states, function (index, state) {
                            stateSelect.append(`<option value="${state.iso2}">${state.name}</option>`);
                        });
                    });
                }

                // Trigger state fetching when the country dropdown changes
                $('select[name="country"]').on('change', function () {
                    let countryIso = $(this).val();
                    if (countryIso) {
                        fetchStates(countryIso);
                    }
                });

                // On page load, fetch states for the initially selected country
                let initialCountryIso = $('select[name="country"]').val();
                if (initialCountryIso) {
                    fetchStates(initialCountryIso);
                }

                // Trigger search and filter when form changes or user types
                function submitSearch() {
                    let formData = $('#search-form').serialize();
                    let url = $('#search-form').attr('action') + '?' + formData;

                    // Fetch and display filtered results
                    $.get(url, function (data) {
                        $('#product-list').html(data.products);
                        if (data.hasMorePages) {
                            $('#load-more').show().data('url', url);
                        } else {
                            $('#load-more').hide();
                        }
                    });
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                let page = 1;
                let loadMoreBtn = $('#load-more');
                let loadMoreUrl = loadMoreBtn.data('url');

                let originalText = loadMoreBtn.text();

                function getFilterParams() {
                    return $('#search-form').serialize();
                }

                function loadProducts(resetPage = false) {
                    if (resetPage) {
                        page = 1; // Reset page to 1 for new search or filter
                        $('#product-list').empty(); // Clear the current products
                        loadMoreBtn.show(); // Ensure the button is shown
                    }

                    let requestUrl = `${loadMoreUrl}?page=${page}&${getFilterParams()}`;

                    // Show loading icon
                    loadMoreBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

                    $.ajax({
                        url: requestUrl,
                        type: 'GET',
                        success: function(response) {
                            if (response.products && response.products.trim() !== "") {
                                $('#product-list').append(response.products);
                                if (!response.hasMorePages) {
                                    loadMoreBtn.hide();
                                } else {
                                    loadMoreBtn.text(originalText);
                                }
                            } else {
                                $('#product-list').append(`
                                    <div class="empty-tab">
                                        <img class="img-fluid empty-img w-100" src="{{ asset('mobile/images/gif/search.gif') }}" alt="empty-search" />
                                        <h2>No Events to Show</h2>
                                        <h5 class="mt-3">No more events found.</h5>
                                    </div>
                                `);

                                loadMoreBtn.hide(); // Hide load more button
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading more products:', error);
                            loadMoreBtn.text(originalText);
                        }
                    });
                }

                // Load more on button click
                loadMoreBtn.click(function() {
                    page++;
                    loadProducts();
                });

                // Reset and reload on filter changes
                $('#search-form select[name="country"], #search-form select[name="state"], #search-form input[name="search"]').on('change keydown', function(event) {
                    // Prevent form submission on Enter key in the search input
                    if (event.type === 'keydown' && (event.key === 'Enter' || event.keyCode === 13)) {
                        event.preventDefault();
                    }
                    loadProducts(true); // Reset page and load with new filters
                });
            });

        </script>
    @endpush
@endsection
