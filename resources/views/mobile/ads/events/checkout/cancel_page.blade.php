@extends('mobile.ads.events.components.cartBase')
@section('content')
    @push('css')
        <style>
            .status-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                text-align: center;
            }
            .status-message {
                font-size: 24px;
                margin-top: 20px;
            }
            .status-icon {
                font-size: 50px;
            }
            .loading-spinner {
                font-size: 30px;
            }
        </style>
    @endpush


    <div class="container status-container">
        <div>
            <div id="loading" class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Checking payment status...</p>
            </div>
            <div id="failure" class="d-none">
                <i class="fas fa-times-circle text-danger status-icon"></i>
                <p class="status-message text-danger">Payment Failed. Please try again.</p>
            </div>
        </div>
    </div>

@endsection
