
<form class="theme-form profile-setting" action="{{route('mobile.user.events.tickets.edit.group.process',['event'=>$event->reference,'ticket'=>$ticket->reference])}}"
      method="post" id="basicSettings"
      enctype="multipart/form-data">
    @csrf
    <h6 class="title">What kind of Ticket is this?</h6>
    <div class="form-group d-block">
        <div class="form-input mb-4 position-relative">
            <div class="boxed-check-group boxed-check-primary row">
                <div class="col-md-4 mt-2 col-4" data-bs-toggle="tooltip" title="Free">
                    <label class="boxed-check">
                        <input class="boxed-check-input" type="radio" name="ticketKind" value="1" {{($ticket->kindOfTicket==1)?'checked':''}}>
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Free </h2>
                        </div>
                    </label>
                </div>
                <div class="col-md-4 mt-2 col-4" data-bs-toggle="tooltip" title="Paid">
                    <label class="boxed-check">
                        <input class="boxed-check-input" type="radio" name="ticketKind" value="2" {{($ticket->kindOfTicket!=1)?'checked':''}}>
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Paid </h2>
                        </div>
                    </label>
                </div>
                <div class="col-md-4 mt-2 col-4" data-bs-toggle="tooltip" title="Will not be listed on your Event page.Invites only.">
                    <label class="boxed-check">
                        <input class="boxed-check-input" type="checkbox" name="inviteOnly" {{($ticket->inviteOnly==1)?'checked':''}}>
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Unlisted</h2>
                        </div>
                    </label>
                </div>
            </div>
        </div>

    </div>
    <div class="form-group d-block mb-3">
        <label for="inputusernumber" class="form-label">
            Ticket Name<sup>
                <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                   title="A name for this ticket - what is it?"></i> <span class="text-danger">*</span>
            </sup>
        </label>
        <div class="form-input">
            <input type="text" class="form-control" id="inputusernumber" placeholder="Free Ticket" name="title" value="{{$ticket->name}}"/>
            <i class="fa fa-note-sticky"></i>
        </div>
    </div>
    <div class="recurringComponents">

        <div class="form-group d-block">
            <label for="inputusernumber" class="form-label">Ticket Stock<sup class="text-danger">*</sup></label>
            <div class="input-group mb-3">
                <select class="form-control" name="stock">
                    <option value="1" {{(!$ticket->hasUnlimitedStock())?'selected':''}}>Limited</option>
                    <option value="2" {{($ticket->hasUnlimitedStock())?'selected':''}}>Unlimited</option>
                </select>
                <input type="number" class="form-control" placeholder="2" aria-label="2" name="quantity"  min="1"
                value="{{$ticket->quantity}}">
            </div>
        </div>
    </div>

    <div class="form-group d-block mb-3">
        <label for="inputusernumber" class="form-label">
            Group Size<sup>
                <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                   title="What is the number of Attendees allowed by this single ticket?"></i> <span class="text-danger">*</span>
            </sup>
        </label>
        <div class="form-input">
            <input type="number" class="form-control" id="inputusernumber" placeholder="4" name="groupSize" min="2" value="{{$ticket->groupSize}}" />
            <i class="fa fa-group"></i>
        </div>
    </div>
    <div class="priceComponent" style="display: none;">
        <div class="form-group d-block">
            <label for="inputusernumber" class="form-label">Group Price<sup class="text-danger">*</sup>
                <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                   title="If the selected currency is not your default account currency, all payments received will be
                   converted to your account currency before settlement"></i>
            </label>
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="2" aria-label="2" name="groupPrice" step="0.01"
                value="{{$ticket->groupPrice}}">
            </div>
        </div>
        <div class="form-group d-block">
            <label for="inputusernumber" class="form-label">Price Per Ticket<sup class="text-danger">*</sup></label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" value="{{$event->currency}}" name="currency" readonly>
                <input type="number" class="form-control" placeholder="2" aria-label="2" name="price" step="0.01" readonly>
            </div>
        </div>
    </div>

    <div class="form-group d-block mb-3">
        <label for="inputusernumber" class="form-label">Purchase Limit<sup>
                <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                   title="The maximum purchase a person can make for a particular ticket"></i> <span class="text-danger">*</span>
            </sup>
        </label>
        <div class="form-input">
            <input type="number" class="form-control" id="inputusernumber" name="purchaseLimit" min="1" value="{{$ticket->purchaseLimit}}"/>
            <i class="fa fa-note-sticky"></i>
        </div>
    </div>
    <div class="form-group d-block mb-3">
        <label for="inputname" class="form-label">
            Ticket Description <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                       title="Describe the ticket"></i></sup>
            <sup class="text-danger">*</sup>
        </label>
        <div class="mb-3">
            <textarea class="form-control" id="description" name="description" rows="3">{{$ticket->description}}</textarea>
        </div>
    </div>

    <div class="form-group d-block mb-3">
        <label class="form-label">Ticket Perks <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                       title="What perks does the buyer enjoy in your event with this ticket?"></i></sup></label>
        <div id="perksList">.
            @foreach($ticket->perks as $key=>$perk)
                <div class="input-group mb-2 perk-item" id="perk-{{$key}}">
                    <input type="text" class="form-control" name="perks[]" placeholder="Perks for this ticket" value="{{$perk}}">
                    <button type="button" class="btn btn-remove" data-id="{{$key}}">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-add btn-auto" id="addPerk">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    <div class="form-group mb-3" id="transferFee" style="display: none">
        <div class="form-check"  >
            <input class="form-check-input" type="checkbox" name="transferFee" id="flexCheckChecked" {{($ticket->guestsShouldPayFee==1)?'checked':''}}>
            <label class="form-check-label" for="flexCheckChecked"
                   data-bs-toggle="tooltip"
                   title="Guest will pay the fee for paid tickets">
                Transfer Fee to Guest
            </label>
        </div>
    </div>


    <div class="text-center mb-5">
        <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto">Update Ticket</button>
    </div>
