<div>
    @include('notifications')
    {{-- Scrollable Actions --}}
    <div class="scrollable-actions d-flex gap-3">
        <div>
            <div wire:loading wire:target="deactivateAccount, activateAccount,makePrimary,deleteAccount" class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        @if($bank->status == 1)
            <button wire:click="deactivateAccount" class="btn btn-warning">
                <i class="fa fa-ban"></i> Deactivate
            </button>
        @else
            <button wire:click="activateAccount" class="btn btn-success">
                <i class="fa fa-check"></i> Activate
            </button>
        @endif

        @if($bank->isPrimary != 1)
            <button wire:click="makePrimary" class="btn btn-info">
                <i class="fa fa-check-circle"></i> Make Primary
            </button>
        @endif

        <button data-bs-toggle="modal" data-bs-target="#withdrawModal" class="btn btn-primary">
            <i class="fa fa-wallet"></i> Withdraw
        </button>

        <button wire:click="deleteAccount" class="btn btn-danger">
            <i class="fa fa-trash"></i> Delete
        </button>

    </div>

    {{-- Withdrawal Modal --}}
    <div wire:ignore.self class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw Funds to this account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="processWithdrawal" id="addLocalSettlementAccount">
                        {{-- Success Message --}}
                        @if($showSuccess)
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $successMessage }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Amount Input --}}
                        <div class="mb-3">
                            <label class="form-label">Amount</label>
                            <div class="input-group">
                                <button type="button" class="input-group-text">{{ $user->mainCurrency }}</button>
                                <input type="number" class="form-control" placeholder="Enter Amount" step="0.01"
                                       wire:model.live.debounce.500ms="amount">
                            </div>

                            {{-- Inline Loader for Amount --}}
                            <div wire:loading wire:target="amount" class="spinner-border spinner-border-sm text-primary ms-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        {{-- Converted Amount --}}
                        <div class="mb-3">
                            <label class="form-label">Amount You'll Receive</label>
                            <div class="input-group">
                                <button type="button" class="input-group-text">{{ $bank->currency }}</button>
                                <input type="number" class="form-control" readonly step="0.001" wire:model="convertedAmount">
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <p class="mb-0">Processor Fee: <strong>{{ number_format($transferFee, 2) }} {{ $bank->currency }}</strong></p>
                                <p class="mb-0">Exchange Rate: <strong>1 {{ $bank->currency }} ≈ {{ number_format(1 / $exchangeRate, 2) }} {{ $user->mainCurrency }}</strong></p>
                            </div>
                        </div>

                        {{-- OTP Verification --}}
                        <div class="mb-3">
                            <label class="form-label">OTP</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" placeholder="Enter OTP"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2" wire:model="enteredOtp">
                                {{-- Send OTP Button --}}
                                @if(!$otpVerified)
                                    <button type="button" class="input-group-text sendOtp" id="basic-addon2" wire:click="sendOTP">Send OTP</button>
                                @endif
                                {{-- Verify OTP Button --}}
                                @if($otpSent && !$otpVerified)
                                    <button type="button" class="input-group-text verifyOtp" id="basic-addon2" wire:click="verifyOTP">Verify OTP</button>
                                @endif

                            </div>

                            {{-- Inline Spinner for Sending OTP --}}
                            <div wire:loading wire:target="sendOTP,verifyOTP" class="spinner-border spinner-border-sm text-primary ms-2" role="status">
                                <span class="visually-hidden">Sending...</span>
                            </div>
                        </div>


                        {{-- Password Field --}}
                        <div class="mb-3">
                            <label class="form-label">Account Password</label>
                            <input type="password" class="form-control" wire:model="password" required>
                        </div>

                        {{-- Error Message --}}
                        @if($showError)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errorMessage }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Submit Button with Spinner --}}
                        @if($otpVerified && !$showError)
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fa fa-paper-plane"></i> Withdraw
                                <div wire:loading wire:target="processWithdrawal" class="spinner-border spinner-border-sm text-light ms-2" role="status">
                                    <span class="visually-hidden">Processing...</span>
                                </div>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>
