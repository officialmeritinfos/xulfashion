<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Organizing Your Event</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f8f9fa; color: #333;">
<table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f8f9fa" style="margin: 0; padding: 20px 0;">
    <tr>
        <td align="center">
            <table cellpadding="0" cellspacing="0" border="0" width="600" bgcolor="#ffffff" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <!-- Header Section -->
                <tr>
                    <td align="center" bgcolor="#0047ba" style="padding: 20px; color: #ffffff;">
                        <h1 style="margin: 0; font-size: 24px; font-weight: bold;">Thank You for Choosing {{ config('app.name') }}</h1>
                    </td>
                </tr>

                <!-- Introductory Message -->
                <tr>
                    <td align="left" style="padding: 20px;">
                        <p style="font-size: 18px; margin: 0 0 10px;"><strong>Dear {{ $event->organizer ?? $event->users->name }},</strong></p>
                        <p style="font-size: 16px; line-height: 1.6;">
                            We deeply appreciate you for using <strong>{{ config('app.name') }}</strong> to host your event, <strong>{{ $event->title }}</strong>. Your trust in our platform motivates us to continuously provide top-notch services.
                        </p>
                    </td>
                </tr>

                <!-- Event Highlights Section -->
                <tr>
                    <td align="left" style="padding: 20px; background-color: #f9f9f9; border-top: 1px solid #ddd;">
                        <h3 style="margin: 0 0 10px; font-size: 20px; color: #0047ba;">Event Details</h3>
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 16px; line-height: 1.6; color: #333;">
                            <tr>
                                <td style="padding: 5px 0;"><strong>Event Name:</strong></td>
                                <td style="padding: 5px 0;">{{ $event->title }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;"><strong>Date:</strong></td>
                                <td style="padding: 5px 0;">{{ \Carbon\Carbon::parse($event->startDate)->setTimezone($event->eventTimeZone)->format('l, F j, Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;"><strong>Time:</strong></td>
                                <td style="padding: 5px 0;">{{ \Carbon\Carbon::parse($event->startTime)->setTimezone($event->eventTimeZone)->format('h:i A') }} - {{ determineEventEndDate($event,true) }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0;"><strong>Location:</strong></td>
                                <td style="padding: 5px 0;">{{ $event->location ?? 'Virtual' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Revenue Details Section -->
                <tr>
                    <td align="left" style="padding: 20px;">
                        <h3 style="margin: 0 0 10px; font-size: 20px; color: #0047ba;">Revenue Summary</h3>
                        <p style="font-size: 16px; line-height: 1.6;">
                            Your event has concluded successfully. Below are the current revenue details:
                        </p>
                        <ul style="font-size: 16px; line-height: 1.6; padding-left: 20px;">
                            <li><strong>Total Sales:</strong> {{  currencySign($event->currency) }}{{ number_format($event->totalSales, 2) }}</li>
                            <li><strong>Current Balance:</strong> {{ currencySign( $event->currency)  }}{{ number_format($event->currentBalance, 2) }}</li>
                            <li><strong>Next Settlement:</strong> {{ $event->nextSettlement ?? 'N/A' }}</li>
                        </ul>
                        <p style="font-size: 16px; line-height: 1.6;">
                            Any pending revenue will be processed and disbursed as per the normal settlement routine. If you have any questions, feel free to contact us.
                        </p>
                    </td>
                </tr>

                <!-- Feedback Section -->
                <tr>
                    <td align="left" style="padding: 20px; background-color: #f9f9f9; border-top: 1px solid #ddd;">
                        <h3 style="margin: 0 0 10px; font-size: 20px; color: #0047ba;">We Value Your Feedback</h3>
                        <p style="font-size: 16px; line-height: 1.6;">
                            Your feedback is essential in helping us improve our platform and services. Please let us know how we did by replying to this email or contacting our support team.
                        </p>
                    </td>
                </tr>

                <!-- Call to Action Section -->
                <tr>
                    <td align="center" style="padding: 20px; background-color: #0047ba; color: #ffffff;">
                        <p style="font-size: 16px; margin: 0;">Looking forward to hosting your next event!</p>
                        <a href="{{ route('mobile.user.events.index') }}" style="background-color: #ffffff; color: #0047ba; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Create a New Event</a>
                    </td>
                </tr>

                <!-- Footer Section -->
                <tr>
                    <td align="center" style="padding: 20px; background-color: #f1f1f1; color: #555; font-size: 14px;">
                        <p style="margin: 0;">&copy; {{ now()->year }} {{ config('app.name') }}. All Rights Reserved.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
