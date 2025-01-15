<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Withdrawal Transactions</h5>
        </div>
    </div>

    {{-- Search & Export --}}
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
                <div class="scrollable-actions">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th> ID</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                                <td>{{ number_format($transaction->amount, 2) }} {{ $bank->currency }}</td>
                                <td>
                                    @switch($transaction->status)
                                        @case(1)
                                            <span class="badge bg-success">
                                                                        <i class="fa fa-check-square"
                                                                           data-bs-toggle="tooltip" title="completed"
                                                                           style="font-size: 15px;"></i>
                                                                    </span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-primary"><i class="fa fa-spinner fa-spin"
                                                                              data-bs-toggle="tooltip" title="processing"
                                                                              style="font-size: 15px;"></i></span>
                                            @break
                                        @default
                                            <span class="badge bg-danger">
                                                                        <i class="fa fa-sad-tear"
                                                                           data-bs-toggle="tooltip" title="Failed"
                                                                           style="font-size: 15px;"></i>
                                                                    </span>
                                            @break
                                    @endswitch

                                </td>
                                <td>{{ $transaction->reference }}</td>
                                <td>
                                    <i class="fa fa-arrow-circle-o-right"></i>
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
                    {{ $transactions->links() }}

                </div>
            @else
                <p>No withdrawal transactions found for this account.</p>
            @endif
        </div>
    </div>
</div>
