<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Event Notification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
<table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
    <tr>
        <td style="background-color: #0047ba; padding: 20px; text-align: center; color: #fff;">
            <h1 style="margin: 0; font-size: 24px;">Upcoming Event Notification</h1>
            <p style="margin: 5px 0; font-size: 16px;">Stay prepared for the next occurrence of your event!</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px; background-color: #ffffff;">
            <h2 style="color: #0047ba; font-size: 20px; margin-top: 0;">Hello, {{ $guest->name }}</h2>
            <p style="font-size: 16px; line-height: 1.5;">
                We are excited to inform you about the next occurrence of the event:
            </p>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 16px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px;">
                <tr>
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Event Name:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $event->title }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Next Date:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $nextOccurrence }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Time:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $nextOccurrence }}</td>
                </tr>

                @if($guest->events->eventType!=1)
                    <tr>
                        <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Platform:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $event->platform }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Link:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                            <a href="{{$guest->events->link}}" class="btn btn-primary">
                                {{$guest->events->link}}
                            </a>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Venue:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $event->location  }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: bold; border-bottom: 1px solid #ddd;">Location:</td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                            {{getStateFromIso2($guest->events->state,$guest->events->country)->name??'N/A'}} {{ getCountryFromIso2($guest->events->country)->name }}
                        </td>
                    </tr>
                @endif
            </table>
            <p style="font-size: 16px; line-height: 1.5;">
                Please mark your calendar and join us for this event. If you have any questions or need further details, feel free to reach out to us.
            </p>
        </td>
    </tr>
    <tr>
        <td style="background-color: #f4f4f4; text-align: center; padding: 20px; font-size: 14px; color: #555;">
            <p style="margin: 0;">Need help? <a href="mailto:{{ $event->supportEmail }}" style="color: #0047ba; text-decoration: none;">Contact Support</a></p>
            <p style="margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </td>
    </tr>
</table>
</body>
</html>
