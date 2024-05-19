@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    @empty($store)
        <div class="product-area">
            <div class="container-fluid">

                <div class="row" style="margin-top:10rem;">
                    <div class="col-xl-6 col-sm-6 mx-auto">
                        <div class=" shadow-none mb-3">
                            <div class="card-body text-center">
                                <a class="btn btn-outline-primary small-button" href="{{route('user.stores.new')}}">
                                    Initialize Store
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if(empty($store->refundPolicy) || empty($store->returnPolicy))
            <div class="container-fluid">
                <div class="row">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <strong><i class="fa fa-warning"></i> Danger!</strong>
                        <marquee>
                            <p style="font-family: Impact; font-size: 18pt">
                                Protect your store from poachers and scam! Add a Return and Refund Policy to your store. Edit your
                                store info to add these.
                            </p>
                        </marquee>
                    </div>
                </div>
            </div>
        @endif
        @include('dashboard.users.stores.store_data',['injected'=>$injected])
        @include('dashboard.users.stores.store_actions')
    @endempty

@endsection
