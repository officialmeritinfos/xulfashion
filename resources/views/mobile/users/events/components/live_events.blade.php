@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-4">

        <form class="theme-form profile-setting" action="{{route('mobile.user.events.new.live.process')}}" method="post" id="basicSettings"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Event Name<sup>
                        <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                           title="A name for this event - what is it?"></i> <span class="text-danger">*</span>
                    </sup>
                </label>
                <div class="form-input">
                    <input type="text" class="form-control" id="inputusernumber" placeholder="My Event" name="title"/>
                    <i class="fa fa-note-sticky"></i>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    Event Description <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                        title="Describe the event"></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="mb-3">
                    <textarea class="form-control editor" id="description" name="description" rows="10"></textarea>
                </div>
            </div>
            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Featured Photo  <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                            title="This is the photo that will first be seen by your customers - it should
                                            represent what you are posting else it will be rejected by compliance."></i></sup><sup class="text-danger">*</sup>
                </label>
                <div class="form-input">
                    <input type="file" class="form-control form-control-lg" id="inputusernumber" name="featuredPhoto" accept="image/*"/>
                    <i class="iconsax icons" data-icon="picture-upload"></i>
                </div>
            </div>
            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">State<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <select class="selectize" name="state">
                        <option value="">Select a Location</option>
                        @foreach($states as $state)
                            <option value="{{$state->iso2}}">{{$state->name}}</option>
                        @endforeach
                    </select>
                    <i class="iconsax icons" data-icon="map-2"></i>
                </div>
            </div>
            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Venue<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" placeholder="Freemont" name="location">
                    <i class="iconsax icons" data-icon="map-2"></i>
                </div>
            </div>
            <div class="form-group d-block mb-3 negotiate">
                <div class="form-input mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="hideVenue">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Hide Venue until Payment</label>
                    </div>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">What kind of Event is it?<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <div class="boxed-check-group boxed-check-warning row">
                        @foreach($categories as $category)
                            <div class="col-md-6 mt-2" data-bs-toggle="tooltip" title="{{$category->description}}">
                                <label class="boxed-check">
                                    <input class="boxed-check-input" type="radio" name="category" value="{{$category->id}}">
                                    <div class="boxed-check-label" style="text-align:center;">
                                        <h2>{{$category->name}} </h2>
                                        <span><i class="fa fa-circle-exclamation"></i></span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">How Do you schedule?<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <div class="boxed-check-group boxed-check-primary row">
                        <div class="col-md-6 mt-2" data-bs-toggle="tooltip" title="">
                            <label class="boxed-check">
                                <input class="boxed-check-input" type="radio" name="scheduleType" value="1" checked>
                                <div class="boxed-check-label" style="text-align:center;">
                                    <h2>One-time Event </h2>
                                    <span>
                                        <small>Your schedule is one-time, and does not repeat.</small>
                                    </span>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6 mt-2" data-bs-toggle="tooltip" title="">
                            <label class="boxed-check">
                                <input class="boxed-check-input" type="radio" name="scheduleType" value="2">
                                <div class="boxed-check-label" style="text-align:center;">
                                    <h2> Recurring Event </h2>
                                    <span>
                                        <small>Event repeats after a given period, and users get access with ticket</small>
                                    </span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Select your Timezone<sup class="text-danger">*</sup></label>
                <div class="form-input mb-4 position-relative">
                    <select class="selectize" id="merchantType" name="timezone">
                        @foreach(timezone_identifiers_list()  as $timezone)
                            <option value="{{$timezone}}"> (@timezoneOffset($timezone)) {{$timezone}} </option>
                        @endforeach
                    </select>
                    <i class="fa fa-filter"></i>
                </div>
            </div>
            <div class="form-group d-block">
                <label for="inputusernumber" class="form-label">Start Date<sup class="text-danger">*</sup></label>
                <div class="input-group mb-3">
                    <input type="date" class="form-control"  name="startDateOnetime">
                    <input type="time" class="form-control" name="startTimeOnetime">
                </div>
            </div>
            <div class="oneTimeComponents">
                <div class="form-group d-block">
                    <label for="inputusernumber" class="form-label">End Date<sup class="text-danger">*</sup></label>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control"  name="endDateOnetime">
                        <input type="time" class="form-control" name="endTimeOnetime">
                    </div>
                </div>
            </div>
            <div class="recurringComponents" style="display: none;">

                <div class="form-group d-block">
                    <label for="inputusernumber" class="form-label">Event Frequency<sup class="text-danger">*</sup></label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="2" aria-label="2" name="interval">
                        <select class="form-control selectize" name="frequency">
                            <option value="">Select Frequency</option>
                            @foreach($intervals as $interval)
                                <option value="{{$interval->id}}">{{$interval->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <h6 class="title">When does your event end?</h6>
                <div class="form-group d-block">
                    <div class="form-input mb-4 position-relative">
                        <div class="boxed-check-group boxed-check-warning row">
                            <div class="col-md-6 mt-2" data-bs-toggle="tooltip" title="On a Date">
                                <label class="boxed-check">
                                    <input class="boxed-check-input" type="radio" name="recurrenceEndType" value="1">
                                    <div class="boxed-check-label" style="text-align:center;">
                                        <h2>On Specific Date </h2>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6 mt-2" data-bs-toggle="tooltip" title="After count">
                                <label class="boxed-check">
                                    <input class="boxed-check-input" type="radio" name="recurrenceEndType" value="2">
                                    <div class="boxed-check-label" style="text-align:center;">
                                        <h2>After certain recurrence </h2>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group dateEnd" style="display: none;">
                        <div class="input-group mb-3">
                            <input type="date" class="form-control"  name="endDateRecur" aria-label="s">
                            <input type="time" class="form-control" name="endTimeRecur" aria-label="r">
                        </div>
                    </div>
                    <div class="form-group countEnd" style="display: none">
                        <div class="input-group mb-3">
                            <span class="input-group-text">After</span>
                            <input type="number" class="form-control" placeholder="3" aria-label="Username" name="numberOfOccurrence">
                            <span class="input-group-text">occurrences</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group d-block mb-3">
                <label for="inputusernumber" class="form-label">
                    Support Email<sup>
                        <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                           title="This is the email we will use to contact you if we need anything. This is also the
                   email your buyers will reach out to for help."></i> <span class="text-danger">*</span>
                    </sup>
                </label>
                <div class="form-input">
                    <input type="email" class="form-control" id="inputusernumber"  name="supportEmail"
                           value="{{$event->supportEmail}}"/>
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
            <h3 class="title">Social Details</h3>
            <div class="form-group d-block">
                <div class="form-input mb-4 position-relative">
                    <input type="url" class="form-control" aria-label="Username" aria-describedby="basic-addon1"
                           placeholder="Your Facebook Url" name="facebook">
                    <i class="fa fa-facebook"></i>
                </div>
            </div>
            <div class="form-group d-block">
                <div class="form-input mb-4 position-relative">
                    <input type="url" class="form-control" aria-label="Username" aria-describedby="basic-addon1"
                           placeholder="Your Twitter(X) Url" name="twitter">
                    <i class="fa fa-twitter"></i>
                </div>
            </div>
            <div class="form-group d-block">
                <div class="form-input mb-4 position-relative">
                    <input type="url" class="form-control" aria-label="Username" aria-describedby="basic-addon1"
                           placeholder="Your Instagram Url" name="instagram">
                    <i class="fa fa-instagram"></i>
                </div>
            </div>
            <div class="form-group d-block">
                <div class="form-input mb-4 position-relative">
                    <input type="url" class="form-control" aria-label="Username" aria-describedby="basic-addon1"
                           placeholder="Your Website Url" name="website">
                    <i class="fa fa-link"></i>
                </div>
            </div>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto">Continue</button>
            </div>
        </form>
    </div>


    @push('js')
        <script>
            $(function (){
                $('input[name="scheduleType"]').on('click',function (){
                    let values = $(this).val();
                    if (Number(values)===1 ){
                        $('.oneTimeComponents').show();
                        $('.recurringComponents').hide();
                    }else{
                        $('.oneTimeComponents').hide();
                        $('.recurringComponents').show();
                    }
                })
            });

            $(function (){
                $('input[name="recurrenceEndType"]').on('click',function (){
                    let values = $(this).val();
                    if (Number(values)===1 ){
                        $('.dateEnd').show();
                        $('.countEnd').hide();
                    }else{
                        $('.dateEnd').hide();
                        $('.countEnd').show();
                    }
                })
            });
        </script>
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    @endpush
@endsection
