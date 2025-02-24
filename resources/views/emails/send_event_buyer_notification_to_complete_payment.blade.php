<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Purchase</title>
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
            background-color: #ffc107;
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
            color: #ffc107;
            font-weight: bold;
        }

        .button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
            background-color: #ffc107;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #e0a800;
        }

        .footer {
            background-color: #f9f9f9;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .footer a {
            color: #ffc107;
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
        <h1>Don’t Miss Out on Your Purchase!</h1>
    </div>

    <!-- Content for Reminder -->
    <div class="content">
        <p>Dear <span class="highlight">{{ $buyer->name }}</span>,</p>
        <p>
            We noticed that you started purchasing tickets for <span class="highlight">{{ $event->title }}</span>, but it seems you haven’t completed your payment yet.
        </p>
        <p>
            Your selected tickets are reserved for a limited time. Complete your payment to secure your spot and enjoy the event without any interruptions.
        </p>
        <p><strong>Order Details:</strong></p>
        <ul>
            <li><strong>Event:</strong> {{ $event->title }}</li>
            <li><strong>Tickets:</strong> {{ $purchase->tickets->sum('quantity') }}</li>
            <li><strong>Total Amount:</strong> {{ currencySign($purchase->purchaseCurrency) }}{{ number_format($purchase->totalPrice) }}</li>
        </ul>
        <p>
            Click the button below to complete your purchase now:
        </p>
        <a href="{{ $purchase->paymentLink }}" class="button">Complete Purchase</a>
        <p>If you have any questions or need assistance, feel free to contact our support team.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>You are receiving this email because you initiated a purchase on <a href="{{ route('mobile.ads.index') }}">{{ $web->name }}</a>.</p>
    </div>
</div>

</body>
</html>
