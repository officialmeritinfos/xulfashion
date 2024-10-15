@push('css')
    <style>
        .reviews-box {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .response-box {
            padding-left: 50px;
            border-left: 2px solid #eee;
            margin-top: 10px;
            margin-left: 25px;
        }

    </style>
@endpush
@foreach($reviews as $review)
    <div class="reviews-box">
        <!-- Review Content -->
        <div class="d-flex align-items-center gap-2">
            <img class="img-fluid profile-pic" src="{{$review->reviewers->photo ?? asset('mobile/images/icons/profile.png')}}"
                 alt="profile2" width="150"/>
            <div class="d-flex justify-content-between w-100 flex-start">
                <div>
                    <h4 class="theme-color">{{$review->reviewers->name}}</h4>
                    <h4 class="light-text mt-1">{{ $review->updated_at->diffForHumans() }}</h4>
                </div>
                <div class="d-flex align-items-start">
                    <img class="img-fluid stars" src="{{ asset('mobile/images/svg/Star.svg') }}" alt="star" />
                    <h4 class="theme-color fw-normal">{{ number_format($review->rating, 1) }}</h4>
                </div>
            </div>
        </div>
        <p>{{ $review->comment }}</p>

        <!-- Nested Responses -->
        @foreach($review->responses as $response)
            <div class="response-box mt-3 ml-5">
                <div class="d-flex align-items-center gap-2">
                    <img class="img-fluid profile-pic" src="{{$response->users->photo ?? asset('mobile/images/icons/profile.png')}}"
                         alt="profile" width="50"/>
                    <div class="d-flex justify-content-between w-100 flex-start">
                        <div>
                            <h5 class="theme-color">{{$response->users->name}}</h5>
                            <p class="light-text small">{{ $response->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                <p class="small ml-5">{{ $response->comment }}</p>
            </div>
        @endforeach
    </div>
@endforeach
