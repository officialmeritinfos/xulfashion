<div>
    @inject('injected','App\Custom\Regular')
    <div class="row gy-4 mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        Invoices
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span>Show</span>
                            <select class="form-select form-select-sm w-auto" wire:model.live="show">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                        <div class="icon-field">
                            <input type="text" wire:model.live="search" class="form-control form-control-sm w-auto" placeholder="Search">
                            <span class="icon">
                              <iconify-icon icon="ion:search-outline"></iconify-icon>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <select class="form-select form-select-sm w-auto" wire:model.live="status">
                            <option value="all">All</option>
                            <option value="1">Paid</option>
                            <option value="2">Pending</option>
                            <option value="3">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table bordered-table mb-0">
                            <thead>
                            <tr>
                                <th scope="col"> S/L</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">REFERENCE</th>
                                <th scope="col">AMOUNT</th>
                                <th scope="col">DATE</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $key=> $invoice)
                                <tr>
                                    <td>
                                        {{$invoices->firstItem()+$key}}
                                    </td>
                                    <td>
                                        {{$invoice->title}}
                                    </td>
                                    <td>
                                        {{$invoice->reference}}
                                    </td>
                                    <td class="bold">
                                        {{$injected->fetchCurrencySign($invoice->currency)->currency_symbol}} {{$injected->formatNumber($invoice->amount)}}
                                    </td>
                                    <td>
                                        {{date('d M, Y - h:i A', strtotime($invoice->created_at))}}
                                    </td>
                                    <td class="bold">
                                        @switch($invoice->status)
                                            @case(1)
                                                <span class="badge bg-success">Paid</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-info">Pending Payment</span>
                                                @break
                                            @default
                                                <span class="badge bg-danger">Payment Cancelled</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('staff.stores.invoices.detail',['id'=>$store->reference,'ref'=>$invoice->reference])}}"
                                           wire:navigate>
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$invoices->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
