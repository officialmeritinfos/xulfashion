<!-- side bar start -->
<div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft">
    <div class="offcanvas-header">
        @guest()
        <img class="img-fluid profile-pic" src="{{asset('mobile/images/icons/profile.png')}}" alt="profile" />
        @else
        <img class="img-fluid profile-pic" src="{{empty($user->photo)?asset('mobile/images/icons/profile.png'):$user->photo}}" alt="profile" />
        @endguest
        <h4>Hello, {{$user->name??'Guest'}}!</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="sidebar-content">
            <ul class="link-section">
                <li>
                    <div class="pages">
                        <h4>Dark</h4>
                        <div class="switch-btn">
                            <input id="dark-switch" type="checkbox" />
                        </div>
                    </div>
                </li>
                @guest()
                    <li>
                        <a href="{{route('mobile.login')}}" class="pages">
                            <h4>Login</h4>
                            <i class="ri-arrow-drop-right-line"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('mobile.register')}}" class="pages">
                            <h4>Register</h4>
                            <i class="ri-arrow-drop-right-line"></i>
                        </a>
                    </li>
                @endguest
                @auth()
                    <li>
                        <a href="{{route('logout.mobile')}}" class="pages">
                            <h4>Logout</h4>
                            <i class="ri-arrow-drop-right-line"></i>
                        </a>
                    </li>
                @endauth
                <li>
                    <a href="{{ config('app.feature_request_url') }}" class="pages" target="_blank">
                        <h4>Request a Feature</h4>
                        <i class="ri-arrow-drop-right-line"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('mobile.legal.privacy-policy')}}" class="pages">
                        <h4>Privacy Policy</h4>
                        <i class="ri-arrow-drop-right-line"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- side bar end -->

<!-- header start -->
<header class="section-t-space">
    <div class="custom-container">
        <div class="header">
            <div class="head-content">
                <button class="sidebar-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
                    <i class="iconsax menu-icon" data-icon="menu-hamburger"></i>
                </button>
                <div class="header-info">
                    @guest()
                        <img class="img-fluid profile-pic" src="{{asset('mobile/images/icons/profile.png')}}" alt="profile" />
                    @else
                        <img class="img-fluid profile-pic" src="{{empty($user->photo)?asset('mobile/images/icons/profile.png'):$user->photo}}" alt="profile" />
                    @endguest

                    <div>
                        <h4 class="light-text">Welcome</h4>
                        <h2 class="theme-color">{{$user->name??'Guest'}}!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->

<!-- search section starts -->
<section>
    <div class="custom-container mt-4">
        <form class="theme-form search-head row" action="{{ route('mobile.marketplace.search') }}" method="get">
            <div class="form-group mb-2">
                <!-- State Select -->
                <div class="form-input">
                    <select class="form-control form-control-lg" aria-label="Default select example" name="state">
                        <option value="" data-value="{{ route('mobile.marketplace.index') }}">All of {{ $country->name }}</option>
                        @foreach($states as $state)
                            <option value="{{ $state->iso2 }}" {{ (isset($params['state']) && $params['state'] == $state->iso2) ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Industry Select -->
                <div class="form-input">
                    <select class="form-control form-control-lg industrySelect" aria-label="Default select example" name="industry">
                        <option value="" data-value="{{ route('mobile.marketplace.index') }}">All Industry</option>
                        <option value="fashion" {{ (isset($params['industry']) && $params['industry'] == 'fashion') ? 'selected' : '' }}>Fashion</option>
                        <option value="beauty" {{ (isset($params['industry']) && $params['industry'] == 'beauty') ? 'selected' : '' }}>Beauty</option>
                    </select>
                </div>
            </div>
            <div class="form-group mb-2">
                <!-- Category Select -->
                <div class="form-input">
                    <select class="form-control form-control-lg categorySelect" aria-label="Default select example" name="category" data-selected="{{ $params['category'] ?? '' }}">
                        <option value="" data-value="{{ route('mobile.marketplace.index') }}">All</option>

                    </select>
                </div>
                <div class="form-input">
                    <input type="text" class="form-control form-control-lg" id="search-input" placeholder="Search here..." name="search"/>
                    <div id="suggestions-box" class="suggestions-box"></div>
                </div>

            </div>
            <div class="form-group">
                <!-- Submit Button -->
                <div class="form-input">
                    <button class="form-control-lg form-control search-btn" type="submit" aria-label="Search">
                        <i class="fa fa-search"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>
</section>
<!-- search section end -->
