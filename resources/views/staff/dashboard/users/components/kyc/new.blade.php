@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.users.components.merchant.kyc.kyc-new :userId="$merchant->reference">



@endsection
