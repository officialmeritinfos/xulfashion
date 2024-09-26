@extends('mobile.ads.layout.storeInnerBase')
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

<!-- other furniture section start -->
<section class="section-t-space mt-3">
    <div class="custom-container">

        @if($stores->count()>0)
            <div class="row g-3" id="product-list">
                @include('mobile.ads.layout.store_listing')
            </div>
            @if($stores->hasMorePages())
                <div class="text-center mt-4">
                    <button id="load-more" class="btn btn-light" data-url="{{ url()->full() }}">Load More</button>
                </div>
            @endif
        @else
            <div class="empty-tab">
                <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />

                <h2>No Store to Show</h2>
                <h5 class="mt-3">No store found.</h5>
            </div>
        @endif
    </div>
</section>


    @push('js')
        <script>
            $(document).ready(function(){
                function fetchSuggestions() {
                    let query = $('#search-input').val();
                    let state = $('#state-select').val();

                    if(query.length > 2) { // Start searching after 3 characters
                        $.ajax({
                            url: "{{ route('mobile.marketplace.store.search') }}", // Your AJAX route
                            type: "GET",
                            data: {
                                query: query,
                                state: state,
                            },
                            success: function(data) {
                                let suggestionsHTML = '';
                                if (data.length > 0) {
                                    data.forEach(function(suggestion) {
                                        let categoryText = suggestion.category !== 'N/A' ? ` in ${suggestion.category}` : '';
                                        let locationText = suggestion.location !== 'N/A' ? ` at ${suggestion.location}` : '';
                                        let stateText = suggestion.stateName !== 'All of ' ? ` in ${suggestion.stateName}` : '';

                                        suggestionsHTML += `
                                <div class="suggestion-item"
                                     data-search="${suggestion.search}"
                                     data-url="${suggestion.url}"
                                     data-category="${suggestion.category}"
                                     data-location="${suggestion.location}"
                                     data-state="${suggestion.state}">
                                    <strong>${suggestion.search}${categoryText}${locationText}${stateText}</strong>
                                </div>
                            `;
                                    });
                                } else {
                                    suggestionsHTML = '<p>No suggestions found</p>';
                                }
                                $('#suggestions-box').html(suggestionsHTML).show();
                            },
                            error: function() {
                                $('#suggestions-box').html('<p>An error occurred</p>').show();
                            }
                        });
                    } else {
                        $('#suggestions-box').hide();
                    }
                }

                // Fetch suggestions when typing in the search input
                $('#search-input').on('keyup', function() {
                    fetchSuggestions();
                });

                // Fetch suggestions when the state is changed
                $('#state-select').on('change', function() {
                    fetchSuggestions();
                });

                // Handle suggestion click
                $(document).on('click', '.suggestion-item', function(e) {
                    e.preventDefault();

                    let url = $(this).data('url');
                    if (url) {
                        window.location.href = url;
                    }
                });

                // Hide suggestions when clicking outside
                $(document).click(function(e) {
                    if (!$(e.target).closest('#search-input, #suggestions-box').length) {
                        $('#suggestions-box').hide();
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                let page = 1;
                let loadMoreBtn = $('#load-more');
                let loadMoreUrl = loadMoreBtn.data('url');
                let originalText = loadMoreBtn.text();

                loadMoreBtn.click(function() {
                    page++;
                    //show loading icon
                    loadMoreBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                    $.ajax({
                        url: loadMoreUrl,
                        type: 'GET',
                        data: { page: page },
                        success: function(response) {
                            if(response.products) {
                                $('#product-list').append(response.products);
                                if(!response.hasMorePages) {
                                    loadMoreBtn.hide();
                                } else {
                                    loadMoreBtn.text(originalText);
                                }
                            }else {
                                loadMoreBtn.text(originalText);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading more products:', error);
                            loadMoreBtn.text(originalText);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
