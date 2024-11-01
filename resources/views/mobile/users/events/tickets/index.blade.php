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
    <div class="container mt-4">
        <div class="alert alert-light text-center" role="alert">
            {{$siteName}} is free for free events. When you charge your guests a fee, we charge only a little percentage
            of tha fee - please refer to our pricing page for detail.
        </div>

        <!-- Tickets Section Header -->
        <div class="d-flex justify-content-center align-items-center mb-3">
            <button type="button" data-bs-toggle="modal" data-bs-target="#newTicket" class="btn btn-auto categories-item">Add Tickets</button>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td style="font-size: 12px;">{{ucfirst($ticket->ticketType)}}</td>
                            <td style="font-size: 12px;">{{$ticket->name}}</td>
                            <td style="font-size: 12px;">{{$ticket->ticketSold}} / {{($ticket->unlimited==1)?'Unlimited':$ticket->quantity}}</td>
                            <td style="font-size: 12px;">
                                @if($ticket->isFree())
                                    Free
                                @else
                                    {{currencySign($event->currency)}}{{$ticket->price()}}
                                @endif

                            </td>
                            <td class="text-end">
                                <!-- Ellipsis Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-link p-0 m-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" style="font-size: 18px;"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="{{route('mobile.user.events.tickets.edit',['ticket'=>$ticket->reference])}}">Edit</a></li>
                                        <li><span class="dropdown-item text-danger" data-id="{{$ticket->id}}" data-name="{{$ticket->name}}"
                                            data-bs-toggle="modal" data-bs-target="#deleteTicket">Delete</span></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{$tickets->links()}}
            </div>
        </div>



    </div>

    @push('js')
        <div class="modal fade" id="newTicket" tabindex="-1" aria-labelledby="eventTypeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" id="eventTypeModalLabel">Select Ticket Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Event Type Options -->
                        <div class="row">
                            <!-- Live Event Card -->
                            <div class="col-12 mb-3">
                                <div class="card option-card shadow" data-url="{{route('mobile.user.events.tickets.new',['event'=>$event->reference,'type'=>'single'])}}" data-value="Live Event" onclick="selectOption(this)">
                                    <div class="card-body text-center">
                                        <div class="icon mb-2">
                                            <i class="fa-solid fa-ticket-simple text-primary"  style="width: 40px;"></i>
                                        </div>
                                        <h5 class="card-title">Single Ticket</h5>
                                        <p class="card-text">Admits only one person to your event.</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <input type="radio" name="eventType" class="form-check-input" value="1" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Online Event Card -->
                            <div class="col-12 mb-3 ">
                                <div class="card option-card shadow" data-url="{{route('mobile.user.events.tickets.new',['event'=>$event->reference,'type'=>'group'])}}" data-value="Online Event" onclick="selectOption(this)">
                                    <div class="card-body text-center">
                                        <div class="icon mb-2">
                                            <i class="fa-solid fa-ticket text-primary"  style="width: 40px;"></i>
                                        </div>
                                        <h5 class="card-title">Group Ticket</h5>
                                        <p class="card-text">Admits more than one person to your event</p>
                                        <div class="d-flex justify-content-center mt-3">
                                            <input type="radio" name="eventType" class="form-check-input" value="2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-12">
                                <button type="button" id="continueButton" class="btn btn-auto btn-outline-primary"
                                        disabled onclick="redirectToUrl()">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteTicket" tabindex="-1" aria-labelledby="eventTypeModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h5 class="modal-title" id="eventTypeModalLabel">Delete <span class="ticketName"></span> </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center" style="font-size: 20px;">
                            Are you sure you want to delete this ticket? This is permanent and irreversible.
                        </p>
                        <form id="basicSettings" method="POST" action="{{route('mobile.user.events.ticket.delete',['event'=>$event->reference])}}">
                            <div class="form-group  mb-3" style="display: none;">
                                <label for="inputusernumber" class="form-label">
                                    Ticket Id<sup>
                                        <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                           title="A name for this ticket - what is it?"></i> <span class="text-danger">*</span>
                                    </sup>
                                </label>
                                <div class="form-input">
                                    <input type="text" class="form-control" id="id" placeholder="Free Ticket" name="ticketId"/>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <button type="submit" class="btn btn-danger btn-auto submit">Delete</button>
                                <button type="button" class="btn btn-secondary btn-auto" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <script>
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

        <script>
            $(document).ready(function () {
                $('#deleteTicket').on('show.bs.modal', function (event) {
                    let button = $(event.relatedTarget); // Button that triggered the modal
                    let ticketId = button.data('id'); // Extract ticket ID from data-* attribute
                    let name = button.data('name'); // Extract ticket ID from data-* attribute
                    $('.ticketName').text(name)
                    $('#id').val(ticketId)
                });
            });
        </script>
        <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    @endpush
@endsection
