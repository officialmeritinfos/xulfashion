@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

@include('dashboard.common.components.home_data',['injected'=>$injected])
@includeWhen(!empty($store),'dashboard.common.components.home_store_data',['injected'=>$injected])

@endsection
