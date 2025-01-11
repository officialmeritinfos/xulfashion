@if(!$payout->is_international)
    <div class="modal fade" id="add-{{ strtolower($payoutCurrency->currency) }}-settlement" tabindex="-1" aria-labelledby="usdModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add {{ strtoupper($payoutCurrency->currency) }} Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('mobile.user.settlement.account.local-account.process') }}" method="POST" id="addLocalSettlementAccount">
                        @csrf
                        <input type="hidden" name="currency" value="{{ $payoutCurrency->currency }}">
                        <div class="col-md-12 mt-2" style="display: none;">
                            <label for="inputEmail4" class="form-label"></label>
                            <input value="{{ route('mobile.user.payments.payout-method.fetch-bank-by-country',['country'=>strtoupper($fiat->iso2)]) }}" class="bankLink">
                            <input value="{{$payoutCurrency->requires_destination_branch_code}}" class="hasBranch"
                                   name="hasBranch">
                            <input value="{{($payoutCurrency->currency=='NGN')?1:0}}" class="validateAccount" name="validateAccount" data-url="{{route('mobile.user.payments.payout-method.fetch-account-detail')}}">
                        </div>
                        {{-- Account Bank --}}
                        @if($payoutCurrency->requires_account_bank)
                            <div class="mb-3 bank">
                                <label for="account_bank" class="form-label">Account Bank</label>
                                <select class="form-control" id="account_bank" name="account_bank" required>

                                </select>
                            </div>
                            <input class="bankName" name="bankName" style="display: none;">
                        @endif
                        <div class="destination-inputs" style="display: none;">
                            {{-- Destination Branch Code --}}
                            @if($payoutCurrency->requires_destination_branch_code)
                                <div class="mb-3">
                                    <label for="destination_branch_code" class="form-label">Destination Branch Code</label>
                                    <select class="form-control" id="destination_branch_code" name="destination_branch_code" required>
                                    </select>
                                </div>

                                <input class="destinationName" name="destinationName" style="display: none;">
                            @endif
                        </div>
                        <div class="other-inputs" style="display: none;">
                            {{-- Account Number --}}
                            @if($payoutCurrency->requires_account_number)
                                <div class="mb-3">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="number" class="form-control" id="account_number" name="account_number" required>
                                </div>
                            @endif

                            <div class="mb-3 accountName" style="display: none;">
                                <label for="account_name" class="form-label">Beneficiary Name</label>
                                <input type="text" class="form-control" id="account_name" name="account_name" value="" readonly>
                            </div>


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

                            <div class="col-md-12 mt-2 otpSection">
                                <label for="inputEmail4" class="form-label">OTP</label>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Enter OTP"
                                           aria-label="Recipient's username" aria-describedby="basic-addon2" name="otp">
                                    <button type="button" class="input-group-text sendOtp" id="basic-addon2"
                                            data-otp="{{route('mobile.user.payments.payout-method.send-otp')}}"
                                    >Send OTP</button>
                                    <button type="button" class="input-group-text verifyOtp" id="basic-addon2" style="display: none;"
                                            data-otp-verify="{{ route('mobile.user.payments.payout-method.verify-otp') }}"
                                    >Verify OTP</button>
                                    <button type="button" class="input-group-text resendOTP" id="basic-addon2" style="display: none;"
                                            data-otp-resend="{{ route('mobile.user.payments.payout-method.send-otp') }}"
                                    >Resend OTP</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="inputEmail4" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="inputEmail4"
                                       required/>
                            </div>
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
        <script src="{{ asset('mobile/js/requests/payout-account.js') }}"></script>
    @endpush
@endif


@if($payout->is_international)
    <div class="modal fade" id="add-{{ strtolower($payoutCurrency->currency) }}-settlement" tabindex="-1" aria-labelledby="usdModalLabel" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add {{ strtoupper($payoutCurrency->currency) }} Account</h5>
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

                        <div class="col-md-12 mt-2">
                            <label for="inputEmail4" class="form-label">OTP</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="Enter OTP"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2" name="otp">
                                <button type="button" class="input-group-text sendOtp" id="basic-addon2"
                                        data-bs-otp="{{route('mobile.user.payments.payout-method.send-otp')}}">Send OTP</button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('mobile/js/requests/payout-account-international.js') }}"></script>
    @endpush
@endif
