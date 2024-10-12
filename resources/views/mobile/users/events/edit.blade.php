@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-4">
        @includeWhen($event->eventType==1,'mobile.users.events.components.edit_live_events')
        @includeWhen($event->eventType==2,'mobile.users.events.components.edit_online_events')
    </div>
@endsection
