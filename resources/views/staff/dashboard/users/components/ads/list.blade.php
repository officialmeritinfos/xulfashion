@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.users.components.merchant.ads.ad-list :userId="$merchant->reference">
@endsection
