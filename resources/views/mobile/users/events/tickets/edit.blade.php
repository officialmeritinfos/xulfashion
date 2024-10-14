@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            /* Styles for Add button */
            .btn.btn-add {
                display: inline-flex;
                align-items: center;
                background-color: #f24884 !important;
                color: white !important;
                border-radius: 5px;
                padding: 6px 12px;
                font-weight: bold;
                font-size: 14px;
                border: none !important;
            }
            .btn.btn-add i {
                margin-right: 5px;
            }

            /* Styles for Remove button */
            .btn.btn-remove {
                background-color: #f24884 !important;
                color: white !important;
                border: none !important;
                border-radius: 0 4px 4px 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                padding: 0 12px;
            }
            .btn.btn-remove i {
                font-size: 16px;
            }

            /* Input and Remove button alignment */
            .input-group.perk-item {
                display: flex;
                align-items: center;
            }
            .input-group.perk-item input.form-control {
                border-radius: 4px 0 0 4px;
            }


        </style>
    @endpush
    <div class="container mt-4">

        @includeWhen($ticket->ticketType=='single','mobile.users.events.tickets.components.edit_single_ticket')
        @includeWhen($ticket->ticketType!='single','mobile.users.events.tickets.components.edit_group_ticket')

    </div>
@endsection
