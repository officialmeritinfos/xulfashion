<div>
    <section>
        <div class="custom-container">
            <ul class="notification-setting">
                <div wire:loading wire:target="updateEmailNotification,updatePush,updateNewsletter,updateWithdrawal,updateDeposit" class="spinner-border text-primary"
                     role="status"
                     style="width: 1.5rem; height: 1.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <li>
                    <div class="notification pt-0">
                        <h5 class="fw-semibold theme-color">Email Notifications</h5>
                        <div class="switch-btn">
                            <input type="checkbox" wire:model.live="emailNotification" wire:change="updateEmailNotification"
                                   wire:loading.attr="disabled"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="notification pt-0">
                        <h5 class="fw-semibold theme-color">Push Notification</h5>
                        <div class="switch-btn">
                            <input type="checkbox" wire:model.live="push" wire:change="updatePush" wire:loading.attr="disabled"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="notification pt-0">
                        <h5 class="fw-semibold theme-color">Receive Newsletters</h5>
                        <div class="switch-btn">
                            <input type="checkbox" wire:model.live="newsletter" wire:change="updateNewsletter" wire:loading.attr="disabled"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="notification pt-0">
                        <h5 class="fw-semibold theme-color">Withdrawal Notifications</h5>
                        <div class="switch-btn">
                            <input type="checkbox" wire:model.live="withdrawal" wire:change="updateWithdrawal" wire:loading.attr="disabled"/>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="notification pt-0">
                        <h5 class="fw-semibold theme-color">Deposit Notifications</h5>
                        <div class="switch-btn">
                            <input type="checkbox" wire:model.live="deposit" wire:change="updateDeposit" wire:loading.attr="disabled"/>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>


    <section>
        <div class="custom-container">
            <ul class="notification-setting">
                <div wire:loading wire:target="updateTwoFactor" class="spinner-border text-primary"
                     role="status"
                     style="width: 1.5rem; height: 1.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <li>
                    @if(!$showOtpForm)
                        <div class="notification pt-0">
                            <h5 class="fw-semibold theme-color">Two-Factor Authentication</h5>
                            <div class="switch-btn">
                                <input type="checkbox" wire:model.live="twoFactor" wire:change="updateTwoFactor"
                                       wire:loading.attr="disabled"/>
                            </div>
                        </div>
                    @else
                        <form class="address-form" wire:submit.prevent="processTwoFactorUpdate">
                            @if($showError)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p style="font-size: 12px;">{{ $errorMessage }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            {{-- Success Message --}}
                            @if($showSuccess)
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <p style="font-size: 12px;">{{ $successMessage }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="form-group">

                                <label class="form-label">OTP</label>
                                <div class="input-group mb-3">
                                    <input  type="number" class="form-control" placeholder="Enter OTP from your email" wire:model="enteredOtp" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"
                                          wire:click.prevent="resendOtp" wire:loading.attr="disabled">
                                         <span wire:loading.remove>Resend OTP</span>
                                        <span wire:loading>Resending...</span>
                                    </span>
                                </div>
                            </div>


                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>{{ $twoFactorText }}</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button type="button" wire:click.prevent="cancelAction" class="btn btn-outline-secondary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Cancel</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </li>

            </ul>
        </div>
    </section>



</div>
