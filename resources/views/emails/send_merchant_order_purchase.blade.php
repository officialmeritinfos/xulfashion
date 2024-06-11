
<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>{{$store->name}} - {{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/invoice/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/invoice/fonts/font-awesome/css/font-awesome.min.css')}}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{asset($store->logo)}}" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('dashboard/invoice/css/style.css')}}">
    @include('genericCss')
</head>
<body>
@inject('injected','App\Custom\StoreFront')

<!-- Invoice 4 start -->
<div class="invoice-4 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner" id="invoice_wrapper">
                    <div class="invoice-top">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="logo">
                                    <img src="{{asset($store->logo)}}" alt="logo" style="width: 70px;height: 70px;">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="invoice text-end">
                                    <h1>Invoice</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-titel">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="invoice-number">
                                    <h3>Invoice Number: #{{$order->reference}}</h3>
                                </div>
                            </div>
                            <div class="col-sm-6 text-end">
                                <div class="invoice-date">
                                    <h3>Invoice Date: {{date('d M Y',strtotime($order->created_at))}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-info">
                        <div class="row">
                            <div class="col-sm-6 mb-30">
                                <div class="invoice-number">
                                    <h4 class="inv-title-1">Invoice To</h4>
                                    <p class="invo-addr-1">
                                        {{$customer->name}} <br/>
                                        {{$customer->email}} <br/>
                                        {{$customer->phone}} <br/>
                                        {{$customer->address}} <br/>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-30">
                                <div class="invoice-number text-end">
                                    <h4 class="inv-title-1">Bill To</h4>
                                    <p class="invo-addr-1">
                                        {{$store->name}}  <br/>
                                        {{$store->email}} <br/>
                                        {{$store->address}} <br/>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-30">
                                <h4 class="inv-title-1">Payment Status</h4>
                                <p class="inv-from-1">
                                    @switch($order->paymentStatus)
                                        @case(1)
                                            <span class="badge bg-success">Successful</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-info">Pending Payment</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-primary">Payment Received - Processing</span>
                                            @break
                                        @case(5)
                                            <span class="badge bg-warning text-white">Incomplete Payment</span>
                                            @break
                                        @case(6)
                                            <span class="badge bg-dark">Payment Received - Processing & In Escrow</span>
                                            @break
                                        @default
                                            <span class="badge bg-dark">Payment Under Review - Please contact support</span>
                                            @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-sm-4 mb-30">
                                <h4 class="inv-title-1">Order Status</h4>
                                <p class="inv-from-1">
                                    @switch($order->status)
                                        @case(1)
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-info">Pending Payment</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-primary">Payment Received - Processing</span>
                                            @break
                                        @case(5)
                                            <span class="badge bg-warning text-white">Incomplete Payment</span>
                                            @break
                                        @case(6)
                                            <span class="badge bg-dark">Payment Received - Processing & In Escrow</span>
                                            @break
                                        @default
                                            <span class="badge bg-dark">Payment Under Review - Please contact support</span>
                                            @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-sm-4 text-end mb-30">
                                @if($order->checkoutType==1)
                                    <h4 class="inv-title-1">Payment Method</h4>
                                    <p class="inv-from-1">
                                        <span class="badge bg-dark">Completed On Whatsapp</span>
                                    </p>
                                @else
                                    <h4 class="inv-title-1">Payment Method</h4>
                                    <p class="inv-from-1">
                                        @if(!empty($order->paymentMethod))
                                            <span class="badge bg-dark">{{str_replace('_',' ',$order->paymentMethod)}}</span>
                                        @else
                                            <span class="badge bg-dark">Online</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="order-summary">
                        <div class="table-responsive">
                            <table class="table invoice-table">
                                <thead class="bg-active">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Totals</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key=>$item)
                                    <tr>
                                        <td>
                                            <div class="item-desc-1">
                                                <span>{{$injected->fetchProductById($item->product)->name}}</span>
                                                <small>Size: <b>{{$item->sizeVariants}}</b></small>
                                                <small>Color: <b>{{$item->colorVariant}}</b></small>
                                            </div>
                                        </td>
                                        <td class="text-center">{{$order->currency}}{{number_format($item->amount,2)}}</td>
                                        <td class="text-center">{{$item->quantity}}</td>
                                        <td class="text-right">{{$order->currency}}{{number_format($item->totalAmount,2)}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end">SubTotal</td>
                                    <td class="text-right">{{$order->currency}}{{number_format($order->amount,2)}}</td>
                                </tr>
                                @if(!empty($order->coupon))
                                    <tr>
                                        <td colspan="3" class="text-end">Discount({{($coupon->couponType==1)?$coupon->discount.'%':$coupon->currency.$coupon->discount}})</td>
                                        <td class="text-right">{{$order->currency}}{{number_format($order->discount)}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Grand Total</td>
                                    <td class="text-right fw-bold">{{$order->currency}}{{number_format($order->totalAmountToPay,2)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="invoice-contact clearfix">
                        <div class="row g-0">
                            <div class="col-lg-9 col-md-11 col-sm-12">
                                <div class="contact-info">
                                    @if($settings->whatsappSupport==1)
                                        <a href="https://wa.me/{{$settings->whatsappSupportNumber}}?text=Hello support"
                                        target="_blank"><i class="fa fa-whatsapp"></i> Chat on Whatsapp</a>
                                    @endif
                                    <a href="mailto:{{$store->email}}"><i class="fa fa-envelope"></i>
                                        {{$store->email}}</a>
                                    <a href="{{config('app.url')}}" target="_blank" class="mr-0 d-none-580"><i class="fa fa-bolt text-warning"></i> Powered by {{$siteName}}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @if($viewMailButton==1)
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="{{route('merchant.store.checkout.order.invoice',['subdomain'=>$subdomain,'id'=>$order->reference])}}" class="btn btn-lg btn-print">
                            <i class="fa fa-credit-card"></i> {{$settings->defaultBuyText??'Make Payment'}}
                        </a>
                    </div>
                @endif
                @if($showButton==1)
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="{{route('merchant.store',['subdomain'=>$subdomain])}}" target="_blank" class="btn btn-lg btn-info">
                            <i class="fa fa-arrow-left"></i> Back To Store
                        </a>
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Print
                        </a>
                        @if($order->paymentStatus!=1)
                            <button type="button" class="btn btn-lg btn-primary submit" data-url="{{route('merchant.store.checkout.make.payment',['subdomain'=>$subdomain,'id'=>$order->reference])}}">
                                <i class="fa fa-credit-card"></i> Make Payment
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Invoice 4 end -->

<script src="{{asset('dashboard/invoice/js/jquery.min.js')}}"></script>
<script src="{{asset('dashboard/invoice/js/jspdf.min.js')}}"></script>
<script src="{{asset('dashboard/invoice/js/html2canvas.js')}}"></script>
<script src="{{asset('dashboard/invoice/js/app.js')}}"></script>
@include('basicInclude')
<script>
    $(function (){
        $('.submit').on('click', function() {
            var url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' // Add CSRF token for security
                },
                beforeSend:function(){
                    $('.submit').attr('disabled', true);
                    $(".submit").LoadingOverlay("show",{
                        text        : "processing...",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.error===true)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);

                        //return to natural stage
                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.error === 'ok')
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);

                        setTimeout(function(){
                            $('.submit').attr('disabled', false);
                            $(".submit").LoadingOverlay("hide");
                            window.location.replace(data.data.redirectTo)
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(jqXHR.responseJSON.data.error);
                    $("#processCheckout :input").prop("readonly", false);
                    $('.submit').attr('disabled', false);
                    $(".submit").LoadingOverlay("hide");
                },
            });
        });
    });
</script>
</body>
</html>
