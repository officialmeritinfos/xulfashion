@extends('tickets.header')
@section('content')
@push('css')
    @includeIf('tickets.templates.' . ($template ?? 'default'))
    <style>
        .ticket-header{
            font-size: 20px;
        }
    </style>
@endpush
    <div class="ticket-card" id="ticketCard">
        <div class="ticket-header">Event Ticket - {{$event->reference}}</div>
        <div class="ticket-body">
            <div class="ticket-info">
                <div>
                    <span>Event:</span> <br> {{$event->title}}
                </div>
                <div>
                    <span>Date:</span> <br>
                    <small>
                        {{$event->startDate}} - {{handleTicketEndTime($event)}}
                    </small>
                </div>
                <div>
                    <span>Time:</span> <br>
                    <small>
                        {{$event->startTime}} - {{handleTicketEndTime($event)}}
                    </small>
                </div>
                @if($event->eventScheduleType!=1)
                    <div>
                        <span>Repeats:</span> <br> <small>Every {{$event->recurrenceInterval}}</small>
                    </div>
                @endif
                <div>
                    <span>Venue:</span> <br>
                    {{($event->eventType==1)?$event->location:$event->link}}
                </div>
                <div>
                    <span>Location:</span> <br>
                    @if($event->eventType==1)
                        {{getStateFromIso2($event->state,$country->iso2)->name}}
                    @else
                        {{$event->platform}}
                    @endif
                </div>
            </div>
        </div>
        <div class="ticket-footer">
            <p>Present this ticket at the entrance. For inquiries, contact {{$event->supportEmail??$web->supportEmail}}</p>
        </div>
        <div class="action-buttons">
            <button onclick="window.print()">Print</button>
            <button id="downloadBtn">Download</button>
        </div>
    </div>


@endsection
