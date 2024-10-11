@extends('mobile.users.layout.base')
@section('content')

    @push('css')
        <style>
            .option-card {
                cursor: pointer;
                border: 1px solid #ddd;
                transition: border-color 0.3s ease;
            }
            .option-card:hover {
                border-color: #007bff;
            }
            .option-card.selected {
                border-color: #007bff;
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.25);
            }
        </style>
    @endpush
    <div class="container-fluid mt-4">
        <div class="modal fade" id="eventTypeModal" tabindex="-1" aria-labelledby="eventTypeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" id="eventTypeModalLabel">Select Event Type</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Event Type Options -->
                        <div class="row">
                            <!-- Online Event Card -->
                            <div class="col-12 mb-3 ">
                                <div class="card option-card shadow" data-url="{{route('mobile.user.events.new.online')}}" data-value="Online Event" onclick="selectOption(this)">
                                    <div class="card-body text-center">
                                        <div class="icon mb-2">
                                            <i class="fa-solid fa-signal text-warning"  style="width: 40px;"></i>
                                        </div>
                                        <h5 class="card-title">Online Event</h5>
                                        <p class="card-text">Takes place online and attendees join using web conferencing services</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <input type="radio" name="eventType" class="form-check-input" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Live Event Card -->
                            <div class="col-12 mb-3">
                                <div class="card option-card shadow" data-url="{{route('mobile.user.events.new.live')}}" data-value="Live Event" onclick="selectOption(this)">
                                    <div class="card-body text-center">
                                        <div class="icon mb-2">
                                            <i class="fa-solid fa-calendar-week text-warning"  style="width: 40px;"></i>
                                        </div>
                                        <h5 class="card-title">Live Event</h5>
                                        <p class="card-text">Takes place at a physical location and attendees join in person</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <input type="radio" name="eventType" class="form-check-input" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12">
                                <button type="button" id="continueButton" class="btn btn-auto btn-outline-warning"
                                        disabled onclick="redirectToUrl()">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(function (){
                $('#eventTypeModal').modal('show')
            })

            let selectedUrl = null;

            function selectOption(element) {
                // Remove active class from all cards and uncheck all radio buttons
                $('.option-card').removeClass('border-primary selected');
                $('.option-card input[type="radio"]').prop('checked', false);

                // Add active class to the clicked card and check its radio button
                $(element).addClass('border-primary selected');
                $(element).find('input[type="radio"]').prop('checked', true);

                // Enable the Continue button and set the URL
                selectedUrl = $(element).data('url');
                $('#continueButton').prop('disabled', false);
            }

            // jQuery click event for the Continue button
            $('#continueButton').on('click', function() {
                if (selectedUrl) {
                    window.location.href = selectedUrl;
                }
            });
        </script>
    @endpush
@endsection
