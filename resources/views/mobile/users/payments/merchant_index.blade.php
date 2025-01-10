@extends('mobile.users.layout.base')
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">Available Balance
                                    <sup><i class="fa-solid fa-circle-info" data-bs-toggle="tooltip"
                                            title="The total amount in your account balance which is can be withdrawn"></i></sup>
                                </h5>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3" data-bs-toggle="tooltip" title="{{currencySign($user->mainCurrency)}}{{ number_format(merchantTotalAvailableBalance($user),2) }}">
                            {{currencySign($user->mainCurrency)}}{{ shorten_number(merchantTotalAvailableBalance($user),2) }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="main mt-2 mb-5">
                <div class="container-fluid text-center">
                    <a href="{{completedProfileMobile('mobile.user.settlement.account.index')}}" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button">
                        Settlement Accounts
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
