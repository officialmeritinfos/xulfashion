@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-5">
        <section class="gradient-custom card">
            <div class="row card-body">
                <div class="col-12">
                    <div class="d-flex flex-start">
                        <img class="rounded-circle shadow-1-strong me-3"
                             src="{{$review->reviewers->photo ?? asset('mobile/images/icons/profile.png')}}" alt="avatar" width="65"
                             height="65" />
                        <div class="flex-grow-1 flex-shrink-1">
                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-1">
                                        {{$review->reviewers->name}} <span class="small">- {{ $review->updated_at->diffForHumans() }}</span>
                                    </p>
                                    <a href="javascript:void(0)" class="reply-toggle back"><i class="fas fa-reply fa-xs"></i><span class="small"> reply</span></a>
                                </div>
                                <p class="small mb-0">
                                    {{ $review->comment }}
                                </p>
                            </div>

                            <!-- Reply Form (initially hidden) -->
                            <div class="reply-form mt-2" style="display: none;">
                                <form action="{{ route('mobile.user.reviews.reply.process',['review'=>$review->reference]) }}" method="POST"
                                      id="basicSettings">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" name="reply" placeholder="Write your reply..."></textarea>
                                    </div>
                                    <div class="justify-content-center">
                                        <button type="button" class="btn btn-secondary btn-sm mt-2 cancel-reply btn-auto">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 btn-auto submit">Submit</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Responses -->
                            @foreach($responses as $response)
                                <div class="d-flex flex-start mt-4">
                                    <a class="me-3" href="#">
                                        <img class="rounded-circle shadow-1-strong"
                                             src="{{$response->users->photo ?? asset('mobile/images/icons/profile.png')}}" alt="avatar"
                                             width="40" height="40" />
                                    </a>
                                    <div class="flex-grow-1 flex-shrink-1">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-1">
                                                    {{$response->users->name}} <span class="small">- {{ $response->updated_at->diffForHumans() }}</span>
                                                </p>
                                            </div>
                                            <p class="small mb-0">
                                                {{$response->comment}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    @push('js')
        <script>
            $(document).ready(function () {
                // Toggle reply form visibility
                $('.reply-toggle').click(function () {
                    $(this).closest('.flex-grow-1').find('.reply-form').toggle();
                });

                // Hide the reply form on cancel
                $('.cancel-reply').click(function () {
                    $(this).closest('.reply-form').hide();
                });
            });
        </script>
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    @endpush
@endsection
