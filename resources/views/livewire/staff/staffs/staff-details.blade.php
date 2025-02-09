<div>

    <div class="row gy-4">
        <div class="col-lg-4 mx-auto">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <img src="{{ asset('staff/images/user-grid/user-grid-bg1.png') }}" alt=""
                     class="w-100 object-fit-cover">
                <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <img src="{{ $staffs->photo??'https://ui-avatars.com/api/?rounded=true&name='.$staffs->name }}"
                             alt=""
                             class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                        <h6 class="mb-0 mt-16">{{ $staffs->name }}</h6>
                        <span class="text-secondary-light mb-16">{{ $staffs->email }}</span>
                    </div>
                    <div class="mt-24 border border-top-0 border-start-0 border-end mb-5">
                        <h6 class="text-xl mb-16">Personal Info</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $staffs->name }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $staffs->email }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Phone Number</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $staffs->phone??'N/A' }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Updated Password</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    @switch($staffs->hasUpdatedPassword)
                                        @case(1)
                                            Yes
                                            @break
                                        @default
                                            No
                                    @endswitch
                                </span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Updated Pin</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    @switch($staffs->setPin)
                                        @case(1)
                                            Yes
                                            @break
                                        @default
                                            No
                                    @endswitch
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Role:</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ ucfirst($staffs->role) }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Last Login:</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ empty($staffs->lastLogin)?'Never':date('d M Y H:i:s', $staffs->lastLogin) }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Current Login:</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ empty($staffs->loginTime)?'Never':date('d M Y H:i:s', $staffs->loginTime) }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Staff Status</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    @if($staffs->status!=1)
                                        <span
                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Suspended</span>
                                    @else
                                        <span
                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span>
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-2 text-center">
                        <h6 class="text-xl mb-16 ">Actions</h6>
                        <div class="row gap-2">
                            <div class="col-md-12">
                                {{-- Loading Spinner for Search --}}
                                <div class="col-md-1 d-flex align-items-center">
                                    <div wire:loading wire:target="verifyEmail,resendVerificationMail,remindAboutProfile,suspendUser,activateUser" class="spinner-border text-primary" role="status"
                                         style="width: 1.5rem; height: 1.5rem;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                            @can('update SuperAdmin')
                                <div class="col-md-12">
                                    <button class="btn btn-info" wire:click="resendVerificationMail">
                                        Resend Verification Mail
                                    </button>
                                </div>
                                @if($staffs->status==1)
                                    <div class="col-md-12" wire:click="suspendUser">
                                        <button class="btn btn-danger">
                                            Suspend
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <button class="btn btn-success" wire:click="activateUser">
                                            Activate
                                        </button>
                                    </div>
                                @endif
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            @inject('option','App\Custom\Regular')
            <div class="card">
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
                </div>
                <div class="card-body">
                    @if($activities->isNotEmpty())
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
                                    <th scope="col">Staff</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Model ID</th>
                                    <th scope="col">Date Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activities as $index=>$activity)
                                    <tr>
                                        <td>
                                            <div class="form-check style-check d-flex align-items-center">
                                                <label class="form-check-label" for="check1">
                                                    {{$activities->firstItem()+$index}}
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{$option->fetchStaffById($activity->staff)->name??'N/A'}}</td>
                                        <td>{{$activity->action}}</td>
                                        <td>{{$activity->model}}</td>
                                        <td>{{$activity->model_id}}</td>
                                        <td>
                                            {{$activity->created_at->format('d/m/Y h:i:s a')}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{$activities->links()}}
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
            </div>
        </div>

    </div>

</div>
