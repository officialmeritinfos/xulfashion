
<form class="theme-form profile-setting" action="{{route('mobile.user.events.ticket.single.process',['event'=>$event->reference])}}"
      method="post" id="basicSettings"
      enctype="multipart/form-data">
    @csrf
    <h6 class="title">What kind of Ticket is this?</h6>
    <div class="form-group d-block">
        <div class="form-input mb-4 position-relative">
            <div class="boxed-check-group boxed-check-primary row">
                <div class="col-md-4 mt-2 col-4" data-bs-toggle="tooltip" title="Free">
                    <label class="boxed-check">
                        <input class="boxed-check-input" type="radio" name="ticketKind" value="1">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Free </h2>
                        </div>
                    </label>
                </div>
                <div class="col-md-4 mt-2 col-4" data-bs-toggle="tooltip" title="Paid">
                    <label class="boxed-check">
                        <input class="boxed-check-input" type="radio" name="ticketKind" value="2">
                        <div class="boxed-check-label" style="text-align:center;">
                            <h2>Paid </h2>
                        </div>
                    </label>
                </div>
                <div class="col-md-4 mt-2 col-4" data-bs-toggle="tooltip" title="Will not be listed on your Event page.Invites only.">
                    <label class="boxed-check">
                        <input class="boxed-check-input" type="checkbox" name="inviteOnly">
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
            <input type="text" class="form-control" id="inputusernumber" placeholder="Free Ticket" name="title"/>
            <i class="fa fa-note-sticky"></i>
        </div>
    </div>
    <div class="recurringComponents">

        <div class="form-group d-block">
            <label for="inputusernumber" class="form-label">Ticket Stock<sup class="text-danger">*</sup></label>
            <div class="input-group mb-3">
                <select class="form-control" name="stock">
                   <option value="1">Limited</option>
                   <option value="2">Unlimited</option>
                </select>
                <input type="number" class="form-control" placeholder="2" aria-label="2" name="quantity" value="0">
            </div>
        </div>
    </div>
    <div class="priceComponent">
        <div class="form-group d-block">
            <label for="inputusernumber" class="form-label">Ticket Price<sup class="text-danger">*</sup>
                <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                   title="If the selected currency is not your default account currency, all payments received will be
                   converted to your account currency before settlement"></i>
            </label>
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="2" aria-label="2" name="price" step="0.01">
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
            <input type="number" class="form-control" id="inputusernumber" name="purchaseLimit" min="1"/>
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
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
    </div>

    <div class="form-group d-block mb-3">
        <label class="form-label">Ticket Perks <sup><i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                       title="What perks does the buyer enjoy in your event with this ticket?"></i></sup></label>
        <div id="perksList"></div>
        <button type="button" class="btn btn-add btn-auto" id="addPerk">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
    <div class="form-group mb-3" id="transferFee" style="display: none">
        <div class="form-check"  >
            <input class="form-check-input" type="checkbox" name="transferFee" id="flexCheckChecked" >
            <label class="form-check-label" for="flexCheckChecked"
                   data-bs-toggle="tooltip"
                   title="Guest will pay the fee for paid tickets">
                Transfer Fee to Guest
            </label>
        </div>
    </div>


    <div class="text-center mb-5">
        <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto">Add Ticket</button>
    </div>
</form>


@push('js')
    <script>
        $(function (){
            $('input[name="ticketKind"]').on('click',function (){
                let values = $(this).val();
                if (Number(values)===2 ){
                    $('.priceComponent').show();
                    $('#transferFee').show();
                }else{
                    $('.priceComponent').hide();
                    $('#transferFee').hide();
                }
            })
        });
        $(function () {
            $('select[name="stock"]').on('change', function () {
                let stock = $(this).val();
                if (Number(stock) === 2) {
                    $('input[name="quantity"]').attr('disabled', true).val('').attr('placeholder', '∞');
                } else {
                    $('input[name="quantity"]').removeAttr('disabled').attr('placeholder', '2');
                }
            });
        });
    </script>
    <script src="{{asset('mobile/js/requests/profile-edit.js')}}"></script>
    <script>
        $(document).ready(function () {
            let perkCount = 0;

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

    </script>
@endpush
