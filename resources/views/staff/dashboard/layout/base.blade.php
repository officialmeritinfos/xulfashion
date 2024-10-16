<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }} - {{ $pageName }}</title>
    <link rel="icon" type="image/png" href="{{asset($web->favicon)}}" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{asset('staff/css/remixicon.css')}}">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/bootstrap.min.css')}}">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/apexcharts.css')}}">
    <!-- Data Table css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/dataTables.min.css')}}">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/editor-katex.min.css')}}">
    <link rel="stylesheet" href="{{asset('staff/css/lib/editor.atom-one-dark.min.css')}}">
    <link rel="stylesheet" href="{{asset('staff/css/lib/editor.quill.snow.css')}}">
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/flatpickr.min.css')}}">
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/full-calendar.css')}}">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/jquery-jvectormap-2.0.5.css')}}">
    <!-- Popup css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/magnific-popup.css')}}">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{asset('staff/css/lib/slick.css')}}">
    <!-- main css -->
    <link rel="stylesheet" href="{{asset('staff/css/style.css')}}">
    <!-- Remixicon CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/remixicon.css')}}">
    <!-- boxicons CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/css/boxicons.min.css')}}">
    @stack('css')
    @include('genericCss')
    @livewireStyles
    <style>
        @media (max-width: 767.98px) {
            .sidebar-nav{
                display: none;
            }
            #mobile-collapse{
                display: none;
            }
            /* Style for mobile devices */
            .footer-bottom {
                position: fixed;
                width: 100%;
                z-index: 9;
                bottom: 0;
                left: 0;
                background: #fff;
                border-top: 1px solid #DCDCE9;
            }
            .footer-bottom ul {
                margin: 0;
                padding: 0;
            }
            .footer-bottom ul li {
                list-style: none;
                display: inline-block;
                margin: 0 8px;
                padding: 10px 0 8px 0;
                position: relative; /* Added */
            }
            .footer-bottom ul li p {
                margin-bottom: 0;
                font-size: 10px;
                -webkit-transition: 0.4s;
                -o-transition: 0.4s;
                transition: 0.4s;
            }
            .footer-bottom ul li a {
                -webkit-transition: 0.4s;
                -o-transition: 0.4s;
                transition: 0.4s;
            }
            .footer-bottom ul li a:hover {
                color: #6236ff;
            }
            .footer-bottom ul li a:hover p {
                color: #6236ff;
            }
            /* Added */
            .footer-bottom .submenu {
                display: none;
                position: absolute;
                left: 0;
                top: 100%;
                background-color: #fff;
                border: 1px solid #ddd;
                width: 100%;
            }
            .footer-bottom .submenu li {
                display: block;
            }
            .footer-bottom .submenu li a {
                display: block;
                padding: 10px;
                color: #333;
                text-decoration: none;
            }
            .footer-bottom .submenu li a:hover {
                background-color: #f5f5f5;
            }
        }

        @media (min-width: 768px) {
            /* Hide navbar on larger screens */
            .footer-bottom {
                display: none;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <button type="button" class="sidebar-close-btn">
            <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
        </button>
        <div>
            <a href="{{route('staff.dashboard')}}" class="sidebar-logo" wire:navigate>
                <img src="{{asset($web->logo)}}" alt="site logo" class="light-logo">
                <img src="{{asset( $web->logo2 )}}" alt="site logo" class="dark-logo">
                <img src="{{asset($web->favicon)}}" alt="site logo" class="logo-icon">
            </a>
        </div>
        <div class="sidebar-menu-area">
            <ul class="sidebar-menu" id="sidebar-menu">
                <li>
                    <a href="{{ route('staff.dashboard') }}" wire:navigate style="font-size: 20px;">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                        <span>Overview</span>
                    </a>
                </li>
                <li class="sidebar-menu-group-title" >Application</li>
                <li class="dropdown">
                    <a href="javascript:void(0)" style="font-size: 20px;">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                        <span>Users</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="{{ route('staff.users.list') }}" wire:navigate><i
                                    class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                List</a>
                        </li>
                        <li>
                            <a href="{{ route('staff.users.new') }}" wire:navigate><i
                                    class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                Add new</a>
                        </li>
                    </ul>
                </li>

                @if($staff->can('create SystemStaff'))
                    <li class="dropdown">
                        <a href="javascript:void(0)" style="font-size: 20px;">
                            <iconify-icon icon="wpf:administrator" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                            <span>Staff</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{route('staff.staffs.list')}}" wire:navigate><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                    List</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if($staff->can('update SuperAdmin'))
                    <li class="dropdown">
                        <a href="javascript:void(0)" style="font-size: 20px;">
                            <iconify-icon icon="oui:app-users-roles" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                            <span>P & R</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{route('staff.roles')}}" wire:navigate><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                    Roles</a>
                            </li>
                            <li>
                                <a href="{{route('staff.permissions')}}" wire:navigate><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Permissions</a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{route('staff.ads.list')}}" wire:navigate style="font-size: 20px;">
                        <iconify-icon icon="mdi:advertisements" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                        <span>Ads</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('staff.events.list')}}" wire:navigate style="font-size: 20px;">
                        <iconify-icon icon="mdi:events" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                        <span>Events</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('staff.stores.list')}}" wire:navigate style="font-size: 20px;">
                        <iconify-icon icon="streamline:shopping-store-2-store-shop-shops-stores" class="menu-icon"
                                      style="font-size: 20px;"></iconify-icon>
                        <span>Stores</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('staff.orders.list')}}" wire:navigate style="font-size: 20px;">
                        <i class="ri-shopping-cart-2-line menu-icon" style="font-size: 20px;"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('staff.activity.index')}}" wire:navigate style="font-size: 22px;">
                        <i class="ri-dashboard-3-line menu-icon" style="font-size: 22px;"></i>
                        <span>Activities</span>
                    </a>
                </li>
                @if($staff->can('update GeneralSetting'))
                    <li class="dropdown">
                        <a href="javascript:void(0)" style="font-size: 20px;">
                            <iconify-icon icon="mdi-light:settings" class="menu-icon" style="font-size: 20px;"></iconify-icon>
                            <span>App Settings</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{route('staff.settings.general')}}" wire:navigate><i
                                        class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                    App Setup</a>
                            </li>
                            <li>
                                <a href="{{ route('staff.settings.service-types') }}" wire:navigate><i
                                        class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Service Types</a>
                            </li>
                            <li>
                                <a href="{{ route('staff.settings.event-categories') }}" wire:navigate><i
                                        class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                    Event Category</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </aside>

    <main class="dashboard-main">
        <div class="navbar-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <button type="button" class="sidebar-toggle">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                            <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                        </button>
                        <button type="button" class="sidebar-mobile-toggle">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                        </button>

                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <button type="button" data-theme-toggle
                            class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>


                        <div class="dropdown">
                            <button class="d-flex justify-content-center align-items-center rounded-circle"
                                type="button" data-bs-toggle="dropdown">
                                <img src="{{$user->photo??asset('staff/images/user.png')}}" alt="image"
                                    class="w-40-px h-40-px object-fit-cover rounded-circle">
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-sm">
                                <div
                                    class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="text-lg text-primary-light fw-semibold mb-2">{{ $user->name }}</h6>
                                        <span class="text-secondary-light fw-medium text-sm">{{
                                            Str::ucfirst($user->role) }}</span>
                                    </div>
                                    <button type="button" class="hover-text-danger">
                                        <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                                    </button>
                                </div>
                                <ul class="to-top-list">
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="{{route('staff.settings.profile')}}" wire:navigate>
                                            <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>
                                            My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                            href="{{ route('staff.logout') }}" wire:navigate>
                                            <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log
                                            Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- Profile dropdown end -->
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0" style="font-size: 5px;">{{ $pageName }}</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ url()->current() }}" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            {{ $pageName }}
                        </a>
                    </li>
                </ul>
            </div>

            @yield('content')

        </div>
        <footer class="d-footer">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p class="mb-0">© {{ date('Y') }} {{ $siteName }}. All Rights Reserved.</p>
                </div>
                <div class="col-auto">
                    <p class="mb-0">Made by <span class="text-primary-600">Kopium LLC</span></p>
                </div>
            </div>
        </footer>

        <div class="footer-bottom text-center">
            <ul>
                <li>
                    <a href="{{route('staff.dashboard')}}">
                        <i class="fa fa-home"></i>
                        <p>Overview</p>
                    </a>
                </li>
                <li>
                    <a href="{{route('staff.users.list')}}">
                        <i class="ri-group-line"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li>
                    <a href="{{route('staff.staffs.list')}}">
                        <i class="ri-table-alt-line"></i>
                        <p>Staff</p>
                    </a>
                </li>
                <li>
                    <a href="{{route('staff.ads.list')}}">
                        <i class="ri-advertisement-line"></i>
                        <p>ADS</p>
                    </a>
                </li>
                <li>
                    <a class="menu-bar" href="{{route('staff.stores.list')}}">
                        <i class="ri-store-2-line"></i>
                        <p>Stores</p>
                    </a>
                </li>
                <li>
                    <a class="menu-bar" href="{{route('staff.orders.list')}}">
                        <i class="ri-shopping-cart-2-line"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li>
                    <a class="menu-bar" href="{{route('staff.activity.index')}}">
                        <i class="ri-dashboard-3-line"></i>
                        <p>Activities</p>
                    </a>
                </li>
            </ul>
        </div>
    </main>
    <!-- jQuery library js -->
    <script src="{{asset('staff/js/lib/jquery-3.7.1.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('staff/js/lib/bootstrap.bundle.min.js')}}"></script>
    <!-- Apex Chart js -->
    <script src="{{asset('staff/js/lib/apexcharts.min.js')}}"></script>
    <!-- Data Table js -->
    <script src="{{asset('staff/js/lib/dataTables.min.js')}}"></script>
    <!-- Iconify Font js -->
    <script src="{{asset('staff/js/lib/iconify-icon.min.js')}}"></script>
    <!-- jQuery UI js -->
    <script src="{{asset('staff/js/lib/jquery-ui.min.js')}}"></script>
    <!-- Vector Map js -->
    <script src="{{asset('staff/js/lib/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{asset('staff/js/lib/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- Popup js -->
    <script src="{{asset('staff/js/lib/magnifc-popup.min.js')}}"></script>
    <!-- Slick Slider js -->
    <script src="{{asset('staff/js/lib/slick.min.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('staff/js/app.js')}}"></script>

    <script src="{{asset('staff/js/homeTwoChart.js')}}"></script>
    @stack('js')
    @include('basicInclude')
    @if ($staff->setPin!=1)
    <!-- Modal -->
    <div class="modal fade" id="setPin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Setup Authentication Pin</h1>
                </div>
                <div class="modal-body">
                    <livewire:staff.staff-set-pin />

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function(){
            $('#setPin').modal('show');
        });
    </script>

    <script>
        document.addEventListener('livewire:init', ()=> {
            Livewire.on('pinSetSuccessfully', function() {
            setTimeout(function() {
                // window.location.href = "{{ url()->previous() }}";
                $('#setPin').modal('hide');
            }, 2000); // 10-second delay
        });
    });
    </script>
    @endif
    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Boxed Tooltip
        $(document).ready(function() {
            $('.tooltip-button').each(function () {
                var tooltipButton = $(this);
                var tooltipContent = $(this).siblings('.my-tooltip').html();

                // Initialize the tooltip
                tooltipButton.tooltip({
                    title: tooltipContent,
                    trigger: 'hover',
                    html: true
                });

                // Optionally, reinitialize the tooltip if the content might change dynamically
                tooltipButton.on('mouseenter', function() {
                    tooltipButton.tooltip('dispose').tooltip({
                        title: tooltipContent,
                        trigger: 'hover',
                        html: true
                    }).tooltip('show');
                });
            });
        });
    </script>
</body>

</html>
