@extends('mobile.users.layout.base')
@section('content')
<div class="main mt-2 mb-5">
    @if($ads->count()>0)
        <div class="container-fluid text-center">
            <a href="{{route('mobile.user.ads.new')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">Create Ad</a>
        </div>
    @endif
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Ads
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" title="Excludes ads which had expired or under review"></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{$totalAds}}</h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Total Views
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip" title="Views and clicks recorded for active Ads."></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{$views}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($ads->count()<1)
        <!-- cart start -->
        <div class="custom-container">
            <div class="empty-tab">
                <img class="img-fluid empty-img" src="{{asset('mobile/images/gif/cart.gif')}}" alt="empty-cart" />

                <h2>Your Ad list is empty.</h2>
                <h5 class="mt-3">
                    You currently have not listed any ads. Click the button below to create an ad
                </h5>

                <a href="{{route('mobile.user.ads.new')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">Create Ad</a>
            </div>
        </div>
    @else
            <section class="section-b-space">
                <div class="custom-container">
                    <div class="row g-3" id="product-list">
                        @include('mobile.users.ads.components.merchant_ad_list')
                    </div>
                    @if($ads->hasMorePages())
                        <div class="row g-3">
                            <div class="text-center mt-4">
                                <button id="load-more" class="btn btn-light btn-auto btn-sm" data-url="{{ url()->full() }}">Load More</button>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
    @endif

</div>

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
