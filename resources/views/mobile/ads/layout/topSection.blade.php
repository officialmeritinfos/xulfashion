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
    <div class="custom-container mt-4">
        <form class="theme-form search-head" action="{{route('mobile.marketplace.search')}}" method="get">
            <div class="form-group">
                <div class="form-input">
                    <select class="form-control form-control-lg stateAds" aria-label="Default select example" name="state">
                        <option value="" data-value="{{route('mobile.marketplace.index')}}">All of {{$country->name}}</option>
                        @foreach($states as $state)
                            <option value="{{$state->iso2}}" {{(isset($params['state']) && $params['state']==$state->iso2)?'selected':''}} >{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-input">
                    <select class="form-control form-control-lg categoryAds" aria-label="Default select example" name="category">
                        <option value="" data-value="{{route('mobile.marketplace.index')}}">All</option>
                        @foreach($serviceTypes as $serviceType)
                            <option value="{{$serviceType->id}}" {{( isset($params['category']) && $params['category']==$serviceType->id)?'selected':''}}>{{$serviceType->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-input">
                    <input class="form-control-lg form-control" type="submit" aria-label="Default select example" value="Search"/>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- search section end -->
