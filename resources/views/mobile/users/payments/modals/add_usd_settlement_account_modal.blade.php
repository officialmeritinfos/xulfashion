<div class="modal fade" id="add-usd-settlement" tabindex="-1" aria-labelledby="usdModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add USD Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('mobile.user.settlement.account.usd-account.process') }}" method="POST"
                id="addUSDSettlementAccount">
                    @csrf
                    <input type="hidden" name="currency" value="{{ $usdPayoutCurrency->currency }}">
                    {{-- Account Bank --}}
                    @if($payoutCurrency->requires_account_bank)
                        <div class="mb-3">
                            <label for="account_bank" class="form-label">Account Bank</label>
                            <input type="text" class="form-control" id="account_bank" name="account_bank" required>
                        </div>
                    @endif
                    {{-- Account Number --}}
                    @if($usdPayoutCurrency->requires_account_number)
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="account_number" name="account_number" required>
                        </div>
                    @endif

                    {{-- Additional Fields from Meta --}}
                    @if(!empty($usdPayoutCurrency->meta))
                        @php
                            $metaUSDFields = json_decode($usdPayoutCurrency->meta, true);
                        @endphp
                        @foreach($metaUSDFields['fields'] ?? [] as $field)
                            <div class="mb-3">
                                <label for="{{ $field }}" class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" required>
                            </div>
                        @endforeach
                    @endif

                    <div class="col-md-12 mt-2 otpSection">
                        <label for="inputEmail4" class="form-label">OTP</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control otp" placeholder="Enter OTP"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2" name="otp">
                            <button type="button" class="input-group-text sendOtpUSD" id="basic-addon2"
                                    data-otp="{{route('mobile.user.payments.payout-method.send-otp')}}"
                            >Send OTP</button>
                            <button type="button" class="input-group-text verifyOtpUSD" id="basic-addon2" style="display: none;"
                                    data-otp-verify="{{ route('mobile.user.payments.payout-method.verify-otp') }}"
                            >Verify OTP</button>
                            <button type="button" class="input-group-text resendOTPUSD" id="basic-addon2" style="display: none;"
                                    data-otp-resend="{{ route('mobile.user.payments.payout-method.send-otp') }}"
                            >Resend OTP</button>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label for="inputEmail4" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputEmail4"
                               required/>
                    </div>

                    <div class="submit-btn" style="display: none;">
                        <button type="submit" class="btn theme-btn w-100 submit">
                            <i class="fa fa-plus-square"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('mobile/js/requests/payout-account-usd.js') }}"></script>
@endpush
