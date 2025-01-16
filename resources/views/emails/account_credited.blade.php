<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Credit Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .content {
            margin-top: 20px;
        }

        .content h2 {
            color: #28a745;
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
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .details-table td {
                padding: 8px;
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
        <h2>Credit Alert</h2>
        <p>Dear {{ $user->name }},</p>
        <p>Your account has been credited successfully. Below are the transaction details:</p>

        <table class="details-table">
            <tr>
                <td class="label">Amount Credited:</td>
                <td>{{ $currency->sign }} {{ number_format($amount, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Transaction Date:</td>
                <td>{{ \Carbon\Carbon::parse($date)->format('d M Y, h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Transaction Reference:</td>
                <td>{{ $transactionRef }}</td>
            </tr>
            <tr>
                <td class="label">Source:</td>
                <td>{{ $source??'Account Funding' }}</td>
            </tr>
            <tr>
                <td class="label">Available Balance:</td>
                <td>{{ $currency->sign }} {{ number_format($availableBalance, 2) }}</td>
            </tr>
        </table>


        <p>If you did not authorize this transaction, please contact our support team immediately.</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>

</body>
</html>
