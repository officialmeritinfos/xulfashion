<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store is Live!</title>

    <style>
        /* Reset Styles */
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Main Email Container */
        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Header */
        .email-header {
            background-color: #004aad;
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            width: 150px;
        }

        /* Body */
        .email-body {
            padding: 30px;
            color: #333;
        }

        .email-body h1 {
            color: #004aad;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .email-body p {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        /* Button */
        .btn-primary {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff !important;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn-warning {
            display: inline-block;
            background-color: #ffc107;
            color: #000 !important;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Footer */
        .email-footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 20px;
            }

            .btn-primary, .btn-warning {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

<div class="email-container">
    <!-- Header with Logo -->
    <div class="email-header">
        <img src="{{ asset( $web->logo ) }}" alt="{{ config('app.name') }} Logo">
    </div>

    <!-- Email Body -->
    <div class="email-body">
        <h1>Congratulations, {{ $userName }}! 🎉</h1>

        <p>Your store, <strong>{{ $storeName }}</strong>, has been successfully created and is now live!</p>

        <p>Start managing your store, adding products, and growing your business today.</p>

        <a href="{{ $storeUrl }}" class="btn-primary">🚀 Visit Your Store</a>

        <h3>🔎 What's Next?</h3>
        <ol>
            <li><strong>✅ Verify Your Business</strong>
                <p>While not mandatory, verifying your business unlocks premium features like receiving payments, higher product limits, advanced analytics, and priority support.</p>
                <a href="{{ $verifyUrl }}" class="btn-warning">Verify My Business</a>
            </li>

            <li>🎨 <strong>Customize Your Store</strong>
                <p>Update your store's appearance to reflect your brand identity and create a unique shopping experience for your customers.</p>
            </li>

            <li>📦 <strong>Add Products and Categories</strong>
                <p>Start uploading products and organizing them into categories to make shopping easier for your customers.</p>
            </li>

            <li>📢 <strong>Promote Your Store</strong>
                <p>Share your store on social media, run promotions, and engage with customers to drive sales.</p>
            </li>
        </ol>

        <p>If you need assistance, our support team is here to help you every step of the way.</p>

        <p>Thank you for choosing <strong>{{ config('app.name') }}</strong>! We're excited to support your journey to success.</p>

        <p>Best Regards,<br>
            The {{ config('app.name') }} Team</p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p>&copy; {{ now()->year }} {{ config('app.name') }}. All Rights Reserved.</p>
        <p>{!! $web->address !!}</p>
    </div>
</div>

</body>
</html>
