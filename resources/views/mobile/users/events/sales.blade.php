@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            .stats-panel {
                background-color: #ffeae2;
                border-radius: 10px;
                padding: 20px;
                margin-bottom: 20px;
            }
            .stat-item {
                text-align: center;
            }
            .stat-item h2 {
                color: #f24884;
                font-size: 24px;
                margin-bottom: 5px;
            }
            .stat-item p {
                color: #666;
                font-size: 14px;
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

    <div class="container mt-5">
        <!-- Stats Panel -->
        <div class="stats-panel d-flex justify-content-around align-items-center row">
            <div class="stat-item col-6 mt-3">
                <h2>{{shorten_number($ticketSold,0)}}</h2>
                <p>Tickets sold</p>
            </div>
            <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->totalSales}}">
                <h2>{{currencySign($user->mainCurrency)}}{{shorten_number($event->totalSales,2)}}</h2>
                <p>Total Sales revenue</p>
            </div>
            <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->currentBalance}}">
                <h2>{{currencySign($user->mainCurrency)}}{{shorten_number($event->currentBalance,2)}}</h2>
                <p>Current Balance</p>
            </div>
            <div class="stat-item col-6 mt-3" data-bs-toggle="tooltip" title="{{$event->balanceCleared}}">
                <h2>{{currencySign($user->mainCurrency)}}{{shorten_number($event->balanceCleared,2)}}</h2>
                <p>Balance Cleared</p>
            </div>
            <div class="stat-item col-6 mt-3">
                @if($event->currentBalance >0)
                    <h2>
                        {{date('d M, Y H:i',strtotime($event->nextSettlement))}}
                    </h2>
                @else
                    <h2>-</h2>
                @endif
                <p>Next payout date</p>
            </div>
        </div>

       <livewire:mobile.users.events.sales-analytics :user="$user" :event="$event" lazy/>

    </div>

    @push('js')
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
