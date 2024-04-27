@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="order-details-area mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">AMOUNT</th>
                            <th scope="col">REFERENCE</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">DATE</th>
                            <th scope="col">STATUS</th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->currency}}{{number_format($transaction->amount,2)}}</td>
                                <td>
                                    <span class="badge bg-primary">{{$transaction->reference}}</span>
                                </td>
                                <td>
                                    @switch($transaction->transactionType)
                                        @case(1)
                                            <span class="badge bg-success">Withdrawal</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-info">Referral Conversion</span>
                                            @break
                                        @default
                                            <span class="badge bg-primary">Charge</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{date('d-m-Y-H-i-s',strtotime($transaction->created_at))}}
                                </td>
                                <td>
                                    @switch($transaction->status)
                                        @case(1)
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-info">Pending</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning">Please contact support</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{$transactions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
