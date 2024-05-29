@extends('dashboard.layout.base')
@section('content')


    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form product-upload" enctype="multipart/form-data" id="processForm"
            method="post" action="{{route('user.stores.catalog.products.new.process')}}">
                <h3>Product Information</h3>
                <div class="row">
                    <div class="col-md-12">
                        <label for="inputAddress" class="form-label">Featured Photo<sup class="text-danger">*</sup></label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" name="featuredPhoto" accept="image/*">
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Product Name<sup class="text-danger">*</sup> </label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Manufacturer Name</label>
                                    <input type="text" class="form-control" name="manufacturer">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Category<sup class="text-danger">*</sup></label>
                                    <select class="form-select form-control selectize" aria-label="Default select example" name="category">
                                        <option value="">Select an oOption</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->categoryName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Manufacturer Brand</label>
                                    <input type="text" class="form-control" name="brand">
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Price<sup class="text-danger">*</sup></label>
                                    <input type="number" step="0.01" class="form-control" name="price">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>
                                        Quantity Available<sup class="text-danger">*</sup>
                                    </label>
                                    <input type="number" placeholder="Enter product quantity" class="form-control"
                                           name="qty" value="0">
                                    <span style="font-size: 11px;">
                                    Leave at 0 for infinite quantity
                                </span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Description<sup class="text-danger">*</sup></label>
                                    <textarea name="description" class="form-control summernote" cols="30" rows="5" ></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Specifications<sup class="text-danger">*</sup></label>
                                    <textarea name="specifications" class="form-control summernote" cols="30" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Product Features<sup class="text-danger">*</sup></label>
                                    <textarea name="features" class="form-control summernote" cols="30" rows="5"></textarea>
                                </div>
                            </div>

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

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Return Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                        title="This is a necessary protection for your product order"></i> </label>
                                    <textarea name="returnPolicy" class="form-control summernote" cols="30" rows="5"></textarea>
                                    <small>Leave blank to apply store-level Refund policy to product</small>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Refund Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                        title="This is a necessary protection for your product order"></i> </label>
                                    <textarea name="refundPolicy" class="form-control summernote" cols="30" rows="5"></textarea>
                                    <small>Leave blank to apply store-level Refund policy to product</small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Product Images<sup class="text-danger">*</sup> <i class="ri-information-fill" data-bs-toggle="tooltip"
                                title="A maximum of {{$web->fileUploadAllowed}} photos are allowed."></i> </label>
                            <div class="file-upload">
                                <input type="file" name="file[]" id="file" class="inputfile" multiple accept="image/*">
                                <label class="upload" for="file">
                                    <i class="ri-image-2-fill"></i>
                                    Upload Photo
                                </label>
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
                            Upload
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
                    '<div class="col-lg-12 input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Name" name="sizeName[]">' +
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
                    '<div class="col-lg-12 input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Name" name="colorName[]" >' +
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
