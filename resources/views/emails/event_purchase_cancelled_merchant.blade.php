<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancellation Notification</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #ff4d4f;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content p {
            line-height: 1.6;
            margin: 10px 0;
        }

        .content .highlight {
            color: #ff4d4f;
            font-weight: bold;
        }

        .button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
            background-color: #ff4d4f;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #e04344;
        }

        .footer {
            background-color: #f9f9f9;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .footer a {
            color: #ff4d4f;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 600px) {
            .container {
                margin: 10px;
            }

            .content p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Order Cancellation Notification</h1>
    </div>

    <!-- Content for Merchants -->
    <div class="content">
        <p>Dear <span class="highlight">{{ $user->name }}</span>,</p>
        <p>
            This is to inform you that an order for your event <span class="highlight">{{ $event->title }}</span> has been cancelled. The order was placed on
            <span class="highlight">{{ $purchase->created_at->format('d M Y, h:i A') }}</span> but no payment was received within the required 48-hour period.
        </p>
        <p>
            Below are the details of the cancelled order:
        </p>
        <ul>
            <li><strong>Event:</strong> {{ $event->title }}</li>
            <li><strong>Buyer Name:</strong> {{ $buyer->name }}</li>
            <li><strong>Tickets:</strong> {{ $purchase->tickets->sum('quantity') }}</li>
            <li><strong>Order ID:</strong> {{ $purchase->reference }}</li>
            <li><strong>Cancellation Date:</strong> {{ date('d M Y, h:i A') }}</li>
        </ul>
        <p>If you have any questions or would like to discuss this cancellation, please contact our support team.</p>
        <a href="{{ route('mobile.user.help') }}" class="button">Contact Support</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>You are receiving this email because of your recent activity on <a href="{{ route('mobile.ads.index') }}">{{ $web->name }}</a>.</p>
        <p>If you have any questions, please visit our <a href="{{ route('home.faq') }}">FAQ page</a> or contact our <a href="{{ route('mobile.user.help') }}">support team</a>.</p>
    </div>
</div>

</body>
</html>
