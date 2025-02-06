@inject('option','App\Custom\Regular')
<div>
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card h-100 p-0 radius-12">

                <div class="card h-100 p-0 radius-12">

                    <div class="card-body p-24">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12 user-grid-card   ">
                                <div class="position-relative border radius-16 overflow-hidden">
                                    <div class="dropdown position-absolute top-0 end-0 me-16 mt-16">
                                        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="bg-primary w-32-px h-32-px radius-8 border border-light-white d-flex justify-content-center align-items-center text-white">
                                            <iconify-icon icon="entypo:dots-three-vertical" class="icon "></iconify-icon>
                                        </button>
                                        <ul class="dropdown-menu p-12 border bg-base shadow">
                                            <li>
                                                <a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200
                                                text-hover-neutral-900 d-flex align-items-center gap-10"
                                                   wire:click="toggleAddBalance">
                                                    Credit Balance
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-danger-100
                                                text-hover-danger-600 d-flex align-items-center gap-10"
                                                   wire:click="toggleSubBalance">
                                                    Debit Balance
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="ps-16 pb-16 pe-16 text-center mt-5">
                                        <h6 class="text-lg mb-0 mt-4">
                                            Main Balance
                                        </h6>
                                        <span class="text-secondary-light mb-16">{{$currency->sign}} {{number_format($user->accountBalance,2)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4 mx-auto">
            <div class="card h-100 p-0 radius-12">

                <div class="card h-100 p-0 radius-12">

                    <div class="card-body p-24">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12 user-grid-card   ">
                                <div class="position-relative border radius-16 overflow-hidden">

                                    <div class="ps-16 pb-16 pe-16 text-center mt-5">
                                        <h6 class="text-lg mb-0 mt-4">
                                            Pending Balance
                                        </h6>
                                        <span class="text-secondary-light mb-16">{{$currency->sign}} {{number_format($user->pendingBalance,2)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4 mx-auto">
            <div class="card h-100 p-0 radius-12">

                <div class="card h-100 p-0 radius-12">

                    <div class="card-body p-24">
                        <div class="row gy-4">
                            <div class="col-xxl-12 col-md-12 user-grid-card   ">
                                <div class="position-relative border radius-16 overflow-hidden">
                                    <div class="dropdown position-absolute top-0 end-0 me-16 mt-16">
                                        <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="bg-primary w-32-px h-32-px radius-8 border border-light-white d-flex justify-content-center align-items-center text-white">
                                            <iconify-icon icon="entypo:dots-three-vertical" class="icon "></iconify-icon>
                                        </button>
                                        <ul class="dropdown-menu p-12 border bg-base shadow">
                                            <li>
                                                <a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200
                                                text-hover-neutral-900 d-flex align-items-center gap-10" wire:click="toggleAddRefBalance">
                                                    Credit Account
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-danger-100
                                                text-hover-danger-600 d-flex align-items-center gap-10" wire:click="toggleSubRefBalance">
                                                    Debit Account
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="ps-16 pb-16 pe-16 text-center mt-5">
                                        <h6 class="text-lg mb-0 mt-4">Referral Balance</h6>
                                        <span class="text-secondary-light mb-16">
                                            {{$currency->sign}} {{number_format($user->referralBalance,2)}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if($showAddBalance)
        <div class="card mt-3 mb-4">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <h6 style="font-size: 12px;">Top-up Balance</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <form wire:submit.prevent="submitAddBalance" class="row g-3">
                            <div class="mb-2">
                                <p class="text-center text-success">
                                    You are about fund this merchant's account.
                                </p>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" wire:model.live="amount">
                                @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Authorization Pin</label>
                                <input type="password" class="form-control" id="state" wire:model.live="accountPin" minlength="6" maxlength="6">
                                @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-outline-success text-sm btn-sm radius-8">
                                <span>
                                    Fund Account Balance
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($showSubBalance)
        <div class="card mt-3 mb-4">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <h6 style="font-size: 12px;">Debit Balance</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <form wire:submit.prevent="submitSubBalance" class="row g-3">
                            <div class="mb-2">
                                <p class="text-center text-warning">
                                    You are about debit this merchant's account.
                                </p>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" wire:model.live="amount">
                                @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Authorization Pin</label>
                                <input type="password" class="form-control" id="state" wire:model.live="accountPin" minlength="6" maxlength="6">
                                @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-outline-warning text-sm btn-sm radius-8">
                                <span>
                                    Debit Account Balance
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($showAddRefBalance)
        <div class="card mt-3 mb-4">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <h6 style="font-size: 10px;">Top-up Referral Balance</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <form wire:submit.prevent="submitAddRefBalance" class="row g-3">
                            <div class="mb-2">
                                <p class="text-center text-primary">
                                    You are about fund this merchant's referral account.
                                </p>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" wire:model.live="amount">
                                @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Authorization Pin</label>
                                <input type="password" class="form-control" id="state" wire:model.live="accountPin" minlength="6" maxlength="6">
                                @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-outline-primary text-sm btn-sm radius-8">
                                <span>
                                    Fund Referral Balance
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($showSubRefBalance)
        <div class="card mt-3 mb-4">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <h6 style="font-size: 12px;">Debit Balance</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <form wire:submit.prevent="submitSubRefBalance" class="row g-3">
                            <div class="mb-2">
                                <p class="text-center text-info">
                                    You are about debit this merchant's account.
                                </p>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" wire:model.live="amount">
                                @error('amount') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label for="state" class="form-label">Authorization Pin</label>
                                <input type="password" class="form-control" id="state" wire:model.live="accountPin" minlength="6" maxlength="6">
                                @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-outline-info text-sm btn-sm radius-8">
                                <span>
                                    Debit Referral Balance
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Transaction -->
    <div class="card mt-3 mb-4">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <h6 style="font-size: 12px;">Transactions</h6>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search by Reference ID" wire:model.live.debounce.250ms="transactionSearch">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="transactionStatus">
                    <option value="all">All</option>
                    <option value="1">Completed</option>
                    <option value="2">Processing</option>
                    <option value="3">Issue</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            @if($transactions->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">
                                S.L
                            </th>
                            <th scope="col">Amount</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $index=>$transaction)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        {{ $transactions->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>{{$transaction->currency}}{{number_format($transaction->amount,2)}}</td>
                                <td>
                                    <span class="badge bg-primary">{{$transaction->reference}}</span>
                                </td>
                                <td>
                                    {{date('d-m-Y H-i-s',strtotime($transaction->created_at))}}
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
                                        @case(6)
                                            <span class="badge bg-dark">Balance Top-up</span>
                                            @break
                                        @case(7)
                                            <span class="badge bg-info">Referral Earning</span>
                                            @break
                                        @case(8)
                                            <span class="badge bg-dark">Refund</span>
                                            @break
                                        @case(9)
                                            <span class="badge bg-dark">Debit from Pending Balance</span>
                                            @break
                                        @case(10)
                                            <span class="badge bg-dark">Credit From Pending Balance</span>
                                            @break
                                        @case(11)
                                            <span class="badge bg-dark">Event Settlement</span>
                                            @break
                                        @case(12)
                                            <span class="badge bg-dark">Bonus Earning</span>
                                            @break
                                        @default
                                            <span class="badge bg-primary">Charge</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($transaction->status)
                                        @case(1)
                                            <span class="badge bg-success text-white">
                                                <i class="bx bx-checkbox-checked"
                                                   data-bs-toggle="tooltip" title="completed"
                                                   style="font-size: 15px;"></i>
                                            </span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-primary text-white">
                                                <i class="bx bx-loader-circle bx-spin" data-bs-toggle="tooltip" title="processing"
                                                   style="font-size: 15px;"></i>
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-danger text-white">
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
                    <div class="mt-5">
                        {{ $transactions->links() }}

                    </div>
                </div>

            @else
                <div class="row gy-4">
                    <div class="col-lg-12 col-sm-12">
                        <div
                            class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                            <h6 class="text-primary-light text-md mb-8 text-center">No Data found.</h6>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Withdrawals-->
    <div class="card mt-3">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <h6 style="font-size: 12px;">Payouts</h6>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search by Reference ID" wire:model.live.debounce.250ms="withdrawalSearch">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="withdrawalStatus">
                    <option value="all">All</option>
                    <option value="1">Completed</option>
                    <option value="2">Pending</option>
                    <option value="3">Cancelled</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            @if($withdrawals->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">
                                S.L
                            </th>
                            <th>Id</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($withdrawals as $index=>$withdrawal)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        {{ $withdrawals->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{$withdrawal->reference}}
                                    </span>
                                </td>
                                <td>
                                    {{$withdrawal->currency}}{{number_format($withdrawal->amount,2)}}
                                    <sup>({{$withdrawal->currency}}{{number_format($withdrawal->amountCredit,2)}})</sup>
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
                                <td>
                                    <a href="{{ route('staff.users.balance.payouts',['merchant'=>$user->reference,'id'=>$withdrawal->reference]) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle
                                    d-inline-flex align-items-center justify-content-center" wire:navigate>
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $withdrawals->links() }}

                    </div>
                </div>

            @else
                <div class="row gy-4">
                    <div class="col-lg-12 col-sm-12">
                        <div
                            class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                            <h6 class="text-primary-light text-md mb-8 text-center">No Data found.</h6>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
