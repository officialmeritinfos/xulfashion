<div>
    @if ($user->isVerified == 2 || $user->isVerified == 3)
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold mb-0">Know Your Customer (KYC) Verification</h1>
                    <button class="btn btn-link text-decoration-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#kycCollapse" aria-expanded="true" aria-controls="kycCollapse">
                        <i class="fa fa-chevron-up collapsed-icon" style="font-size: 1.25rem;"></i>
                        <i class="fa fa-chevron-down expanded-icon" style="font-size: 1.25rem; display: none;"></i>
                    </button>
                </div>
            </div>
            <div id="kycCollapse" class="collapse show">
                <div class="card-body">
                    <p class="text-muted">
                        To ensure the safety and compliance of our platform, we require all merchants to complete the Know Your Customer (KYC)
                        verification process. This involves collecting and verifying your personal information, identity, and contact details in line
                        with global regulatory standards. Completing this process helps us prevent fraud, ensure transparency, and maintain trust
                        within our community.
                    </p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @include('notifications')
                <form wire:submit.prevent="submitKyc">
                    <div class="row mb-3 scrollable-table-container">
                        <div class="col-md-12">
                            <h3 class="mb-3">Select your available Document</h3>
                            <div class="boxed-check-group boxed-check-primary d-flex flex-nowrap" style="overflow-x: auto;">
                                @foreach($documentTypes as $documentType)
                                    <label class="boxed-check mx-2" style="flex: 0 0 300px;">
                                        <input class="boxed-check-input" type="radio"  value="{{ $documentType->slug }}"
                                               data-title="{{ $documentType->name }}"
                                               data-back="{{ $documentType->hasBack }}"
                                               wire:model.live="docType">
                                        <div class="boxed-check-label" style="text-align: center;">
                                            <h2>{{ $documentType->name }}</h2>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('docType') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    @if($docType)
                        <div class="row g-3 idUploads">
                            @if($hasBack)
                                <div class="col-md-4 idNumber">
                                    <label for="idNumber" class="form-label"><span class="idName">{{ $docName }}</span> Number</label>
                                    <input type="text" class="form-control" id="idNumber" wire:model.live="idNumber">
                                    @error('idNumber') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 frontImage">
                                    <label for="frontImage" class="form-label">Front of <span class="idName">{{ $docName }}</span></label>
                                    <input type="file" class="form-control" id="frontImage" wire:model="frontImage">
                                    @error('frontImage') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 backImage">
                                    <label for="backImage" class="form-label">Back of <span class="idName">{{ $docName }}</span></label>
                                    <input type="file" class="form-control" id="backImage" wire:model="backImage">
                                    @error('backImage') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            @else
                                <div class="col-md-6 idNumber">
                                    <label for="idNumber" class="form-label"><span class="idName">{{ $docName }}</span> Number</label>
                                    <input type="text" class="form-control" id="idNumber" wire:model.live="idNumber">
                                    @error('idNumber') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 frontImage">
                                    <label for="frontImage" class="form-label">Front of <span class="idName">{{ $docName }}</span></label>
                                    <input type="file" class="form-control" id="frontImage" wire:model="frontImage">
                                    @error('frontImage') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                    @endif


                    <div class="mt-3 col-12">
                        <label for="country" class="form-label">
                            Country
                            <i class="ri-question-line" data-bs-toggle="tooltip" data-placement="top" title="We need to know where you are from for AML purposes"></i>
                        </label>
                        <select class="form-control selectize" id="country" wire:model.live="country">
                            <option value="">Select an Option</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->iso3 }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12 mt-3" wire:ignore.self>
                        <label for="state" class="form-label">State</label>
                        <select class="form-control selectize" id="country" wire:model.live="state">
                            <option value="">Select an Option</option>
                            @foreach($states as $state)
                                <option value="{{ $state->name }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" wire:model.live="address" placeholder="1234 Main St"></textarea>
                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <label for="addressProof" class="form-label">Proof of Address</label>
                        <input type="file" class="form-control" id="addressProof" wire:model="addressProof">
                        @error('addressProof') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-12 mt-3 text-center">
                        <button class="btn btn-outline-primary text-sm btn-sm radius-8">
                            <span>
                                Submit
                                <div wire:loading>
                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                </div>
                            </span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    @elseif ($user->isVerified == 4)
        <div class="mt-4">
            <div class="alert alert-primary text-center">
                <h3>Your KYC verification is under review.</h3>
                <p>Please wait while we review your submitted details. You will be notified once the process is complete.</p>
            </div>
        </div>
    @elseif ($user->isVerified == 1)
        <div class="mt-4">
            <div class="alert alert-success text-center">
                <h3>Congratulations! Your KYC verification is complete.</h3>
                <p>Thank you for verifying your identity. You now have full access to all platform features.</p>
            </div>
        </div>
    @endif
</div>
