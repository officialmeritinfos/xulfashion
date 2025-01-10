@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            {{-- Main Currency Account Button --}}
            @if($payoutCurrency)
                <div class="col-6">
                    <div class="main mt-2 mb-5">
                        <div class="container-fluid text-center">
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#add-{{ strtolower($payoutCurrency->currency) }}-settlement"
                                class="btn theme-btn w-100 mt-3 mb-3 btn-auto"
                                role="button">
                                Add {{ $payoutCurrency->currency }} Account
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            {{-- USD Account Button (Visible if the main currency is not USD) --}}
            @if($payoutCurrency->currency !== 'USD')
                <div class="col-6">
                    <div class="main mt-2 mb-5">
                        <div class="container-fluid text-center">
                            <button
                                data-bs-toggle="modal"
                                data-bs-target="#add-usd-settlement"
                                class="btn theme-btn w-100 mt-3 mb-3 btn-auto"
                                role="button">
                                Add USD Account
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Include Modals for Adding Accounts --}}
    @include('mobile.users.payments.modals.add_settlement_account_modal', ['payout' => $payoutCurrency])
@endsection
