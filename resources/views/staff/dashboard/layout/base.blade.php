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
    @stack('css')
    @include('genericCss')
    @livewireStyles
</head>

<body>
    <aside class="sidebar">
        <button type="button" class="sidebar-close-btn">
            <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
        </button>
        <div>
            <a href="index" class="sidebar-logo">
                <img src="{{asset($web->logo)}}" alt="site logo" class="light-logo">
                <img src="{{asset( $web->logo2 )}}" alt="site logo" class="dark-logo">
                <img src="{{asset($web->favicon)}}" alt="site logo" class="logo-icon">
            </a>
        </div>
        <div class="sidebar-menu-area">
            <ul class="sidebar-menu" id="sidebar-menu">
                <li>
                    <a href="{{ route('staff.dashboard') }}" wire:navigate>
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>Overview</span>
                    </a>
                </li>
                <li class="sidebar-menu-group-title">Application</li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>User Management</span>
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

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>Staff Management</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                List</a>
                        </li>
                        <li>
                            <a href="#"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                                Add new</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="solar:document-text-outline" class="menu-icon"></iconify-icon>
                        <span>Stores</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="typography"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                List</a>
                        </li>


                        <li>
                            <a href="star-rating"><i class="ri-circle-fill circle-icon text-indigo w-auto"></i>
                                Add New</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                        <span>Order Management</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="form"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Input
                                List</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="mingcute:storage-line" class="menu-icon"></iconify-icon>
                        <span>Financial Management</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="table-basic"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Transactions List</a>
                        </li>
                        <li>
                            <a href="table-data"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                Account Funding</a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                        <span>General Settings</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="users-list"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Settings </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="terms-condition">
                        <iconify-icon icon="octicon:info-24" class="menu-icon"></iconify-icon>
                        <span>Notifications</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:void(0)">
                        <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                        <span>Settings</span>
                    </a>
                    <ul class="sidebar-submenu">
                        <li>
                            <a href="company"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                                Security</a>
                        </li>
                        <li>
                            <a href="notification"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                                General</a>
                        </li>
                    </ul>
                </li>
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
                            <button
                                class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
                                type="button" data-bs-toggle="dropdown">
                                <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                                <div
                                    class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
                                    </div>
                                    <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center
                                        align-items-center">05</span>
                                </div>

                                <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                                    <a href="javascript:void(0)"
                                        class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
                                        <div
                                            class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
                                            <span
                                                class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                                                <iconify-icon icon="bitcoin-icons:verify-outline" class="icon text-xxl">
                                                </iconify-icon>
                                            </span>
                                            <div>
                                                <h6 class="text-md fw-semibold mb-4">Congratulations</h6>
                                                <p class="mb-0 text-sm text-secondary-light text-w-200-px">Your profile
                                                    has been Verified. Your profile has been Verified</p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
                                    </a>
                                </div>

                                <div class="text-center py-12 px-16">
                                    <a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">See All
                                        Notification</a>
                                </div>

                            </div>
                        </div><!-- Notification dropdown end -->

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
                                            href="view-profile">
                                            <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>
                                            My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="email">
                                            <iconify-icon icon="tabler:message-check" class="icon text-xl">
                                            </iconify-icon> Inbox
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="company">
                                            <iconify-icon icon="icon-park-outline:setting-two" class="icon text-xl">
                                            </iconify-icon> Setting
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3"
                                            href="{{ route('staff.logout') }}">
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
