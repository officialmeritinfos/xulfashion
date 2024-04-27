@inject('injected','App\Custom\Regular')
@foreach($jobs as $job)
    <div class="col-lg-4 col-md-6 col-sm-6 mt-4 shadow">
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
