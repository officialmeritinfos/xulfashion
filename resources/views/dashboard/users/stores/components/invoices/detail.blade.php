@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="invoice-area">
        <form class="form" style="max-width: none; width: 100%;">
            <div class="invoice-header mb-24 d-flex justify-content-between">
                <div class="invoice-left-text">
                    <h3 class="mb-0">{{$store->name}}</h3>
                    <p class="mt-2 mb-0">
                        {!! $store->address !!}
                    </p>
                </div>

                <div class="invoice-right-text">
                    <h3 class="mb-0 text-uppercase">Invoice</h3>
                </div>
            </div>

            <div class="invoice-middle mb-24">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="text">
                            <h4 class="mb-2">Bill To</h4>
                            <span class="d-block mb-1">{{$customer->name}}</span>
                            <span class="d-block mb-1">{{$customer->phone}}</span>
                            <span class="d-block">{{$customer->email}}</span>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="text">
                            <h5>Invoice: <small class="badge bg-dark">{{$invoice->title}}</small></h5>
                            <h5>Invoice # <small class="badge bg-primary">{{$invoice->reference}}</small></h5>
                            <h5>Invoice Date  <small class="badge bg-primary">{{date('d/m/Y',strtotime($invoice->created_at))}}</small></h5>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="text text-end">
                            <h5>Status: <small >
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
                                </small></h5>
                            <h5>Payment Status # <small>
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
                                </small></h5>
                            <h5>Date Paid <small >

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
                                </small></h5>
                            <h5>Payment Method <small >

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
                                </small></h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="invoice-table table-responsive mb-24">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Unit Price({{$invoice->currency}})</th>
                        <th>Total</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($invoice->items as $key=>$value)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$value}}</td>
                            <td class="text-end">{{$invoice->itemQuantity[$key]}}</td>
                            <td class="text-end">{{$invoice->itemPrice[$key]}}</td>
                            <td class="text-end">{{$invoice->currency}} {{number_format($invoice->itemPrice[$key]*$invoice->itemQuantity[$key],2)}}</td>
                        </tr>
                    @endforeach


                    <tr>
                        <td class="text-end" colspan="4"><strong>Subtotal</strong></td>
                        <td class="text-end">{{$invoice->currency}} {{number_format($invoice->amount)}}</td>
                    </tr>

                    <tr>
                        <td class="text-end" colspan="4"><strong>Processor Fee {{$fiat->charge}}%+{{$invoice->currency}}{{$fiat->transactionCharge}}</strong></td>
                        <td class="text-end">
                            {{$invoice->currency}} {{number_format($injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-end total" colspan="4"><strong>Total</strong></td>
                        <td class="text-end total-price"><strong>
                                {{$invoice->currency}} {{number_format($invoice->amount-$injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                            </strong></td>
                    </tr>
                    @if($invoice->paymentStatus==1 && $invoice->paymentMethod!='offline' && !empty($invoice->paymentMethod))
                        <tr>
                            <td class="text-end total" colspan="4"><strong>Amount Credited</strong></td>
                            <td class="text-end total-price"><strong>
                                    {{$invoice->currency}} {{number_format($invoice->amountCredit,2)}}
                                </strong></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </form>

        <div class="invoice-btn-box row justify-content-center">
            <div class="col-md-4 col-6">
                <a href="{{route('user.stores.invoices.print',['id'=>$invoice->reference])}}"
                class="default-btn mb-4" ><i class='bx bx-printer'></i>Print </a>
            </div>
            <div class="col-md-4 col-6">
                <form method="post" action="{{route('user.stores.invoice.notify.process',['id'=>$invoice->reference])}}"
                      style="max-width: none; width: 100%;" id="processForm">
                    <button type="submit" class="default-btn submit"><i class='bx bx-paper-plane'></i> Notify</button>
                </form>
            </div>
            <div class="col-md-4 col-12">
                <a href="{{route('user.stores.invoice.paid.process',['id'=>$invoice->reference])}}"
                   class="success-btn mt-3" ><i class='bx bx-money'></i> Mark Payment Status</a>
            </div>
        </div>
    </div>


    @push('js')
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
