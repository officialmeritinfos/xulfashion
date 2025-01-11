<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Payout Account Added</title>
    <style>
        /* Basic Reset */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .logo {
            max-width: 150px;
            height: auto;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        .content h2 {
            color: #333333;
        }

        .content p {
            font-size: 16px;
            color: #666666;
            line-height: 1.6;
        }

        /* Account Details */
        .details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #e0e0e0;
        }

        .details p {
            margin: 5px 0;
            color: #333333;
        }

        /* Button */
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #999999;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .content, .header, .footer {
                padding: 15px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }

            .logo {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header with Logo -->
    <div class="header">
        <a href="{{ config('app.url') }}">
            <img src="{{ asset($web->logo) }}" alt="{{ config('app.name') }} Logo" class="logo">
        </a>
    </div>

    <!-- Content -->
    <div class="content">
        <h2>Hello {{ $user->name }},</h2>
        <p>
            A new <strong>Payout Account</strong> has been successfully added to your account on {{ config('app.name') }}.
        </p>

        <!-- Account Details -->
        <div class="details">
            <p><strong>Bank Name:</strong> {{ $accountDetails->bankName ?? 'N/A' }}</p>
            <p><strong>Account Number:</strong> {{ $accountDetails->accountNumber ?? 'N/A' }}</p>
            <p><strong>Account Name:</strong> {{ $accountDetails->accountName ?? 'N/A' }}</p>
            <p><strong>Currency:</strong> {{ $accountDetails->currency ?? 'N/A' }}</p>

            @if(!empty($accountDetails->meta))
                @php
                    $metaData = is_array($accountDetails->meta)
                                ? $accountDetails->meta
                                : json_decode($accountDetails->meta, true);
                @endphp

                <hr>
                <h4 style="margin-top: 10px;">Additional Information</h4>

                @foreach($metaData as $key => $value)
                    <p><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value ?? 'N/A' }}</p>
                @endforeach
            @endif
        </div>


        <p>If you did not authorize this action, please contact our support team immediately.</p>


        <p>Thank you for choosing {{ config('app.name') }}!</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>

</body>
</html>
