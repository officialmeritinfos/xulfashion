@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            .popover-body {
                max-height: 250px;  /* Set maximum height for scroll */
                overflow-y: auto;   /* Enable vertical scrolling */
            }
            .example-message {
                font-style: italic;
                color: #555;
                padding-left: 10px;
                border-left: 3px solid #007bff;
                margin-top: 10px;
            }
        </style>
    @endpush
    <div class="container-fluid mt-5">
        <form class="theme-form profile-setting" action="{{route('mobile.user.events.tickets.email.process',['event'=>$event->reference])}}" method="post" id="basicSettings"
              enctype="multipart/form-data">
        @csrf
            <div class="form-group d-block mb-3">
                <label for="inputname" class="form-label">
                    E-mail message for Ticket Purchase <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                              title="This will be sent to the buyer upon successful purchase of ticket for this event."></i></sup>
                    <sup class="text-danger">*</sup>
                </label>
                <div class="mb-3">
                    <textarea class="form-control editor" id="description" name="message" rows="10">{{$event->successMail}}</textarea>
                </div>
                <small class="text-muted"><i class="fa fa-question-circle" id="popoverButton" data-bs-toggle="popover"
                                             title="How to Customize Your Success Message" data-bs-html="true"
                                                  data-bs-container="body"
                    data-bs-placement="top"></i> </small>
            </div>
            <div class="text-center mb-5 mt-3">
                <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-lg">Set Live</button>
            </div>
        </form>

    </div>

    @push('js')
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
        <script>
            $(function () {
                $('#popoverButton').popover({
                    html: true,
                    content: `
                    <p>To customize your success message, use the following variables to dynamically insert event and buyer details:</p>
                    <ul>
                        <li><strong>{title}</strong> - The title of your event.</li>
                        <li><strong>{description}</strong> - A brief description of the event.</li>
                        <li><strong>{start-date}</strong> - The start date of the event.</li>
                        <li><strong>{end-date}</strong> - The end date of the event (if applicable).</li>
                        <li><strong>{platform}</strong> - The platform where the event will be hosted (for online events).</li>
                        <li><strong>{link}</strong> - The link to access the event (for online events).</li>
                        <li><strong>{venue}</strong> - The physical venue of the event (for live events).</li>
                        <li><strong>{timezone}</strong> - The timezone of the event.</li>
                        <li><strong>{buyer-name}</strong> - The name of the ticket purchaser.</li>
                        <li><strong>{buyer-email}</strong> - The email of the ticket purchaser.</li>
                    </ul>
                    <p>For example, your message could be:</p>
                    <p class="example-message">
                        Thank you {buyer-name} for purchasing a ticket to {title}! The event starts on {start-date} at {venue}. See you there!
                    </p>
                `
                });
            });
        </script>
    @endpush
@endsection
