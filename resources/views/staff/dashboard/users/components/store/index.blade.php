@extends('staff.dashboard.layout.base')
@section('content')

<livewire:staff.users.components.merchant.store.store-list :userId="$merchant->reference"/>

@endsection
