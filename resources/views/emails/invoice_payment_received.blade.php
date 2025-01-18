<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Payment Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            color: #555555;
        }
        .details {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .details p {
            margin: 5px 0;
            font-size: 15px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888888;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ asset($web->logo) }}" alt="Company Logo">
        <h2>Invoice Payment Received</h2>
    </div>

    <div class="content">
        <p>Dear {{ $merchant->name }},</p>
        <p>We are pleased to inform you that payment has been successfully received for your invoice <strong>{{ $order->reference }}</strong>. Below are the details of the transaction:</p>

        <div class="details">
            <p><strong>Invoice Name:</strong> {{ $order->title }}</p>
            <p><strong>Invoice Reference:</strong> {{ $order->reference }}</p>
            <p><strong>Payer:</strong> {{ $customer->name }}</p>
            <p><strong>Invoice Amount:</strong> {{ $order->currency }}{{ number_format($order->amount, 2) }}</p>
            <p><strong>Amount Paid:</strong> {{ $order->currency }}{{ number_format($amountPaid, 2) }}</p>
            <p><strong>Charge:</strong> {{ $order->currency }}{{ number_format($totalCharge, 2) }}</p>
            <p><strong>Credited Amount:</strong> {{ $order->currency }}{{ number_format($amountCredit, 2) }}</p>
        </div>

        <p>Thank you for using our platform. If you have any questions, feel free to contact our support team.</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
