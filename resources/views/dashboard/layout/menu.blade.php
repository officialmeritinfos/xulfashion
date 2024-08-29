@inject('injected','App\Custom\Regular')
<!-- Start Sidebar Area -->
<div class="side-menu-area">

        <div class="side-menu-logo bg-linear">
            <a href="{{url('/')}}" class="navbar-brand d-flex align-items-center">
                <img src="{{asset($web->favicon)}}" alt="image" style="width: 35px;">
                <span>{{$siteName}}</span>
            </a>

            <div class="burger-menu d-none d-lg-block">
                <span class="top-bar"></span>
                <span class="middle-bar"></span>
                <span class="bottom-bar"></span>
            </div>

            <div class="responsive-burger-menu d-block d-lg-none">
                <span class="top-bar"></span>
                <span class="middle-bar"></span>
                <span class="bottom-bar"></span>
            </div>
        </div>

    <nav class="sidebar-nav" data-simplebar>
        @if($user->completedProfile==1)
            <ul id="sidebar-menu" class="sidebar-menu">
                <li class="nav-item-title">MENU</li>
                <li>
                    <a href="{{$injected->userDashboard($user)}}" class="box-style">
                        <i class="ri-home-2-line"></i>
                        <span class="menu-title">Overview</span>
                    </a>
                </li>

                <li class="nav-item-title">APPS</li>
                @include('dashboard.layout.menu.user_menu')
            </ul>
        @else
            <ul id="sidebar-menu" class="sidebar-menu placeholder-glow">
                <li class="post">
                    <div class="avatar placeholder"></div>
                    <div class="line placeholder"></div>
                    <div class="line placeholder"></div>
                </li>
                <li class="post">
                    <div class="avatar placeholder"></div>
                    <div class="line placeholder"></div>
                    <div class="line placeholder"></div>
                </li>
                <li class="post">
                    <div class="avatar placeholder"></div>
                    <div class="line placeholder"></div>
                    <div class="line placeholder"></div>
                </li>
                <li class="post">
                    <div class="avatar placeholder"></div>
                    <div class="line placeholder"></div>
                    <div class="line placeholder"></div>
                </li>
                <li class="post">
                    <div class="avatar placeholder"></div>
                    <div class="line placeholder"></div>
                    <div class="line placeholder"></div>
                </li>

            </ul>
        @endif

    </nav>
</div>
<!-- End Sidebar Area -->


<div class="footer-bottom text-center">
    <ul>
        <li>
            <a href="{{$injected->userDashboard($user)}}">
                <i class="fa fa-home"></i>
                <p>Overview</p>
            </a>
        </li>
        <li>
            <a href="{{route('user.account.index')}}">
                <i class="bx bx-money"></i>
                <p>Account</p>
            </a>
        </li>
        <li>
            <a href="{{route('user.ads.index')}}">
                <i class="ri-table-alt-line"></i>
                <p>ADs</p>
            </a>
        </li>
        <li>
            <a href="{{route('user.stores.index')}}">
                <i class="ri-store-2-line"></i>
                <p>Stores</p>
            </a>
        </li>
        @if($injected->checkIfAccessorIsMobile())

            <li>
                <a class="menu-bar" href="{{route('mobile.marketplace.index',['country'=>$user->countryCode])}}">
                    <i class="bx bxs-business"></i>
                    <p>Marketplace</p>
                </a>
            </li>

        @endif
        <li>
            <a class="menu-bar" href="{{route('user.settings.index')}}">
                <i class="ri-settings-2-line"></i>
                <p>Settings</p>
            </a>
        </li>
    </ul>
</div>
