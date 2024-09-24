@extends('mobile.users.layout.innerBase')
@section('content')

    <section class="section-b-space pt-0">
        <div class="custom-container">
            <ul class="profile-list">
                <li>
                    <a href="{{route('mobile.user.post.ads')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="box"></i>
                        </div>
                        <div class="profile-details">
                            <h4>ADS</h4>
                            <h5>Post your ads</h5>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{route('mobile.user.coming.soon')}}" class="profile-box">
                        <div class="profile-img">
                            <i class="iconsax icon" data-icon="receipt-2"></i>
                        </div>
                        <div class="profile-details">
                            <h4>Bookings</h4>
                            <h5>Ongoing bookings, recent booking, past bookings</h5>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{route('mobile.user.coming.soon')}}" class="profile-box">
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
                    <a href="{{route('mobile.user.coming.soon')}}" class="profile-box">
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
                            <h5>Dark mode settings</h5>
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
            </ul>
        </div>
    </section>
    <!-- profile section start -->

@endsection
