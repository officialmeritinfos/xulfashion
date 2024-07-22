@extends('staff.dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="row gy-4">

        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th scope="col"> S/L</th>
                                <th scope="col"> ID</th>
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
                            <tbody>
                            @foreach($customers as $index=> $customer)
                                <tr>
                                    <td>{{$customers->firstItem()+$index}}</td>
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
                                       <a href="{{route('staff.stores.customers.detail',['id'=>$store->reference,'ref'=>$customer->reference])}}"
                                          wire:navigate>
                                           <i class="ri-eye-line"></i>
                                       </a>
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

    </div>

@endsection
