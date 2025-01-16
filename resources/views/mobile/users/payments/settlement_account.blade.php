@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            /* Custom Table Styling */
            .custom-table {
                border-collapse: separate;
                border-spacing: 0 8px;
            }

            .custom-table th {
                background-color: #f8f9fa;
                font-weight: 600;
                text-transform: uppercase;
                border-bottom: 2px solid #dee2e6;
            }

            .custom-table tbody tr {
                background-color: #fff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                transition: transform 0.2s ease-in-out;
            }

            .custom-table tbody tr:hover {
                transform: translateY(-3px);
            }

            .custom-table td, .custom-table th {
                padding: 1rem;
                vertical-align: middle;
            }

            .custom-table .btn-outline-primary {
                border-radius: 50%;
                padding: 0.35rem 0.45rem;
                font-size: 0.9rem;
                box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
            }

            .custom-table .btn-outline-primary:hover {
                background-color: #0d6efd;
                color: #fff;
            }

            .avatar img {
                border-radius: 50%;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            /* Tooltip Customization */
            [data-bs-toggle="tooltip"] {
                cursor: pointer;
            }
            /* Smooth transition for loading spinners */
            .spinner-border {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

        </style>
    @endpush
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            {{-- Main Currency Account Button --}}
            @if($payoutCurrency)
                <div class="col-6">
                    <div class="main mt-2 mb-5">
                        <div class="container-fluid text-center">
                            <button data-bs-toggle="modal" data-bs-target="#add-{{ strtolower($payoutCurrency->currency) }}-settlement"
                                    class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                                Add {{ $payoutCurrency->currency }} Account
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- USD Account Button --}}
            @if($payoutCurrency->currency !== 'USD')
                <div class="col-6">
                    <div class="main mt-2 mb-5">
                        <div class="container-fluid text-center">
                            <button data-bs-toggle="modal" data-bs-target="#add-usd-settlement"
                                    class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                                Add USD Account
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="container mt-3">
        <h2 class="mb-3 text-center text-muted">Payout Accounts</h2>
        {{-- Bank Cards --}}
        <livewire:mobile.users.payments.bank-lists :user="$user"/>
    </div>

    {{-- Include Modals for Adding Accounts --}}
    @include('mobile.users.payments.modals.add_settlement_account_modal', ['payout' => $payoutCurrency])



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

    </script>
@endsection
