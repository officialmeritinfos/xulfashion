@extends('staff.dashboard.layout.base')
@section('content')
    <livewire:staff.users.components.merchant.store.products.product-list :storeId="$store->reference" />

@endsection
