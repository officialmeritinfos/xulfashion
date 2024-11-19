<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Ticket</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 20px;">
        <h1 style="color: #333333;">🎉 Welcome to {{ $guest->events->title }} 🎉</h1>
    </div>

    <!-- Personalized Message -->
    <p style="font-size: 16px; line-height: 1.5; color: #333333;">
        Dear <strong>{{ $guest->name }}</strong>,
    </p>
    <p style="font-size: 16px; line-height: 1.5; color: #333333;">
        You have been successfully registered for the event <strong>{{ $guest->events->title }}</strong>. Below are the details of the event and your ticket information:
    </p>

    <!-- Ticket Information -->
    <h3 style="color: #007bff;">🎟️ Your Ticket Details</h3>
    <ul style="font-size: 16px; line-height: 1.5; color: #333333; padding-left: 20px;">
        <li><strong>Ticket Code:</strong> {{ $guest->ticketCode }}</li>
        <li><strong>Ticket Name:</strong> {{ $guest->ticket->ticket->name }}</li>
        <li><strong>Price:</strong> {{ currencySign($guest->ticket->currency) . ' ' . number_format($guest->ticket->price ,2 ) }}</li>
    </ul>

    <!-- Event Information -->
    <h3 style="color: #007bff;">📅 Event Details</h3>
    <ul style="font-size: 16px; line-height: 1.5; color: #333333; padding-left: 20px;">
        <li><strong>Event Title:</strong> {{ $guest->events->title }}</li>
        <li><strong>Description:</strong> {!! $guest->events->description !!}</li>
        <li><strong>Start Date:</strong> {{ displayEventStartDate($guest->events) }}</li>
        <li><strong>Start Time:</strong> {{ displayEventStartTime($guest->events) }}</li>
        @if($guest->events->eventScheduleType==1)
            <li><strong>End Date:</strong> {{ formatOnlyDateToReadableDate($guest->events->endDate, $guest->events->eventTimeZone) }}</li>
            <li><strong>End Time:</strong> {{ displayEventEndTime($guest->events) }}</li>
        @elseif($guest->events->eventScheduleType!=1 && $guest->events->recurrenceEndType==1)
            <li><strong>End Date:</strong> {{ formatOnlyDateToReadableDate($guest->events->endDate, $guest->events->eventTimeZone) }}</li>
            <li><strong>End Time:</strong> {{ displayEventEndTime($guest->events) }}</li>
        @else
            <li><strong>Recurs:</strong>  Every {{ $guest->events->recurrenceInterval }} for {{$guest->events->recurrenceEndCount}} times</li>
            <li><strong>End Time:</strong>  {{ displayEventEndPeriod($guest->events) }}</li>
        @endif
        @if($guest->events->eventType!=1)
            <li><strong>Platform:</strong> {{$guest->events->platform}}</li>
            <li><strong>Link:</strong>
                <a href="{{$guest->events->link}}" class="btn btn-primary">
                    {{$guest->events->link}}
                </a>
            </li>
        @else
            <li><strong>Venue:</strong> {{$guest->events->location}}</li>
            <li><strong>Location:</strong> {{getStateFromIso2($guest->events->state,$guest->events->country)->name??'N/A'}} {{ getCountryFromIso2($guest->events->country)->name }}</li>
        @endif
    </ul>

    <p style="font-size: 16px; line-height: 1.5; color: #333333;">
        Please keep this email safe as it contains your unique ticket code and event details. You’ll need your ticket to check into the event.
    </p>

    <!-- Action Button -->
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $downloadUrl }}" style="display: inline-block; background-color: #28a745; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-size: 16px;">🎟️ Download Your Ticket</a>
    </div>

    <!-- Organizer Contact -->
    <p style="font-size: 16px; line-height: 1.5; color: #333333;">
        If you have any questions or concerns, feel free to reach out to the event organizer:
    </p>
    <ul style="font-size: 16px; line-height: 1.5; color: #333333; padding-left: 20px;">
        @if($guest->events->supportEmail)
            <li><strong>Email:</strong> <a href="mailto:{{ $guest->events->supportEmail }}">{{ $guest->events->supportEmail }}</a></li>
        @endif
        @if($guest->events->facebook)
            <li><strong>Facebook:</strong> <a href="{{ $guest->events->facebook }}" target="_blank">{{ $guest->events->facebook }}</a></li>
        @endif
        @if($guest->events->instagram)
            <li><strong>Instagram:</strong> <a href="{{ $guest->events->instagram }}" target="_blank">{{ $guest->events->instagram }}</a></li>
        @endif
        @if($guest->events->twitter)
            <li><strong>Twitter:</strong> <a href="{{ $guest->events->twitter }}" target="_blank">{{ $guest->events->twitter }}</a></li>
        @endif
    </ul>

    <!-- Closing Note -->
    <p style="font-size: 16px; line-height: 1.5; color: #333333;">
        We look forward to seeing you at <strong>{{ $guest->events->title }}</strong>! Thank you for being a part of this event.
    </p>

    <p style="font-size: 16px; line-height: 1.5; color: #333333;">
        Best regards,<br>
        <strong>{{ $guest->events->organizer }}</strong><br>
        Event Organizer
    </p>

    <hr style="border: none; border-top: 1px solid #dddddd; margin: 20px 0;">
    <p style="font-size: 12px; line-height: 1.5; color: #999999; text-align: center;">
        This email was sent to {{ $guest->email }} because you were added as a guest for {{ $guest->events->title }}. If you believe this email was sent to you by mistake, please contact the event organizer at <a href="mailto:{{ $guest->events->supportEmail }}">{{ $guest->events->supportEmail }}</a>.
    </p>
</div>
</body>
</html>
