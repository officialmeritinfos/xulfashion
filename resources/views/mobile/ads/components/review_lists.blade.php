@foreach($reviews as $review)
    <div class="reviews-box">
        <div class="d-flex align-items-center gap-2">
            <img class="img-fluid profile-pic" src="{{$review->reviewers->photo??asset('mobile/images/icons/profile.png')}}"
                 alt="profile2" width="150"/>
            <div class="d-flex justify-content-between w-100">
                <div>
                    <h4 class="theme-color">{{$review->reviewers->name}}</h4>
                    <h4 class="light-text mt-1">{{ $review->updated_at->diffForHumans() }}</h4>
                </div>
                <div class="d-flex align-items-start">
                    <img class="img-fluid stars" src="{{asset('mobile/images/svg/Star.svg')}}" alt="star" />
                    <h4 class="theme-color fw-normal">{{number_format($review->rating,1)}}</h4>
                </div>
            </div>
        </div>
        <p>{{ $review->comment }}</p>
    </div>
@endforeach