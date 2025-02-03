@extends('mobile.ads.events.components.cartBase')
@section('content')
@push('css')
    <style>
        .status-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .status-message {
            font-size: 24px;
            margin-top: 20px;
        }
        .status-icon {
            font-size: 50px;
        }
        .loading-spinner {
            font-size: 30px;
        }
    </style>
@endpush


<div class="container status-container">
    <div class="row">
        <div id="loading" class="loading-spinner">
            <i class="fas fa-spinner fa-spin light-text"></i>
            <p class="light-text">Checking payment status...</p>
           <div class="col-md-12 mt-4">
               <a id="paymentStatusBtn" href="#" class="btn theme-btn w-100 " style="display: none;">
                   Retry Payment
               </a>
           </div>
        </div>
        <div id="success" class="d-none">
            <i class="fas fa-check-circle text-success status-icon"></i>
            <p class="status-message text-success">Payment Successful!</p>
        </div>
        <div id="failure" class="d-none mt-3">
            <i class="fas fa-times-circle text-danger status-icon light-text"></i>
            <p class="status-message text-danger light-text">Payment Failed. Please try again.</p>
        </div>
    </div>
</div>


    @push('js')
        <script>
            $(document).ready(function () {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "5000"
                };

                function checkPaymentStatus() {
                    $('#paymentStatusBtn').hide();
                    $.ajax({
                        url: "{{ route('mobile.marketplace.events.ticket.purchase.checkout.payment.status', ['purchaseRef'=>$purchase->reference, 'transactionId' => $transactionId]) }}",
                        method: "GET",
                        success: function (response) {
                            if (response.status === 'success') {
                                $('#loading').addClass('d-none');
                                $('#success').removeClass('d-none');
                                toastr.success(response.message || 'Payment was successful.');

                                setTimeout(function () {
                                    window.location.href = response.url;
                                }, 6000);

                            } else if (response.status === 'pending') {
                                $('#loading').removeClass('d-none');
                                $('#success').addClass('d-none');
                                $('#failure').addClass('d-none');
                                toastr.info(response.message || 'Payment is still pending. Checking again soon.');
                                let newPaymentUrl = response.link;
                                updatePaymentStatusUrl(newPaymentUrl);
                            } else {
                                $('#loading').addClass('d-none');
                                $('#failure').removeClass('d-none');
                                toastr.error(response.message || 'Payment failed. Please try again.');
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = 'An error occurred while checking the payment status.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            $('#loading').addClass('d-none');
                            $('#failure').removeClass('d-none');
                            toastr.error(errorMessage);
                        }
                    });
                }

                // Fetch payment status on page load
                checkPaymentStatus();
                // Check payment status every 30 seconds
                setInterval(checkPaymentStatus, 30000);

                function updatePaymentStatusUrl(newUrl) {
                    $("#paymentStatusBtn").attr("href", newUrl);
                    $('#paymentStatusBtn').show()
                }
            });
        </script>
    @endpush
@endsection
