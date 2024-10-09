@extends('mobile.users.layout.detailsBase')
@section('content')
    @inject('injected','App\Custom\Regular')

    <!-- product-image section start -->
    <section>
        <div class="product-image-slider">
            <div class="swiper product-1 ms-4">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img class="img-fluid product-img" src="{{$ad->featuredImage}}" alt="p26" />
                    </div>
                    @if($photos->count()>0)
                        @foreach($photos as $photo)
                            <div class="swiper-slide">
                                <img class="img-fluid product-img" src="{{$photo->photo}}" alt="p27" />
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="product-info d-flex justify-content-between">
                    <div class="swiper-pagination"></div>
                    <ul class="color-variation">
                        <li class="product-color color1"></li>
                        <li class="product-color color2"></li>
                        <li class="product-color color3"></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- product-image section end -->

    <!-- product-details section start -->
    <section class="pt-0">
        <div class="custom-container">
            <div class="product-details">
                <div class="product-name">
                    <h2 class="theme-color">
                        {{$ad->title}}
                    </h2>
                    <h6>
                        {{serviceTypeById($ad->serviceType)->name}}
                    </h6>
                </div>
                <p class="mt-2 mb-2">
                    @php
                        $cates = explode(',',$ad->tags)
                    @endphp
                    @foreach($cates as $cate)
                        <span class="badge bg-primary text-white">
                            {{$cate}}
                        </span>
                    @endforeach
                </p>

                <div class="ratings mt-1">
                    <div class="d-flex align-items-center gap-1">
                        <h4 class="theme-color fw-normal">{{number_format($averageRating,1)}}</h4>

                        <ul class="rating-stars">
                            @php
                                $fullStars = floor($averageRating);
                                $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                $emptyStars = 5 - ($fullStars + $halfStar);
                            @endphp

                            {{-- Display full stars --}}
                            @for ($i = 0; $i < $fullStars; $i++)
                                <li><img class="img-fluid stars" src="{{asset('mobile/images/svg/Star.svg')}}" alt="star" /></li>
                            @endfor

                            {{-- Display half star if applicable --}}
                            @if ($halfStar)
                                <li><img class="img-fluid stars" src="{{ asset('mobile/images/svg/HalfStar.svg') }}" alt="half-star" /></li>
                            @endif
                            {{-- Display empty stars --}}
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <li><img class="img-fluid stars" src="{{asset('mobile/images/svg/star1.svg')}}" alt="empty star" /></li>
                            @endfor
                        </ul>
                        <h4 class="reviews">{{$totalRatings}} Review(s)</h4>
                    </div>
                </div>
                <div class="product-price">
                    <h3>
                        @empty($ad->amount)
                            Contact for Price
                        @else
                            {{currencySign($ad->currency)}} {{number_format($ad->amount,2)}}
                        @endempty
                    </h3>
                </div>
                <p>
                    {{$ad->description}}
                </p>

                <div class="accordion details-accordion" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingOne">
                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-p1">Ad Meta</div>
                        </div>

                        <div id="panelsStayOpen-p1" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table table-bordered text-center m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">Company</th>
                                        <th scope="col">Number of Views</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$ad->companyName??'N/A'}}</td>
                                        <td>{{$ad->numberOfViews}}</td>
                                        <td>{{$injected->fetchState($ad->country,$ad->state)->name}}</td>
                                        <td>
                                            @switch($ad->status)
                                                @case(1)
                                                    <i class="fa fa-check-circle text-success" style="font-size: 14px;"
                                                       data-bs-toggle="tooltip" title="Active"></i>
                                                    @break
                                                @case(2)
                                                    <i class="fa fa-rotate-270 fa-rotate text-primary" style="font-size: 14px;"
                                                       data-bs-toggle="tooltip" title="Review"></i>
                                                    @break
                                                @case(3)
                                                    <i class="fa fa-ban text-danger" style="font-size: 14px;"
                                                       data-bs-toggle="tooltip" title="Cancelled"></i>
                                                    @break
                                                @default
                                                    <i class="fa fa-warning text-danger" style="font-size: 14px;"
                                                       data-bs-toggle="tooltip" title="Rejected"></i>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <div class="accordion-header" id="headingThree">
                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-p3">Details</div>
                        </div>
                        <div id="panelsStayOpen-p3" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="product-description">
                                    <p>
                                        {{$ad->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingFour">
                            <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-p4">Reviews</div>
                        </div>
                        <div id="panelsStayOpen-p4" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                            <div class="accordion-body pb-0">
                                <div class="reviews-display">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="theme-color">{{$totalRatings}} Review(s)</h4>
                                    </div>
                                    @if($reviews->count()>0)
                                        <div id="product-list">
                                            @include('mobile.ads.components.review_lists')
                                        </div>
                                        @if($reviews->hasMorePages())
                                            <div class="row g-3">
                                                <div class="text-center mt-4">
                                                    <button id="load-more" class="btn btn-light" data-url="{{ url()->full() }}">Load More</button>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
