<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Attending {{ $event->title }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333;">
<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f4f4f4" style="margin: 0; padding: 20px 0;">
    <tr>
        <td align="center">
            <table cellpadding="0" cellspacing="0" border="0" width="600" bgcolor="#ffffff" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <!-- Header Section -->
                <tr>
                    <td align="center" bgcolor="#0047ba" style="padding: 20px; color: #ffffff;">
                        <h1 style="margin: 0; font-size: 24px; font-weight: bold;">Thank You for Joining Us!</h1>
                    </td>
                </tr>

                <!-- Event Details Section -->
                <tr>
                    <td align="left" style="padding: 20px;">
                        <p style="font-size: 18px; margin: 0 0 10px;"><strong>Dear {{ $guest->name }},</strong></p>
                        <p style="font-size: 16px; line-height: 1.6;">
                            On behalf of the entire {{ $event->organizer ?? $event->title }} team, we want to express our heartfelt gratitude for attending <strong>{{ $event->title }}</strong>. Your presence made the event even more memorable and impactful.
                        </p>
                        <p style="font-size: 16px; line-height: 1.6;">
                            We hope you found the event valuable, inspiring, and engaging. Our goal is always to deliver experiences that leave a lasting impression, and having you as part of our audience helped us achieve that.
                        </p>
                    </td>
                </tr>

                <!-- Highlights Section -->
                <tr>
                    <td align="left" style="padding: 20px; background-color: #f9f9f9; border-top: 1px solid #ddd;">
                        <h3 style="margin: 0 0 10px; font-size: 20px; color: #0047ba;">Event Highlights</h3>
                        <ul style="list-style-type: disc; margin: 0; padding-left: 20px; font-size: 16px; line-height: 1.6;">
                            <li><strong>Event Name:</strong> {{ $event->title }}</li>
                            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->startDate)->setTimezone($event->eventTimeZone)->format('l, F j, Y') }}</li>
                            <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->startTime)->setTimezone($event->eventTimeZone)->format('h:i A') }} ({{ $event->eventTimeZone }})</li>
                            <li><strong>End Date:</strong> {{ determineEventEndDate($event,true) }}</li>
                            @if($guest->events->eventType!=1)
                                <li><strong>Platform:</strong> {{$guest->events->platform}} </li>
                            @else
                                <li><strong>Venue:</strong> {{$guest->events->location}}</li>
                                <li><strong>Location:</strong> {{getStateFromIso2($guest->events->state,$guest->events->country)->name??'N/A'}} {{ getCountryFromIso2($guest->events->country)->name }}</li>
                            @endif
                        </ul>
                    </td>
                </tr>

                <!-- Thank You Note Section -->
                <tr>
                    <td align="left" style="padding: 20px;">
                        <p style="font-size: 16px; line-height: 1.6;">
                            We’d love to hear your feedback to make our future events even better! Please take a moment to share your thoughts by replying to this email or contacting us directly at
                            <a href="mailto:{{ $event->supportEmail }}" style="color: #0047ba; text-decoration: none;">{{ $event->supportEmail }}</a>.
                        </p>
                        <p style="font-size: 16px; line-height: 1.6;">
                            Stay connected with us for updates on upcoming events, news, and special offers. We look forward to welcoming you again in the near future!
                        </p>
                    </td>
                </tr>

                <!-- Call to Action Section -->
                <tr>
                    <td align="center" style="padding: 20px; background-color: #0047ba; color: #ffffff;">
                        <p style="font-size: 16px; margin: 0;">Want to stay informed?</p>
                        <a href="{{ $event->website ?? '#' }}" style="background-color: #ffffff; color: #0047ba; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Visit Our Website</a>
                    </td>
                </tr>

                <!-- Footer Section -->
                <tr>
                    <td align="center" style="padding: 20px; background-color: #f1f1f1; color: #555; font-size: 14px;">
                        <p style="margin: 0;">&copy; {{ now()->year }} {{  config('app.name') }}. All Rights Reserved.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
