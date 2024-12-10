<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #0047ba;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            color: #0047ba;
            font-size: 20px;
        }

        .content p {
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .custom-message {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .custom-message p {
            margin: 5px 0;
            font-style: italic;
        }

        .event-details {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .event-details h3 {
            margin-top: 0;
            color: #0047ba;
            font-size: 18px;
        }

        .event-details p {
            margin: 5px 0;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #555;
        }

        .footer a {
            color: #0047ba;
            text-decoration: none;
        }

        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #0047ba;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .cta-button:hover {
            background-color: #003088;
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="header">
        <h1>{{ $event->title }} - {{ $title }}</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Hello, {{ $guest->name }}</h2>

        <p>We are reaching out to share an important notification regarding your registered event. Please take a moment to review the message below:</p>

        <!-- Custom Message -->
        <div class="custom-message">
            {!! $messages !!}
        </div>


        <p>If you have any questions or need further assistance, feel free to reach out to us.</p>

        <p>Thank you for your attention. We look forward to seeing you at the event!</p>

        <p>Best regards,<br>The {{ $event->organizer??$event->title }} Team</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Need help? <a href="mailto:{{ $event->supportEmail }}">Contact us</a></p>
        <p>&copy; {{ date('Y') }} {{ $event->organizer??$event->title }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
