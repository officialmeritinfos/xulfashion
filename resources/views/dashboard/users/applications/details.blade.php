@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')


    <div class="profile-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="profile-face">
                        <div class="row align-items-end justify-content-center">
                            <div class="col-lg-12 col-md-12">
                                <div class="projects">
                                    <h6>{{$job->title}}</h6>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-4">
                                <div class="projects">
                                    <h6><a href="{{$application->tutorCv}}" class="default-btn" target="_blank">View</a> </h6>
                                    <p class="mt-2">Submitted CV</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="today-card-area">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-sm-12">
                                <div class="single-today-card d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="today">{{$rateType->name}} Salary</span>
                                        <h6 style="word-break: break-word;font-size: 15px;">{{$job->currency}}{{number_format($job->amount,2)}}</h6>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <img src="{{asset('dashboard/images/icon/discount.png')}}" alt="Images">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-information">
                        <h6>Information</h6>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Employment Type :</th>
                                    <td>{{$jobType->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Duration :</th>
                                    <td>
                                        {{$job->intervals}} {{$interval->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Reference :</th>
                                    <td>
                                        <span class="badge bg-primary">{{$application->reference}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Application Status :</th>
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
                                </tr>
                                <tr>
                                    <th scope="row">Location :</th>
                                    <td>
                                        <span class="badge bg-primary">{{$job->country}},{{$job->state}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Opened :</th>
                                    <td>
                                        <span class="badge bg-primary">{{($application->opened)?'Open':'Not Seen'}}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="profile-information projects">
                        <h6>Cover Letter</h6>
                        <div class="projects">
                            <p>
                                {!! html_entity_decode($application->coverLetter) !!}
                            </p>
                        </div>
                    </div>
                    @if($application->invitedForInterview==1)
                        <div class="profile-information">
                            <h6>Interview Information</h6>
                            <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Interview Date:</th>
                                        <td>{{date('d F, Y h:i:s a',$application->interviewDate)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="profile-information projects">
                            <h6>Interview Instruction</h6>
                            <div class="projects">
                                <p>
                                    {!! html_entity_decode($application->interviewInstructions) !!}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>

@endsection
