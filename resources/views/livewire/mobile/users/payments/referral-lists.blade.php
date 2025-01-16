<div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search by transaction ID" wire:model.live.debounce.250ms="referralSearch">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($referrals->count())
                <div class="scrollable-table-container">
                    <table class="table table-striped align-middle text-center">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Date Joined</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($referrals as $index => $referral)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $referral->name }}</td>
                                <td>{{ $referral->user }}</td>
                                <td>{{ $referral->created_at->format('d M Y, h:i A') }}</td>
                                <td>
                                    @if($referral->isVerified==1)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $referrals->links() }}
                </div>
            @else
                <div class="text-center">
                    <p>No Referral Yet</p>
                </div>
            @endif
        </div>
    </div>
</div>
