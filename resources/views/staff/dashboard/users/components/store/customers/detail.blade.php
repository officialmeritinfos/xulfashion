@extends('staff.dashboard.layout.base')
@section('content')
<livewire:staff.users.components.merchant.store.customers.detail :storeId="$store->reference" :customerId="$customer->reference"/>

@endsection
