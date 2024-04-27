@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')
    @include('dashboard.users.applications.components.menu')

    <div class="order-details-area mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">JOB</th>
                            <th scope="col">REFERENCE</th>
                            <th scope="col">DATE APPLIED</th>
                            <th scope="col">STATUS</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                        @foreach($applications as $application)
                            <tr>
                                <td>
                                    {{$injected->fetchJobById($application->jobId)->title}}
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{$application->reference}}</span>
                                </td>
                                <td>
                                    {{date('d-m-Y-H-i-s',strtotime($application->created_at))}}
                                </td>
                                <td>
                                    @switch($application->status)
                                        @case(1)
                                            <span class="badge bg-success">Accepted</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-info">Submitted</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-danger">Closed</span>
                                            @break
                                        @default
                                            <span class="badge bg-warning">Interviewing</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.applications.detail',['id'=>$application->reference])}}">
                                                    Details
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{$applications->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
