@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="order-details-area mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <a href="{{route('user.stores.customers.export')}}" class="new-orders">
                            Export Subscribers
                            <i class="ri-file-excel-2-fill"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">COUNTRY</th>
                            <th scope="col">STATE</th>
                            <th scope="col">CITY</th>
                            <th scope="col">SUBSCRIBED TO NEWSLETTER</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                        @foreach($customers as $customer)
                            <tr>
                                <td>
                                    {{$customer->reference}}
                                </td>
                                <td>
                                    {{$customer->name}}
                                </td>
                                <td>
                                    {{$customer->email}}
                                </td>
                                <td>
                                    {{$customer->phone}}
                                </td>
                                <td>
                                    {{$customer->country}}
                                </td>
                                <td>
                                    {{$customer->state}}
                                </td>
                                <td>
                                    {{$customer->city}}
                                </td>


                                <td>
                                    @if($customer->subscribedToNewletter==1)
                                        <span class="badge bg-success">
                                            Subscribed
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            Unsubscribed
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @switch($customer->status)
                                        @case(1)
                                            <span class="badge bg-success">Active</span>
                                            @break
                                        @default
                                            <span class="badge bg-danger">Inactive</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.customers.detail',['id'=>$customer->reference])}}">
                                                    View
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$customers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
