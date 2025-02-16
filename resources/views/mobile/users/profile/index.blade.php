@extends('mobile.users.layout.innerBase')
@section('content')
    <div class="main mt-2 mb-3">
        <div class="container-fluid text-center">
            <a href="{{completedProfileMobile('mobile.user.ads.new')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                Post an AD
            </a>
        </div>
    </div>
    <section class="section-b-space pt-0">
        <div class="custom-container">
            <ul class="profile-list">
                <li>
                    <a href="{{completedProfileMobile('mobile.user.ads.index')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="box"></i>
                        </div>
                        <div class="profile-details">
                            <h4>ADS</h4>
                            <h5>Post, manage your listings/ads</h5>
                        </div>
                    </a>
                </li>


                <li>
                    <a href="{{completedProfileMobile('mobile.user.store.index')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="shop"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Store</h4>
                            <h5>Create & Manage Your Store</h5>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{route('mobile.user.events.index')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="receipt-2"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Events</h4>
                            <h5>Create & Manage events, buy tickets to fashion events.</h5>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{route('mobile.user.payments.index')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="wallet-open"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Payments</h4>
                            <h5>Transaction History, Wallet</h5>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{route('mobile.user.reviews.index')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="star"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Reviews</h4>
                            <h5>All your reviews</h5>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{route('mobile.user.app.settings')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="setting-1"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Settings</h4>
                            <h5>Notifications, 2FA etc</h5>
                        </div>
                    </a>
                </li>

                <li class="border-bottom-0">
                    <a href="{{route('mobile.user.help')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="phone"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Help</h4>
                            <h5>Customer Support</h5>
                        </div>
                    </a>
                </li>
                @if($user->isVerified==3 || $user->isVerified==2)
                    <li>
                        <a href="{{completedProfileMobile('mobile.user.user.kyc')}}" class="profile-box">
                            <div class="profile-img">
                                <i class="iconsax icon" data-icon="shield-tick"></i>
                            </div>
                            <div class="profile-details">
                                <h4>Account Verification</h4>
                                <h5>Submission not received</h5>
                            </div>
                        </a>
                    </li>
                @elseif($user->isVerified==4)
                    <li>
                        <a href="{{completedProfileMobile('mobile.user.user.kyc')}}" class="profile-box ">
                            <div class="profile-img bg-info"  data-bs-toggle="tooltip" title="Submission under review">
                                <i class="iconsax icon" data-icon="shield-tick"></i>
                            </div>
                            <div class="profile-details">
                                <h4>Verification Status </h4>
                                <h5>
                                    Pending Review
                                </h5>
                            </div>
                        </a>
                    </li>
                @else

                    <li>
                        <a href="{{completedProfileMobile('mobile.user.user.kyc')}}" class="profile-box ">
                            <div class="profile-img bg-success"  data-bs-toggle="tooltip" title="Account Verified">
                                <i class="iconsax icon" data-icon="shield-tick"></i>
                            </div>
                            <div class="profile-details">
                                <h4>Verification Status</h4>
                                <h5>
                                    <i class="fa fa-user-check text-success"></i>
                                </h5>
                            </div>
                        </a>
                    </li>
                @endif


                <li>
                    <a href="{{route('mobile.user.coming.soon')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="teacher"></i>
                        </div>
                        <div class="profile-details">
                            <h4>School</h4>
                            <h5>Host admissions, classes etc in your business</h5>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <!-- profile section start -->

@endsection
