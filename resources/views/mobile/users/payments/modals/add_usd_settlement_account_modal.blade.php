<div class="modal fade" id="add-usd-settlement" tabindex="-1" aria-labelledby="usdModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add USD Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/') }}" method="POST">
                    @csrf
                    <input type="hidden" name="currency" value="{{ $payoutCurrency->currency }}">
                    {{-- Account Number --}}
                    @if($payoutCurrency->requires_account_number)
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="account_number" name="account_number" required>
                        </div>
                    @endif

                    {{-- Additional Fields from Meta --}}
                    @if(!empty($payoutCurrency->meta))
                        @php
                            $metaFields = json_decode($payoutCurrency->meta, true);
                        @endphp
                        @foreach($metaFields['fields'] ?? [] as $field)
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" required>
                            </div>
                        @endforeach
                    @endif

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('mobile/js/requests/payout-account-international.js') }}"></script>
@endpush
