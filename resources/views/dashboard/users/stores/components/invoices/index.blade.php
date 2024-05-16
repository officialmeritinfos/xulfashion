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
                        <a href="#newInvoice" data-bs-toggle="modal" class="new-orders">
                            Add New Invoice
                            <i class="ri-add-circle-line"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive h-auto" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">TITLE</th>
                            <th scope="col">REFERENCE</th>
                            <th scope="col">CUSTOMER</th>
                            <th scope="col">AMOUNT</th>
                            <th scope="col">DATE</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="searches">

                        @foreach($invoices as $invoice)
                            <tr>
                                <td>
                                    {{$invoice->title}}
                                </td>
                                <td>
                                    {{$invoice->reference}}
                                </td>
                                <td>
                                    {{$injected->customerById($invoice->customer)->name}}
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
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
{{--                                            <li>--}}
{{--                                                <a class="dropdown-item cpy"--}}
{{--                                                   data-clipboard-text="Follow this link to make payment for your invoice: {{$invoice->title}} on {{$siteName}}--}}
{{--                                                   {{route('merchant.store.invoice.detail',['subdomain'=>$store->slug,'id'=>$invoice->reference])}}">--}}
{{--                                                    Share--}}
{{--                                                    <i class="ri-share-forward-2-fill"></i>--}}
{{--                                                </a>--}}
{{--                                            </li>--}}
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.invoices.details',['id'=>$invoice->reference])}}">
                                                    Details
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.invoices.edit',['id'=>$invoice->reference])}}">
                                                    Edit
                                                    <i class="ri-edit-2-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{$invoices->links()}}
                </div>
            </div>
        </div>
    </div>

    @push('js')

        <!-- Modal -->
        <div class="modal fade" id="newInvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">New Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="submit-property-form" id="processForm" action="{{route('user.stores.invoice.new.process')}}" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputTitle" class="form-label">Invoice Title<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="inputTitle" name="title">
                                </div>
                                <div class="col-md-12">
                                    <label for="inputTitle" class="form-label">Invoice Description<sup class="text-danger">*</sup></label>
                                    <textarea type="text" class="form-control summernote" id="inputTitle" name="description" rows="5"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="inputTitle" class="form-label">Customer Name<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="inputTitle" name="name">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputTitle" class="form-label">Customer Email</label>
                                    <input type="text" class="form-control" id="inputTitle" name="email">
                                </div>
                                <div class="col-md-12">
                                    <label for="inputTitle" class="form-label">Customer Phone<sup class="text-danger">*</sup>
                                        <i class="ri-information-fill" data-bs-toggle="tooltip" title="Include the country code."></i> </label>
                                    <input type="text" class="form-control" id="inputTitle" name="phone">
                                </div>
                                <div class="col-lg-12 row mb-5 mt-3">
                                    <label class="mb-3">Invoice Item</label>
                                    <div class="colorVariations"></div>
                                    <button type="button" class="btn btn-primary addColorVariation">Add Invoice Item</button>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="default-btn submit">Generate Invoice</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(".addColorVariation").click(function () {
                newRowsAdd =
                    '<div id="rows" class="row"> ' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Item Name<sup class="text-danger">*</sup></label> <input type="text" class="form-control" name="itemName[]"></div></div>' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Unit Price<sup class="text-danger">*</sup></label> <input type="number" step="0.001" class="form-control" name="itemPrice[]"></div></div>' +
                    '<div class="col-lg-12 input-group mb-3">' +
                    '<input type="number" class="form-control" placeholder="Quantity" name="itemQuantity[]">' +
                    '<button class="btn btn-danger" id="DeleteRows" type="button">Delete</button> ' +
                    ' </div>';

                $('.colorVariations').append(newRowsAdd);
            });
            $("body").on("click", "#DeleteRows", function () {
                $(this).parents("#rows").remove();
            })
        </script>
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
