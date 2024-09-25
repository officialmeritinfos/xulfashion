<div>
    @inject('option','App\Custom\Regular')
    <div class="card">
        @if(!$showEditForm && !$showAddForm)
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">

                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <select class="form-select form-select-sm w-auto" wire:model.live="show">
                            <option>5</option>
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>

                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    @can('create ServiceType')
                        <button wire:click.prevent="toggleAddService" class="btn btn-sm btn-primary-600"><i
                                class="ri-add-line"></i>
                            <span wire:loading.remove> Add Service Type</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if($serviceTypes->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label" for="checkAll">
                                            S.L
                                        </label>
                                    </div>
                                </th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($serviceTypes as $index=>$serviceType)
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            <label class="form-check-label" for="check1">
                                                {{$serviceTypes->firstItem()+$index}}
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$serviceType->name}}</td>
                                    <td>{{shortenText($serviceType->description,5)}}</td>
                                    <td>
                                        <img src="{{$serviceType->photo}}"
                                             class="w-64-px h-64-px rounded-circle object-fit-cover lightboxed"/>
                                    </td>
                                    <td>
                                        @switch($serviceType->status)
                                            @case(1)
                                                <span class="badge bg-success">Active</span>
                                            @break
                                            @default
                                                <span class="badge bg-danger">Inactive</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {{$serviceType->created_at->format('d/m/Y h:i:s a')}}
                                    </td>
                                    <td>
                                        @can('update ServiceType')
                                            <a wire:click.prevent="toggleEditService({{$serviceType->id}})"
                                               class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <iconify-icon icon="lucide:edit"></iconify-icon>
                                            </a>
                                        @endcan
                                        @can('delete ServiceType')
                                            <a wire:click.prevent="toggleDeleteService({{$serviceType->id}})"
                                               class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$serviceTypes->links()}}
                        </div>
                    </div>
                @else
                    <div class="row gy-4">
                        <div class="col-lg-12 col-sm-12">
                            <div
                                class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                                <h6 class="text-primary-light text-md mb-8 text-center">No Data found.</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @if($showAddForm)
           <div class="card-body">
                <h6 class="text-md text-primary-light mb-16">Add New Service Type</h6>

                <form wire:submit.prevent="submitNewServiceType" class="row">

                    <div class="mb-20">
                        <label for="name"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Service Name <span
                                class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                               id="name" wire:model="name" placeholder="Enter Name">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-20 col-md-12">
                        <label for="password_confirmation"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Description
                            <span class="text-danger-600">*</span></label>
                        <textarea class="form-control radius-8 @error('description') is-invalid @enderror" wire:model="description"
                               placeholder="Enter Description"></textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-20 col-md-6">
                        <label for="password"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Image<span
                                class="text-danger-600">*</span></label>
                        <input type="file"
                               class="form-control radius-8 @error('photo') is-invalid @enderror" wire:model="photo" >
                        @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-20 col-md-6">
                        <label for="password"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Status<span
                                class="text-danger-600">*</span></label>
                        <select class="form-control radius-8 @error('status') is-invalid @enderror" wire:model="status" >
                            <option value="">Select an Option</option>
                            <option value="1">Active</option>
                            <option value=2">Inactive</option>
                        </select>
                        @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                            <span wire:loading.remove>Proceed</span>
                            <span wire:loading>Processing...</span>
                        </button>
                        <button wire:click.prevent="cancelAction" class="btn btn-outline-light" wire:loading.attr="disabled">
                            <span wire:loading.remove>Cancel</span>
                            <span wire:loading>Processing...</span>
                        </button>
                    </div>
                </form>
           </div>
        @endif

            @if($showEditForm)
                <div class="card-body">
                    <h6 class="text-md text-primary-light mb-16">Edit {{$name}}</h6>

                    <form wire:submit.prevent="submitUpdateServiceType" class="row">

                        <div class="mb-20">
                            <label for="name"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Service Name <span
                                    class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                                   id="name" wire:model="name" placeholder="Enter Name">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-20 col-md-12">
                            <label for="password_confirmation"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Description
                                <span class="text-danger-600">*</span></label>
                            <textarea class="form-control radius-8 @error('description') is-invalid @enderror" wire:model="description"
                                      placeholder="Enter Description"></textarea>
                            @error('description') <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-20 col-md-6">
                            <label for="password"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Image<span
                                    class="text-danger-600">*</span></label>
                            <input type="file"
                                   class="form-control radius-8 @error('photo') is-invalid @enderror" wire:model="photo" >
                            @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-20 col-md-6">
                            <label for="password"
                                   class="form-label fw-semibold text-primary-light text-sm mb-8">Status<span
                                    class="text-danger-600">*</span></label>
                            <select class="form-control radius-8 @error('status') is-invalid @enderror" wire:model="status" >
                                <option value="">Select an Option</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                                <span wire:loading.remove>Update</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click.prevent="cancelAction" class="btn btn-outline-light" wire:loading.attr="disabled">
                                <span wire:loading.remove>Cancel</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif
    </div>
</div>
