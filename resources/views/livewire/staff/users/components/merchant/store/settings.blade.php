<div>
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <form wire:submit.prevent="submit" enctype="multipart/form-data">
                    <div class="submit-property-form product-upload mt-3">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="notifications"  wire:model.live="notifications">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="notifications">
                                            Receive notifications
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="Receive notifications for activities done by customers on your store."></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="newsletter"  wire:model.live="newsletter">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="newsletter">
                                            Allow Newsletters signup
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="Allow your customers to join newsletters on your store - that is if you offer one."></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="signups"  wire:model.live="signups">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="signups">
                                            Allow signups on store
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="This will automatically create an account for your customers on your store"></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="collectPhone"  wire:model.live="collectPhone">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="collectPhone">
                                            Collect customer's phone number upon checkout
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="In addition to other details which we will collect by default, your customers contact number will be required"></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="collectPayment"  wire:model.live="collectPayment">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="collectPayment">
                                            Allow your customers to pay online
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="By default, your customers pay online - you can however turn this option off and they will have to contact your
                                   for their orders. If your business is not verified, payments received will be kept pending and not released to your  until
                                   you have verified your business."></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="whatsappPayment"  wire:model.live="whatsappPayment">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="whatsappPayment">
                                            Allow your customers to checkout on Whatsapp
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="This allows your customers to be redirected to Whatsapp where they can complete their purchase."></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3" style="{{ $whatsappPayment ? '' : 'display: none;' }}">
                                    <label for="inputState" class="form-label">Whatsapp Number<sup class="text-danger">*</sup>
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="The Whatsapp number where your users will be redirected to including the country code. e.g 234902345786"></i>
                                    </label>
                                    <input type="text" class="form-control" id="price" placeholder="Whatsapp contact" wire:model.live="whatsappNumber">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="whatsappSupport"  wire:model.live="whatsappSupport">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="whatsappSupport">
                                            Offer Whatsapp Support
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="This is your helpdesk for customers on Whatsapp. Activate it to enable your customers to contact you on whatsapp."></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3" style="{{ $whatsappSupport ? '' : 'display: none;' }}">
                                    <label for="inputState" class="form-label">Whatsapp Support Number<sup class="text-danger">*</sup>
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="The Whatsapp number where your users will be redirected to including the country code. e.g 234902345786"></i>
                                    </label>
                                    <input type="text" class="form-control" id="price" placeholder="Whatsapp contact" wire:model.live="whatsappSupportNumber">
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="escrowPayment"  wire:model.live="escrowPayment">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="escrowPayment">
                                            Enable Escrow Checkout
                                            <i class="ri-information-fill" data-bs-toggle="tooltip"
                                               title="Enable escrow payment. Escrow payment helps you build confidence in your customer such that you will
                                   deliver what they have paid. Payments received are held in confidence until order has been fulfilled. "></i>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="inputState" class="form-label">Default Buy Text<sup class="text-danger">*</sup>
                                        <i class="ri-information-fill" data-bs-toggle="tooltip"
                                           title="This text will display instead of the default Add to cart text"></i>
                                    </label>
                                    <input type="text" class="form-control" id="price" placeholder="Default Add to Cart Text" wire:model.live="defaultBuyText">
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-outline-success rounded submit">
                                Update settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
