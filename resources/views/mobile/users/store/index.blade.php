@extends('mobile.users.layout.base')
@section('content')

@if(empty($store))
    @push('css')
        <style>
            /* Adjust spacing around the skeleton */
            .skeleton-container {
                max-width: 600px;
                margin: 50px auto;
            }
            .skeleton-card {
                margin-bottom: 20px;
            }
        </style>
    @endpush
    <div class="main mt-2 mb-5">
        <div class="container-fluid text-center">
            <a href="{{ route('mobile.user.store.initialize') }}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                Create your store
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="skeleton-container">
            <!-- Skeleton Loader -->
            <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="skeleton-gradient">
                        <stop offset="0%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="50%" stop-color="#e0e0e0">
                            <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="100%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                    </linearGradient>
                </defs>

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>

            <livewire:mobile.users.store.components.landing-page-preloader lazy/>

        </div>
    </div>

@else
    @push('css')
        <!-- Custom Styles -->
        <style>
            .dashboard-card {
                border: none;
                transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            }

            .icon-large {
                font-size: 2.5rem;
                margin-bottom: 10px;
            }

            .btn {
                padding: 10px 25px;
                font-size: 14px;
            }

            .btn-auto {
                width: auto;
                padding: 10px 30px;
            }
        </style>
        <style>
            /* Ensure the parent container does not overflow */
            .scrollable-table-container {
                width: 100%;
                max-width: 100%;
                overflow-x: auto !important;
                overflow-y: hidden !important;
                display: block;
                position: relative;
            }

            /* Control the table width */
            .scrollable-table-container table {
                width: max-content;
                min-width: 100%;
                border-collapse: collapse;
            }

            /* Prevent the table from affecting page layout */
            .scrollable-table-container th,
            .scrollable-table-container td {
                white-space: nowrap;
                padding: 10px;
            }

            /* Optional: Smooth scrollbar styling */
            .scrollable-table-container::-webkit-scrollbar {
                height: 8px;
            }

            .scrollable-table-container::-webkit-scrollbar-thumb {
                background-color: #ccc;
                border-radius: 10px;
            }

            .scrollable-table-container::-webkit-scrollbar-track {
                background-color: #f1f1f1;
            }

        </style>
    @endpush
    <div class="container-fluid">
        <div class="mb-2">
            <livewire:mobile.users.store.components.business-data :store="$store" lazy/>
        </div>
        <div class="mb-4">
            <livewire:mobile.users.store.components.business-actions lazy/>
        </div>

    </div>
@endif

@endsection
