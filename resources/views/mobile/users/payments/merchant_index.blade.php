@extends('mobile.users.layout.base')
@section('content')
    @push('css')
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
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Available Balance
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                            title="The total amount in your account balance which is can be withdrawn"></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3" data-bs-toggle="tooltip" title="{{currencySign($user->mainCurrency)}}{{ number_format($user->accountBalance,2) }}">
                            {{currencySign($user->mainCurrency)}}{{ shorten_number($user->accountBalance,2) }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Pending Balance
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                            title="The total amount in your account balance but cannot be withdrawn due incomplete KYC"></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3" data-bs-toggle="tooltip" title="{{currencySign($user->mainCurrency)}}{{ number_format($user->pendingBalance,2) }}">
                            {{currencySign($user->mainCurrency)}}{{ shorten_number($user->pendingBalance,2) }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Referral Balance
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                            title="The total amount you have earned through your referrals. "></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3" data-bs-toggle="tooltip" title="{{currencySign($user->mainCurrency)}}{{ number_format($user->referralBalance,2) }}">
                            {{currencySign($user->mainCurrency)}}{{ shorten_number($user->referralBalance,2) }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="main mt-2 mb-5">
                <div class="container-fluid text-center">
                    <a href="{{completedProfileMobile('mobile.user.settlement.account.index')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                        Payout Accounts
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-3 mb-5">
            <livewire:mobile.users.payments.transaction-list :user="$user" lazy/>
        </div>
        <div class="mt-3 mb-5">
            <livewire:mobile.users.payments.withdrawal-list :user="$user" lazy/>
        </div>


        {{-- Referral Link Section --}}
        <div class="row">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <h5 class="mb-0">Your Referral Link</h5>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="icon-field">
                                <a href="#" class="back" data-bs-toggle="offcanvas" data-bs-target="#referralListOffcanvas" aria-controls="referralListOffcanvas">
                                    Referral List <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $referralLink = route('mobile.register',['ref'=>$user->username]);
                        @endphp

                        <div class="input-group">
                            <input type="text" id="referralLink" class="form-control" value="{{ $referralLink }}" readonly>
                            <button class="input-group-text"  id="copyReferralLink">
                                <i class="fa fa-copy"></i> Copy
                            </button>
                        </div>
                        <small class="text-muted">Share this link with your friends and earn rewards!</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas for Referral List -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="referralListOffcanvas" aria-labelledby="referralListOffcanvasLabel">
        <div class="offcanvas-header bg-dark text-white">
            <h5 id="referralListOffcanvasLabel">Referral List</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
           <livewire:mobile.users.payments.referral-lists :user="$user" lazy />
        </div>
    </div>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const copyButton = document.getElementById('copyReferralLink');
                const referralLinkInput = document.getElementById('referralLink');

                copyButton.addEventListener('click', function () {
                    referralLinkInput.select();
                    referralLinkInput.setSelectionRange(0, 999999999999); // For mobile devices

                    navigator.clipboard.writeText(referralLinkInput.value)
                        .then(() => {
                            toastr.success('Referral link copied to clipboard!');
                        })
                        .catch(() => {
                            toastr.error('Failed to copy the referral link.');
                        });
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });

        </script>
        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    toastr.success('Transaction reference copied to clipboard!');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                });
            }
        </script>
    @endpush
@endsection
