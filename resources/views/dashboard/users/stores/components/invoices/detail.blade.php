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
                    <div class="col-lg-3">
                        <div class="text">
                            <h4 class="mb-2">Bill To</h4>
                            <span class="d-block mb-1">{{$customer->name}}</span>
                            <span class="d-block mb-1">{{$customer->phone}}</span>
                            <span class="d-block">{{$customer->email}}</span>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="text text-end">
                            <h5>Invoice: <small class="badge bg-dark">{{$invoice->title}}</small></h5>
                            <h5>Invoice # <small class="badge bg-primary">{{$invoice->reference}}</small></h5>
                            <h5>Invoice Date  <small class="badge bg-primary">{{date('d/m/Y',strtotime($invoice->created_at))}}</small></h5>
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
                            <td>{{$key}}</td>
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
                        <td class="text-end" colspan="4"><strong>Processor Fee {{$fiat->charge}}%</strong></td>
                        <td class="text-end">
                            {{$invoice->currency}} {{number_format($injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                        </td>
                    </tr>

                    <tr>
                        <td class="text-end total" colspan="4"><strong>Total</strong></td>
                        <td class="text-end total-price"><strong>
                                {{$invoice->currency}} {{number_format($invoice->amount+$injected->calculateChargeOnAmount($invoice->amount,$invoice->currency),2)}}
                            </strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </form>

        <div class="invoice-btn-box text-end">
            <a href="{{route('user.stores.invoices.print',['id'=>$invoice->reference])}}" class="default-btn mb-4" ><i class='bx bx-printer'></i> Go To Print Page</a>
            <form method="post" action="{{route('user.stores.invoice.notify.process',['id'=>$invoice->reference])}}"
                  style="max-width: none; width: 100%;" id="processForm">
                <button type="submit" class="default-btn submit"><i class='bx bx-paper-plane'></i> Notify Payer</button>
            </form>
        </div>
    </div>


    @push('js')
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
