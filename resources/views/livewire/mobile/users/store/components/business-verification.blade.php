<div>
    <div class="container py-5">
        @if($status == 1)
            <!-- Verified State -->
            <div class="alert alert-success d-flex align-items-center shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                <div>
                    <h5 class="mb-1">Business Verified!</h5>
                    <p class="mb-0">Congratulations! Your business has been successfully verified. You now have full access to all platform features and services.</p>
                </div>
            </div>
        @elseif($status == 2 || $status==3)
            <!-- Pending Submission State -->
            @if($verification)
                <div class="alert alert-warning d-flex align-items-center shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2 fs-4"></i>
                    <div>
                        <h5 class="mb-1">Submission was rejected!</h5>
                        <p class="mb-0">
                            {!! $verification->rejectReason !!}
                        </p>
                    </div>
                </div>
            @endif
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    Submit Verification Details
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submitVerification" class="row g-4">
                        @include('notifications')
                        @if($currentStep == 1)
                            <div class="col-md-12">
                                <label for="legalName" class="form-label">Legal Business Name<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="legalName" wire:model.live.debounce.250ms="legalName" placeholder="Enter your registered business name">
                                @error('legalName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="button" wire:click="nextStep" wire:loading.attr="disabled" class="btn btn-outline-primary mt-0 w-100 submit mb-3 btn-auto">
                                    <span wire:loading.remove>Next</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Loading...</span>
                                </button>
                            </div>
                        @elseif($currentStep == 2)
                            <div class="col-md-12">
                                <label for="regNumber" class="form-label">Registration Number<sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="regNumber" placeholder="xxxx-xxxx-xxxx" wire:model.live.debounce.250ms="regNumber">
                                @error('regNumber') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="doingBusinessAs" class="form-label">Doing Business As (DBA)</label>
                                <input type="text" class="form-control" id="doingBusinessAs" wire:model.live.debounce.250ms="doingBusinessAs">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" wire:click="prevStep" wire:loading.attr="disabled" class="btn btn-outline-secondary mt-0  submit mb-3 btn-auto">
                                    <span wire:loading.remove>Previous</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Loading...</span>
                                </button>
                                <button type="button" wire:click="nextStep" wire:loading.attr="disabled" class="btn btn-outline-primary mt-0  submit mb-3 btn-auto">
                                    <span wire:loading.remove>Next</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Loading...</span>
                                </button>
                            </div>
                        @elseif($currentStep == 3)
                            <div class="col-12">
                                <label for="address" class="form-label">Address<sup class="text-danger">*</sup></label>
                                <textarea class="form-control" id="address" placeholder="1234 Main St" wire:model.live.debounce.250ms="address"></textarea>
                                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" wire:click="prevStep" wire:loading.attr="disabled" class="btn btn-outline-secondary mt-0  submit mb-3 btn-auto">
                                    <span wire:loading.remove>Previous</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Loading...</span>
                                </button>
                                <button type="button" wire:click="nextStep" wire:loading.attr="disabled" class="btn btn-outline-primary mt-0  submit mb-3 btn-auto">
                                    <span wire:loading.remove>Next</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Loading...</span>
                                </button>
                            </div>
                        @elseif($currentStep == 4)
                            <div class="col-md-12">
                                <label for="regCert" class="form-label">Registration Certificate<sup class="text-danger">*</sup></label>
                                <input type="file" class="form-control" id="regCert" wire:model.live.debounce.250ms="regCert">
                                @error('regCert') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <label for="addressProof" class="form-label">Proof of Address<sup class="text-danger">*</sup></label>
                                <input type="file" class="form-control" id="addressProof" wire:model.live="addressProof">
                                @error('addressProof') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" wire:click="prevStep" wire:loading.attr="disabled" class="btn btn-outline-secondary mt-0  submit mb-3 btn-auto">
                                    <span wire:loading.remove>Previous</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Loading...</span>
                                </button>
                                <button type="submit" wire:loading.attr="disabled" class="btn btn-outline-success mt-0  submit mb-3 btn-auto">
                                    <span wire:loading.remove>Submit</span>
                                    <span wire:loading><i class="spinner-border spinner-border-sm"></i> Submitting...</span>
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        @elseif($status == 4)
            <!-- Under Review State -->
            <div class="alert alert-info d-flex align-items-center shadow-sm" role="alert">
                <i class="bi bi-hourglass-split me-2 fs-4"></i>
                <div>
                    <h5 class="mb-1">Verification in Progress</h5>
                    <p class="mb-0">Your verification details have been received and are currently under review. This process may take up to 1-2 business days.</p>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    Verification Progress
                </div>
                <div class="card-body">
                    <p><strong>Submission Date:</strong> {{ $verification->created_at->format('d M Y, h:i A') }}</p>
                    <p><strong>Current Status:</strong> Under Review</p>
                    <div class="progress mt-3" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 75%;">
                            75% - Under Review
                        </div>
                    </div>
                    <p class="mt-3">If you have any questions, please contact support.</p>
                    <a href="{{ route('mobile.user.store.index') }}" class="btn btn-outline-secondary mt-3 btn auto">
                        <i class="fa fa-arrow-left-long me-1"></i> Back to Business Dashboard
                    </a>
                </div>
            </div>
        @else
            <!-- Unknown State -->
            <div class="alert alert-secondary d-flex align-items-center shadow-sm" role="alert">
                <i class="bi bi-question-circle-fill me-2 fs-4"></i>
                <div>
                    <h5 class="mb-1">Status Unknown </h5>
                    <p class="mb-0">We couldn't determine your verification status. Please contact support for assistance.</p>
                </div>
            </div>
        @endif
    </div>
</div>
