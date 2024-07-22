@extends('staff.dashboard.layout.base')
@section('content')
    <livewire:staff.users.components.merchant.store.categories.category-list :storeId="$store->reference" />

@endsection
