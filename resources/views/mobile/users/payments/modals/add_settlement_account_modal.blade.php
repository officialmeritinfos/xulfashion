{{-- Modal for NGN accounts is different from others since they require some other data to be processed --}}
@include('mobile.users.payments.modals.add_local_settlement_account_modal',['payout'=>$payout])
@include('mobile.users.payments.modals.add_usd_settlement_account_modal',['payout'=>$payout])
