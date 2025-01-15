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
    @endpush


    <div class="container-fluid mt-5">

        {{-- Bank Information Card --}}
        <livewire:mobile.users.payments.settlement-account-details :bank="$bank"/>

        {{-- Actions Card --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <livewire:mobile.users.payments.settlement-account-actions :bank="$bank"/>
            </div>
        </div>


        {{-- Transactions Card --}}
        <livewire:mobile.users.payments.settlement-account-transactions :bankId="$bank->reference"/>

    </div>

@endsection

@push('js')
    <x-livewire-alert::scripts />
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
@endpush
