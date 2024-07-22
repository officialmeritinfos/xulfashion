<div>
    @inject('injected','App\Custom\Regular')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body py-40">
                    <div class="row justify-content-center" id="invoice">
                        <div class="col-lg-12">
                            <div class="shadow-4 border radius-8">
                                <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div>
                                        <h3 class="text-xl">Invoice #{{$invoice->reference}}</h3>
                                        <p class="mb-1 text-sm">Date Issued: {{$invoice->created_at->format('d/m/Y')}}</p>
                                    </div>
                                    <div>
                                        <img src="{{$store->logo}}" alt="image" class="mb-8 w-72-px h-72-px radius-8 object-fit-cover lightboxed">
                                        <p class="mb-1 text-sm">{{$store->address}}</p>
                                        <p class="mb-0 text-sm">{{$store->email}}, {{$store->phone}}</p>
                                    </div>
                                </div>
                                <div class="py-28 px-20">
                                    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                        <div>
                                            <h6 class="text-md">Issued To:</h6>
                                            <table class="text-sm text-secondary-light">
                                                <tbody>
                                                <tr>
                                                    <td>Name: </td>
                                                    <td class="ps-8">{{$customer->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email:</td>
                                                    <td class="ps-8">{{$customer->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Phone number:</td>
                                                    <td class="ps-8">{{$customer->phone}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <table class="text-sm text-secondary-light">
                                                <tbody>
                                                <tr>
                                                    <td>Status:</td>
                                                    <td class="ps-8">
                                                        @switch($invoice->status)
                                                            @case(1)
                                                                <span class="badge bg-success">Paid</span>
                                                                @break
                                                            @case(2)
                                                                <span class="badge bg-info">Pending Payment</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-danger">Cancelled</span>
                                                                @break
                                                        @endswitch
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Status: </td>
                                                    <td class="ps-8">
                                                        @switch($invoice->paymentStatus)
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Date Paid: </td>
                                                    <td class="ps-8">
                                                        @switch($invoice->paymentStatus)
                                                            @case(1)
                                                                <span class="badge bg-primary">{{date('d/m/Y h:i A',$invoice->datePaid)}}</span>
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Method: </td>
                                                    <td class="ps-8">
                                                        @switch($invoice->paymentStatus)
                                                            @case(1)
                                                                <span class="badge bg-primary">{{str_replace('_',' ',$invoice->paymentMethod)}}</span>
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
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mt-24">
                                        <div class="table-responsive scroll-sm">
                                            <table class="table bordered-table text-sm">
                                                <thead>
                                                <tr>
                                                    <th scope="col" class="text-sm">SL.</th>
                                                    <th scope="col" class="text-sm">Description</th>
                                                    <th scope="col" class="text-sm">Qty</th>
                                                    <th scope="col" class="text-sm">Units Price ({{$fiat->sign}})</th>
                                                    <th scope="col" class="text-end text-sm">Price ({{$fiat->sign}})</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($invoice->items as $key=>$value)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$value}}</td>
                                                        <td >{{$invoice->itemQuantity[$key]}}</td>
                                                        <td >{{$invoice->itemPrice[$key]}}</td>
                                                        <td class="text-end"> {{number_format($invoice->itemPrice[$key]*$invoice->itemQuantity[$key],2)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-end gap-3 mt-3">

                                            <div>
                                                <table class="text-sm">
                                                    <tbody>
                                                    <tr>
                                                        <td class="pe-64">Subtotal:</td>
                                                        <td class="pe-16">
                                                    <span class="text-primary-light fw-semibold">
                                                        {{$fiat->sign}} {{number_format($invoice->amount)}}
                                                    </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64">Processor Fee {{$fiat->charge}}%+{{$fiat->sign}}{{$fiat->transactionCharge}}:</td>
                                                        <td class="pe-16">
                                                    <span class="text-primary-light fw-semibold">
                                                        {{$fiat->sign}} {{number_format($injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                                                    </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64 border-bottom pb-4">Tax:</td>
                                                        <td class="pe-16 border-bottom pb-4">
                                                            <span class="text-primary-light fw-semibold">0.00</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pe-64 pt-4">
                                                            <span class="text-primary-light fw-semibold">Total:</span>
                                                        </td>
                                                        <td class="pe-16 pt-4">
                                                    <span class="text-primary-light fw-semibold">
                                                        {{$fiat->sign}} {{number_format($invoice->amount-$injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                                                    </span>
                                                        </td>
                                                    </tr>
                                                    @if($invoice->paymentStatus==1 && $invoice->paymentMethod!='offline' && !empty($invoice->paymentMethod))
                                                        <tr>
                                                            <td class="pe-64 pt-4">
                                                                <span class="text-primary-light fw-semibold">Amount Credited:</span>
                                                            </td>
                                                            <td class="pe-16 pt-4">
                                                        <span class="text-primary-light fw-semibold">
                                                            {{$fiat->sign}} {{number_format($invoice->amountCredit,2)}}
                                                        </span>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
