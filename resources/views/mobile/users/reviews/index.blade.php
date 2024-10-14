@extends('mobile.users.layout.base')
@section('content')
    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Merchant</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td style="font-size: 12px;">{{$review->merchants->displayName??$review->merchants->name}}</td>
                            <td style="font-size: 12px;">{{$review->rating}}/5</td>
                            <td style="font-size: 12px;">{{shortenText($review->comment,5)}}</td>
                            <td style="font-size: 12px;">
                                @switch($review->status)
                                    @case(1)
                                        <span class="badge bg-success">Active</span>
                                    @break
                                    @case(2)
                                        <span class="badge bg-primary">Review</span>
                                    @break
                                    @default
                                        <span class="badge bg-danger">Cancelled</span>
                                    @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{route('mobile.user.reviews.detail',['review'=>$review->reference])}}"
                                class="btn btn-outline-primary btn-auto">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{$reviews->links()}}
            </div>
        </div>

    </div>
@endsection
