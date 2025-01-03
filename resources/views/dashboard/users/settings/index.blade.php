@extends('dashboard.layout.base')
@section('content')

    <div class="container-fluid" style="margin-bottom: 5rem;">

        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-user-settings-line"></i> Portfolio Setting
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Manage your bio information
                    </p>
                </div>
                <a href="{{route('user.settings.portfolio')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-settings-2-line"></i> Basic Setting
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Manage your settings
                    </p>
                </div>
                <a href="{{route('user.settings.basic')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>


        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-lock-password-fill"></i> Security Setting
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Manage your account security
                    </p>
                </div>
                <a href="{{route('user.settings.security')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-bank-line"></i> Payout Accounts
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Add your payout accounts.
                    </p>
                </div>
                <a href="{{route('user.settings.payout')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-shield-check-fill"></i> User Verification
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Manage your Identity Verification
                    </p>
                </div>
                <a href="{{route('user.settings.verification')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>


        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-git-pull-request-line"></i> Features Requests
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Help us make {{$siteName}} better by requesting for a feature or upvoting on already requested features.
                    </p>
                </div>
                <a href="{{config('app.feature_request_url')}}" target="_blank" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Request
                </a>
            </div>
        </div>


    </div>
@endsection
