@extends('storefront.account.layouts.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="profile-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="cover-img">
                        <img src="{{asset('dashboard/images/cover-img.jpg')}}" alt="Images">
                    </div>

                    <div class="profile-face">
                        <div class="row align-items-end justify-content-center">
                            <div class="col-lg-4 col-md-4">
                                <div class="avatar">
                                    <img src="{{'https://ui-avatars.com/api/?rounded=true&name='.$customer->name}}" alt="Images">
                                    <h6>{{$customer->name}}</h6>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-4">
                                <div class="projects">
                                    <h6>{{$orders}}</h6>
                                    <p>Number of Orders</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-md-4">
                                <div class="projects">
                                    <h6>{{$store->currency}}{{number_format($sumOfOrders,2)}}</h6>
                                    <p>Amount Spent</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-information">
                        <h6>Information</h6>
                        <p>
                            {{$customer->bio}}
                        </p>

                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{$customer->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile :</th>
                                    <td>
                                        <a href="tel:{{$customer->phone}}">{{$customer->phone}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>
                                        <a href="mailto:{{$customer->email}}">
                                            {{$customer->email}}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Location :</th>
                                    <td>{{$customer->state}}, {{$customer->country}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Address :</th>
                                    <td>{{$customer->address??'N/A'}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


@endsection
