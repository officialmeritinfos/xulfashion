<div>
    {{-- Search Bar --}}
    <div class="row mb-2">
        <div class="col-md-11">
            <input type="text" wire:model.live.debounce.500ms="search" class="form-control rounded-pill shadow-sm" placeholder="🔍 Search by bank name or account number...">
        </div>
        {{-- Loading Spinner for Search --}}
        <div class="col-md-1 d-flex align-items-center">
            <div wire:loading wire:target="search" class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    @if($banks->count())
        {{-- Bank Accounts Table --}}
        <div class="table-responsive">
            <table class="table table-striped custom-table align-middle shadow-sm rounded-3 overflow-hidden">
                <thead>
                <tr>
                    <th>Bank</th>
                    <th>Account Number</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banks as $bank)
                    <tr>
                        {{-- Bank Name with Status Icon --}}
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-2">
                                    <img src="{{ asset('country/' . strtolower($bank->country->iso2) . '.png') }}" alt="Country Flag" class="rounded-circle" width="35">
                                </div>
                                <div>
                                    <strong>{{ $bank->bankName }}</strong>

                                    {{-- Status Icon with Tooltip --}}
                                    @if($bank->status == 1)
                                        <i class="fa fa-check-circle text-success ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Active"></i>
                                    @else
                                        <i class="fa fa-times-circle text-danger ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive"></i>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Masked Account Number --}}
                        <td>
                             {{ $bank->accountNumber }}
                        </td>

                        {{-- Action Icon --}}
                        <td class="text-end">
                            <a href="{{ route('mobile.user.settlement.account.details', ['bank' => $bank->reference]) }}"
                               class="btn btn-sm btn-outline-primary shadow-sm"
                               title="View Full Details">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3 d-none d-sm-block">
            <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            {{ $banks->links() }}
        </div>
        <div class="mt-3 d-flex justify-content-center d-sm-none">
            <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            {{ $banks->links() }}
        </div>
    @else
        <div class="alert alert-warning text-center shadow-sm">
            <i class="fa fa-exclamation-circle"></i> No bank accounts found.
        </div>
    @endif
</div>
