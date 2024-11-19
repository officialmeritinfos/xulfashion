<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            background-color: #4CAF50;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            border-radius: 10px 10px 0 0;
            color: #fff;
        }
        .content {
            margin: 20px 0;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            min-width: 400px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f1f1f1;
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 16px;
            margin: 5px;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
        }
        .contact-info {
            margin-top: 20px;
        }
        .social-media {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .social-media li {
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Ticket Purchase Confirmation</h2>
    </div>
    <div class="content">
        <p>Dear {{ $buyer->name }},</p>
        <p>Thank you for purchasing tickets for the event "<strong>{{ $event->title }}</strong>". We are excited to have you join us!</p>
        <p>Below are the details of your tickets and the event. Please keep this email as it contains important information regarding your purchase and event entry.</p>

        <h3>Event Details</h3>
        <p><strong>Event Name:</strong> {{ $event->title }}</p>
        <p><strong>Event Type:</strong> {{ eventType($event->id) }}</p>
        <p><strong>Event Start Date:</strong> {{ displayEventStartDate($event) }}</p>
        <p><strong>Event Start Time:</strong> {{displayEventStartTime($event) }}</p>
        @if($event->eventScheduleType!=1 && $event->recurrenceEndType!=1)
            <p><strong>Recurs:</strong> Every {{ $event->recurrenceInterval }}</p>
            <p><strong>Event Ends:</strong> After {{ $event->recurrenceEndCount*extractIntervalFromRecurrenceInterval($event->recurrenceInterval).' '.extractPeriodFromRecurrenceInterval($event->recurrenceInterval) }}</p>
        @else
            <p><strong>Event End Date:</strong> {{ displayEventEndDate($event) }}</p>
            <p><strong>Event End Time:</strong> {{ displayEventEndTime($event) }}</p>
        @endif

        <h3>Ticket Details</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Ticket Name</th>
                    <th>Quantity</th>
                    <th>Admits</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase->tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->ticket->name }}</td>
                        <td>{{ $ticket->quantity }}</td>
                        <td>{{ $ticket->number_admits }}</td>
                        <td>{{ currencySign($event->currency) }} {{ number_format($ticket->price * $ticket->quantity, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <a href="{{ route('mobile.user.events.purchase.detail', ['purchase' => $purchase->reference]) }}" class="button" style="background-color: #FF5722;">Add Guest Details</a>
        </div>

        <p>If you have any questions or need further assistance, please feel free to reach out to the event organizer using the contact information below.</p>

        <div class="contact-info">
            <h3>Contact the Organizer</h3>
            <p><strong>Email:</strong> {{ $event->supportEmail }}</p>
            <ul class="social-media">
                @if(!empty($event->facebook))
                    <li><a href="{{ $event->facebook }}" target="_blank">Facebook</a></li>
                @endif
                @if(!empty($event->twitter))
                    <li><a href="{{ $event->twitter }}" target="_blank">Twitter</a></li>
                @endif
                @if(!empty($event->instagram))
                    <li><a href="{{ $event->instagram }}" target="_blank">Instagram</a></li>
                @endif
            </ul>
        </div>
    </div>
    <div class="footer">
        <p>We look forward to seeing you at the event. Enjoy the experience!</p>
        <p><em>Thank you for choosing our platform.</em></p>
    </div>
</div>
</body>
</html>
