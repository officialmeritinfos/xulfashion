@extends('staff.dashboard.layout.base')
@section('content')
    <livewire:staff.users.components.merchant.store.invoices.invoice-detail :storeId="$store->reference" :invoiceId="$invoice->reference"/>

@endsection
