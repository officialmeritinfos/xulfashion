@extends('staff.dashboard.layout.base')
@section('content')
    <livewire:staff.users.components.merchant.store.order.order-detail :storeId="$store->reference" :orderId="$order->reference" />

@endsection
