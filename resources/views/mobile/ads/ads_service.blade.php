@extends('mobile.ads.layout.innerBase')
@section('content')

    <section class="section-b-space mt-5">
        <div class="custom-container">
            @if($ads->count()>0)
                <div class="row g-3" id="product-list">
                    @include('mobile.ads.layout.ads_listing')
                </div>
                <div class="text-center mt-4">
                    <button id="load-more" class="btn btn-light" data-url="{{ url()->full() }}">Load More</button>
                </div>
            @else
                <div class="empty-tab">
                    <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />

                    <h2>No Result to Show</h2>
                    <h5 class="mt-3">No ads found matching the filter. Checkout the listing below</h5>
                </div>
            @endif
        </div>
    </section>


    @push('js')
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
