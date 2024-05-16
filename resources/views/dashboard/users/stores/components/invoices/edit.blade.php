@extends('dashboard.layout.base')
@section('content')
    <div class="container-fluid">
        <div class="ui-kit-cards grid mb-24">
            <form class="submit-property-form" id="processForm" action="{{route('user.stores.invoice.edit.process',['id'=>$invoice->reference])}}" method="post">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="inputTitle" class="form-label">Invoice Title<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputTitle" name="title" value="{{$invoice->title}}">
                    </div>
                    <div class="col-md-12">
                        <label for="inputTitle" class="form-label">Invoice Description<sup class="text-danger">*</sup></label>
                        <textarea type="text" class="form-control summernote" id="inputTitle" name="description" rows="5">{!! $invoice->description !!}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="inputTitle" class="form-label">Customer Name<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputTitle" name="name" value="{{$customer->name}}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="inputTitle" class="form-label">Customer Email</label>
                        <input type="text" class="form-control" id="inputTitle" name="email" value="{{$customer->email}}" disabled>
                    </div>
                    <div class="col-md-12">
                        <label for="inputTitle" class="form-label">Customer Phone<sup class="text-danger">*</sup>
                            <i class="ri-information-fill" data-bs-toggle="tooltip" title="Include the country code."></i> </label>
                        <input type="text" class="form-control" id="inputTitle" name="phone" value="{{$customer->phone}}" disabled>
                    </div>
                    <div class="col-lg-12 row mb-5 mt-3">
                        <label class="mb-3">Invoice Item</label>
                        @foreach($invoice->items as $key=>$value)
                            <div id="rows" class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Item Name<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" name="itemName[]" value="{{$value}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Unit Price<sup class="text-danger">*</sup></label>
                                        <input type="number" step="0.001" class="form-control" name="itemPrice[]"
                                        value="{{$invoice->itemPrice[$key]}}">
                                    </div>
                                </div>
                                <div class="col-lg-12 input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Quantity" name="itemQuantity[]"
                                    value="{{$invoice->itemQuantity[$key]}}">
                                    <button class="btn btn-danger" id="DeleteRows" type="button">Delete</button>
                                </div>
                            </div>
                        @endforeach
                        <div class="colorVariations"></div>
                        <button type="button" class="btn btn-primary addColorVariation">Add Invoice Item</button>
                    </div>
                    <div class="col-md-12">
                        <label for="inputTitle" class="form-label">Invoice Status<sup class="text-danger">*</sup></label>
                        <select type="text" class="form-control selectize" id="inputTitle" name="status">
                            <option value="">Select an option</option>
                            <option value="1" {{($invoice->status==1)?'selected':''}}>Paid</option>
                            <option value="2" {{($invoice->status==2)?'selected':''}}>Pending Payment</option>
                            <option value="3" {{($invoice->status==3)?'selected':''}}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="default-btn submit">Update Invoice</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    @push('js')
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
