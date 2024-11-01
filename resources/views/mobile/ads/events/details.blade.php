@extends('mobile.ads.layout.innerBaseProductDetail')
@section('content')
@push('css')
    <style>
        .scrollable-box {
            max-height: 100px; /* Adjust this value as needed */
            overflow-y: auto;  /* Enables vertical scrolling if content exceeds max height */
            padding-right: 10px; /* Optional padding to avoid scrollbar overlap */
        }
    </style>
@endpush
    <!-- product-image section start -->
    <section class="product2-image-section">
        <div class="custom-container">
            <div class="product2-img-slider">
                <img class="img-fluid product2-bg" src="{{asset('mobile/images/background/product-img-bg.png')}}" alt="product-bg" />
                <div class="swiper product-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img class="img-fluid product-img" src="{{$event->featuredImage}}" alt="p26" />
                        </div>
                        <div class="swiper-slide swiper-slide-active">
                            <img class="img-fluid product-img active" src="{{$event->featuredImage}}" alt="p27" />
                        </div>
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
    <!-- product-image section end -->

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
                        {{$event->title}}
                    </h2>
                    <h6>{{ eventType($event->eventType) }}</h6>
                </div>
                <div class="mt-4">
                    <div class="accordion details-accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <div class="accordion-header" id="headingThree">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-p3">About This Event</div>
                            </div>
                            <div id="panelsStayOpen-p3" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="product-description">
                                        {!! $event->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- delivery section start -->
<section>
    <div class="delivery-sec">
        <h4 class="fw-semibold theme-color">Event Schedule</h4>

        <div class="d-flex justify-content-between gap-3">
            <div class="dimensions-box delivery-box">
                <div class="d-block">
                    <i class="iconsax dimensions-icons" data-icon="calendar-1"></i>
                    <h6>
                        {{formatOnlyDateToReadableDate($event->startDate,$event->eventTimeZone)}}
                    </h6>
                </div>
            </div>
            <div class="dimensions-box delivery-box scrollable-box">
                <div class="d-block">
                    <i class="iconsax dimensions-icons" data-icon="clock"></i>
                    <h6>{{eventShowCaseTimeFormat($event)}}</h6>
                </div>
            </div>
            <div class="dimensions-box delivery-box scrollable-box">
                <div class="d-block">
                    <i class="iconsax dimensions-icons" data-icon="location"></i>
                    <h6>
                        @if($event->hideVenue==1)
                            Visible on ticket purchase
                        @else
                            {{$event->location??$event->platform.': link on ticket purchase'}}
                        @endif
                    </h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- similar product section starts -->
<section class="similer-product">
    <div class="custom-container">
        <div class="title">
            <h2>Similar Events</h2>
            <a href="{{route('mobile.marketplace.events')}}">View All Events</a>
        </div>

        <div class="swiper similer-product">
            <div class="swiper-wrapper">
                @foreach($others as $other)
                    <div class="swiper-slide">
                        <div class="product-box">
                            <div class="product-box-img">
                                <a href="{{route('mobile.marketplace.events.detail',['slug'=>textToSlug($other->title),'id'=>$other->reference])}}"> <img class="img" src="{{$other->featuredImage}}" alt="p1" /></a>

                                <div class="cart-box">
                                    <a href="{{route('mobile.marketplace.events.detail',['slug'=>textToSlug($other->title),'id'=>$other->reference])}}" class="cart-bag">
                                        <i class="fa fa-arrow-right" data-icon="basket-2"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-box-detail">
                                <h4>{{$other->title}}</h4>
                                <h5>{!! shortenText($other->description,5) !!}</h5>
                                <div class="bottom-panel d-flex justify-content-between gap-3">
                                    <div class="price">
                                        <h4>
                                            {{{getStateFromIso2($other->state,$other->country)->name}}}
                                        </h4>
                                    </div>
                                    <div class="rating">
                                        <span class="badge bg-primary">{{eventCategoryById($other->category)->name}}</span>
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

    @push('js')
        <!-- cart box starts -->
        <section class="fixed-cart-btn section-b-space ">
            <div class="custom-container text-center">
                <a href="{{route('mobile.marketplace.events.tickets',['id'=>$event->reference])}}" class="cart-box-sec text-center">
                    <div class="d-flex align-items-center text-center gap-2 ">
                        <i class="iconsax bag" data-icon="ticket-2"></i>
                        <h2>Get A Ticket</h2>
                    </div>
                </a>
            </div>
        </section>
    @endpush
@endsection
