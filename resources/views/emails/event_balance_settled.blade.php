<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Balance Settled</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            margin-top: 20px;
        }

        .content h2 {
            color: #007bff;
            text-align: center;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .details-table td.label {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 40%;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="{{ asset($web->logo) }}" alt="{{ config('app.name') }} Logo">
        <h3>{{ config('app.name') }}</h3>
    </div>

    <div class="content">
        <h2>Event Balance Settled</h2>
        <p>Dear {{ $user->name }},</p>
        <p>We are pleased to inform you that your event balance has been successfully settled. Below are the settlement details:</p>

        <table class="details-table">
            <tr>
                <td class="label">Event Title:</td>
                <td>{{ $eventTitle }}</td>
            </tr>
            <tr>
                <td class="label">Event ID:</td>
                <td>{{ $eventId }}</td>
            </tr>
            <tr>
                <td class="label">Amount Settled:</td>
                <td>{{ $currency->sign }} {{ number_format($amountSettled, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Amount Received:</td>
                <td>{{ $userCurrency->sign }} {{ number_format($amountReceived, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Settlement ID:</td>
                <td>{{ $settlementId }}</td>
            </tr>
            <tr>
                <td class="label">Transaction Date:</td>
                <td>{{ \Carbon\Carbon::parse($date)->format('d M Y, h:i A') }}</td>
            </tr>
        </table>


        <p>You should receive a Credit Notification in your account soonest. <br/>If you have any questions, feel free to contact our support team.</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>

</body>
</html>
