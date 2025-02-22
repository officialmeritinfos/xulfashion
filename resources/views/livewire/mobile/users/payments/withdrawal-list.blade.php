<div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Payout Transactions</h5>
        </div>
    </div>

    {{-- Search & Export --}}
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search by transaction ID" wire:model.live.debounce.250ms="withdrawSearch">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="perPage">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                    <option>100</option>
                </select>
            </div>
            <div wire:loading wire:target="perPage, search" class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="card-body">
            @if($transactions->count())
                <div class="scrollable-table-container">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>AMOUNT</th>
                            <th>BANK</th>
                            <th>ACCOUNT NAME</th>
                            <th>ACCOUNT NUMBER</th>
                            <th>DATE</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $withdrawal)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{$withdrawal->reference}}
                                        </span>
                                    </td>
                                    <td>
                                        {{$withdrawal->fiats->sign}}{{number_format($withdrawal->amount,2)}}
                                        ({{$withdrawal->fiatTos->sign}}{{number_format($withdrawal->amountCredit,2)}})
                                    </td>
                                    <td>
                                        {{ $withdrawal->banks->bankName }}
                                    </td>
                                    <td>
                                        {{ $withdrawal->banks->accountName }}
                                    </td>
                                    <td>
                                        {{ $withdrawal->banks->accountNumber }}
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
                                            @case(4)
                                                <span class="badge bg-info">Sent</span>
                                                @break
                                            @default
                                                <span class="badge bg-danger">Cancelled</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <i class="fa fa-arrow-circle-o-right"
                                           wire:click="viewDetails('{{ $withdrawal->reference }}')" data-bs-toggle="offcanvas"
                                           data-bs-target="#withdrawalDetailsCanvas"></i>
                                        <i class="fa fa-arrow-circle-o-right"
                                           wire:click="viewDetails('{{ $withdrawal->reference }}')" data-bs-toggle="offcanvas"
                                           data-bs-target="#withdrawalDetailsCanvas"></i>
                                        <i class="fa fa-arrow-circle-o-right"
                                           wire:click="viewDetails('{{ $withdrawal->reference }}')" data-bs-toggle="offcanvas"
                                           data-bs-target="#withdrawalDetailsCanvas"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    {{ $transactions->links() }}
                </div>
            @else
                <p>No Payout Record found</p>
            @endif
        </div>
    </div>

    <!-- Offcanvas for Withdrawal Details -->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="withdrawalDetailsCanvas" aria-labelledby="withdrawalDetailsLabel">
        <div class="offcanvas-header bg-dark text-white">
            <h5 id="withdrawalDetailsLabel">Withdrawal Details</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if($selectedWithdrawal)
                <!-- Transaction Details Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Transaction Summary</h5>
                        <span class="badge {{ $selectedWithdrawal->status == 1 ? 'bg-success' : ($selectedWithdrawal->status == 2 ? 'bg-warning' : 'bg-danger') }}">
                    @switch($selectedWithdrawal->status)
                                @case(1)
                                    Completed
                                    @break
                                @case(2)
                                    Under Review
                                    @break
                                @case(4)
                                    Sent
                                    @break
                                @default
                                    Cancelled
                                    @break
                            @endswitch
                </span>
                    </div>
                    <div class="card-body">
                        <!-- Transaction Reference -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-hashtag me-2"></i>Transaction Reference</h6>
                                <p class="fw-bold text-muted mb-0">{{ $selectedWithdrawal->reference }}</p>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('{{ $selectedWithdrawal->reference }}')">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>

                        <!-- Amount -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-wallet me-2"></i>Amount</h6>
                                <p class="fw-bold text-muted mb-0">{{ $selectedWithdrawal->fiats->sign }}{{ number_format($selectedWithdrawal->amount, 2) }}</p>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-exchange-alt me-2"></i>Converted Amount</h6>
                                <p class="fw-bold text-muted mb-0">{{ $selectedWithdrawal->fiatTos->sign }}{{ number_format($selectedWithdrawal->convertedAmount, 2) }}</p>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-wallet me-2"></i>Amount You'll Receive</h6>
                                <p class="fw-bold text-muted mb-0">{{ $selectedWithdrawal->fiats->sign }}{{ number_format($selectedWithdrawal->amountCredit, 2) }}</p>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-flag me-2"></i>Processor Fee</h6>
                                <p class="fw-bold text-muted mb-0">{{ $selectedWithdrawal->fiatTos->sign }}{{ number_format($selectedWithdrawal->convertedAmount - $selectedWithdrawal->amountCredit, 2) }}</p>
                            </div>
                        </div>

                        <!-- Bank Details -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2"><i class="fa fa-university me-2"></i>Bank Details</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Bank:</strong> {{ $selectedWithdrawal->banks->bankName }}</li>
                                <li class="list-group-item"><strong>Account Name:</strong> {{ $selectedWithdrawal->banks->accountName }}</li>
                                <li class="list-group-item"><strong>Account Number:</strong> {{ $selectedWithdrawal->banks->accountNumber }}</li>
                            </ul>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-1"><i class="fa fa-calendar-alt me-2"></i>Date of Withdrawal</h6>
                            <p class="fw-bold text-muted mb-0">{{ date('D, d M Y H:i:s', strtotime($selectedWithdrawal->created_at)) }}</p>
                        </div>

                        <!-- Status -->
                        <div class="text-center mt-4">
                    <span class="badge py-2 px-3 {{ $selectedWithdrawal->status == 1 ? 'bg-success' : ($selectedWithdrawal->status == 2 ? 'bg-warning' : 'bg-danger') }}">
                        @switch($selectedWithdrawal->status)
                            @case(1)
                                <i class="fa fa-check-circle me-1"></i> Completed
                                @break
                            @case(2)
                                <i class="fa fa-clock me-1"></i> Under Review
                                @break
                            @case(4)
                                <i class="fa fa-clock me-1"></i>  Sent
                                @break
                            @default
                                <i class="fa fa-times-circle me-1"></i> Cancelled
                                @break
                        @endswitch
                    </span>
                        </div>
                    </div>
                </div>
            @endif
                <div wire:loading>
                    <p>Loading details...</p>
                </div>
        </div>
    </div>


</div>
