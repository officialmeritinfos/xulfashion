@extends('dashboard.layout.base')
@section('content')
    @include('dashboard.users.jobs.components.menu')

    <div class="container-fluid categories-area h-auto mb-5">
        <div class="d-none d-md-block">
            <form action="{{route('user.jobs.search')}}" method="GET" class="row g-3">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" name="title" placeholder="Search by Title">
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control selectize" name="state">
                        <option value="">Search By State</option>
                        @foreach($states as $state)
                            <option value="{{$state->iso2}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control selectize" name="work_type">
                        <option value="">Search By Job Type</option>
                        @foreach($jobTypes as $jobType)
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
                    <select class="form-control selectize" name="state">
                        <option value="">Search By State</option>
                        @foreach($states as $state)
                            <option value="{{$state->iso2}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 col-6">
                    <input type="text" class="form-control" name="title" placeholder="Search by Title">
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="default-btn">Search</button>
                </div>
            </form>
        </div>

        <div class="row justify-content-center" id="data-wrapper">

            @include('dashboard.users.jobs.job_data')
        </div>

        <!-- Data Loader -->
        <div class="auto-load text-center" style="display: none;">
            <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                <path fill="#000"
                      d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                      from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                </path>
            </svg>
        </div>
    </div>


    @push('js')

        <script>
            var ENDPOINT = "{{ route('user.jobs.index') }}";
            var page = 1;
            /*------------------------------------------
            --------------------------------------------
            Call on Scroll
            --------------------------------------------
            --------------------------------------------*/
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 20)) {
                    page++;
                    infinteLoadMore(page);
                }
            });

            /*------------------------------------------
            --------------------------------------------
            call infinteLoadMore()
            --------------------------------------------
            --------------------------------------------*/
            function infinteLoadMore(page) {
                $.ajax({
                    url: ENDPOINT + "?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                    .done(function (response) {
                        if (response.html == '') {
                            $('.auto-load').html("");
                            return;
                        }
                        $('.auto-load').hide();
                        $("#data-wrapper").append(response.html);
                    })
                    .fail(function (jqXHR, ajaxOptions, thrownError) {
                        console.log('Server error occured');
                    });
            }
        </script>
    @endpush
@endsection
