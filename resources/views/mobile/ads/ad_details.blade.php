@extends('mobile.ads.layout.innerBaseProductDetail')
@section('content')
    @inject('injected','App\Custom\Regular')
    @push('css')
        <!-- Lightbox2 CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('mobile/css/vendors/swiper-bundle.min.css')}}" />
        <style>

            .rate {
                border-bottom-right-radius: 12px;
                border-bottom-left-radius: 12px
            }

            .rating {
                display: flex;
                flex-direction: row-reverse;
                justify-content: center
            }

            .rating>input {
                display: none
            }

            .rating>label {
                position: relative;
                width: 1em;
                font-size: 30px;
                font-weight: 300;
                color: #FFD600;
                cursor: pointer
            }

            .rating>label::before {
                content: "\2605";
                position: absolute;
                opacity: 0
            }

            .rating>label:hover:before,
            .rating>label:hover~label:before {
                opacity: 1 !important
            }

            .rating>input:checked~label:before {
                opacity: 1
            }

            .rating:hover>input:checked~label:before {
                opacity: 0.4
            }

            .buttons {
                top: 36px;
                position: relative
            }

            .rating-submit {
                border-radius: 8px;
                color: #fff;
                height: auto
            }

            .rating-submit:hover {
                color: #fff
            }
        </style>
        <style>
            /* Floating Share Button - Improved Rectangular Design */
            .floating-share-button {
                position: fixed;
                top: 50%; /* Lower Position - Middle of the Page */
                left: 20px; /* Positioned to the Left */
                z-index: 999;
                display: flex;
                flex-direction: column;
                align-items: center;
                transform: translateY(-50%);
            }

            /* Main Share Button - Rectangular with New Color */
            .share-main-btn {
                background: #ff6600; /* Changed to Orange */
                color: white;
                border: none;
                padding: 12px 20px;
                font-size: 16px;
                cursor: pointer;
                border-radius: 5px; /* Rectangular Shape */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                transition: background 0.3s, transform 0.2s;
            }

            .share-main-btn:hover {
                background: #cc5200; /* Darker Orange on Hover */
                transform: scale(1.05);
            }

            /* Share Options - Hidden Initially */
            .share-options {
                display: none;
                position: absolute;
                top: 50px;
                left: 0;
                flex-direction: column;
                gap: 10px;
                background: white;
                border-radius: 10px;
                padding: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                transition: all 0.3s ease;
            }

            .share-options.active {
                display: flex;
            }

            /* Individual Social Share Buttons */
            .share-options a {
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                color: white;
                border-radius: 50%;
                text-decoration: none;
                transition: transform 0.2s;
            }

            /* Facebook */
            .fb { background: #1877f2; }
            .fb:hover { background: #0d5bbf; }

            /* Twitter */
            .tw { background: #1da1f2; }
            .tw:hover { background: #0c85d0; }

            /* WhatsApp */
            .wa { background: #25d366; }
            .wa:hover { background: #1ebc57; }

            /* Instagram */
            .ig { background: #e4405f; }
            .ig:hover { background: #cc3751; }

            .share-options a:hover {
                transform: scale(1.1);
            }

        </style>
    @endpush

    <!-- product-image section start -->
    <section class="product2-image-section">
        <div class="custom-container">
            <div class="product2-img-slider">
                <a href="{{ asset('mobile/images/background/product-img-bg.png') }}" data-lightbox="image-1" class="back">
                    <img class="img-fluid product2-bg" src="{{ asset('mobile/images/background/product-img-bg.png') }}" alt="product-bg" />
                </a>
                <div class="swiper product-2">
                    <div class="swiper-wrapper">
                        @foreach($photos as $photo)
                        <div class="swiper-slide">
                            <a href="{{ $photo->photo }}" data-lightbox="image-1" class="back">
                                <img class="img-fluid product-img" src="{{ $photo->photo }}" alt="p26" />
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next">
                        <i class="iconsax arrow" data-icon="arrow-right"></i>
                    </div>
                    <div class="swiper-button-prev">
                        <i class="iconsax arrow" data-icon="arrow-left"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- product-details section start -->
    <section class="position-relative">
        <img src="{{asset('mobile/images/effect.png')}}" class="img-fluid product-details-effect" alt="effect" />
        <img class="img-fluid product-details-effect-dark" src="{{asset('mobile/images/effect-dark.png')}}" alt="effect-dark" />
        <ul class="color-option">
            <li class="product-color color1"></li>
            <li class="product-color color2"></li>
            <li class="product-color color3"></li>
            <li class="product-color color4"></li>
        </ul>
        <div class="custom-container">
            <div class="product-details">
                <div class="product-name">
                    <h2 class="theme-color">
                        {{$ad->title}}
                    </h2>
                    <h6>
                        {{$ad->service->name}}
                    </h6>
                </div>
                <p class="mt-1">
                    @php
                        $cates = explode(',',$ad->tags)
                    @endphp
                    @foreach($cates as $cate)
                        <span class="badge bg-primary text-white">
                            {{$cate}}
                        </span>
                    @endforeach
                </p>

                <div class="product-price">
                    <h3>
                        @empty($ad->amount)
                            Contact for Price
                        @else
                            {{currencySign($ad->currency)}} {{number_format($ad->amount,2)}}
                        @endempty
                    </h3>

                </div>
                <div class="d-flex justify-content-between gap-3">
                    <div class="dimensions-box">
                        <div class="d-block">
                            <h6>{{$ad->companyName}}</h6>
                        </div>
                    </div>
                    <div class="dimensions-box">
                        <div class="d-block">
                            <h6>Number of Views</h6>
                            <h6>
                                {{$ad->numberOfViews}}
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box">
                        <div class="d-block">
                            <h6>
                                {{$injected->fetchState($ad->country,$ad->state)->name}}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Floating Share Button -->
        <div class="floating-share-button">
            <button onclick="toggleShareOptions()" class="share-main-btn">
                <i class="fas fa-share-alt"></i> Share
            </button>

            <div class="share-options" id="shareOptions">
                @if(!empty($shareLinks['facebook']))
                    <a href="{{ $shareLinks['facebook'] }}" target="_blank" class="back fb"><i class="fab fa-facebook-f"></i></a>
                @endif
                @if(!empty($shareLinks['twitter']))
                    <a href="{{ $shareLinks['twitter'] }}" target="_blank" class="back tw"><i class="fab fa-twitter"></i></a>
                @endif
                @if(!empty($shareLinks['whatsapp']))
                    <a href="{{ $shareLinks['whatsapp'] }}" target="_blank" class="back wa"><i class="fab fa-whatsapp"></i></a>
                @endif
            </div>
        </div>
    </section>
    <!-- delivery section start -->

    <!-- details section starts -->
    <section class="mb-4">
        <div class="custom-container">
            <h4 class="theme-color fw-semibold">Description :</h4>
            <p class="theme-color fw-normal mt-1">
                {{ str_replace('<p> </p>', '',$ad->description) }}
            </p>
        </div>
    </section>
    <!-- details section end -->

    <!-- review section starts -->
    <section>
        <div class="custom-container">
            <div class="rating-sec">
                <div class="total-rating text-center">
                    <!-- Average Rating Display -->
                    <h2 class="theme-color">{{ number_format($averageRating, 1) }}</h2>
                    <ul class="rating-stars mt-1">
                        @php
                            $fullStars = floor($averageRating);
                            $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - ($fullStars + $halfStar);
                        @endphp

                        {{-- Full Stars --}}
                        @for ($i = 0; $i < $fullStars; $i++)
                            <li><img class="img-fluid stars" src="{{ asset('mobile/images/svg/Star.svg') }}" alt="star" /></li>
                        @endfor

                        {{-- Half Star --}}
                        @if ($halfStar)
                            <li><img class="img-fluid stars" src="{{ asset('mobile/images/svg/HalfStar.svg') }}" alt="half-star" /></li>
                        @endif

                        {{-- Empty Stars --}}
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <li><img class="img-fluid stars" src="{{ asset('mobile/images/svg/star1.svg') }}" alt="empty-star" /></li>
                        @endfor
                    </ul>
                    <h6 class="light-text text-center lh-base fw-normal mt-2">
                        {{ $totalRatings }} Ratings \ <span class="theme-color fw-normal">{{ $totalReviews }} Reviews</span>
                    </h6>
                </div>

                <!-- Star Rating Breakdown -->
                <ul class="progress-main">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        @php
                            $percentage = ($totalRatings > 0) ? ($ratingsCount[$star] / $totalRatings) * 100 : 0;
                        @endphp
                        <li class="d-flex align-items-center">
                            <span>{{ $star }}</span>
                            <img class="img-fluid stars" src="{{ asset('mobile/images/svg/Star.svg') }}" alt="star" />
                            <div class="progress flex-grow-1 mx-2" role="progressbar" aria-label="{{ $star }} Star" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: {{ $percentage }}%;"></div>
                            </div>
                            <h4>{{ number_format($percentage, 0) }}%</h4>
                        </li>
                    @endforeach
                </ul>
            </div>
            @auth()
                @if(auth()->user()->id!=$ad->user)
                    <!-- Write a Review Button -->
                    <a href="#my-review" class="my-review back" data-bs-toggle="offcanvas" role="button">+ Write Your Review</a>
                @endif
            @endauth

            <div class="accordion details-accordion" id="accordionPanelsStayOpenExample">

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
                                                <button id="load-more" class="btn btn-light btn-auto btn-sm" data-url="{{ url()->full() }}">Load More</button>
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
    </section>
    <!-- review section end -->


    <section>
        <div class="title" style="margin-left: 2rem;">
            <h2 class="">Merchant</h2>
        </div>
        <div class="delivery-sec">

            <div class="d-flex justify-content-between gap-3">
                <div class="dimensions-box delivery-box">
                    <div class="d-block">
                        <h6>Contact</h6>
                        <h6 id="contact-number" style="cursor: pointer;">
                            <a href="https://api.whatsapp.com/send?phone={{formatContactToWhatsapp($merchant->phone,$merchant->countryCode)}}&text=Hi,%20I%20came%20from%20Xulfashion"
                            target="_blank" class="back">
                                <i class="fa fa-whatsapp" style="font-size: 50px;"></i>
                            </a>
                        </h6>
                    </div>
                </div>
                <div class="dimensions-box delivery-box">
                    <div class="d-block">
                        <h6>Display Name</h6>
                        <h6><a href="{{route('mobile.marketplace.merchant',['id'=>$merchant->reference])}}">
                            {{ucfirst($merchant->displayName??$merchant->username)}}
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- delivery section end -->

    @if(!empty($store))
        <section class="mb-4">
            <div class="title" style="margin-left: 2rem;">
                <h2>Store</h2>
            </div>
            <div class="delivery-sec">

                <div class="d-flex justify-content-between gap-3">
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Logo</h6>
                            <h6>
                                <img  src="{{ empty($store->logo)?$merchant->photo:$store->logo }}" style="width: 70px;" alt="Image">
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Address</h6>
                            <h6>{{$store->address}}</h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Visit Store</h6>
                            <h6>

                                <a href="{{route('mobile.marketplace.store.detail',['id'=>$store->reference])}}">
                                    <img src="https://glenthemes.github.io/iconsax/icons/external-square.svg" style="font-size: 12px;"/>
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($ads->count()>0)
        <!-- similar product section starts -->
        <section class="similer-product">
            <div class="custom-container">
                <div class="title">
                    <h2>Similar Ads</h2>
                </div>

                <div class="swiper similer-product">
                    <div class="swiper-wrapper">
                        @foreach($ads as $similarAd)
                            <div class="swiper-slide">
                                <div class="product-box">
                                    <div class="product-box-img">
                                        <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($similarAd->title),'id'=>$similarAd->reference])}}">
                                            <img class="img" src="{{$similarAd->featuredImage}}" alt="p1" /></a>

                                        <div class="cart-box">
                                            <a href="{{route('mobile.marketplace.detail',['slug'=>textToSlug($similarAd->title),'id'=>$similarAd->reference])}}" class="cart-bag">
                                                <i class="iconsax bag" data-icon="basket-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-box-detail">
                                        <h4>{{$similarAd->title}}</h4>
                                        <h5>{{$similarAd->service->name}}</h5>
                                        <div class="d-flex justify-content-between gap-3">
                                            <h5>By: {{$similarAd->companyName}}</h5>
                                            <h3 class="text-end">
                                                {{getStateFromIso2($similarAd->state,$country->iso2)->name}}
                                            </h3>
                                        </div>
                                        <div class="bottom-panel">
                                            <div class="price">
                                                <h4>
                                                    @empty($similarAd->amount)
                                                        Contact for Price
                                                    @else
                                                        {{currencySign($similarAd->currency)}} {{number_format($similarAd->amount,2)}}
                                                    @endempty
                                                </h4>
                                            </div>
                                            <div class="rating">
                                                <img src="{{asset('mobile/images/svg/Star.svg')}}" alt="star" />
                                                <h6>{{number_format(averageMerchantRatings($ad->user),1)}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </section>
        <!-- similar product section end -->
    @endif


    <!-- my-review offcanvas start -->
    <div class="offcanvas offcanvas-bottom my-review-offcanvas" tabindex="-1" id="my-review">
        <div class="offcanvas-header review-head">
            <h4 class="offcanvas-title" id="offcanvasBottomLabel">Add Review</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body review-body">
            <form class="theme-form" id="basicSettings" action="{{route('mobile.user.reviews.new.process')}}" method="post">
                <div class="row">
                    <div class="col-md-12" style="display: none;">
                        <div class="form-group mt-3">
                            <label for="name" class="form-check-label">Ad</label>
                            <input type="text" class="form-control" id="name" name="ad" value="{{$ad->user}}" required="" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class=" d-flex justify-content-center mt-5">
                            <div class=" text-center mb-5">
                                <div class="rating">
                                    <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                                    <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                    <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                    <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                    <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="review" class="form-check-label">Review</label>
                            <textarea class="form-control" placeholder="Write Your Review Here" id="exampleFormControlTextarea1" name="review" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button class="btn theme-btn mt-3 btn-auto submit" type="submit">Submit Your Review</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- my-review offcanvas end -->

    @push('js')
        <!-- range-slider js -->
        <script src="{{asset('mobile/js/range-slider.js')}}"></script>

        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <script>
            $(document).ready(function() {
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true
                })
            });
        </script>
        <!-- JavaScript to Toggle Share Options -->
        <script>
            function toggleShareOptions() {
                document.getElementById("shareOptions").classList.toggle("active");
            }
        </script>

    @endpush
@endsection
