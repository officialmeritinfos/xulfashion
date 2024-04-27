@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="container-fluid categories-area h-auto mb-5">
        <div class="d-none d-md-block">
            <form action="{{route('user.jobs.search')}}" method="GET" class="row g-3">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="title" placeholder="Search by Title" value="{{key_exists('title',$searchParam)?$searchParam['title']:''}}">
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control selectize" name="state">
                        <option value="">Search By State</option>
                        @foreach($states as $state)
                            @if(key_exists('state',$searchParam) && $state->iso2==$searchParam['state'])
                                <option value="{{$state->iso2}}" selected>{{$state->name}}</option>
                                @continue
                            @endif
                            <option value="{{$state->iso2}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control selectize" name="work_type">
                        <option value="">Search By Job Type</option>
                        @foreach($jobTypes as $jobType)
                            @if(key_exists('work_type',$searchParam) && $jobType->id==$searchParam['work_type'])
                                <option value="{{$jobType->id}}" selected>{{$jobType->name}}</option>
                                @continue
                            @endif
                            <option value="{{$jobType->id}}">{{$jobType->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!--Mobile view-->
        <div class="d-md-none d-block">
            <form action="{{route('user.jobs.search')}}" method="GET" class="row g-3">
                <div class="form-group col-md-3 col-6">
                    <input type="text" class="form-control" name="title" placeholder="Search by Title"
                           value="{{key_exists('title',$searchParam)?$searchParam['title']:''}}">
                </div>
                <div class="form-group col-md-3 col-6">
                    <select class="form-control selectize" name="state">
                        <option value="">Search By State</option>
                        @foreach($states as $state)
                            @if(key_exists('state',$searchParam) && $state->iso2==$searchParam['state'])
                                <option value="{{$state->iso2}}" selected>{{$state->name}}</option>
                                @continue
                            @endif
                            <option value="{{$state->iso2}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="default-btn">Search</button>
                </div>
            </form>
        </div>
            @if(isset($jobs) && !$jobs->isEmpty())
                <div class="row justify-content-center" id="data-wrapper">
                    @include('dashboard.users.jobs.job_data')
                    <div class="ui-kit-card mt-5">
                        {{$jobs->links()}}
                    </div>
                </div>
            @else
                <div class="row mt-3">
                    <div class="col">
                        <div class="ui-kit-card mb-24">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    No results found. Please check below for similar jobs or search again using another parameter
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        @if(isset($fallbackJobs) && !$fallbackJobs->isEmpty())
            <div class="row mt-5" style="margin-bottom: 1rem;">
                <div class="col-12">
                    <h4 class="text-center text-primary">You might like</h4>
                </div>
                <div class="large-12 columns">
                    <div class="owl-carousel owl-theme">
                        @foreach($fallbackJobs as $job)
                            <div class="col-lg-12 col-md-12 col-sm-6 mt-4 shadow">
                                <div class="single-cat mb-30">
                                    <div class="cat-cap">
                                        <h5 class="text-center"><a href="{{route('user.jobs.detail',['id'=>$job->reference])}}">{{$job->title}}</a></h5>
                                        <ul>
                                            <li>
                                                <p><i class="bx bx-money"></i>{{$job->currency}}{{$injected->shortenNumberToLetters($job->amount,2)}} {{$injected->paymentType($job->paymentType)->name}}</p>
                                            </li>
                                            <li>
                                                <p><i class="fas fa-map-marker-alt"></i> {{$job->country}}, {{$job->state}}</p>
                                            </li>
                                            <li>
                                                <p><i class="bx bx-briefcase-alt"></i>{{$injected->jobTypeById($job->typeOfJob)->name}}</p>
                                            </li>
                                        </ul>
                                        <div class="pricing d-flex justify-content-between align-items-center">
                                            <div class="left">
                                                <img src="{{$injected->employerById($job->user)->photo}}" style="width: 100px;">
                                                <p>{{$injected->fetchRecruiterName($job->user)}}</p>
                                            </div>
                                            <span class="time">{{$injected->getTimeAgo($job->created_at)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>



    @push('js')
        <script>
            $(document).ready(function() {
                var owl = $('.owl-carousel');
                owl.owlCarousel({
                    items: 4,
                    loop: true,
                    margin: 10,
                    autoplay: true,
                    autoplayTimeout: 1000,
                    autoplayHoverPause: true,
                    responsiveClass:true,
                    responsive:{
                        0:{
                            items:1,
                            nav:true
                        },
                        600:{
                            items:3,
                            nav:false,
                            loop:true
                        },
                        1000:{
                            items:4,
                            nav:false,
                            loop:true
                        }
                    }
                });
            })
        </script>
    @endpush
@endsection
