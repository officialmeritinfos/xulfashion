<!-- side bar start -->
<div class="offcanvas sidebar-offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft">
    <div class="offcanvas-header">
        @guest()
        <img class="img-fluid profile-pic" src="{{asset('mobile/images/icons/profile.png')}}" alt="profile" />
        @else
        <img class="img-fluid profile-pic" src="https://ui-avatars.com/api/?name={{$user->name}}" alt="profile" />
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
                        <img class="img-fluid profile-pic" src="https://ui-avatars.com/api/?name={{$user->name}}&rounded?true" alt="profile" />
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
    <div class="custom-container">
        <form class="theme-form search-head" target="_blank">
            <div class="form-group">
                <div class="form-input">
                    <input type="text" class="form-control search" id="inputusername" placeholder="Search here..." />
                    <i class="iconsax search-icon" data-icon="search-normal-2"></i>
                </div>

                <a href="#search-filter" class="btn filter-btn mt-0" data-bs-toggle="modal">
                    <i class="iconsax filter-icon" data-icon="media-sliders-3"></i>
                </a>
            </div>
        </form>
    </div>
</section>
<!-- search section end -->
