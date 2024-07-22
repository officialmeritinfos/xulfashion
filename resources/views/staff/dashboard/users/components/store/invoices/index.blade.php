@extends('staff.dashboard.layout.base')
@section('content')
    <livewire:staff.users.components.merchant.store.invoices.invoice-list :storeId="$store->reference"/>

@endsection
