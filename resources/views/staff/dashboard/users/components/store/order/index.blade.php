@extends('staff.dashboard.layout.base')
@section('content')
    <livewire:staff.users.components.merchant.store.order.order-list :storeId="$store->reference" />

@endsection
