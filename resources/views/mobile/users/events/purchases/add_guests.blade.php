@extends('mobile.users.layout.base')
@section('content')

    <section class="section-b-space">
        <div class="custom-container">
           x
        </div>
    </section>




    @push('js')
        <script>
            $(document).ready(function () {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                };

                const maxGuests = {{ ($ticket->number_admits * $ticket->quantity) - count($ticket->guests) }}; // Maximum guests allowed
                let guestCount = 0;

                // Add Guest Button Click Handler
                $('#add-guest-button').on('click', function () {
                    if (guestCount >= maxGuests) {
                        toastr.error('You have reached the maximum number of guests for this ticket.');
                        return;
                    }

                    addGuestField();
                });

                // Function to Add a New Guest Input Field
                function addGuestField() {
                    const guestField = `
            <div class="mb-4 guest-input-group" id="guest-field-${guestCount + 1}">
                <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label">
                        Guest ${guestCount + 1} Details
                    </label>
                    <i class="fa fa-trash text-danger delete-guest-button" style="cursor: pointer;" title="Remove Guest"></i>
                </div>

                <!-- Name -->
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                    <input
                        type="text"
                        name="guests[${guestCount}][name]"
                        class="form-control"
                        placeholder="Guest Name"
                        required
                    />
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input
                        type="email"
                        name="guests[${guestCount}][email]"
                        class="form-control"
                        placeholder="Guest Email"
                        required
                    />
                </div>

                <!-- Ticket Code -->
                <label class="form-label">Ticket Code</label>
                <div class="input-group mb-3">
                    <input
                        type="text"
                        name="guests[${guestCount}][ticketCode]"
                        class="form-control"
                        placeholder="Generate ticket code"
                        readonly
                        required
                    />
                    <span class="input-group-text generate-code-button">
                        Generate
                    </span>
                </div>
            </div>
        `;

                    $('#guest-fields-container').append(guestField);
                    guestCount++;
                }

                // Delete Guest Field
                $(document).on('click', '.delete-guest-button', function () {
                    $(this).closest('.guest-input-group').remove();
                    guestCount--;
                });

                // Generate Unique Ticket Code
                $(document).on('click', '.generate-code-button', function () {
                    const code = generateFormattedCode(12);
                    $(this).siblings('input[name*="[ticketCode]"]').val(code);
                });

                // Function to Generate Formatted Ticket Code
                function generateFormattedCode(length) {
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    let result = '';
                    for (let i = 0; i < length; i++) {
                        result += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    return result.match(/.{1,4}/g).join('-').toUpperCase();
                }
            });


        </script>
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    @endpush

@endsection
