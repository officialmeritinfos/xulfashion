<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
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
        .header img {
            max-width: 150px;
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
        .content strong {
            color: #5a2d82;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #666;
        }
        .footer a {
            color: #5a2d82;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 15px;
            }
            .header h1 {
                font-size: 20px;
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
        <img src="{{ asset($web->logo2) }}" alt="{{ $web->name }} Logo">
        <h1>{{ $subject }}</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <p>Hello <strong>{{ $merchant->name }}</strong>,</p>

        <p>{!! nl2br(e($messageContent)) !!}</p>

        <p>If you have any questions, feel free to <a href="mailto:{{ $web->supportEmail }}">contact our support team</a>.</p>

        <p>Best Regards,<br><strong>The {{ $web->name }} Team</strong></p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $web->name }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
