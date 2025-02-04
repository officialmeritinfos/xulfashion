<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Your {{ $web->name }} Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background: #5a2d82;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }
        .logo {
            width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .content {
            padding: 20px;
            text-align: left;
            color: #333;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            text-decoration: none;
            background-color: #5a2d82;
            color: #ffffff;
            font-size: 16px;
            border-radius: 5px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #666;
        }
        @media (max-width: 600px) {
            .container {
                width: 90%;
                margin: 10px auto;
                padding: 15px;
            }
            .header h1 {
                font-size: 20px;
            }
            .content p {
                font-size: 14px;
            }
            .button {
                font-size: 14px;
                padding: 10px 16px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ asset($web->logo2) }}" alt="{{ $web->name }} Logo" class="logo">
        <h1>Complete Your {{ $web->name }} Profile</h1>
    </div>
    <div class="content">
        <p>Hi {{ $merchant->name }},</p>

        <p>We noticed that you've signed up on {{ $web->name }} but haven't completed your profile yet. Completing your profile unlocks full access to:</p>

        <ul>
            <li>Showcase your store & services to thousands of customers.</li>
            <li>Receive and manage bookings seamlessly.</li>
            <li>Sell products and services directly on {{ $web->name }}.</li>
            <li>Organize and manage fashion events effortlessly.</li>
        </ul>

        <p>Don't miss out on these amazing opportunities! Click the button below to complete your profile and start selling.</p>

        <div class="button-container">
            <a href="{{ $profileCompletionLink }}" class="button">Complete My Profile</a>
        </div>

        <p>If you need any assistance, our support team is always ready to help.</p>

        <p>Best regards,<br>
            <strong>The {{ $web->name }} Team</strong></p>
    </div>
    <div class="footer">
        <p>If you have any questions, feel free to <a href="mailto:{{ $web->supportEmail }}">contact us</a>.</p>
        <p>&copy; {{ date('Y') }} {{ $web->name }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
