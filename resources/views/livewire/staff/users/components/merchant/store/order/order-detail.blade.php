<div>
    @inject('injected','App\Custom\Regular')

    <div class="cart-area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <form class="cart-controller">
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">PRODUCT NAME</th>
                                    <th scope="col"></th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">QUANTITY</th>
                                    <th scope="col">TOTAL</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($breakdowns as $breakdown)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{$injected->fetchProductById($breakdown->product)->featuredImage}}" class="lightboxed">
                                                <img src="{{$injected->fetchProductById($breakdown->product)->featuredImage}}" alt="Image"
                                                     style="width: 50px;">
                                            </a>
                                        </td>

                                        <td class="product-name">
                                            <a href="{{route('merchant.store.product.detail',['subdomain'=>$store->slug,'id'=>$injected->fetchProductById($breakdown->product)->reference])}}"
                                               target="_blank">
                                                {{$injected->fetchProductById($breakdown->product)->name}}</a>
                                            <span>
                                                @if(!empty($breakdown->colorVariant))
                                                    Color: {{$breakdown->colorVariant}}
                                                @endif
                                                @if(!empty($breakdown->sizeVariants))
                                                    , Size: {{$breakdown->sizeVariants}}
                                                @endif
                                            </span>
                                        </td>

                                        <td class="product-price">
                                            <span class="unit-amount">{{$order->currency}}{{number_format($breakdown->amount,2)}}</span>
                                        </td>

                                        <td class="product-price">
                                            <span class="unit-amount">{{$breakdown->quantity}}</span>
                                        </td>


                                        <td class="product-subtotal">
                                            <span class="subtotal-amount">{{$order->currency}}{{number_format($breakdown->totalAmount,2)}}</span>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                </div>

                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="shadow-4 border radius-8">
                                <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div>
                                        <h3 class="text-xl">Order Total</h3>
                                        <p class="mb-1 text-sm">SubTotal: {{$fiat->sign}}{{number_format($order->amount,2)}}</p>
                                        <p class="mb-0 text-sm">
                                            @if($order->discount>0)
                                                Discount <span>{{$fiat->sign}}{{number_format($order->discount,2)}}</span>
                                            @endif
                                        </p>
                                        <p class="mb-0 text-sm">
                                            Payable Total: {{$fiat->sign}}{{number_format($order->totalAmountToPay,2)}}
                                        </p>
                                        @if($order->paymentStatus==1 && !empty($order->paymentMethod))
                                            Charge ({{$fiat->charge.'%+'.$fiat->sign.$fiat->transactionCharge}}) <span>{{$fiat->sign}}{{number_format($order->charge,2)}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 mt-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="shadow-4 border radius-8">
                                <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div>
                                        <h3 class="text-xl">Order Detail</h3>
                                        <ul>
                                            <li>Order ID <span class="badge bg-primary text-white">{{$order->reference}}</span></li>
                                            @if($order->discount>0)
                                                <li> Coupon <span class="badge bg-info text-white">{{$coupon->code}}</span></li>
                                            @endif
                                            <li>CheckoutType <span class="badge bg-dark text-white">{{($order->checkoutType==1)?'Whatsapp':'Online'}}</span></li>
                                            <li>Order Status <span>
                                                    @switch($order->status)
                                                        @case(1)
                                                            <span class="badge bg-success text-white">Completed</span>
                                                            @break
                                                        @case(2)
                                                            <span class="badge bg-info text-white">Pending Payment</span>
                                                            @break
                                                        @case(3)
                                                            <span class="badge bg-danger text-white">Cancelled</span>
                                                            @break
                                                        @case(4)
                                                            <span class="badge bg-primary text-white">Payment Received - Processing</span>
                                                            @break
                                                        @case(5)
                                                            <span class="badge bg-warning text-white">Incomplete Payment</span>
                                                            @break
                                                        @case(6)
                                                            <span class="badge bg-dark text-white">Payment Received - Processing & In Escrow</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-dark text-white">Payment Under Review - Please contact support</span>
                                                            @break
                                                    @endswitch
                                                </span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(!empty($order->channelPaymentReference))
                    <div class="col-lg-4 mt-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="shadow-4 border radius-8">
                                    <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                        <div>
                                            <h3 class="text-xl">Payment Detail</h3>
                                            <ul>
                                                <li>Payment Reference <span class="badge bg-primary text-white">{{$order->channelPaymentReference}}</span></li>
                                                <li>Payment Status <span>
                                                    @switch($order->paymentStatus)
                                                            @case(1)
                                                                <span class="badge bg-success text-white">Successful</span>
                                                                @break
                                                            @case(2)
                                                                <span class="badge bg-info text-white">Pending Payment</span>
                                                                @break
                                                            @case(3)
                                                                <span class="badge bg-danger text-white">Cancelled</span>
                                                                @break
                                                            @case(4)
                                                                <span class="badge bg-primary text-white">Payment Received - Processing</span>
                                                                @break
                                                            @case(5)
                                                                <span class="badge bg-warning text-white">Incomplete Payment</span>
                                                                @break
                                                            @case(6)
                                                                <span class="badge bg-dark text-white">Payment Received - Processing & In Escrow</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-dark text-white">Payment Under Review - Please contact support</span>
                                                                @break
                                                        @endswitch
                                                </span>
                                                </li>
                                                @if($order->paymentStatus==1)
                                                    <li> Amount To Credit <span class="fw-bolder">{{$fiat->sign}}{{number_format($order->amountToCredit)}}</span></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </div>

</div>
