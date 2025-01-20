@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            /* Scrollable container for action buttons */
            .scrollable-actions {
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 10px;
            }

            .scrollable-actions::-webkit-scrollbar {
                height: 8px;
            }

            .scrollable-actions::-webkit-scrollbar-thumb {
                background-color: #ccc;
                border-radius: 10px;
            }

            .scrollable-actions::-webkit-scrollbar-track {
                background-color: #f1f1f1;
            }

            /* Smooth scroll on hover */
            .scrollable-actions button {
                min-width: 160px;
            }

            @media (max-width: 576px) {
                .scrollable-actions button {
                    min-width: 140px;
                    font-size: 14px;
                }
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


    <div class="container-fluid mt-5">

        {{-- Bank Information Card --}}
        <div class="mb-3">
            <livewire:mobile.users.payments.settlement-account-details :bank="$bank" lazy/>
        </div>

        {{-- Actions Card --}}
        <div class="mb-3">
            <livewire:mobile.users.payments.settlement-account-actions :bank="$bank" lazy/>
        </div>

        {{-- Transactions Card --}}
        <div class="mb-3">
            <livewire:mobile.users.payments.settlement-account-transactions :bankId="$bank->reference" lazy/>
        </div>

    </div>

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Copy on click functionality
            document.querySelectorAll('.copyable').forEach(item => {
                item.addEventListener('click', function () {
                    const content = this.getAttribute('data-content');
                    navigator.clipboard.writeText(content).then(() => {
                        toastr.success('Copied to clipboard!');
                    }).catch(() => {
                        toastr.error('Failed to copy!');
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.addEventListener('success-withdrawal-message', event => {
                let url = event.detail.url;
                setTimeout(() => {
                    window.location.href = url;
                }, 5000);
            });
        });
    </script>
@endpush
