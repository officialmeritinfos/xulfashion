<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{$order->reference}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header, .footer {
            text-align: center;
            padding: 10px;
        }
        .header img {
            max-width: 100px;
        }
        .invoice-title {
            font-size: 24px;
            margin-top: 10px;
        }
        .invoice-details, .customer-details, .summary-table {
            width: 100%;
            margin-top: 20px;
        }
        .invoice-details th, .customer-details th, .summary-table th {
            text-align: left;
            padding: 8px;
            background-color: #f8f8f8;
        }
        .invoice-details td, .customer-details td, .summary-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            font-size: 12px;
        }
        .bg-success { background-color: #28a745; }
        .bg-info { background-color: #17a2b8; }
        .bg-danger { background-color: #dc3545; }
        .bg-primary { background-color: #007bff; }
        .bg-warning { background-color: #ffc107; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-primary { background-color: #007bff; }
        .btn-info { background-color: #17a2b8; }
        .btn-success { background-color: #28a745; }
        .btn-print { background-color: #6c757d; }

        @media (max-width: 600px) {
            .invoice-container {
                padding: 10px;
            }
            .invoice-details, .customer-details, .summary-table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
@inject('injected','App\Custom\Regular')
<div class="invoice-container">
    <div class="header">
        <img src="{{ asset($store->logo) }}" alt="Logo">
        <h1 class="invoice-title">Invoice #{{$order->reference}}</h1>
        <p>Date: {{date('d M Y', strtotime($order->created_at))}}</p>

        @include('notifications')
    </div>

    <table class="customer-details">
        <tr>
            <th>Invoice To:</th>
            <th>Bill From:</th>
        </tr>
        <tr>
            <td>
                {{$customer->name}}<br>
                {{$customer->email}}<br>
                {{$customer->phone}}<br>
                {{$customer->address}}
            </td>
            <td>
                {{$store->name}}<br>
                {{$store->email}}<br>
                {{$store->address}}
            </td>
        </tr>
    </table>

    <table class="invoice-details">
        <tr>
            <th>Payment Status</th>
            <th>Order Status</th>
            <th>Payment Method</th>
        </tr>
        <tr>
            <td>
                @switch($order->paymentStatus)
                    @case(1) <span class="badge bg-success">Successful</span> @break
                    @case(2) <span class="badge bg-info">Pending Payment</span> @break
                    @case(3) <span class="badge bg-danger">Cancelled</span> @break
                    @default <span class="badge bg-warning">Unknown</span>
                @endswitch
            </td>
            <td>
                @switch($order->status)
                    @case(1) <span class="badge bg-success">Completed</span> @break
                    @case(2) <span class="badge bg-info">Pending</span> @break
                    @case(3) <span class="badge bg-danger">Cancelled</span> @break
                    @case(4) <span class="badge bg-primary">Processing</span> @break
                    @case(5) <span class="badge bg-warning text-white">Incomplete</span> @break
                    @case(6) <span class="badge bg-dark">In Escrow</span> @break
                    @default <span class="badge bg-secondary">Under Review</span>
                @endswitch
            </td>
            <td>
                @if($order->checkoutType == 1)
                    <span class="badge bg-dark">Completed on WhatsApp</span>
                @else
                    <span style="color: #0E1C1F;">{{ $order->paymentMethod ?? 'Online' }}</span>
                @endif
            </td>
        </tr>
    </table>

    <table class="summary-table">
        <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{$injected->fetchProductById($item->product)->name}}</td>
                <td>{{$order->currency}}{{number_format($item->amount, 2)}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$order->currency}}{{number_format($item->totalAmount, 2)}}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3"><strong>SubTotal</strong></td>
            <td>{{$order->currency}}{{number_format($order->amount, 2)}}</td>
        </tr>
        @if(!empty($order->coupon))
            <tr>
                <td colspan="3"><strong>Discount</strong></td>
                <td>-{{$order->currency}}{{number_format($order->discount, 2)}}</td>
            </tr>
        @endif
        <tr>
            <td colspan="3"><strong>Grand Total</strong></td>
            <td>{{$order->currency}}{{number_format($order->totalAmountToPay, 2)}}</td>
        </tr>
        </tbody>
    </table>

    <div class="footer">
        @if($viewMailButton == 1)
            <a href="{{route('merchant.store.checkout.order.invoice', ['subdomain'=>$subdomain, 'id'=>$order->reference])}}" class="btn btn-primary">
                <i class="fa fa-credit-card"></i> {{$settings->defaultBuyText ?? 'Make Payment'}}
            </a>
        @endif

        @if($showButton == 1)
            <a href="{{route('merchant.store', ['subdomain' => $subdomain])}}" target="_blank" class="btn btn-info">
                <i class="fa fa-arrow-left"></i> Back to Store
            </a>
            <a href="javascript:window.print()" class="btn btn-print">
                <i class="fa fa-print"></i> Print
            </a>
            @if($order->paymentStatus != 1)
                    <button
                        data-url="{{ route('merchant.store.checkout.make.payment', ['subdomain' => $subdomain, 'id' => $order->reference]) }}"
                        class="btn btn-success make-payment-btn">
                        <i class="fa fa-credit-card"></i> Make Payment
                    </button>
                @endif
        @endif
    </div>
</div>
</body>
</html>
