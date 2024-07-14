@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.users.components.merchant.ads.create-ad :userId="$merchant->reference">
@endsection
