@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            .stats-panel {
                background-color: #ffeae2;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .stat-item {
                text-align: center;
            }
            .stat-item h2 {
                color: #f24884;
                font-size: 24px;
                margin-bottom: 5px;
            }
            .stat-item p {
                color: #666;
                font-size: 14px;
            }
        </style>
    @endpush

    <div class="container mt-5">
        <!-- Stats Panel -->
        <div class="stats-panel d-flex justify-content-around align-items-center row">
            <div class="stat-item col-6 mt-3">
                <h2>{{shorten_number($ticketSold,0)}}</h2>
                <p>Tickets sold</p>
            </div>
            <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->totalSales}}">
                <h2>{{currencySign($user->mainCurrency)}}{{shorten_number($event->totalSales,2)}}</h2>
                <p>Total Sales revenue</p>
            </div>
            <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->currentBalance}}">
                <h2>{{currencySign($user->mainCurrency)}}{{shorten_number($event->currentBalance,2)}}</h2>
                <p>Current Balance</p>
            </div>
            <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->balanceCleared}}">
                <h2>{{currencySign($user->mainCurrency)}}{{shorten_number($event->balanceCleared,2)}}</h2>
                <p>Balance Cleared</p>
            </div>
            <div class="stat-item col-6 mt-3">
                @if($event->currentBalance >0)
                    <h2>
                        {{date('d M, Y H:i',strtotime($event->nextSettlement))}}
                    </h2>
                @else
                    <h2>-</h2>
                @endif
                <p>Next payout date</p>
            </div>
        </div>

        <!-- Sales Section -->
        <div class="sales-section mt-4 card">
            <div class="card-body">
                <h3 class="fw-bold mb-1">Sales</h3>
                <div class="table-responsive border">
                    <table class="table">
                       <thead>
                        <th>#</th>
                        <th>Buyer</th>
                        <th>ID</th>
                        <th>Payment ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                       </thead>
                        <tbody>
                        @foreach($purchases as $key => $purchase)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    {{$purchase->users->name}}
                                </td>
                                <td>
                                    {{$purchase->reference}}
                                </td>
                                <td>
                                    {{$purchase->paymentReference??'N/A'}}
                                </td>
                                <td>
                                    {{currencySign($purchase->purchaseCurrency)}}{{number_format($purchase->price,2)}}
                                </td>

                                <td>
                                    @switch($purchase->paymentStatus)
                                        @case(1)
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                        @case(2)
                                        <span class="badge bg-primary">Pending</span>
                                        @break
                                        @case(4)
                                        <span class="badge bg-info">Processing</span>
                                        @break
                                        @case(3)
                                        <span class="badge bg-warning">Cancelled</span>
                                        @break
                                        @case(5)
                                        <span class="badge bg-warning">Cancelled By Compliance</span>
                                        @break
                                        @default
                                            <span class="badge bg-danger">Failed</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{route('mobile.user.events.sales.purchase-detail',['event'=>$event->reference,'purchase'=>$purchase->reference])}}">
                                        <i class="fa fa-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$purchases->links()}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment History Section -->
        <div class="payment-history-section mt-4 card">
            <div class="card-body">
                <h3 class="fw-bold">Settlement History</h3>

                <div class="table-responsive border">
                    <table class="table">
                        <thead>
                            <th>S/N</th>
                            <th>ID</th>
                            <th>Account</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                        @foreach($settlements as $settlement)
                            <tr>
                                <td>{{$settlements->firstItem()+1}}</td>
                                <td>
                                    {{$settlement->reference}}
                                </td>
                                <td>
                                    <span style="font-size: 12px;">{{$purchase->banks->accountName}} ({{$settlement->banks->bankName}})</span>
                                </td>
                                <td>
                                    {{currencySign($settlement->currency)}}{{number_format($settlement->amount,2)}}
                                </td>
                                <td>
                                    @switch($settlement->payoutStatus)
                                        @case(1):
                                            <span class="badge bg-success">Completed</span>
                                        @break
                                        @case(2):
                                            <span class="badge bg-primary">Pending</span>
                                        @break
                                        @case(4):
                                            <span class="badge bg-info">Processing</span>
                                        @break
                                        @case(3):
                                            <span class="badge bg-warning">Cancelled</span>
                                        @break
                                        @case(5):
                                            <span class="badge bg-warning">Cancelled By Compliance</span>
                                        @break
                                        @default
                                            <span class="badge bg-danger">Failed</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <button href="#" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$settlements->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
