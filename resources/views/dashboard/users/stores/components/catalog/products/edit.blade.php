@extends('dashboard.layout.base')
@section('content')


    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form product-upload" enctype="multipart/form-data" id="processForm"
                  method="post" action="{{route('user.stores.catalog.product.edit.process',['id'=>$product->reference])}}">
                <h3>Product Information</h3>
                <div class="row">
                    <div class="col-md-12">
                        <label for="inputAddress" class="form-label">Featured Photo</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="featuredPhoto" accept="image/*">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Product Name<sup class="text-danger">*</sup> </label>
                                    <input type="text" class="form-control" name="name" value="{{$product->name}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Manufacturer Name</label>
                                    <input type="text" class="form-control" name="manufacturer" value="{{$product->manufacturer}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Category<sup class="text-danger">*</sup></label>
                                    <select class="form-select form-control selectize" aria-label="Default select example" name="category">
                                        <option value="">Select an oOption</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{($product->category==$category->id)?'selected':''}}>{{$category->categoryName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Manufacturer Brand</label>
                                    <input type="text" class="form-control" name="brand" value="{{$product->brand}}">
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Price<sup class="text-danger">*</sup></label>
                                    <input type="number" step="0.01" class="form-control" name="price" value="{{$product->amount}}">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>
                                        Quantity Available<sup class="text-danger">*</sup>
                                    </label>
                                    <input type="number" placeholder="Enter product quantity" class="form-control"
                                           name="qty" value="{{$product->quantity}}">
                                    <span style="font-size: 11px;">
                                    Leave at 0 for infinite quantity
                                </span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Description<sup class="text-danger">*</sup></label>
                                    <textarea name="description" class="form-control summernote" cols="30" rows="5" >{!! $product->description !!}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Specifications<sup class="text-danger">*</sup></label>
                                    <textarea name="specifications" class="form-control summernote" cols="30" rows="5">{!! $product->specifications !!}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Features<sup class="text-danger">*</sup></label>
                                    <textarea name="features" class="form-control summernote" cols="30" rows="5">{!! $product->keyFeatures !!}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" value="1" type="checkbox" id="addAnother"
                                   name="addAnother">
                            <label class="form-check-label" for="addAnother">
                                Add another Product
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <button type="submit" class="default-btn me-3 submit">
                            Edit Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
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
