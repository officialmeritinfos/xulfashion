<div>
    <div class="card h-100 p-0 radius-12 mb-5">

        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <h6 class="text-lg fw-semibold mb-0">Metrics</h6>
                <select  class="form-select form-select-sm w-auto" id="currency" wire:model.live="targetCurrency">
                    @foreach ($availableCurrencies as $currency)
                        <option value="{{ $currency }}">{{ strtoupper($currency) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="duration">
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                    <option value="custom">Custom</option>
                </select>
                @if ($duration == 'custom')
                    <input type="date" class="form-control form-control-sm w-auto" wire:model.live="customStartDate">
                    <input type="date" class="form-control form-control-sm w-auto" wire:model.live="customEndDate">
                @endif
                <div>
                    <div wire:loading wire:target="targetCurrency, duration,customStartDate,customEndDate" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body p-24">

            <div class="row gy-4 justify-content-center mb-3">

                <div class="col-xxl-6 col-sm-6">
                    <div class="card p-3 shadow-none radius-8 border h-100 bg-gradient-end-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="mb-0 w-48-px h-48-px bg-success-600 flex-shrink-0 text-white d-flex justify-content-center
                                        align-items-center rounded-circle h6 mb-0">
                                        <iconify-icon icon="vaadin:money-deposit" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-sm">Total Account Funding</span>
                                        <h6 class="fw-semibold">{{currencySign($targetCurrency)}}{{ $totalDeposit }}</h6>
                                    </div>
                                </div>
                                <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-sm-6">
                    <div class="card p-3 shadow-none radius-8 border h-100 bg-gradient-end-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                        <iconify-icon icon="vaadin:money-deposit" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-sm">Total Deposits</span>
                                        <h6 class="fw-semibold">{{ $totalDepositCount }}</h6>
                                    </div>
                                </div>
                                <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gy-4">

                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-none radius-8 border h-100 bg-gradient-end-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                        <iconify-icon icon="vaadin:money-deposit" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-sm">Pending Funding</span>
                                        <h6 class="fw-semibold">{{ $pendingFundingCount }}</h6>
                                    </div>
                                </div>
                                <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                            <p class="text-sm mb-0">
                                {{ $pendingFundingIncrease >= 0 ? 'Increase' : 'Decrease' }} by
                                <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                                    {{ $pendingFundingIncrease }}
                                </span>
                                {{ $duration=='today'?$duration:'this '.$duration }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-none radius-8 border h-100 bg-gradient-end-2">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                        <iconify-icon icon="vaadin:money-deposit" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-sm">Completed Funding</span>
                                        <h6 class="fw-semibold">{{ $completedFundingsCount }}</h6>
                                    </div>
                                </div>
                                <div id="active-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                            <p class="text-sm mb-0">
                                {{ $completedFundingIncrease >= 0 ? 'Increase' : 'Decrease' }} by
                                <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                                    {{ $completedFundingIncrease }}
                                </span>
                                {{ $duration=='today'?$duration:'this '.$duration }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-5">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Failed Funding</p>
                                    <h6 class="mb-0">{{ $failedDepositsCount }}</h6>
                                </div>
                                <div
                                    class="w-50-px h-50-px bg-red rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="vaadin:money-deposit" class="text-base text-2xl mb-0"></iconify-icon>
                                </div>
                            </div>
                            <p class="text-sm mb-0">
                                {{ $failedFundingIncrease >= 0 ? 'Increase' : 'Decrease' }} by
                                <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">
                                    {{ $failedFundingIncrease }}
                                </span>
                                {{ $duration=='today'?$duration:'this '.$duration }}
                            </p>
                        </div>
                    </div><!-- card end -->
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search by Reference Or IDs" wire:model.live.debounce.250ms="search">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="status">
                    <option value="all">All</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>
        </div>

        <div class="card-body">
            @if($deposits->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">
                                S.L
                            </th>
                            <th scope="col">Merchant</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Channel</th>
                            <th scope="col">Date Made</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($deposits as $index=>$deposit)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $deposit->users->name }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ $deposit->currency }} {{ number_format($deposit->amount) }}
                                    </div>
                                </td>
                                <td><span class="text-primary-600">{{ $deposit->reference }}</span></td>
                                <td>{{ $deposit->channel }}</td>
                                <td>{{ date('F d, Y h:i:s', strtotime($deposit->created_at)) }}</td>
                                <td>
                                    @switch($deposit->status)
                                        @case(1)
                                            <span
                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Successful</span>
                                            @break
                                        @case(2)
                                            <span
                                                class="bg-primary-focus text-primary-main px-24 py-4 rounded-pill fw-medium text-sm">Pending</span>
                                            @break
                                        @case(4)
                                            <span
                                                class="bg-info-focus text-info-main px-24 py-4 rounded-pill fw-medium text-sm">Processing</span>
                                            @break
                                        @default
                                            <span
                                                class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('staff.users.detail',['id'=>$deposit->reference]) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle
                                        d-inline-flex align-items-center justify-content-center" wire:navigate>
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    @can('update User')
                                        <a href="javascript:void(0)"
                                           class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                    @endcan
                                    @can('delete User')
                                        <a href="javascript:void(0)"
                                           class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $deposits->links() }}

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
