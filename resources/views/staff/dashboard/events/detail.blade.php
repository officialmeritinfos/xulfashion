@extends('staff.dashboard.layout.base')
@section('content')

    <livewire:staff.events.details :eventId="$event->id" lazy/>

@endsection
