@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-4">
        @includeWhen($event->eventType==1,'mobile.users.events.components.edit_live_events')
        @includeWhen($event->eventType==2,'mobile.users.events.components.edit_online_events')
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                var currentEventState = "{{ $event->state }}";
                // Function to fetch states based on country code
                function fetchStates(countryCode) {

                    let loadingSpinner = $('#loading-spinner'); // Reference to the spinner

                    // Show the spinner
                    loadingSpinner.show();

                    $.ajax({
                        url: "{{ route('get.states') }}",  // URL to fetch states
                        type: "GET",
                        data: { country_code: countryCode },
                        success: function (states) {
                            let stateSelect = $('select[name="state"]');

                            if (stateSelect[0].selectize) {
                                stateSelect[0].selectize.destroy();
                            }

                            stateSelect.empty();  // Clear existing options


                            // Populate with new options
                            $.each(states, function (index, state) {
                                let selected = state.iso2 === currentEventState ? 'selected' : ''; // Check if matches current event state
                                stateSelect.append('<option value="' + state.iso2 + '" ' + selected + '>' + state.name + '</option>');
                            });
                            stateSelect.removeClass('form-control');
                            stateSelect.selectize()
                        },
                        complete: function () {
                            loadingSpinner.hide();
                        }
                    });
                }

                // Trigger state population on country change
                $('select[name="country"]').on('change', function () {
                    let countryCode = $(this).val();
                    if (countryCode) {
                        fetchStates(countryCode);
                    } else {
                        $('select[name="state"]').empty().append('<option value="">Select a Location</option>');
                    }
                });

                // Trigger the function on page load if a country is already selected
                let initialCountryCode = $('select[name="country"]').val();
                if (initialCountryCode) {
                    fetchStates(initialCountryCode);
                }
            });
        </script>
    @endpush
@endsection
