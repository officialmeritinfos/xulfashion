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
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">EMPLOYER</th>
                            <th scope="col">JOB</th>
                            <th scope="col">REFERENCE</th>
                            <th scope="col">AMOUNT</th>
                            <th scope="col">DATE</th>
                            <th scope="col">STATUS</th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    {{$injected->employerById($payment->employer)->companyName}}
                                </td>
                                <td>
                                    {{$injected->fetchJobByEmploymentRef($payment->employmentRef)->title}}
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{$payment->reference}}</span>
                                </td>
                                <td>{{$payment->currency}}{{number_format($payment->amount,2)}}</td>
                                <td>
                                    {{date('d-m-Y-H-i-s',strtotime($payment->created_at))}}
                                </td>
                                <td>
                                    @switch($payment->status)
                                        @case(1)
                                            <span class="badge bg-success">Completed</span>
                                        @break
                                        @case(2)
                                            <span class="badge bg-info">Pending</span>
                                        @break
                                        @default
                                            <span class="badge bg-warning">Please contact support</span>
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{$payments->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
