<div>
    @inject('option','App\Custom\Regular')
    <div class="card h-100 p-0 radius-12">

        <div class="card-body p-24">
            <div class="table-responsive scroll-sm">
                <table class="table bordered-table sm-table mb-0">
                    <thead>
                    <tr>
                        <th scope="col">
                            <div class="d-flex align-items-center gap-10">
                                S.L
                            </div>
                        </th>
                        <th scope="col">Bank</th>
                        <th scope="col">Account Name</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Currency</th>
                        <th scope="col">Meta</th>
                        <th scope="col" class="text-center">STATUS</th>
                        <th scope="col" class="text-center">Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($option->userPayoutAccounts($user) as $index=> $bank)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        {{ $accounts->firstItem() + $index }}
                                    </div>
                                </td>
                                <td>
                                    {{$bank->bankName}}
                                </td>
                                <td>
                                    {{$bank->accountName}}
                                </td>
                                <td>
                                    {{$bank->accountNumber}}
                                </td>
                                <td>
                                    {{$bank->currency}}
                                </td>
                                <td>
                                    @if(!empty($bank->meta) && json_decode($bank->meta, true) !== [])
                                        @php $metaData = json_decode($bank->meta, true); @endphp
                                        <div class="row">
                                            @foreach($metaData as $key => $value)
                                                <div class="col-6 col-md-6 mb-3">
                                                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                                    <p class="copyable" data-content="{{ $value }}">{{ $value }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <strong>No other information</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($bank->status==1)
                                        <span class="badge bg-success">
                                                Active
                                            </span>
                                    @else
                                        <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                    @endif
                                </td>
                                <td>
                                    {{date('D, d M Y H:i:s',strtotime($bank->created_at))}}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
