@extends('mobile.ads.layout.innerBase')
@section('content')

    <!-- other furniture section start -->
    <section class="section-t-space mt-3">
        <div class="custom-container">

            @if($stores->count()>0)
                <div class="row g-3" id="product-list">
                    @include('mobile.ads.layout.store_listing')
                </div>
                <div class="text-center mt-4">
                    <button id="load-more" class="btn btn-light" data-url="{{ url()->full() }}">Load More</button>
                </div>
            @else
                <div class="empty-tab">
                    <img class="img-fluid empty-img w-100" src="{{asset('mobile/images/gif/search.gif')}}" alt="empty-search" />

                    <h2>No Store to Show </h2>
                    <h5 class="mt-3">No store found for filter. Checkout the stores below:</h5>
                </div>
            @endif
        </div>
    </section>

    @if($others->count()>0 && $stores->count()<1)
        <!-- offer section start -->
        <section class="offer-zone section-b-space pt-0">
            <div class="custom-container">
                <div class="title">
                    <h2>Similar Stores</h2>
                </div>

                <div class="swiper offer">
                    <div class="swiper-wrapper">
                        @foreach($others as $other)
                            <div class="swiper-slide">
                                <div class="horizontal-product-box">
                                    <a href="{{route('mobile.marketplace.store.detail',['id'=>$other->reference])}}" class="horizontal-product-img">
                                        <img class="img-fluid img" src="{{$other->logo}}" alt="" />
                                    </a>
                                    <div class="horizontal-product-details">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h4>{{$other->name}}</h4>
                                        </div>
                                        <h5>{{$other->description}}</h5>
                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="fw-semibold">
                                                   {{$other->city}}, {{getStateFromIso2($other->state,$other->country)->name}}
                                                </h3>
                                            </div>
                                            <a href="{{route('mobile.marketplace.store.detail',['id'=>$other->reference])}}" class="cart-bag">
                                                <i class="iconsax bag" data-icon="basket-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

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
