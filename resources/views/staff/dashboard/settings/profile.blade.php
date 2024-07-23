@extends('staff.dashboard.layout.base')
@section('content')

<livewire:staff.settings.profile />

    @push('js')
        <script>
            function initializePasswordToggle(toggleSelector) {
                $(toggleSelector).on('click', function() {
                    $(this).toggleClass("ri-eye-off-line");
                    var input = $($(this).attr("data-toggle"));
                    if (input.attr("type") === "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
                });
            }
            // Call the function
            initializePasswordToggle('.toggle-password');
        </script>
    @endpush
@endsection
