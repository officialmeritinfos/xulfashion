<div>
    @empty($kyc)
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card h-100 p-0 radius-12">
                    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-center">



                    </div>

                    <div class="card-body p-24">
                        <form wire:submit.prevent="submitKyc" class="row g-3">
                            <div class="col-md-12">
                                <label for="docType" class="form-label">Mode of Verification</label>
                                <select class="form-control" id="docType" wire:model.live="docType">
                                    <option value="">Choose...</option>
                                    @foreach($documentTypes as $doc)
                                        <option value="{{ $doc->slug }}" data-title="{{ $doc->name }}" data-back="{{ $doc->hasBack }}">{{ $doc->name }}</option>
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
                                        Show Form
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
    @endempty

    @if ($kyc)
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card h-100 p-0 radius-12">

                    <div class="card h-100 p-0 radius-12">

                        <div class="card-body p-24">
                            <div class="row gy-4">
                                <div class="col-xxl-12 col-md-12 user-grid-card   ">
                                    <div class="position-relative border radius-16 overflow-hidden">
                                        <img src="{{asset('staff/images/user-grid/user-grid-bg1.png')}}" alt="" class="w-100 object-fit-cover">

                                        <div class="dropdown position-absolute top-0 end-0 me-16 mt-16">
                                            <button type="button" data-bs-toggle="dropdown" aria-expanded="false" class="bg-white-gradient-light w-32-px h-32-px radius-8 border border-light-white d-flex justify-content-center align-items-center text-white">
                                                <iconify-icon icon="entypo:dots-three-vertical" class="icon "></iconify-icon>
                                            </button>
                                            <ul class="dropdown-menu p-12 border bg-base shadow">
                                                <li>
                                                    <a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-neutral-200 text-hover-neutral-900 d-flex align-items-center gap-10" href="javascript:void(0)">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item px-16 py-8 rounded text-secondary-light bg-hover-danger-100 text-hover-danger-600 d-flex align-items-center gap-10" href="javascript:void(0)">
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="ps-16 pb-16 pe-16 text-center mt--50">
                                            <img src="{{$user->photo}}" alt="" class="border br-white border-width-2-px
                                            w-80-px h-80-px rounded-circle object-fit-cover">
                                            <h6 class="text-lg mb-0 mt-4">{{$user->name}}</h6>
                                            <span class="text-secondary-light mb-16">{{$user->email}}</span>

                                            <div class="center-border position-relative bg-danger-gradient-light radius-8 p-12 d-flex align-items-center gap-4">
                                                <div class="text-center w-50">
                                                    <h6 class="text-md mb-0">Status</h6>
                                                    <span class="text-secondary-light text-sm mb-0 mt-3">
                                                        @switch($kyc->status)
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
                                                    </span>
                                                </div>
                                                <div class="text-center w-50">
                                                    <h6 class="text-md mb-0">Time Submitted</h6>
                                                    <span class="text-secondary-light text-sm mb-0 mt-3">{{$kyc->created_at->format('F d, Y h:i A')}}</span>
                                                </div>
                                            </div>
                                            <a href="{{route('staff.users.kyc.submission',['id'=>$user->reference])}}"
                                               class="bg-primary-50 text-primary-600 bg-hover-primary-600 hover-text-white p-10 text-sm
                                               btn-sm px-12 py-12 radius-8 d-flex align-items-center justify-content-center
                                               mt-16 fw-medium gap-2 w-100" wire:navigate>
                                                View Submission
                                                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon text-xl line-height-1"></iconify-icon>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

</div>
