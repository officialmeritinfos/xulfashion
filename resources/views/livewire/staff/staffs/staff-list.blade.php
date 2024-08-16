<div>
    @inject('option','App\Custom\Regular')

    @if(!$showAddStaff && !$showEditStaff && !$showStaffDetails)
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="icon-field">
                        <input type="text" class="form-control form-control-sm w-auto"
                               placeholder="Search by Email or Reference ID" wire:model.live.debounce.250ms="search">
                        <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                    </div>
                    <select class="form-select form-select-sm w-auto" wire:model.live="role">
                        <option value="">Sort By Role</option>
                        @foreach($roles as $role)
                            <option value="{{$role->name}}">{{ucwords(str_replace('-',' ',$role->name))}}</option>
                        @endforeach
                    </select>
                    <select class="form-select form-select-sm w-auto" wire:model.live="show">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <select class="form-select form-select-sm w-auto" wire:model.live="status">
                        <option value="all">All</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                    @can('create SystemStaff')
                        <button wire:click.prevent="toggleShowAddStaff" class="btn btn-sm btn-primary-600"><i
                                class="ri-add-line"></i>
                            <span wire:loading.remove> Onboard Staff</span>
                            <span wire:loading>Please wait...</span>
                        </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if($staffs->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th scope="col">
                                    S.L
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Department</th>
                                <th scope="col">Data Added</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($staffs as $index=>$staff)
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            {{ $staffs->firstItem() + $index }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $staff->photo??'https://ui-avatars.com/api/?rounded=true&name='.$staff->name }}"
                                                 alt="" class="w-40-px h-40-px rounded-circle object-fit-cover lightboxed">
                                            <h6 class="text-md mb-0 fw-medium flex-grow-1"> {{ $staff->name }}</h6>
                                        </div>
                                    </td>
                                    <td>{{ $staff->email }}</td>
                                    <td>
                                        {{ucwords(str_replace('-',' ',$staff->role))}}
                                    </td>
                                    <td>{{ date('F d, Y h:i:s', strtotime($staff->created_at)) }}</td>
                                    <td>
                                        @switch($staff->status)
                                            @case(1)
                                                <span
                                                    class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span>
                                                @break

                                            @default
                                                <span
                                                    class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Inactive</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <a wire:click.prevent="toggleShowStaffDetail({{$staff->id}})" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle
                                        d-inline-flex align-items-center justify-content-center" wire:navigate>
                                            <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                        </a>
                                        @if($mainStaff->role=='superadmin' && $staff->role=='admin')
                                            <button wire:click.prevent="toggleShowEditStaff({{$staff->id}})"
                                                    class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                <iconify-icon icon="lucide:edit"></iconify-icon>
                                            </button>
                                        @endif
                                        @if($staff->role !='superadmin' && $staff->role!='admin')
                                            @can('update SystemStaff')
                                                <button wire:click.prevent="toggleShowEditStaff({{$staff->id}})"
                                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                                </button>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        {{ $staffs->links() }}

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
        </div>
    @endif
    @if($showAddStaff)
        <div class="card">
            <div class="card-body">
                <h6 class="text-md text-primary-light mb-16">Onboard New Staff</h6>

                <form wire:submit.prevent="submitNewStaff" class="row">

                    <div class="mb-20">
                        <label for="name"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span
                                class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                               id="name" wire:model.blur="name" placeholder="Enter Full Name">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-20 col-md-6">
                        <label for="email"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                class="text-danger-600">*</span></label>
                        <input type="email"
                               class="form-control radius-8 @error('email') is-invalid @enderror" id="email"
                               wire:model.blur="email" placeholder="Enter email address">
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-20 col-md-6">
                        <label for="fiat"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Role
                            <span class="text-danger-600">*</span> </label>
                        <select
                            class="form-control radius-8 form-select @error('staffRole') is-invalid @enderror"
                            id="fiat" wire:model.blur="staffRole">
                            <option value="">Select an option</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucwords(str_replace('-',' ',$role->name)) }} </option>
                            @endforeach
                        </select>
                        @error('staffRole') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-20 col-md-6">
                        <label for="password_confirmation"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Password
                            <span class="text-danger-600">*</span></label>
                        <input type="password"
                               class="form-control radius-8 @error('password') is-invalid @enderror"
                               id="password_confirmation" wire:model.blur="password"
                               placeholder="Enter Password">
                        @error('password') <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-20 col-md-6">
                        <label for="password"
                               class="form-label fw-semibold text-primary-light text-sm mb-8">Password Confirmation<span
                                class="text-danger-600">*</span></label>
                        <input type="password"
                               class="form-control radius-8 @error('password_confirmation') is-invalid @enderror"
                               id="password" wire:model.blur="password_confirmation" placeholder="Repeat Password">
                        @error('password_confirmation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                            <span wire:loading.remove>Proceed</span>
                            <span wire:loading>Processing...</span>
                        </button>
                        <button wire:click.prevent="resetForm" class="btn btn-outline-light" wire:loading.attr="disabled">
                            <span wire:loading.remove>Cancel</span>
                            <span wire:loading>Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @if($showEditStaff)
        <div class="card">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Edit {{$name}}</h6>

                        <form wire:submit.prevent="submitUpdate" class="row">

                            <div class="mb-20">
                                <label for="name"
                                       class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span
                                        class="text-danger-600">*</span></label>
                                <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror"
                                       id="name" wire:model.blur="name" placeholder="Enter Full Name">
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-20 col-md-6">
                                <label for="email"
                                       class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                        class="text-danger-600">*</span></label>
                                <input type="email"
                                       class="form-control radius-8 @error('email') is-invalid @enderror" id="email"
                                       wire:model.blur="email" placeholder="Enter email address">
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-20 col-md-6">
                                <label for="fiat"
                                       class="form-label fw-semibold text-primary-light text-sm mb-8">Role
                                    <span class="text-danger-600">*</span> </label>
                                <select
                                    class="form-control radius-8 form-select @error('staffRole') is-invalid @enderror"
                                    id="fiat" wire:model.blur="staffRole">
                                    <option value="">Select an option</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ ucwords(str_replace('-',' ',$role->name)) }} </option>
                                    @endforeach
                                </select>
                                @error('staffRole') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-20 col-md-">
                                <label for="fiat"
                                       class="form-label fw-semibold text-primary-light text-sm mb-8">Status
                                    <span class="text-danger-600">*</span> </label>
                                <select
                                    class="form-control radius-8 form-select @error('staffStatus') is-invalid @enderror"
                                    id="fiat" wire:model.blur="staffStatus">
                                    <option value="">Select an option</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                @error('staffStatus') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Proceed</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button wire:click.prevent="resetForm" class="btn btn-outline-light" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Cancel</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
