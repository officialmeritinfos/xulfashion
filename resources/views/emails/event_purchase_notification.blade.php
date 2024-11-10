<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Purchase Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            border-radius: 10px 10px 0 0;
        }
        .content {
            margin: 20px 0;
        }
        .table-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            min-width: 400px; /* Ensures the table doesn't shrink too much */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f1f1f1;
        }
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>New Ticket Purchase Received</h2>
    </div>
    <div class="content">
        <p>Dear {{ $eventOwner->name }},</p>
        <p>We are pleased to inform you that a purchase for your event <strong>{{ $event->title }}</strong> has been successfully made. Below are the details:</p>

        <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Ticket Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($purchase->tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->ticket->name }}</td>
                        <td>{{ $ticket->quantity }}</td>
                        <td>{{ currencySign($purchase->purchaseCurrency) }} {{ number_format($ticket->price,2) }}</td>
                        <td>{{ currencySign($purchase->purchaseCurrency) }} {{ number_format($ticket->price * $ticket->quantity, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <p><strong>Total Amount Paid:</strong> {{ currencySign($purchase->purchaseCurrency) }} {{ number_format($purchase->price, 2) }}</p>
        <p><strong>Processing Charge:</strong> {{ currencySign($purchase->purchaseCurrency) }} {{ number_format($purchase->charge, 2) }}</p>
        <p><strong>Amount to Settle:</strong> {{ currencySign($purchase->purchaseCurrency) }} {{ number_format($purchase->totalPrice, 2) }}</p>
        <p><strong>Settlement Date:</strong> {{date('l, F j, Y',strtotime( $event->nextSettlement))}}</p>

        <p>Your payment will be settled on the date specified above. Thank you for your continued trust in our platform,except a new payment is received,
        in which case, you will need to request for the payout manually.</p>
    </div>
    <div class="footer">
        <p>Thank you for using our platform.</p>
        <p><em>{{config('app.name')}} Team</em></p>
    </div>
</div>
</body>
</html>
