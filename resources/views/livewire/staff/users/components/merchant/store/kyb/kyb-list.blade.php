<div>
    @inject('injected','App\Custom\Regular')

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                        <button wire:click="notifyCompliance" class="btn btn-sm btn-outline-info radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>

                            <span>
                                Notify Compliance
                                <div wire:loading>
                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                </div>
                            </span>
                        </button>
                            @if($staff->can('update UserStoreVerification'))
                                <button type="button" class="btn btn-sm btn-success radius-8 d-inline-flex align-items-center gap-1"  wire:click="toggleApproveForm">
                                    <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                                    Approve
                                </button>
                                <button type="button" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"  wire:click="toggleRejectForm">
                                    <i class="ri-delete-bin-6-line"></i>
                                    Reject
                                </button>
                            @endif
                    </div>
                </div>
                <div class="card-body py-40">

                        @if($showApproveForm)
                            @if($staff->can('update UserStoreVerification'))
                                <div class="card">
                                    <div class="product-area card-body">
                                        <div class="container-fluid">

                                            <div class="submit-property-area">
                                                <div class="container-fluid">
                                                    <form class="row g-3" id="processForm" wire:submit.prevent="submitApproval">
                                                        <p class="text-center text-success">
                                                            You are about to approve this submission. Ensure it met the criteria.
                                                        </p>
                                                        <div class="col-md-12">
                                                            <label for="inputState" class="form-label"><sup class="text-danger">*</sup>
                                                                Account Pin
                                                            </label>
                                                            <input type="password" minlength="6" maxlength="6" class="form-control" id="inputState" name="legalName"  wire:model.live="accountPin">
                                                            @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-12 text-center mt-3">
                                                            <button class="btn btn-outline-success" type="submit">
                                                                <span>
                                                                    Approve Submission
                                                                    <div wire:loading>
                                                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                                    </div>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if($showRejectForm)
                            @if($staff->can('update UserStoreVerification'))
                                <div class="card">
                                    <div class="product-area card-body">
                                        <div class="container-fluid">

                                            <div class="submit-property-area">
                                                <div class="container-fluid">
                                                    <form class="row g-3" id="processForm" wire:submit.prevent="submitReject">
                                                        <p class="text-center text-danger">
                                                            You are about to reject this submission
                                                        </p>
                                                        <div class="col-md-12">
                                                            <label for="inputState" class="form-label"><sup class="text-danger">*</sup>
                                                                Account Pin
                                                            </label>
                                                            <input type="password" minlength="6" maxlength="6" class="form-control" id="inputState"  wire:model.live="accountPin">
                                                            @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="inputState" class="form-label"><sup class="text-danger">*</sup>
                                                                Reason for Rejecting
                                                            </label>
                                                            <textarea type="text" class="form-control" id="inputState" rows="4" wire:model.live="rejectReason"></textarea>
                                                            @error('rejectReason') <span class="error text-danger">{{ $message }}</span> @enderror
                                                        </div>
                                                        <div class="col-md-12 text-center mt-3">
                                                            <button class="btn btn-outline-danger" type="submit">
                                                                <span>
                                                                    Reject Submission
                                                                    <div wire:loading>
                                                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                                    </div>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @if(!$showForm && !$showApproveForm && !$showRejectForm)
                            <div class="row justify-content-center" id="invoice">
                                <div class="col-lg-12">
                                    <div class="shadow-4 border radius-8">
                                        <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                            <div>
                                                <h3 class="text-xl">ID #{{$verification->reference}}</h3>
                                                <p class="mb-1 text-sm">Date Submitted: {{$verification->created_at->format('d/m/Y')}}</p>
                                            </div>
                                            <div>
                                                <img src="{{$store->logo}}" alt="image"
                                                     class="mb-8 w-44-px h-44-px radius-8 object-fit-cover lightboxed">
                                                <p class="mb-1 text-sm">{{$store->address}}</p>
                                                <p class="mb-0 text-sm">{{$store->email}}, {{$store->phone}}</p>
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
                                                            <td class="ps-8">: {{$user->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address</td>
                                                            <td class="ps-8">: {{$user->address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone number</td>
                                                            <td class="ps-8">: {{$user->phone}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div>
                                                    <table class="text-sm text-secondary-light">
                                                        <tbody>
                                                        <tr>
                                                            <td>Reg. Number:</td>
                                                            <td class="ps-8"> {{$verification->regNumber}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Legal Name:</td>
                                                            <td class="ps-8"> {{$verification->legalName}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Business Address: </td>
                                                            <td class="ps-8"> {{$verification->address}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Doing Business As: </td>
                                                            <td class="ps-8"> {{$verification->dba}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status: </td>
                                                            <td class="ps-8">
                                                                @switch($verification->status)
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
                                                            </td>
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
                                                            <th scope="col" class="text-sm">SL.</th>
                                                            <th scope="col" class="text-sm">Document</th>
                                                            <th scope="col" class="text-sm">Upload</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Certificate of Registration</td>
                                                            <td>
                                                                <a href="{{$verification->certificate}}" target="_blank">
                                                                    {{$verification->certificate}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>02</td>
                                                            <td>Proof of Address</td>
                                                            <td>
                                                                <a href="{{$verification->addressProof}}" target="_blank">
                                                                    {{$verification->addressProof}}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-wrap justify-content-between gap-3">
                                                <div>
                                                    <p class="text-sm mb-0">
                                                <span class="text-primary-light fw-semibold">
                                                    Approved/Rejected By:
                                                </span>
                                                        {{$injected->fetchStaffById($verification->approvedBy)->name??'N/A'}}
                                                    </p>
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
