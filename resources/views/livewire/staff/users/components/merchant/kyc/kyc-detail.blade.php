<div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($staff->can('update UserVerification'))
                    <div class="card-header">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary radius-8 d-inline-flex align-items-center gap-1"
                               wire:click="toggleForm">
                                <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                Edit KYC
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-success radius-8 d-inline-flex align-items-center gap-1"
                               wire:click="toggleApprovalForm">
                                <iconify-icon icon="uil:edit" class="text-xl"></iconify-icon>
                                Approve KYC
                            </a>
                            <a href="javascript:void(0)" class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1"
                               wire:click="toggleRejectForm">
                                <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                                Reject KYC
                            </a>
                        </div>
                    </div>
                @endif
                <div class="card-body py-40">
                    @if($showForm)
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <form wire:submit.prevent="updateKyc" class="row g-3">
                                    <div class="mb-2">
                                        <p class="text-center text-primary">Only fill the section you want to update. The content not updated will retain their
                                        value even when submitted.</p>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="docType" class="form-label">Mode of Verification</label>
                                        <select class="form-control" id="docType" wire:model.live="docType">
                                            <option value="">Choose...</option>
                                            @foreach($documentTypes as $doc)
                                                <option value="{{ $doc->slug }}" data-title="{{ $doc->name }}"
                                                        data-back="{{ $doc->hasBack }}" {{($doc->slug==$documentType->slug)?'selected':''}}>{{ $doc->name }}</option>
                                            @endforeach
                                        </select>
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
                                                    <input type="file" class="form-control" id="frontImage" wire:model.live="frontImage">
                                                    @error('frontImage') <span class="error text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-md-4 backImage">
                                                    <label for="backImage" class="form-label">Back of <span class="idName">{{ $docName }}</span></label>
                                                    <input type="file" class="form-control" id="backImage" wire:model.live="backImage">
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
                                                    <input type="file" class="form-control" id="frontImage" wire:model.live="frontImage">
                                                    @error('frontImage') <span class="error text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="col-md-6 mt-3">
                                        <label for="country" class="form-label">
                                            Country
                                            <i class="ri-question-line" data-bs-toggle="tooltip" data-placement="top" title="We need to know where you are from for AML purposes"></i>
                                        </label>
                                        <select class="form-control" id="country" wire:model.live="country">
                                            <option value="">Select an Option</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->iso3 }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control" id="state" wire:model.live="state">
                                        @error('state') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" wire:model.live="address" placeholder="1234 Main St"></textarea>
                                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="addressProof" class="form-label">Proof of Address</label>
                                        <input type="file" class="form-control" id="addressProof" wire:model.live="addressProof">
                                        @error('addressProof') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mt-5 text-center">
                                        <button class="btn btn-outline-primary text-sm btn-sm radius-8">
                                        <span>
                                            Submit Form
                                            <div wire:loading>
                                                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                            </div>
                                        </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                        @if($showApproveForm)
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <form wire:submit.prevent="approveKyc" class="row g-3">
                                        <div class="mb-2">
                                            <p class="text-center text-success">
                                                You are about approving this KYC submission. Ensure that it meets with the
                                                standard required before proceeding.
                                            </p>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="state" class="form-label">Authorization Pin</label>
                                            <input type="password" class="form-control" id="state" wire:model.live="accountPin" minlength="6" maxlength="6">
                                            @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-12 mt-5 text-center">
                                            <button class="btn btn-outline-success text-sm btn-sm radius-8">
                                            <span>
                                                Approve KYC
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                </div>
                                            </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if($showRejectForm)
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <form wire:submit.prevent="rejectKyc" class="row g-3">
                                        <div class="mb-2">
                                            <p class="text-center text-warning">
                                                You are about disproving this KYC submission.
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="state" class="form-label">Reason for Rejection</label>
                                            <textarea type="text" class="form-control summernote" id="state" wire:model.live="rejectedReason"
                                            rows="5"></textarea>
                                            @error('rejectedReason') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label for="state" class="form-label">Authorization Pin</label>
                                            <input type="password" class="form-control" id="state" wire:model.live="accountPin" max="6" min="6">
                                            @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-12 mt-5 text-center">
                                            <button class="btn btn-outline-warning text-sm btn-sm radius-8">
                                            <span>
                                                Reject KYC
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                </div>
                                            </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @if(!$showForm && !$showApproveForm &&  !$showRejectForm)
                        <div class="row justify-content-center" id="invoice">
                            <div class="col-lg-12">
                                <div class="shadow-4 border radius-8">
                                    <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                        <div>
                                            <h3 class="text-xl">KYC #{{$document->reference}}</h3>
                                            <p class="mb-1 text-sm">Date Submitted: {{$document->created_at->format('F d, Y h:i A')}}</p>
                                            <p class="mb-0 text-sm">Date Updated: {{$document->updated_at->format('F d, Y h:i A')}}</p>
                                        </div>
                                    </div>
                                    <div class="py-28 px-20">
                                        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                            <div>
                                                <h6 class="text-md">Merchant:</h6>
                                                <table class="text-sm text-secondary-light">
                                                    <tbody>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td class="ps-8">{{$user->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address</td>
                                                        <td class="ps-8">{{$user->address}}, {{$user->country}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone number</td>
                                                        <td class="ps-8">{{$user->phone}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div>
                                                <table class="text-sm text-secondary-light">
                                                    <tbody>
                                                    <tr>
                                                        <td>Join Date</td>
                                                        <td class="ps-8">{{$document->created_at->format('F d, Y h:i A')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gender</td>
                                                        <td class="ps-8">{{strtoupper($user->gender)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Birth</td>
                                                        <td class="ps-8">{{date('F d, Y',strtotime($user->dob))}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="mt-24">
                                            <div class="table-responsive scroll-sm">
                                                <table class="table bordered-table text-sm">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="text-sm">Reference</th>
                                                        <th scope="col" class="text-sm">Document Type</th>
                                                        <th scope="col" class="text-sm">ID Number</th>
                                                        <th scope="col" class="text-sm">Utility Bill</th>
                                                        <th scope="col" class="text-sm">Front Image</th>
                                                        <th scope="col" class="text-end text-sm">Back Image</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>{{$document->reference}}</td>
                                                        <td>{{$documentType->name}}</td>
                                                        <td>{{$document->idNumber}}</td>
                                                        <td>
                                                            <img src="{{$document->utilityBill}}" alt="" class="w-44-px h-44-px radius-8 object-fit-cover lightboxed">
                                                        </td>
                                                        <td>
                                                            <img src="{{$document->frontImage}}" alt="" class="w-44-px h-44-px radius-8 object-fit-cover lightboxed">
                                                        </td>
                                                        <td class="text-end">
                                                            @empty($document->backImage)
                                                                N/A
                                                            @else
                                                            <img src="{{$document->backImage}}" alt="" class="w-44-px h-44-px radius-8 object-fit-cover lightboxed">
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex flex-wrap justify-content-between gap-3">
                                                <div>
                                                    <p class="text-sm mb-0"><span class="text-primary-light fw-semibold">Status:</span> </p>
                                                    <p class="text-sm mb-0">
                                                        @switch($document->status)
                                                            @case(1)
                                                                <span class="badge text-sm fw-semibold bg-dark-success-gradient px-20 py-9 radius-4 text-white">
                                                                    Verified
                                                                </span>
                                                                @break
                                                            @case(4)
                                                                <span class="badge text-sm fw-semibold bg-dark-primary-gradient px-20 py-9 radius-4 text-white">Under Review</span>
                                                                @break
                                                            @default
                                                                <span class="badge text-sm fw-semibold bg-dark-lilac-gradient px-20 py-9 radius-4 text-white">Pending Submission/Rejected</span>
                                                                @break
                                                        @endswitch
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
