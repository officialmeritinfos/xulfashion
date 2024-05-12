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
                            <th scope="col">EMAIL</th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                        @foreach($subscribers as $subscriber)
                            <tr>
                                <td>
                                    {{$subscriber->reference}}
                                </td>
                                <td>
                                    {{$subscriber->email}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$subscribers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
