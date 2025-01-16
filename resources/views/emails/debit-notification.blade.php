<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debit Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #0d6efd;
            color: #ffffff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header img {
            width: 150px;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
            color: #333333;
        }

        .content h2 {
            color: #d9534f;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
        }

        .details {
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 15px;
        }

        .details p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }

        @media (max-width: 600px) {
            .email-container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header with Company Logo -->
    <div class="header">
        <img src="{{ asset($web->logo) }}" alt="Company Logo">
        <h1>Debit Notification</h1>
    </div>

    <!-- Content Section -->
    <div class="content">
        <p>Hello {{ $user->name }},</p>

        <h2>{{ $userFiat->sign }}{{ number_format($withdrawal->amount, 2) }} Debited</h2>

        <p>Your account has been debited successfully. Below are the details of this transaction:</p>

        <div class="details">
            <p><strong>Amount Debited:</strong> {{ $userFiat->sign }}{{ number_format($withdrawal->amount, 2) }}</p>
            <p><strong>Amount To Receive:</strong> {{ $bankFiat->sign }}{{ number_format($withdrawal->amountCredit, 2) }}</p>
            <p><strong>Account Name:</strong> {{ $bank->accountName }}</p>
            <p><strong>Account Number:</strong> {{ $bank->accountNumber }}</p>
            <p><strong>Bank Name:</strong> {{ $bank->bankName }}</p>
            <p><strong>Transaction Date:</strong> {{ $withdrawal->created_at->format('d M Y, h:i A') }}</p>
            <p><strong>Transaction Reference:</strong> {{ $withdrawal->reference }}</p>
            <p><strong>Current Balance:</strong> {{ $userFiat->sign }}{{ number_format($user->accountBalance, 2) }}</p>
        </div>

        <p>If you did not authorize this transaction, please contact our support team immediately.</p>

        <p>Thank you for banking with us.</p>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        &copy; {{ date('Y') }} {{ $web->name }}. All rights reserved.<br>
        This is an automated message. Please do not reply.
    </div>
</div>
</body>
</html>
