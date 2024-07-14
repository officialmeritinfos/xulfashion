@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.users.components.merchant.ads.ad-detail :userId="$merchant->reference" :adId="$ad->id">
@endsection
