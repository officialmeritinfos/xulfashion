@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.staffs.staff-details :staffs="$staffs"/>

@endsection
