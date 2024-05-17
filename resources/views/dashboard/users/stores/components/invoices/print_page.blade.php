
<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta charset="UTF-8">
    <meta name="author" content="{{$siteName}}"/>
    <meta name="description" content="{{$web->description}}"/>
    <meta name="keywords" content="{{$web->keywords}}">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/invoice/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/invoice/fonts/font-awesome/css/font-awesome.min.css')}}">


    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/invoice/css/style.css')}}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset($store->logo??$web->favicon)}}">
    <!-- Title -->
    <title>{{$pageName}} - {{$store->name}}</title>
</head>
<body>
@inject('injected','App\Custom\Regular')

<!-- Invoice 2 start -->
<div class="invoice-2 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-logo">
                                        <!-- logo started -->
                                        <div class="logo">
                                            <img src="{{$store->logo}}" alt="logo" style="width: 50px;height: 50px;"/>
                                        </div>
                                        <!-- logo ended -->
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-id">
                                        <div class="info">
                                            <h1 class="inv-header-1">Invoice</h1>
                                            <p class="mb-1">Invoice Number: <span>#{{$invoice->reference}}</span></p>
                                            <p class="mb-0">Invoice Date: <span>{{date('d M Y')}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <h4 class="inv-title-1">Invoice To</h4>
                                        <h2 class="name">{{$customer->name}}</h2>
                                        <p class="invo-addr-1">
                                            {{$customer->phone}} <br/>
                                            {{$customer->email}} <br/>
                                            {!! $customer->address !!} <br/>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <div class="invoice-number-inner">
                                            <h4 class="inv-title-1">Invoice From</h4>
                                            <h2 class="name">{{$store->name}}</h2>
                                            <p class="invo-addr-1">
                                                {{$store->phone}}  <br/>
                                                {{$store->email}} <br/>
                                                {!! $store->address !!} <br/>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped invoice-table">
                                    <thead class="bg-active">
                                    <tr class="tr">
                                        <th>No.</th>
                                        <th class="pl0 text-start">Item Description</th>
                                        <th class="text-center">Unit Price({{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}})</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Total({{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}})</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice->items as $key=>$value)
                                        <tr class="tr">
                                            <td>
                                                <div class="item-desc-1">
                                                    <span>{{$key+1}}</span>
                                                </div>
                                            </td>
                                            <td class="pl0">{{$value}}</td>
                                            <td class="text-center">{{$invoice->itemPrice[$key]}}</td>
                                            <td class="text-center">{{$invoice->itemQuantity[$key]}}</td>
                                            <td class="text-end">{{number_format($invoice->itemPrice[$key]*$invoice->itemQuantity[$key],2)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">SubTotal</td>
                                        <td class="text-end">{{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}}{{number_format($invoice->amount)}}</td>
                                    </tr>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">Processor Fee ({{$fiat->charge}}%)</td>
                                        <td class="text-end">
                                            {{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}}{{number_format($injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                                        </td>
                                    </tr>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center f-w-600 active-color">Grand Total</td>
                                        <td class="f-w-600 text-end active-color">
                                            {{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}}{{number_format($invoice->amount+$injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="terms-conditions mb-30">
                                        <h3 class="inv-title-1">Terms & Conditions</h3>
                                        <p>
                                            You agree to be bound by the merchant's Terms and Conditions including their refund
                                            policies. Ensure that you have read their terms and conditions very carefully.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-contact clearfix">
                            <div class="row g-0">
                                <div class="col-sm-12">
                                    <div class="contact-info clearfix">
                                        <a href="tel:{{$store->phone}}" class="d-flex"><i class="fa fa-phone"></i> {{$store->phone}}</a>
                                        <a href="mail:{{$store->email}}" class="d-flex"><i class="fa fa-envelope"></i>
                                            {{$store->email}}</a>
                                        <a  class="mr-0 d-flex d-none-580"><i class="fa fa-map-marker"></i> {!! $store->address !!}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Print Invoice
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                            <i class="fa fa-download"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 2 end -->

<script src="{{asset('dashboard/invoice/js/jquery.min.js')}}"></script>
<script src="{{asset('dashboard/invoice/js/jspdf.min.js')}}"></script>
<script src="{{asset('dashboard/invoice/js/html2canvas.js')}}"></script>
<script src="{{asset('dashboard/invoice/js/app.js')}}"></script>
</body>
</html>
