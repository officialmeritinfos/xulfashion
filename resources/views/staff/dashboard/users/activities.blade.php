@extends('staff.dashboard.layout.base')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check style-check d-flex align-items-center">
                                <label class="form-check-label" for="checkAll">
                                    S.L
                                </label>
                            </div>
                        </th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($activities as $index=>$activity)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label" for="check1">
                                        {{$activities->firstItem()+$index}}
                                    </label>
                                </div>
                            </td>
                            <td>{{$activity->title}}</td>
                            <td>
                                <p class="d-flex align-items-center" style="word-break: break-word;">
                                    {{$activity->content}}
                                </p>
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
                            <td>{{$activity->created_at->format('d M. Y h:i:s a')}}</td>
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

@endsection
