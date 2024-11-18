@extends('mobile.users.layout.base')
@section('content')
    <section class="section-b-space">
        <div class="custom-container">

        </div>
    </section>
    <div class="custom-container">
        <!-- Event Details Section -->
        <div class="card shadow-sm p-4 mb-4">
            <div class="row">
                <div class="col-12">
                    <h2 class="fw-bold text-center theme-color">{{ $purchase->events->title }}</h2>
                </div>
            </div>
            <hr class="mb-4">

            <!-- Event Details -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <p><strong>Description:</strong></p>
                    <p class="text-muted">{{ strip_tags($purchase->events->description) }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mt-2">
                    <p><strong>Start Date:</strong> <span class="text-info">{{ displayEventStartDate($purchase->events) }}</span></p>
                </div>
                <div class="col-md-6 mt-2">
                    <p><strong>Start Time:</strong> <span class="text-info">{{ displayEventStartTime($purchase->events) }}</span></p>
                </div>
                <div class="col-md-12 row mt-2">
                    @if($purchase->events->eventScheduleType==1)
                        <div class="col-md-6 mt-2">
                            <p><strong>End Date:</strong> <span class="text-primary">{{ formatOnlyDateToReadableDate($purchase->events->endDate, $purchase->events->eventTimeZone) }}</span></p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <p><strong>End Time:</strong> <span class="text-primary">{{ date('h:i A', strtotime($purchase->events->endTime)) }}</span></p>
                        </div>
                    @elseif($purchase->events->eventScheduleType!=1 && $purchase->events->recurrenceEndType==1)
                        <div class="col-md-6 mt-2">
                            <p><strong>End Date:</strong> <span class="text-primary">{{ formatOnlyDateToReadableDate($purchase->events->endDate, $purchase->events->eventTimeZone) }}</span></p>
                        </div>
                        <div class="col-md-6 mt-2">
                            <p><strong>End Time:</strong> <span class="text-primary">{{ date('h:i A', strtotime($purchase->events->endTime)) }}</span></p>
                        </div>
                    @else
                        <div class="col-md-4 mt-2">
                            <p><strong>Recurs:</strong>
                                <span class="text-info">
                                Every {{ $purchase->events->recurrenceInterval }} for {{$purchase->events->recurrenceEndCount}} times
                            </span>
                            </p>
                        </div>
                        <div class="col-md-4 mt-2">
                            <p><strong>Current:</strong>
                                <span class="text-info">
                                {{$purchase->events->currentRecurring}}
                            </span>
                            </p>
                        </div>
                        <div class="col-md-4 mt-2">
                            <p><strong>End Date:</strong>
                                <span class="text-info">
                                {{ displayEventEndPeriod($purchase->events) }}
                            </span>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Section -->
            <div class="row mb-4">
                <div class="col-md-6 mt-1">
                    <p><strong>Status:</strong>

                        @php
                            $currentDate = now()->setTimezone($purchase->events->eventTimeZone);
                            $isRecurring = $purchase->events->eventScheduleType !== 1;
                        @endphp

                        @if($isRecurring)
                            @if($purchase->events->recurrenceEndType == 1)
                                {{-- Recurring with a fixed end date --}}
                                @if($purchase->events->recurrenceEndDate < $currentDate->format('Y-m-d'))
                                    <span class="badge bg-danger text-white">Concluded</span>
                                @else
                                    <span class="badge bg-success text-white">Ongoing</span>
                                @endif
                            @else
                                {{-- Recurring with occurrences --}}
                                @if($purchase->events->currentRecurring >= $purchase->events->recurrenceEndCount)
                                    <span class="badge bg-danger text-white">Concluded</span>
                                @else
                                    <span class="badge bg-success text-white">Ongoing</span>
                                @endif
                            @endif
                        @else
                            {{-- Non-recurring event --}}
                            @if($purchase->events->endDate < $currentDate->format('Y-m-d'))
                                <span class="badge bg-danger text-white">Concluded</span>
                            @else
                                <span class="badge bg-success text-white">Ongoing</span>
                            @endif
                        @endif

                    </p>
                </div>
                <div class="col-md-6 mt-1">
                    <p><strong>Purchase Status:</strong>
                        @if($purchase->isPaid())
                            <span class="badge bg-success text-white">Paid</span>
                        @else
                            <span class="badge bg-warning text-white">Pending</span>
                        @endif
                    </p>
                </div>
            </div>
            @if($purchase->isPaid() && $purchase->events->hideVenue())
                <!-- Venue Section -->
                <div class="row mb-4">
                    @if($purchase->events->eventType!=1)
                        <div class="col-md-6 mt-1">
                            <p><strong>Platform:</strong>
                                <span class="badge bg-success text-white">
                                    {{$purchase->events->platform}}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mt-1">
                            <p><strong>Link:</strong>
                                <a href="{{$purchase->events->link}}" class="btn btn-primary">
                                    {{$purchase->events->link}}
                                </a>
                            </p>
                        </div>
                    @else
                        <div class="col-md-6 mt-1">
                            <p><strong>Venue:</strong>
                                <span class="">
                                    {{$purchase->events->location}}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mt-1">
                            <p><strong>Location:</strong>
                                <span>
                                    {{getStateFromIso2($purchase->events->state,$purchase->events->country)->name??'N/A'}}
                                </span>
                            </p>
                        </div>
                    @endif
                </div>
            @elseif(!$purchase->events->hideVenue())
                <!-- Venue Section -->
                <div class="row mb-4">
                    @if($purchase->events->eventType!=1)
                        <div class="col-md-6 mt-1">
                            <p><strong>Platform:</strong>
                                <span class="badge bg-success text-white">
                                    {{$purchase->events->platform}}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mt-1">
                            <p><strong>Link:</strong>
                                <a href="{{$purchase->events->link}}" class="btn btn-primary">
                                    {{$purchase->events->link}}
                                </a>
                            </p>
                        </div>
                    @else
                        <div class="col-md-6 mt-1">
                            <p><strong>Venue:</strong>
                                <span class="">
                                    {{$purchase->events->location}}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mt-1">
                            <p><strong>Location:</strong>
                                <span>
                                    {{getStateFromIso2($purchase->events->state,$purchase->events->country)->name??'N/A'}}
                                </span>
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <hr class="mb-4">

            <!-- Purchase Details -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="fw-bold">Purchase Details</h4>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Total Amount :</strong> <span class="text-info">{{ currencySign($purchase->purchaseCurrency) . number_format($purchase->price, 2) }}</span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Method:</strong> <span class="text-info">{{ ucfirst($purchase->paymentMethod) ?? 'Not Selected' }}</span></p>
                </div>
            </div>
        </div>


        <!-- Tickets Section -->
        <div class="card shadow-sm p-4 mb-4">
            <h3 class="fw-medium theme-color mb-4">Tickets</h3>
            @foreach($purchase->tickets as $ticket)
                <div class="ticket-box border rounded p-4 mb-4">
                    <!-- Ticket Name -->
                    <div class="row align-items-center mb-2">
                        <div class="col-md-9">
                            <h5 class="fw-semibold theme-color mb-1">{{ $ticket->ticket->name }}</h5>
                        </div>
                    </div>

                    <!-- Ticket Details -->
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <p><strong>Price:</strong> <span class="text-primary">{{ currencySign($ticket->currency) . number_format($ticket->price, 2) }}</span></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Quantity:</strong> <span class="text-primary">{{ $ticket->quantity }}</span></p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Guests Admissible:</strong> <span class="text-primary">{{ $ticket->number_admits * $ticket->quantity }}</span></p>
                        </div>
                    </div>

                    <!-- Guests Section -->
                    <div class="guests-section mt-2">
                        <h6 class="fw-bold mb-3">Guests:</h6>
                        @if($ticket->guests->count() > 0)
                            <ul class="list-unstyled">
                                @foreach($ticket->guests as $guest)
                                    <li class="mb-2">
                                        <i class="iconsax" data-icon="user"></i>
                                        <span class="fw-medium">{{ $guest->name }}</span>
                                        <span class="text-muted">({{ $guest->email }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No guests added yet.</p>
                        @endif

                        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
                            <!-- Add Guests Button -->
                            @if($ticket->guests->count() < ($ticket->number_admits * $ticket->quantity))
                                <a href="{{ route('mobile.user.events.purchase.add-guests',['purchase'=>$purchase->reference]) }}" class="btn btn-primary btn-sm">
                                    Add Guests
                                </a>
                            @endif

                            <!-- View Ticket Button -->
                            <a href="{{ url('/') }}" class="btn btn-success btn-sm">
                                View Ticket
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>


@endsection
