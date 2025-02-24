@extends('mobile.users.layout.base')
@section('content')
    @push('css')
        <style>
            /* File Upload */
            .file-upload {
                position: relative;
                display: inline-block;
                width: 100%;
            }

            .file-upload input[type="file"] {
                display: none;
            }

            .file-upload label {
                cursor: pointer;
                background-color: #f8f9fa;
                padding: 15px;
                border: 2px dashed #ced4da;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
            }

            .file-upload label i {
                font-size: 1.5rem;
            }

            /* General Styles */
            .image-preview-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            }

            .image-preview, .image-previews {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 5px;
                border: 1px solid #ddd;
                padding: 5px;
                position: relative;
            }

            .remove-image {
                position: absolute;
                top: 5px;
                right: 5px;
                background: red;
                color: white;
                border: none;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                cursor: pointer;
                font-size: 14px;
                text-align: center;
            }

            .image-wrapper {
                position: relative;
                display: inline-block;
            }
        </style>
    @endpush

    <div class="container-fluid mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h4>Edit Product</h4>
            </div>
            <div class="card-body">
                <form id="basicSettings" method="post" action="{{ route('mobile.user.store.catalog.products.edit.process',['ref'=>$product->reference]) }}"
                      enctype="multipart/form-data">
                    <div class="row g-4">
                        <!-- Featured Product Image Upload -->
                        <div class="col-lg-12">
                            <label>Featured Product Image <sup class="text-danger">*</sup></label>
                            <div class="file-upload">
                                <input type="file" id="featuredFile" accept="image/*" onchange="previewFeaturedImage(event)" name="featuredPhoto">
                                <label for="featuredFile">
                                    <i class="fa fa-file-image-o"></i> Upload Featured Image
                                </label>
                                <img id="featuredImagePreview" class="image-preview" style="display: none;" />
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div class="col-md-12">
                            <label for="inputTitle" class="form-label">Product Name <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="inputTitle" name="name" value="{{ $product->name }}"
                                   placeholder="e.g., Trendy Boutique" >
                        </div>
                        <!-- Manufacturer Name -->
                        <div class="col-6">
                            <label for="inputTitle" class="form-label">Manufacturer Name <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="inputTitle" name="manufacturer"
                                   placeholder="e.g., Dolce & Gab" value="{{ $product->manufacturer }}">
                        </div>
                        <!-- Manufacturer Brand -->
                        <div class="col-6">
                            <label for="inputTitle" class="form-label">Manufacturer Brand <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control" id="inputTitle" name="brand"
                                   placeholder="e.g., Gucci" value="{{ $product->brand }}">
                        </div>
                        <!-- Discounted Price -->
                        <div class="col-6">
                            <label for="inputTitle" class="form-label">
                                Compare Price
                                <i class="fa fa-info-circle" data-bs-toggle="tooltip" title="This is the price which users can compare with the selling price"></i>
                            </label>
                            <input type="number" class="form-control" id="inputTitle" name="comparePrice" step="0.01" value="{{ $product->comparePrice??1 }}">
                        </div>
                        <!-- Price -->
                        <div class="col-6">
                            <label for="inputTitle" class="form-label">
                                Selling Price <sup class="text-danger">*</sup>
                                <i class="fa fa-info-circle" data-bs-toggle="tooltip" title="This is the actual price of the product"></i>
                            </label>
                            <input type="number" class="form-control" id="inputTitle" name="sellingPrice" step="0.01" value="{{ $product->amount }}">
                        </div>
                        <!-- Quantity -->
                        <div class="col-12">
                            <label for="inputTitle" class="form-label">
                                Quantity Available <sup class="text-danger">*</sup>
                                <i class="fa fa-info-circle" data-bs-toggle="tooltip" title="Leave empty to indicate unlimited stock"></i>
                            </label>
                            <input type="number" value="{{ $product->quantity }}" class="form-control" id="inputTitle" name="qty" >
                        </div>
                        <div class="col-md-12">
                            <label for="inputCategory" class="form-label">Category <sup class="text-danger">*</sup></label>
                            <select class="form-select selectize" id="inputCategory" name="category">
                                <option value="">Select an option</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category==$category->id?'selected':'' }}>{{ $category->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description <sup class="text-danger">*</sup></label>
                            <textarea class="form-control editor" id="description" name="description" rows="4">{{ $product->description }}</textarea>
                        </div>

                        <!-- Specifications -->
                        <div class="col-12">
                            <label class="form-label">Product Specifications <sup class="text-danger">*</sup></label>
                            <textarea class="form-control editor" id="description" name="specifications" rows="4">{{ $product->specifications }}</textarea>
                        </div>

                        <!-- Features -->
                        <div class="col-12">
                            <label class="form-label">Product Features <sup class="text-danger">*</sup></label>
                            <textarea class="form-control editor" id="description" name="features" rows="4">{{ $product->keyFeatures }}</textarea>
                        </div>


                        <div class="col-12">
                            <label class="form-label">Stock level Alert <i class="fa fa-info-circle" data-bs-toggle="tooltip"
                                                                           title="Receive notification when this product quantity goes low"></i> </label>
                            <div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="stockAlert" value="1" {{ $product->stockAlert==1?'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Stock Level Alert</label>
                                </div>
                            </div>
                        </div>
                        <!-- Stock Alert -->
                        <div class="col-md-12" id="alertQuantity">
                            <label for="alertQuantity" class="form-label">Stock Alert Quantity </label>
                            <input type="number" class="form-control" id="inputTitle" name="alertQuantity" value="{{ $product->alertQuantity }}">
                        </div>


                        <div class="col-md-12" >
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="1" name="featured" id="featured" {{ $product->featured==1?'checked':'' }}>
                                <label class="form-check-label" for="featured">
                                    Make Product Featured
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center">
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto">
                                    <span>Update Product</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            // Featured Image Preview
            function previewFeaturedImage(event) {
                const input = event.target;
                const preview = document.getElementById('featuredImagePreview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Multiple Product Images Preview
            function previewProductImages(event) {
                const input = event.target;
                const previewContainer = document.getElementById('productImagePreviewContainer');
                previewContainer.innerHTML = ""; // Clear existing previews

                if (input.files) {
                    Array.from(input.files).forEach((file) => {
                        if (!file.type.startsWith("image/")) return;

                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const img = document.createElement("img");
                            img.src = e.target.result;
                            img.classList.add("image-previews");

                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    });
                }
            }
        </script>
        <script type="text/javascript">
            $(".addSizeVariation").click(function () {
                newRowAdd =
                    '<div id="row" class="row"> ' +
                    '<div class="col-lg-12 input-group mb-3">' +
                    '<input type="text" class="form-control" placeholder="Name" name="sizeName[]">' +
                    '<span  id="DeleteRow" class="input-group-text" ><i class="fa fa-trash text-danger"></i></span> ' +
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
                    '<span id="DeleteRows" class="input-group-text"><i class="fa fa-trash text-danger"></i></span> ' +
                    ' </div>';

                $('.colorVariations').append(newRowsAdd);
            });
            $("body").on("click", "#DeleteRows", function () {
                $(this).parents("#rows").remove();
            })
        </script>
        <script src="{{asset('mobile/js/requests/store.js?ver1.0')}}"></script>

        <script>
            $(document).ready(function() {
                $('input[name="stockAlert"]').change(function() {
                    if ($(this).is(':checked')) {
                        $('input[name="alertQuantity"]').prop('readonly', false).val(2); // Enable and set value to 2
                    } else {
                        $('input[name="alertQuantity"]').prop('readonly', true).val(0); // Disable and set value to 0
                    }
                });

                // Ensure it initializes correctly when the page loads
                if (!$('input[name="stockAlert"]').is(':checked')) {
                    $('input[name="alertQuantity"]').prop('readonly', true).val(0);
                }
            });
        </script>
    @endpush
@endsection
