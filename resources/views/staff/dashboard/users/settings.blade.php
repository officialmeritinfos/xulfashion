@extends('staff.dashboard.layout.base')
@section('content')
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Settings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th scope="col">Email Notification</th>
                                <th scope="col">Newsletter Notification</th>
                                <th scope="col">Debit Alert</th>
                                <th scope="col">Credit Alert</th>
                                <th scope="col">Receive Payments </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    {{($settings->emailNotification==1)?'Active':'Inactive'}}
                                </td>
                                <td>
                                    {{($settings->newsletters==1)?'Subscribed':'Unsubscribed'}}
                                </td>
                                <td>
                                    {{($settings->withdrawalNotification==1)?'Active':'Inactive'}}
                                </td>
                                <td>
                                    {{($settings->depositNotification==1)?'Active':'Inactive'}}
                                </td>
                                <td>
                                    {{($settings->collectPayment==1)?'Active':'Inactive'}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
