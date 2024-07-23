@extends('staff.dashboard.layout.base')
@section('content')

<livewire:staff.users.components.merchant.store.settings :storeId="$store->reference"/>

@endsection