</form>


@push('js')
    <script>
        $(function () {
            // Function to show/hide priceComponent and transferFee based on ticketKind value
            function togglePriceComponent() {
                let values = $('input[name="ticketKind"]:checked').val();
                if (Number(values) === 2) {
                    $('.priceComponent').show();
                    $('#transferFee').show();
                } else {
                    $('.priceComponent').hide();
                    $('#transferFee').hide();
                }
            }

            // Call function on page load
            togglePriceComponent();

            // Call function on click
            $('input[name="ticketKind"]').on('click', function () {
                togglePriceComponent();
            });
        });

        $(function () {
            // Function to show/hide quantity based on stock value
            function toggleQuantityInput() {
                let stock = $('select[name="stock"]').val();
                if (Number(stock) === 2) {
                    $('input[name="quantity"]').attr('disabled', true).val('').attr('placeholder', '∞');
                } else {
                    $('input[name="quantity"]').removeAttr('disabled').attr('placeholder', '2');
                }
            }

            // Call function on page load
            toggleQuantityInput();

            // Call function on change
            $('select[name="stock"]').on('change', function () {
                toggleQuantityInput();
            });
        });
    </script>
    <script src="{{asset('mobile/js/requests/profile-edit.js?ver=1.0')}}"></script>
    <script>
        $(document).ready(function () {
            let perkCount = {{count($ticket->perks)}};

            // Add perk button click event
            $('#addPerk').on('click', function () {
                perkCount++;
                $('#perksList').append(`
            <div class="input-group mb-2 perk-item" id="perk-${perkCount}">
                <input type="text" class="form-control" name="perks[]" placeholder="Perks for this ticket">
                <button type="button" class="btn btn-remove" data-id="${perkCount}">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        `);
            });
            // Remove perk button click event
            $('#perksList').on('click', '.btn-remove', function () {
                const perkId = $(this).data('id');
                $(`#perk-${perkId}`).remove();
            });
        });


        $(function () {

            function updateMainPrice() {
                let price = parseFloat($('input[name="groupPrice"]').val()) || 0;
                let size = parseFloat($('input[name="groupSize"]').val()) || 1;
                let mainPrice = price / size;
                $('input[name="price"]').val(mainPrice.toFixed(2));
            }
            updateMainPrice();
            $('input[name="groupPrice"], input[name="groupSize"]').on('input', function () {
                updateMainPrice();
            });
        });


    </script>
@endpush
