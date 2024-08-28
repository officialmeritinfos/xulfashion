@inject('injected','App\Custom\Regular')
<ul class="navbar-nav ms-auto mb-lg-0">
    <li class="nav-item">
        <a href="#" class="nav-link ri-fullscreen-btn" id="fullscreen-button">
            <i class="ri-fullscreen-line"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" id="theme-switcher">
            <i id="theme-icon" class="ri-moon-line"></i>
        </a>
    </li>

    <li class="nav-item notification-box dropdown">
        <div class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="notification-btn">
                <i class="ri-notification-2-line"></i>
                <span class="badge">{{$injected->fetchUserActivities($user)->count()}}</span>
            </div>
        </div>

        <div class="dropdown-menu">
            <div class="dropdown-header d-flex justify-content-between align-items-center bg-linear">
                <span class="title d-inline-block">{{$injected->fetchUserActivities($user)->count()}} unread Notifications</span>
            </div>

            <div class="dropdown-body" data-simplebar>
                @foreach($injected->fetchUserActivities($user) as $activity)
                    <a href="{{route('user.dashboard.activity.read',['id'=>$activity->id])}}" class="dropdown-item d-flex align-items-center">
                        <div class="icon">
                            <i class='bx bx-message-rounded-dots'></i>
                        </div>

                        <div class="content">
                            <span class="d-block">{{$activity->title}}</span>
                            <p class="sub-text mb-0">{{$injected->getTimeAgo($activity->created_at)}}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="dropdown-footer">
                <a href="{{route('user.dashboard.activity')}}" class="dropdown-item">View All</a>
            </div>
        </div>
    </li>

    <li class="nav-item dropdown profile-nav-item">
        <a class="nav-link dropdown-toggle avatar" href="#" id="navbarDropdown-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{empty($user->photo)?asset('dashboard/images/avatar1.png'):$user->photo}}" alt="Images"
            style="width: 50px;">
            <h3>{{$user->name}}</h3>
            <span>{{($user->completedProfile!=1)?'N/A':$accountType}}</span>
        </a>

        <div class="dropdown-menu">
            <div class="dropdown-header d-flex flex-column align-items-center">
                <div class="figure mb-3">
                    <img src="{{empty($user->photo)?asset('dashboard/images/avatar1.png'):$user->photo}}" class="rounded-circle" alt="image"
                         style="width: 50px;">
                </div>

                <div class="info text-center">
                    <span class="name">{{$user->name}}</span>
                    <p class="mb-3 email">
                        {{$user->reference}}
                    </p>
                </div>
            </div>

            <div class="dropdown-body">
                <ul class="profile-nav p-0 pt-3">
                    <li class="nav-item">
                        <a href="{{route('user.settings.portfolio')}}" class="nav-link">
                            <i class="ri-user-line"></i>
                            <span>Profile</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('user.dashboard.activity.all')}}" class="nav-link">
                            <i class="ri-book-open-fill"></i>
                            <span>My Activities</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('user.settings.payout')}}" class="nav-link">
                            <i class="ri-bank-fill"></i>
                            <span>Payout Account</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('user.settings.index')}}" class="nav-link">
                            <i class="ri-settings-5-line"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{config('app.feature_request_url')}}" class="nav-link" target="_blank">
                            <i class="ri-git-pull-request-line"></i>
                            <span>Features Request</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown-footer">
                <ul class="profile-nav">
                    @if($injected->checkIfAccessorIsMobile())
                        <li class="nav-item">
                            <a href="{{route('logout.mobile')}}" class="nav-link">
                                <i class="ri-login-circle-line"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link">
                                <i class="ri-login-circle-line"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </li>


</ul>
