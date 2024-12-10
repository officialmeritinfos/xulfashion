@extends('mobile.users.layout.mainDetailBase')
@section('content')

    <div class="container mt-5">
        <!-- Notify Attendees Card -->
        <div class="card">
            <div class="card-header text-center mt-2">
                <h4>Notify Attendees</h4>
            </div>
            <div class="card-body">
                <form id="basicSettings" action="{{route('mobile.user.events.attendees.notify.process',['event'=>$event->reference])}}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label for="notification_type" class="form-label">Notification Type</label>
                        <select class="form-select form-control form-control-lg" id="notification_type" name="notification_type" required>
                            <option value="reminder">Default Reminder</option>
                            <option value="custom">Custom Notification</option>
                        </select>
                    </div>
                    <div class="mb-2" id="custom-message-group" style="display: none;">
                        <textarea
                            type="text"
                            name="message"
                            class="form-control editor"
                            placeholder="Message"
                        ></textarea>
                    </div>

                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <!-- Add Guest Button -->
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-primary btn-sm w-100">Send Notification</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sent Notifications Card -->
        <div class="card mt-4">
            <div class="card-header mt-2 text-center">
                <h4>Sent Notifications</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Message</th>
                            <th>Sent At</th>
                            <th>Sent By</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($event->notifications as $notification)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $notification->message ?? 'Default Reminder' }}</td>
                                <td>{{ $notification->created_at->format('d M Y, h:i A') }}</td>
                                <td>{{ $notification->merchant->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No notifications sent yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                $('#basicSettings').on('submit', function (e) {
                    e.preventDefault(); // Prevent default form submission

                    // Fetch the form's action URL dynamically
                    let url = $(this).attr('action');

                    // Serialize the form data
                    let formData = $(this).serialize();

                    // Show loader or disable button to indicate processing
                    let submitButton = $(this).find('button[type="submit"]');
                    submitButton.prop('disabled', true).text('Sending...');

                    // AJAX request
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            if (response.success) {
                                // Show success notification using Toastr
                                toastr.success('Notification sent successfully!');

                                // Clear the form and reset fields
                                $('#basicSettings')[0].reset();
                                $('#custom-message-group').hide();
                            } else {
                                // Show error notification if the response contains an error
                                toastr.error(response.message || 'An error occurred.');
                            }
                        },
                        error: function (xhr) {
                            // Show error notification using Toastr
                            toastr.error(xhr.responseJSON.message || 'An error occurred while sending the notification.');
                        },
                        complete: function () {
                            // Re-enable the button and reset text
                            submitButton.prop('disabled', false).text('Send Notification');
                        }
                    });
                });

                // Toggle custom message field
                $('#notification_type').on('change', function () {
                    if ($(this).val() === 'custom') {
                        $('#custom-message-group').show();
                    } else {
                        $('#custom-message-group').hide();
                    }
                });
            });


        </script>

    @endpush
@endsection
