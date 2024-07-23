@extends('staff.dashboard.layout.base')
@section('content')

<livewire:staff.users.components.merchant.store.kyb.kyb-list :storeId="$store->reference"/>

@endsection
