<div>
    @inject('option','App\Custom\Regular')
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                <button type="button" wire:click="toggleShowApproveForm" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">
                    <iconify-icon icon="pepicons-pencil:paper-plane" class="text-xl"></iconify-icon>
                    Approve Ad
                </button>
                <button type="button" wire:click="toggleShowRejectForm" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1">
                    <iconify-icon icon="solar:close-circle-outline" class="text-xl"></iconify-icon>
                    Reject Ad
                </button>
            </div>
        </div>
        <div class="card-body py-40">
            @if($showRejectForm)
                <form wire:submit.prevent="submitReject" class="row gy-3">
                    <p class="text-center text-danger">
                        You are about rejecting this Ad.
                    </p>
                    <div class="col-md-12">
                        <label class="form-label">Reason<i class="text-danger">*</i> </label>
                        <textarea wire:model.live="rejectReason" class="form-control form-control-lg" rows="8"></textarea>
                        @error('rejectReason') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Authorization Pin<i class="text-danger">*</i></label>
                        <input type="password" wire:model.live="accountPin" class="form-control form-control-lg" minlength="6" maxlength="6">
                        @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-outline-danger" type="submit">
                                <span>
                                    Reject
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                        </button>
                    </div>
                </form>
            @endif

            @if($showApproveForm)
                    <form wire:submit.prevent="submitApprove" class="row gy-3">
                        <p class="text-center text-success">
                            You are about approving this Ad. Ensure it meets the standard.
                        </p>
                        <div class="col-md-12">
                            <label class="form-label">Authorization Pin<i class="text-danger">*</i></label>
                            <input type="password" wire:model.live="accountPin" class="form-control form-control-lg" minlength="6" maxlength="6">
                            @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button class="btn btn-outline-success" type="submit">
                                <span>
                                    Approve
                                    <div wire:loading>
                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                    </div>
                                </span>
                            </button>
                        </div>
                    </form>
            @endif
            @if(!$showApproveForm && !$showRejectForm)
                <div class="row justify-content-center" id="invoice">
                    <div class="col-lg-12">
                        <div class="shadow-4 border radius-8">
                            <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                <div>
                                    <h3 class="text-xl">ID #{{$ad->reference}}</h3>
                                    <p class="mb-1 text-sm">Date Created: {{$ad->created_at->format('d/m/Y h:i:s a')}}</p>
                                    @if($ad->status==1)
                                        <p class="mb-0 text-sm">Date Approved: {{date('d/m/Y h:i:s a', $ad->dateApproved)}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="py-28 px-20">
                                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                    <div>
                                        <h6 class="text-md">Ads Detail:</h6>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                            <tr>
                                                <td>Title</td>
                                                <td class="ps-8">: {{$ad->title}}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td class="ps-8">: {{($ad->priceType==2)? $ad->currency.$ad->amount:'Contact for price'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Service Type</td>
                                                <td class="ps-8">: {{$option->serviceTypeById($ad->serviceType)->name??'N/A'}} </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <table class="text-sm text-secondary-light">
                                            <tbody>
                                            <tr>
                                                <td>Location</td>
                                                <td class="ps-8">: {{$option->fetchState($ad->country,$ad->state)->name}}, {{$option->fetchCountryIso2($ad->country)->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Categories</td>
                                                <td class="ps-8">:
                                                    @php
                                                        $cates = explode(',',$ad->tags)
                                                    @endphp
                                                    @foreach($cates as $cate)
                                                        <span class="badge bg-primary text-white">
                                                {{$cate}}
                                            </span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Company Name</td>
                                                <td class="ps-8">: {{$ad->companyName??'N/A'}}</td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td class="ps-8">:
                                                    @switch($ad->status)
                                                        @case(1)
                                                            <span class="text-success" data-bs-toggle="tooltip" title="Active">
                                                            Active <i class="ri-check-double-fill text-success" style="font-size: 20px;"></i>
                                                        </span>
                                                            @break
                                                        @case(2)
                                                            <span class="text-primary" data-bs-toggle="tooltip" title="Under-review">
                                                            Under Review <i class="bx bx-loader-alt bx-spin text-primary" style="font-size: 20px;"></i>
                                                        </span>
                                                            @break
                                                        @case(3)
                                                            <span class="text-danger" data-bs-toggle="tooltip" title="Deactivated">
                                                            Deactivated<i class="ri-alert-fill text-danger" style="font-size: 20px;"></i>
                                                        </span>
                                                            @break
                                                        @default
                                                            <span class="text-danger" data-bs-toggle="tooltip" title="Rejected By support">
                                                            Rejected By Support<i class="ri-error-warning-fill text-danger" style="font-size: 20px;"></i>
                                                        </span>
                                                            @break
                                                    @endswitch
                                                </td>
                                            </tr>
                                            @if($ad->status==4)
                                                <tr>
                                                    <td>
                                                        Rejection Reason
                                                    </td>
                                                    <td class="ps-8">:
                                                        {{$ad->rejectReason}}
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="mt-64">
                                    <p class="text-center text-secondary-light text-sm fw-semibold">
                                        {{$ad->description}}
                                    </p>
                                </div>


                                <div class="mt-24">
                                    <div class="table-responsive scroll-sm">
                                        <table class="table bordered-table text-sm">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="text-sm">Image</th>
                                                <th scope="col" class="text-sm">Type</th>
                                                <th scope="col" class="text-end text-sm">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <img src="{{$ad->featuredImage}}"  class="w-80-px h-80-px radius-8 object-fit-cover lightboxed"
                                                         alt=""/>
                                                </td>
                                                <td>Featured Image</td>
                                                <td class="text-end">
                                                    @if($showEditFeaturedImage)
                                                        <form wire:submit.prevent="updateFeaturedImage" class="row gy-3">
                                                            <div class="col-md-12">
                                                                <label class="form-label">Featured Image<i class="text-danger">*</i></label>
                                                                <input type="file" wire:model="featuredImage" class="form-control form-control-lg" minlength="6" maxlength="6">
                                                                @error('featuredImage') <span class="error text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Authorization Pin<i class="text-danger">*</i></label>
                                                                <input type="password" wire:model.live="accountPin" class="form-control form-control-lg" minlength="6" maxlength="6">
                                                                @error('accountPin') <span class="error text-danger">{{ $message }}</span> @enderror
                                                            </div>
                                                            <div class="col-12 text-center mt-3">
                                                                <button class="btn btn-outline-primary" type="submit">
                                                                <span>
                                                                    Update
                                                                    <div wire:loading>
                                                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                                    </div>
                                                                </span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-primary-50 radius-8 d-inline-flex align-items-center gap-1"
                                                            wire:click="toggleShowEditFeaturedImageForm">
                                                        <iconify-icon icon="solar:smartphone-update-line-duotone" class="text-xl"></iconify-icon>
                                                        Update Featured Image
                                                    </button>
                                                </td>
                                            </tr>
                                            @foreach($adImages as $adImage)
                                                <tr>
                                                    <td>
                                                        <img src="{{$adImage->photo}}"  class="w-80-px h-80-px radius-8 object-fit-cover lightboxed"
                                                             alt=""/>
                                                    </td>
                                                    <td>Image</td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-sm btn-danger radius-8 d-inline-flex align-items-center gap-1"
                                                                wire:click="deleteAdPhoto({{$ad->id}},{{$adImage->id}})">
                                                            <iconify-icon icon="solar:trash-bin-2-outline" class="text-xl"></iconify-icon>
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex flex-wrap justify-content-between gap-3">
                                        <div>
                                            <p class="text-sm mb-0"><span class="text-primary-light fw-semibold">Approved/Rejected By:</span>
                                                {{$option->fetchStaffById($ad->approvedBy)->name??'N/A'}}</p>
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
