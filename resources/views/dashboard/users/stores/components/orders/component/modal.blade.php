<!-- Modal -->
<div class="modal fade" id="completedOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Complete Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    Before you complete this order, ensure you have received the payment for it. If this transaction was
                    completed on Whatsapp, first mark the payment as paid before performing this action
                </p>
                <form class="submit-property-form" id="processForm" action="{{route('user.stores.orders.complete.process',['id'=>$order->reference])}}" method="post">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="inputTitle" class="form-label">Password<sup class="text-danger">*</sup></label>
                            <input type="password" class="form-control" id="inputTitle" name="password" >
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="default-btn submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="markPaid" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Payment Status To Paid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    Only do this if payment was completed offline. If user selected online payment upon checkout, contact our support
                    before doing this.
                </p>
                <form class="submit-property-form" id="markPaidForm" action="{{route('user.stores.orders.paid.process',['id'=>$order->reference])}}" method="post">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="inputTitle" class="form-label">Amount Paid<sup class="text-danger">*</sup></label>
                            <input type="number" step="0.01" class="form-control" id="inputTitle" name="amount" >
                        </div>
                        <div class="col-md-12">
                            <label for="inputTitle" class="form-label">Password<sup class="text-danger">*</sup></label>
                            <input type="password" class="form-control" id="inputTitle" name="password" >
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="default-btn submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cancelOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cancel Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    Only cancel this order when customer fails to make payment. This action could result to litigation by the customer.
                </p>
                <form class="submit-property-form" id="cancelOrderForm" action="{{route('user.stores.orders.cancel.process',['id'=>$order->reference])}}" method="post">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="inputTitle" class="form-label">Password<sup class="text-danger">*</sup></label>
                            <input type="password" class="form-control" id="inputTitle" name="password" >
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="default-btn submit">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
