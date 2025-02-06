<div>
    <div class="card h-100 p-0 radius-12 mb-5">

        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <h6 class="text-lg fw-semibold mb-0">Metrics</h6>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="duration">
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                    <option value="custom">Custom</option>
                </select>
                @if ($duration == 'custom')
                <input type="date" class="form-control form-control-sm w-auto" wire:model.live="customStartDate">
                <input type="date" class="form-control form-control-sm w-auto" wire:model.live="customEndDate">
                @endif
            </div>
        </div>
        <div class="card-body p-24">
            <div class="row gy-4">

                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-none radius-8 border h-100 bg-gradient-end-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-sm">New Users</span>
                                        <h6 class="fw-semibold">{{ $newUsersThisPeriod }}</h6>
                                    </div>
                                </div>
                                <div id="new-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                            <p class="text-sm mb-0">
                                {{ $newUsersIncrease >= 0 ? 'Increase' : 'Decrease' }} by
                                <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                                    {{ $newUsersIncrease }}
                                </span>
                                {{ $duration=='today'?$duration:'this '.$duration }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6">
                    <div class="card p-3 shadow-none radius-8 border h-100 bg-gradient-end-2">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                        <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="mb-2 fw-medium text-secondary-light text-sm">Active Users</span>
                                        <h6 class="fw-semibold">{{ $activeUsersCount }}</h6>
                                    </div>
                                </div>
                                <div id="active-user-chart" class="remove-tooltip-title rounded-tooltip-value"></div>
                            </div>
                            <p class="text-sm mb-0">
                                {{ $activeUsersIncrease >= 0 ? 'Increase' : 'Decrease' }} by
                                <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">
                                    {{ $activeUsersIncrease }}
                                </span>
                                {{ $duration=='today'?$duration:'this '.$duration }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-5">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Inactive Users</p>
                                    <h6 class="mb-0">{{ $inactiveUsersCount }}</h6>
                                </div>
                                <div
                                    class="w-50-px h-50-px bg-red rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="mingcute:user-follow-fill" class="text-base text-2xl mb-0">
                                    </iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div><!-- card end -->
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="show">
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                        placeholder="Search by Email or Reference ID" wire:model.live.debounce.250ms="search">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="profileStatus">
                    <option value="all">All</option>
                    <option value="1">Completed</option>
                    <option value="2">Incomplete</option>
                </select>
                <select class="form-select form-select-sm w-auto" wire:model.live="status">
                    <option value="all">All</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
                @can('create User')
                <a href="{{ route('staff.users.new') }}" class="btn btn-sm btn-primary-600" wire:navigate><i
                        class="ri-add-line"></i>
                    Onboard Merchant
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            @if($users->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">
                                    S.L
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Email</th>
                                <th scope="col">Email Verification</th>
                                <th scope="col">Profile</th>
                                <th scope="col">Date Joined</th>
                                <th scope="col">Deletion Request</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index=>$user)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        {{ $users->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->photo??'https://ui-avatars.com/api/?rounded=true&name='.$user->name }}"
                                            alt="" class="w-64-px h-64-px rounded-circle object-fit-cover lightboxed">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $user->name }}</h6>
                                    </div>
                                </td>
                                <td><a href="{{ route('staff.users.detail',['id'=>$user->reference]) }}"
                                        class="text-primary-600">{{ $user->reference }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @empty($user->email_verified_at)
                                        <span
                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Unverified</span>
                                    @else
                                        <span
                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Verified</span>
                                    @endempty
                                </td>
                                <td>
                                    @if($user->completedProfile!=1)
                                        <span
                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Incomplete</span>
                                    @else
                                        <span
                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Completed</span>
                                    @endif
                                </td>
                                <td>{{ date('F d, Y h:i:s', strtotime($user->created_at)) }}</td>
                                <td>
                                    @switch($user->requestedForAccountDeletion)
                                    @case(1)
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Received</span>
                                    @break

                                    @default
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Not Received</span>
                                    @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($user->status)
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
                                    <a href="{{ route('staff.users.detail',['id'=>$user->reference]) }}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle
                                        d-inline-flex align-items-center justify-content-center" wire:navigate>
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    @can('delete User')
                                        <button type="button" wire:click="deleteUser({{ $user->id }})"  wire:loading.attr="disabled"
                                                class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $users->links() }}

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

</div>
