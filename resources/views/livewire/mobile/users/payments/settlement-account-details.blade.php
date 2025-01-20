<div>
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Available Balance
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                            title="The total amount in your account balance which is can be withdrawn"></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3" data-bs-toggle="tooltip" title="{{currencySign($user->mainCurrency)}}{{ number_format($user->accountBalance,2) }}">
                            {{currencySign($user->mainCurrency)}}{{ shorten_number($user->accountBalance,2) }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Bank Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Bank Name --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Bank Name:</strong>
                    <p class="copyable" data-content="{{ $bank->bankName }}">{{ $bank->bankName }}</p>
                </div>

                {{-- Account Number --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Account Number:</strong>
                    <p class="copyable" data-content="{{ $bank->accountNumber }}"> {{ $bank->accountNumber }}</p>
                </div>

                {{-- Account Name --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Account Name:</strong>
                    <p class="copyable" data-content="{{ $bank->accountName }}">{{ $bank->accountName }}</p>
                </div>

                {{-- Currency --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Currency:</strong>
                    <p class="copyable" data-content="{{ $bank->currency }}">{{ $bank->currency }}</p>
                </div>

                {{-- Country --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Country:</strong>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('country/' . strtolower($bank->country->iso2) . '.png') }}" alt="{{ $bank->currency }}" width="24" class="me-2">
                        <p class="mb-0 copyable" data-content="{{ $bank->country->name }}">{{ $bank->country->name }}</p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Status:</strong>
                    @if($bank->status == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>

                {{-- Primary Account --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Primary Account:</strong>
                    @if($bank->isPrimary == 1)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </div>

                {{-- Created At --}}
                <div class="col-6 col-md-6 mb-3">
                    <strong>Created On:</strong>
                    <p>{{ $bank->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Meta Data Card (Displayed only if meta is meaningful) --}}
    @if(!empty($bank->meta) && json_decode($bank->meta, true) !== [])
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Additional Details</h5>
            </div>
            <div class="card-body">
                @php $metaData = json_decode($bank->meta, true); @endphp
                <div class="row">
                    @foreach($metaData as $key => $value)
                        <div class="col-6 col-md-6 mb-3">
                            <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                            <p class="copyable" data-content="{{ $value }}">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
