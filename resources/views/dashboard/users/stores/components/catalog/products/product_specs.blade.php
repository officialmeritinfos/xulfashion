@extends('dashboard.layout.base')
@section('content')

    <div class="product-area">
        <div class="container-fluid">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <a href="#addProductImage" data-bs-toggle="modal" class="primary-btn">
                            Add New Variant
                            <i class="ri-add-circle-line"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="latest-transaction-area">
            <h6>SIZE VARIANTS</h6>
            <div class="table-responsive h-auto" data-simplebar>
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th scope="col">TITLE</th>
                        <th scope="col">PRICE</th>
                        <th scope="col">QUANTITY</th>
                        <th scope="col">DATE ADDED</th>
                        <th scope="col">ACTION</th>
                    </tr>
                    </thead>
                    <tbody class="searches">
                    @foreach($sizes as $size)
                        <tr>
                            <td>
                                {{$size->name}}
                            </td>
                            <td>
                                {{$product->currency}}{{number_format($size->price,2)}}
                            </td>
                            <td>
                                {{$size->quantity}}
                            </td>
                            <td>
                                {{date('d M, Y - h:i A')}}
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                        <li>
                                            <a class="dropdown-item" href="{{route('user.stores.catalog.product.size.delete',['ref'=>$product->reference,'id'=>$size->id])}}">
                                                Delete
                                                <i class="ri-delete-bin-6-line"></i>
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
                {{$sizes->links()}}
            </div>
        </div>
        <div class="latest-transaction-area mt-5">
            <h6>COLOR VARIANTS</h6>
            <div class="table-responsive h-auto" data-simplebar>
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th scope="col">TITLE</th>
                        <th scope="col">PRICE</th>
                        <th scope="col">QUANTITY</th>
                        <th scope="col">DATE ADDED</th>
                        <th scope="col">ACTION</th>
                    </tr>
                    </thead>
                    <tbody class="searches">
                    @foreach($colors as $color)
                        <tr>
                            <td>
                                {{$color->name}}
                            </td>
                            <td>
                                {{$product->currency}}{{number_format($color->price,2)}}
                            </td>
                            <td>
                                {{$color->quantity}}
                            </td>
                            <td>
                                {{date('d M, Y - h:i A')}}
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                        <li>
                                            <a class="dropdown-item" href="{{route('user.stores.catalog.product.color.delete',['ref'=>$product->reference,'id'=>$color->id])}}">
                                                Delete
                                                <i class="ri-delete-bin-6-line"></i>
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
                {{$colors->links()}}
            </div>
        </div>
    </div>

    @push('js')

        <!-- Modal -->
        <div class="modal fade" id="addProductImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">New Variants</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="submit-property-form" id="processForm" action="{{route('user.stores.catalog.product.variant.new.process',['id'=>$product->reference])}}" method="post"
                              enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-lg-12 row mb-5">
                                    <label class="mb-3">Product Size Variations</label>
                                    <div class="sizeVariations"></div>
                                    <button type="button" class="btn btn-secondary addSizeVariation">Add Variation</button>
                                </div>


                                <div class="col-lg-12 row mb-5">
                                    <label class="mb-3">Product Color Variations</label>
                                    <div class="colorVariations"></div>
                                    <button type="button" class="btn btn-primary addColorVariation">Add Variation</button>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="default-btn submit">Add Variants</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(".addSizeVariation").click(function () {
                newRowAdd =
                    '<div id="row" class="row"> ' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Name<sup class="text-danger">*</sup></label> <input type="text" class="form-control" name="sizeName[]"></div></div>' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Price<sup class="text-danger">*</sup></label> <input type="text" class="form-control" name="sizePrice[]"></div></div>' +
                    '<div class="col-lg-12 input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Quantity" name="sizeQuantity[]" value="0">' +
                    '<button class="btn btn-danger" id="DeleteRow" type="button">Delete</button> ' +
                    ' </div>';

                $('.sizeVariations').append(newRowAdd);
            });
            $("body").on("click", "#DeleteRow", function () {
                $(this).parents("#row").remove();
            })
        </script>
        <script type="text/javascript">
            $(".addColorVariation").click(function () {
                newRowsAdd =
                    '<div id="rows" class="row"> ' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Name<sup class="text-danger">*</sup></label> <input type="text" class="form-control" name="colorName[]"></div></div>' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Price<sup class="text-danger">*</sup></label> <input type="text" class="form-control" name="colorPrice[]"></div></div>' +
                    '<div class="col-lg-12 input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Quantity" name="colorQuantity[]" value="0">' +
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
