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



</div>
