@extends('dashboard.layout.base')
@section('content')
    @inject('option','App\Custom\Regular')
    <div class="wallet-chart-area with-exchange">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto">
                    <div class="row justify-content-center">

                        <div class="col-lg-6 col-sm-6">
                            <div class="single-today-card d-flex align-items-center">
                                <div class="flex-grow-1">
                                        <span class="today">
                                            Main Balance <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                            title="This account serves as your account balance for salaries/wages paid.
                                                            You can withdraw from this anytime you want."></i>
                                        </span>
                                    <h6>
                                            <span style="word-break: break-word;">
                                                {{$user->mainCurrency}} {{number_format($user->accountBalance,2)}}
                                            </span>
                                    </h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="dropdown">
                                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" data-bs-toggle="modal" href="#withdraw_main_balance">
                                                    <i class="ri-send-plane-fill"></i>
                                                    Withdraw Balance
                                                </a>
                                            </li>
{{--                                            <li>--}}
{{--                                                <a class="dropdown-item" data-bs-toggle="modal" href="#fund_main_balance">--}}
{{--                                                    <i class="bx bx-money"></i>--}}
{{--                                                    Fund Balance--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="single-today-card d-flex align-items-center">
                                <div class="flex-grow-1">
                                        <span class="today">
                                            Referral Balance <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                title="Funds here are amount you received from your referrals"></i>
                                        </span>
                                    <span class="text-info">
                                                {{$user->mainCurrency}} {{number_format($user->referralBalance,2)}}
                                            </span>
                                </div>
                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="dropdown">
                                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                            <li>
                                                <a class="dropdown-item" data-bs-toggle="modal" href="#convert_referral_balance">
                                                    <i class="bx bx-repeat"></i>
                                                    Convert Balance
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="order-details-area mb-24">
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
                                                    @case(4)
                                                        <span class="badge bg-primary">Order Settlement</span>
                                                        @break
                                                    @case(5)
                                                        <span class="badge bg-dark">Invoice Settlement</span>
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
                                                        <span class="badge bg-success">
                                                                <i class="bx bx-checkbox-checked"
                                                                   data-bs-toggle="tooltip" title="completed"
                                                                   style="font-size: 15px;"></i>
                                                            </span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge bg-primary"><i class="bx bx-loader-circle bx-spin"
                                                                                          data-bs-toggle="tooltip" title="processing"
                                                                                          style="font-size: 15px;"></i></span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-danger">
                                                                <i class="bx bx-sad"
                                                                   data-bs-toggle="tooltip" title="Please contact support"
                                                                   style="font-size: 15px;"></i>
                                                            </span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="ui-kit-cards grid mb-24">
                        <h3>Account Withdrawal</h3>

                        <div class="latest-transaction-area">
                            <div class="table-responsive h-auto" data-simplebar>
                                <table class="table align-middle mb-0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th >Amount</th>
                                        <th>Bank</th>
                                        <th>Account Number</th>
                                        <th>Narration</th>
                                        <th>DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($withdrawals as $withdrawal)
                                        <tr>
                                            <td>
                                        <span class="badge bg-primary">
                                            {{$withdrawal->reference}}
                                        </span>
                                            </td>
                                            <td>
                                                {{$withdrawal->currency}}{{number_format($withdrawal->amount,2)}}
                                                ({{$withdrawal->currency}}{{number_format($withdrawal->amountCredit,2)}})
                                            </td>
                                            <td>
                                                {{empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails))?'N/A':$option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->bankName}}
                                            </td>
                                            <td>
                                                {{empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails))?'N/A':$option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->accountNumber}}
                                                (
                                                {{empty($option->fetchPayoutAccountByReference($withdrawal->paymentDetails))?'N/A':$option->fetchPayoutAccountByReference($withdrawal->paymentDetails)->accountName}}
                                                )
                                            </td>
                                            <td>
                                                <span class="badge bg-dark">Withdrawal from Account</span>
                                            </td>
                                            <td>
                                                {{date('D, d M Y H:i:s',strtotime($withdrawal->created_at))}}
                                            </td>
                                            <td>
                                                @switch($withdrawal->status)
                                                    @case(1)
                                                        <span class="badge bg-success">Completed</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge bg-primary">Pending</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-danger">Cancelled</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        @include('dashboard.common.components.modals')
        <script src="{{asset('requests/dashboard/account_funding.js')}}"></script>
        <script src="{{asset('requests/dashboard/tutor/settings.js')}}"></script>
    @endpush
@endsection
