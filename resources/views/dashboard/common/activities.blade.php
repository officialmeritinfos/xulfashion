@extends('dashboard.layout.base')
@section('content')
    @inject('option','App\Custom\Regular')

    <div class="order-details-area mb-0">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <a href="{{route('user.dashboard.activity.read.all')}}" class="new-orders">
                            Mark all as read
                            <i class="ri-add-circle-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">TITLE</th>
                            <th scope="col">CONTENT</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">DATE</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td>
                                    {{$activity->title}}
                                </td>
                                <td>
                                    {!! $activity->content !!}
                                </td>
                                <td>
                                    @switch($activity->status)
                                        @case(1)
                                            <span class="badge bg-success">Read</span>
                                            @break
                                        @default
                                            <span class="badge bg-primary">Unread</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{date('d M, Y - h:m A',strtotime($activity->created_at))}}
                                </td>

                                <td class="text-center">
                                    @if($activity->status!=1)
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.dashboard.activity.read',['id'=>$activity->id])}}">
                                                        Read
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{$activities->links()}}
                </div>
            </div>
        </div>
    </div>

@endsection
