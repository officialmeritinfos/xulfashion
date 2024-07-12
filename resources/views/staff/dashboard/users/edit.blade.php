@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.users.user-edit :userId="$merchant->reference"/>

@endsection
