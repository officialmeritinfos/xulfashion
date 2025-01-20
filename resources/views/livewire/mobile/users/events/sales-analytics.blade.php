<div>

    <!-- Sales History -->
    <div class="mb-3">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Sales</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="icon-field">
                        <input type="text" class="form-control form-control-sm w-auto"
                               placeholder="Search by transaction ID" wire:model.live.debounce.250ms="salesSearch">
                        <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <select class="form-select form-select-sm w-auto" wire:model.live="salesPerPage">
                        <option>1</option>
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div wire:loading wire:target="salesPerPage, salesSearch" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="card-body">
                @if($purchases->count())
                    <div class="scrollable-table-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Buyer</th>
                                <th>Reference</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $index => $purchase)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>
                                        {{ $purchase->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td>
                                        {{$purchase->users->name}}
                                    </td>
                                    <td>
                                        {{$purchase->reference}}
                                    </td>
                                    <td>
                                        {{currencySign($purchase->purchaseCurrency)}}{{number_format($purchase->price,2)}}
                                    </td>

                                    <td>
                                        @switch($purchase->paymentStatus)
                                            @case(1)
                                                <span class="badge bg-success" data-bs-toggle="tooltip" title="completed">
                                                        <i class="fa fa-check-square"></i>
                                                    </span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-primary" data-bs-toggle="tooltip" title="pending">
                                                        <i class="fa fa-info-circle"></i>
                                                    </span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-info" data-bs-toggle="tooltip" title="processing">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </span>
                                                @break
                                            @case(3)
                                                <span class="badge bg-warning" data-bs-toggle="tooltip" title="Cancelled">
                                                        <i class="fa fa-close"></i>
                                                    </span>
                                                @break
                                            @case(5)
                                                <span class="badge bg-warning" data-bs-toggle="tooltip" title="Cancelled By Compliance">
                                                        <i class="fa fa-warning"></i>
                                                    </span>
                                                @break
                                            @default
                                                <span class="badge bg-danger" data-bs-toggle="tooltip" title="Failed">
                                                        <i class="fa fa-sad-tear"></i>
                                                    </span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{route('mobile.user.events.sales.purchase-detail',['event'=>$event->reference,'purchase'=>$purchase->reference])}}">
                                            <i class="fa fa-arrow-circle-o-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-0">
                        <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        {{ $purchases->links() }}

                    </div>
                @else
                    <p>No Sales transactions found for this event.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Settlement History Section -->
    <div class="mb-3">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Settlement History</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="icon-field">
                        <input type="text" class="form-control form-control-sm w-auto"
                               placeholder="Search by transaction ID" wire:model.live.debounce.250ms="search">
                        <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <select class="form-select form-select-sm w-auto" wire:model.live="perPage">
                        <option>1</option>
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
                @if($settlements->count())
                    <div class="scrollable-table-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>ID</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settlements as $key => $settlement)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        {{$settlement->reference}}
                                    </td>
                                    <td>
                                        {{ucfirst($settlement->payoutAccount)}}
                                    </td>
                                    <td>
                                        {{currencySign($settlement->currency)}}{{number_format($settlement->amount,2)}}
                                    </td>
                                    <td>
                                        {{ $settlement->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td>
                                        @switch($settlement->payoutStatus)
                                            @case(1)
                                                <span class="badge bg-success" data-bs-toggle="tooltip" title="completed">
                                                            <i class="fa fa-check-square"></i>
                                                        </span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-primary" data-bs-toggle="tooltip" title="pending">
                                                        <i class="fa fa-info-circle"></i>
                                                    </span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-info" data-bs-toggle="tooltip" title="processing">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </span>
                                                @break
                                            @case(3)
                                                <span class="badge bg-warning" data-bs-toggle="tooltip" title="Cancelled">
                                                        <i class="fa fa-close"></i>
                                                    </span>
                                                @break
                                            @case(5)
                                                <span class="badge bg-warning" data-bs-toggle="tooltip" title="Cancelled By Compliance">
                                                        <i class="fa fa-warning"></i>
                                                    </span>
                                                @break
                                            @default
                                                <span class="badge bg-danger" data-bs-toggle="tooltip" title="Failed">
                                                        <i class="fa fa-sad-tear"></i>
                                                    </span>
                                                @break
                                        @endswitch

                                    </td>
                                    <td>
                                        <i class="fa fa-arrow-circle-o-right" wire:click="viewDetails('{{ $settlement->reference }}')"
                                           data-bs-toggle="offcanvas" data-bs-target="#settlementCanvas"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-0">
                        <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        {{ $settlements->links() }}

                    </div>
                @else
                    <p>No settlement transactions found for this event.</p>
                @endif

            </div>
        </div>
    </div>

    <!-- Offcanvas for Withdrawal Details -->
    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="settlementCanvas" aria-labelledby="settlementDetails">
        <div class="offcanvas-header bg-dark text-white">
            <h5 id="withdrawalDetailsLabel">Settlement Details</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if($settlementDetail)
                <!-- Transaction Details Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Transaction Summary</h5>
                        <span class="badge {{ $settlementDetail->payoutStatus == 1 ? 'bg-success' : ($settlementDetail->payoutStatus == 2 ? 'bg-warning' : 'bg-danger') }}">
                    @switch($settlementDetail->payoutStatus)
                                @case(1)
                                    Completed
                                    @break
                                @case(2)
                                    Pending
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
                                <p class="fw-bold text-muted mb-0">{{ $settlementDetail->reference }}</p>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('{{ $settlementDetail->reference }}')">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>

                        <!-- Amount -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-wallet me-2"></i>Amount</h6>
                                <p class="fw-bold text-muted mb-0">{{ $settlementDetail->currency }}{{ number_format($settlementDetail->amount, 2) }}</p>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1"><i class="fa fa-exchange-alt me-2"></i>Amount You Received</h6>
                                <p class="fw-bold text-muted mb-0">{{ $settlementDetail->toCurrency }}{{ number_format($settlementDetail->convertedAmount, 2) }}</p>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-1"><i class="fa fa-calendar-alt me-2"></i>Date of Transaction</h6>
                            <p class="fw-bold text-muted mb-0">{{ date('D, d M Y H:i:s', strtotime($settlementDetail->created_at)) }}</p>
                        </div>

                        <!-- Status -->
                        <div class="text-center mt-4">
                    <span class="badge py-2 px-3 {{ $settlementDetail->status == 1 ? 'bg-success' : ($settlementDetail->status == 2 ? 'bg-warning' : 'bg-danger') }}">
                        @switch($settlementDetail->status)
                            @case(1)
                                <i class="fa fa-check-circle me-1"></i> Completed
                                @break
                            @case(2)
                                <i class="fa fa-clock me-1"></i> Pending
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
