@extends('mobile.users.layout.mainDetailBase')
@section('content')
    <div class="container-fluid mt-4">
        <!-- product-image section start -->
        <section class="product2-image-section mb-3">
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
                    <div class="accordion details-accordion" id="accordionPanelsStayOpenExample">

                        <div class="accordion-item">
                            <div class="accordion-header" id="headingFour">
                                <div class="accordion-button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-p4">
                                    Description
                                </div>
                            </div>
                            <div id="panelsStayOpen-p4" class="accordion-collapse collapse show" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body pb-0">
                                    <div class="reviews-display">
                                        <div class="fw-normal mt-1 card">
                                           <div class="card-body">
                                            <p class="normal-text theme-color"> {!! $event->description !!}</p>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between gap-3">
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 >Type:</h6>
                                <h6>
                                    {{eventType($event->eventType)}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 >Start Time:</h6>
                                <h6>
                                    {{$event->startDate}} {{$event->startTime}}
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6 >End Time:</h6>
                                <h6>
                                   <span style="word-break: break-word;">
                                       {{eventEndTime($event)}}
                                   </span>
                                </h6>
                            </div>
                        </div>
                        <div class="dimensions-box">
                            <div class="d-block">
                                <h6>Schedule Type</h6>
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
                <h4 class="fw-semibold theme-color">Event Schedule</h4>
                <h4 class="fw-normal light-text mt-1"></h4>

                <div class="d-flex justify-content-between gap-3">
                    <div class="dimensions-box delivery-box">
                        <div class="d-block scrollable-box">
                            <h6>Timezone</h6>
                            <h6>
                                {{$event->eventTimeZone}}
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block scrollable-box">
                            <h6>Platform/Venue</h6>
                            <h6>
                                {{($event->eventType==1)?$event->location:$event->platform}}
                            </h6>
                        </div>
                    </div>
                    <div class="dimensions-box delivery-box">
                        <div class="d-block scrollable-box">
                            <h6>State/Link</h6>
                            <h6>
                                @if($event->eventType==1)
                                    {{getStateFromIso2($event->state,$country->iso2)->name}}
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

        <div class="container mt-4">
            <!-- Nav Tabs with equal spacing -->
            <ul class="nav nav-tabs justify-content-around" id="myTab" role="tablist">
                <!-- Dropdown for Tickets -->
                <li class="nav-item dropdown" role="presentation">
                    <span class="nav-link dropdown-toggle active" id="ticketsDropdown" data-bs-toggle="dropdown" role="button" aria-expanded="false">Tickets</span>
                    <ul class="dropdown-menu" aria-labelledby="ticketsDropdown">
                        <li><a class="dropdown-item" href="{{route('mobile.user.events.tickets.index',['event'=>$event->reference])}}"
                               role="tab" aria-controls="tickets">Tickets</a></li>
                        <li><a class="dropdown-item" href="{{route('mobile.user.events.tickets.email',['event'=>$event->reference])}}"
                               role="tab" aria-controls="ticketEmail">Ticket email</a></li>
                    </ul>
                </li>

                <!-- Single Tab for Manage Guestlist -->
                <li class="nav-item dropdown" role="presentation">
                    <span class="nav-link dropdown-toggle active" id="ticketsDropdown" data-bs-toggle="dropdown" role="button" aria-expanded="false">Attendees</span>
                    <ul class="dropdown-menu" aria-labelledby="ticketsDropdown">
                        <li><a class="dropdown-item" href="{{route('mobile.user.events.attendees',['event'=>$event->reference])}}" role="tab" aria-controls="tickets">Attendee List</a></li>
                        <li><a class="dropdown-item" href="{{route('mobile.user.events.attendees.notify',['event'=>$event->reference])}}" role="tab" aria-controls="discounts">Notify Guests</a></li>
                        <li><a class="dropdown-item" href="{{route('mobile.user.events.attendees.check-in-list',['event'=>$event->reference])}}"
                               role="tab" aria-controls="discounts">Check-in Lists</a></li>
                    </ul>
                </li>

                <!-- Single Tab for Sales -->
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" href="{{route('mobile.user.events.sales',['event'=>$event->reference])}}"
                       role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                </li>
            </ul>
        </div>


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
