@extends('mobile.users.layout.mainDetailBase')
@section('content')
    <div class="container-fluid mt-4">
        <!-- product-image section start -->
        <section class="product2-image-section">
            <div class="custom-container">
                <div class="product2-img-slider">
                    <img class="img-fluid product2-bg" src="{{asset('mobile/images/background/product-img-bg.png')}}" alt="product-bg" />
                    <div class="swiper product-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="img-fluid product-img active" src="{{$event->featuredImage}}" alt="event image" />
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid product-img active" src="{{$event->featuredImage}}" alt="event image" />
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
                            <sup>
                                <a href="{{route('mobile.user.events.edit',['event'=>$event->reference])}}"><i class="fa fa-edit"></i></a>
                            </sup>
                        </h2>
                        <h6>{{eventCategoryById($event->category)->name}}</h6>
                    </div>
                    <p class="theme-color fw-normal mt-1">
                        {!! $event->description !!}
                    </p>

                    <div class="d-flex justify-content-between gap-3">
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 class="text-primary">Type:</h6>
                                <h6>
                                    {{eventType($event->eventType)}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 class="text-primary">Start Time:</h6>
                                <h6>
                                    {{$event->startDate}} {{$event->startTime}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 class="text-primary">End Time:</h6>
                                <h6>
                                   <span style="word-break: break-word;">
                                       {{eventEndTime($event)}}
                                   </span>
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 class="text-primary">Schedule Type</h6>
                                <h6 style="word-break: break-word;">
                                    @if($event->eventScheduleType==1)
                                        One-time Event
                                    @else
                                        Recurring Event
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="delivery-sec">
                <h4 class="fw-semibold theme-color">Check Delivery</h4>
                <h4 class="fw-normal light-text mt-1">Enter pincode to check delivery date / pickup</h4>

                <div class="d-flex justify-content-between gap-3">
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>Timezone</h6>
                            <h6>
                                {{$event->eventTimeZone}}
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <p>Platform/Venue</p>
                            <h6>
                                {{($event->eventType==1)?$event->location:$event->platform}}
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block">
                            <h6>State/Link</h6>
                            <h6>
                                @if($event->eventType==1)
                                    {{getStateFromIso2($event->state,$user->countryCode)->name}}
                                @else
                                    <span id="clickToRevealText">
                                        Click to reveal
                                    </span>
                                    <span style="word-break: break-word;display: none;cursor: pointer;" class="cpy-link"
                                          data-clipboard-text="{{$event->link}}" id="eventLink">
                                        {{$event->link}}
                                    </span>
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('js')
        <script>
            $(document).ready(function(){
                $('#clickToRevealText').on('click', function(){
                    $('#clickToRevealText').hide();
                    $('#eventLink').show();
                });
            });
        </script>
    @endpush
@endsection
