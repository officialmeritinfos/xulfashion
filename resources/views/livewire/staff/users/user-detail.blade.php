<div>
    <div class="row gy-4">
        <div class="col-lg-4 mx-auto">
            <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                <img src="{{ asset('staff/images/user-grid/user-grid-bg1.png') }}" alt=""
                    class="w-100 object-fit-cover">
                <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                    <div class="text-center border border-top-0 border-start-0 border-end-0">
                        <img src="{{ $user->photo??'https://ui-avatars.com/api/?rounded=true&name='.$user->name }}"
                            alt=""
                            class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                        <h6 class="mb-0 mt-16">{{ $user->name }}</h6>
                        <span class="text-secondary-light mb-16">{{ $user->email }}</span>
                    </div>
                    <div class="mt-24">
                        <h6 class="text-xl mb-16">Personal Info</h6>
                        <ul>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->name }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Display Name</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->displayName }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->email }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Phone Number</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->phone??'N/A' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Username</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->username??'N/A' }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Account type</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    @switch($user->accountType)
                                    @case(1)
                                    Merchant/Fashion Designer
                                    @break
                                    @case(2)
                                    Model
                                    @break
                                    @default
                                    User
                                    @endswitch
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Country:</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->country }}</span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Address:</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->address??'N/A' }}</span>
                            </li>


                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> State:</span>
                                <span class="w-70 text-secondary-light fw-medium">: {{ $user->state??'N/A' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Email Status</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    @empty($user->email_verified_at)
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Unverified</span>
                                    @else
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Verified</span>
                                    @endempty
                                </span>
                            </li>

                            <li class="d-flex align-items-center gap-1 mb-12">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Profile Status</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    @if($user->completedProfile!=1)
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">Incomplete</span>
                                    @else
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Completed</span>
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex align-items-center gap-1">
                                <span class="w-30 text-md fw-semibold text-primary-light"> Bio</span>
                                <span class="w-70 text-secondary-light fw-medium">:
                                    {!! $user->bio !!}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mx-auto">
            <div class="container-fluid" style="margin-bottom: 5rem;">

                @can('update UserBalance')
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> Merchant Balance
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                Manage User Account Balance - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="Be able to fund and debit merchant's account balance."></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.balance',['id'=>$user->reference])}}" class="btn btn-outline-primary rounded-pill btn-sm small-button"
                        wire:navigate>
                            Manage
                        </a>
                    </div>
                </div>
                @endcan

                @can('update UserBalance')
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> Merchant Bank
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                Manage User Payout Account - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="Manage merchant's payout account"></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.payout-account',['id'=>$user->reference])}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                            Manage
                        </a>
                    </div>
                </div>
                @endcan

                @can(['create UserVerification','update UserVerification','create User'])
                @if ($user->completedProfile!=1)
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> Complete Profile Setup
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                Complete Profile Setup - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="Edit Merchant Information"></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.complete-profile',['id'=>$user->reference])}}" class="btn btn-outline-primary
                        rounded-pill btn-sm small-button">
                            Manage
                        </a>
                    </div>
                </div>
                @endif
                @endcan

                @can('update User')
                @if ($user->completedProfile==1)
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> Edit Merchant Information
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                Edit merchant information- <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="Edit Merchant Information"></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.bio.edit-info',['id'=>$user->reference])}}" class="btn btn-outline-primary rounded-pill btn-sm small-button"
                        wire:navigate>
                            Manage
                        </a>
                    </div>
                </div>
                @endif
                @endcan

                @can(['create UserVerification','update UserVerification'])
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> KYC
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                Manage Merchant KYC - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="Edit Merchant Information"></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.kyc',['id'=>$user->reference])}}" class="btn btn-outline-primary rounded-pill btn-sm small-button"
                        wire:navigate>
                            Manage
                        </a>
                    </div>
                </div>
                @endcan


                @can('read UserAd')
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> Merchant Listings
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                View all merchant's ads - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="View merchant's ads"></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.ads',['id'=>$user->reference])}}" class="btn btn-outline-primary rounded-pill btn-sm small-button"
                        wire:navigate>
                            Manage
                        </a>
                    </div>
                </div>
                @endcan

                    @can('read UserActivity')
                        <div class="card shadow mb-3">
                            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                <div class="flex-grow-1 mb-3 mb-md-0">
                                    <h5 class="card-title">
                                        <i class="ri-apps-2-fill"></i> Merchant Activity
                                    </h5>
                                    <p class="card-text" style="word-break: break-word;">
                                        View all merchant's activities - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                            title="View merchant's activities"></i>
                                    </p>
                                </div>
                                <a href="{{route('staff.users.activities',['id'=>$user->reference])}}" wire:navigate
                                   class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                    Manage
                                </a>
                            </div>
                        </div>
                    @endcan

                    @can('read UserSetting')
                        <div class="card shadow mb-3">
                            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                <div class="flex-grow-1 mb-3 mb-md-0">
                                    <h5 class="card-title">
                                        <i class="ri-apps-2-fill"></i> Merchant Settings
                                    </h5>
                                    <p class="card-text" style="word-break: break-word;">
                                        View all merchant's settings - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                          title="View merchant's settings"></i>
                                    </p>
                                </div>
                                <a href="{{route('staff.users.settings',['id'=>$user->reference])}}" wire:navigate
                                   class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                    Manage
                                </a>
                            </div>
                        </div>
                    @endcan

                @can('read UserStore')
                <div class="card shadow mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                        <div class="flex-grow-1 mb-3 mb-md-0">
                            <h5 class="card-title">
                                <i class="ri-apps-2-fill"></i> Merchant Store
                            </h5>
                            <p class="card-text" style="word-break: break-word;">
                                View all merchant's Store - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                    title="View merchant's ads"></i>
                            </p>
                        </div>
                        <a href="{{route('staff.users.store',['id'=>$user->reference])}}" class="btn btn-outline-primary rounded-pill btn-sm small-button"
                        wire:navigate>
                            Manage
                        </a>
                    </div>
                </div>
                @endcan


            </div>
        </div>
    </div>
</div>
