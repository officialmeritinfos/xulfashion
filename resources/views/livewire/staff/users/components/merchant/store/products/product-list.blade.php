<div>
    @inject('injected','App\Custom\Regular')

    @if($showNewForm)
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-center gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <button class="btn btn-sm btn-primary-600" wire:click="toggleNewForm"><i class="ri-add-line"></i> Show Products</button>
                </div>
            </div>
            <div class="card-body">
                <div class="submit-property-area">
                    <div class="container-fluid">
                        <form wire:submit.prevent="submit" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputAddress" class="form-label">Featured Photo<sup class="text-danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="inputGroupFile02" wire:model.live="featuredPhoto">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                    @error('featuredPhoto') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="inputAddress" class="form-label">Product Images<sup class="text-danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" id="inputGroupFile02" wire:model.live="productImages" multiple>
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                    @error('productImages.*') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="row">
                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group">
                                                <label>Product Name<sup class="text-danger">*</sup></label>
                                                <input type="text" class="form-control" wire:model.live="name">
                                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group">
                                                <label>Manufacturer Name</label>
                                                <input type="text" class="form-control" wire:model.live="manufacturer">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group">
                                                <label>Category<sup class="text-danger">*</sup></label>
                                                <select class="form-select form-control" wire:model.live="category">
                                                    <option value="">Select an option</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group">
                                                <label>Manufacturer Brand</label>
                                                <input type="text" class="form-control" wire:model.live="brand">
                                            </div>
                                        </div>

                                        <div class="col-lg-8 mt-3">
                                            <div class="form-group">
                                                <label>Price<sup class="text-danger">*</sup></label>
                                                <input type="number" step="0.01" class="form-control" wire:model.live="price">
                                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-4 mt-3">
                                            <div class="form-group">
                                                <label>Quantity Available<sup class="text-danger">*</sup></label>
                                                <input type="number" class="form-control" wire:model.live="qty">
                                                <span style="font-size: 11px;">Leave at 0 for infinite quantity</span>
                                                @error('qty') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3">
                                            <div class="form-group">
                                                <label>Product Description<sup class="text-danger">*</sup></label>
                                                <textarea class="form-control" wire:model.live="description" cols="30" rows="5"></textarea>
                                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3">
                                            <div class="form-group">
                                                <label>Product Specifications<sup class="text-danger">*</sup></label>
                                                <textarea class="form-control" wire:model.live="specifications" cols="30" rows="5"></textarea>
                                                @error('specifications') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3">
                                            <div class="form-group">
                                                <label>Product Features<sup class="text-danger">*</sup></label>
                                                <textarea class="form-control" wire:model.live="features" cols="30" rows="5"></textarea>
                                                @error('features') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 row mb-5">
                                            <label class="mb-3">Product Size Variations</label>
                                            @foreach($sizeVariations as $index => $sizeVariation)
                                                <div class="col-lg-12 input-group mb-3" wire:key="size-{{ $index }}">
                                                    <input type="text" class="form-control" placeholder="Name" wire:model.live="sizeVariations.{{ $index }}">
                                                    <button class="btn btn-danger" type="button" wire:click="removeSizeVariation({{ $index }})">Delete</button>
                                                    @error('sizeVariations.'.$index) <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-secondary" wire:click="addSizeVariation">Add Variation</button>
                                        </div>

                                        <div class="col-lg-12 row mb-5">
                                            <label class="mb-3">Product Color Variations</label>
                                            @foreach($colorVariations as $index => $colorVariation)
                                                <div class="col-lg-12 input-group mb-3" wire:key="color-{{ $index }}">
                                                    <input type="text" class="form-control" placeholder="Name" wire:model.live="colorVariations.{{ $index }}">
                                                    <button class="btn btn-danger" type="button" wire:click="removeColorVariation({{ $index }})">Delete</button>
                                                    @error('colorVariations.'.$index) <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            @endforeach
                                            <button type="button" class="btn btn-primary" wire:click="addColorVariation">Add Variation</button>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Return Policy</label>
                                                <textarea class="form-control" wire:model.live="returnPolicy" cols="30" rows="5"></textarea>
                                                <small>Leave blank to apply store-level Refund policy to product</small>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Refund Policy</label>
                                                <textarea class="form-control" wire:model.live="refundPolicy" cols="30" rows="5"></textarea>
                                                <small>Leave blank to apply store-level Refund policy to product</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="switch1" wire:model.live="featured">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch1">Make Product Featured</label>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="switch2" wire:model.live="addAnother">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="switch2">Add another Product</label>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-outline-primary">
                                        <span>
                                        Add Product
                                            <div wire:loading>
                                                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                            </div>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(!$showNewForm)
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span>Show</span>
                        <select class="form-select form-select-sm w-auto" wire:model.live="show">
                            <option>1</option>
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="icon-field">
                        <input type="text" name="#0" class="form-control form-control-sm w-auto" placeholder="Search" wire:model.live="search">
                        <span class="icon">
                          <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>

                    <button class="btn btn-sm btn-primary-600" wire:click="toggleNewForm"><i class="ri-add-line"></i> Add New Product</button>
                </div>
            </div>
            <div class="card-body">
                @if($showEditForm)
                    <div class="submit-property-area">
                        <div class="container-fluid">
                            <form wire:submit.prevent="submitEditing" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="inputAddress" class="form-label">Product Images<sup class="text-danger">*</sup></label>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" id="inputGroupFile02" wire:model.live="featuredPhoto">
                                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                        </div>
                                        @error('featuredPhoto') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <div class="row">
                                            <div class="col-lg-6 mt-3">
                                                <div class="form-group">
                                                    <label>Product Name<sup class="text-danger">*</sup></label>
                                                    <input type="text" class="form-control" wire:model.live="name">
                                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <div class="form-group">
                                                    <label>Manufacturer Name</label>
                                                    <input type="text" class="form-control" wire:model.live="manufacturer">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <div class="form-group">
                                                    <label>Category<sup class="text-danger">*</sup></label>
                                                    <select class="form-select form-control" wire:model.live="category">
                                                        <option value="">Select an option</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6 mt-3">
                                                <div class="form-group">
                                                    <label>Manufacturer Brand</label>
                                                    <input type="text" class="form-control" wire:model.live="brand">
                                                </div>
                                            </div>

                                            <div class="col-lg-8 mt-3">
                                                <div class="form-group">
                                                    <label>Price<sup class="text-danger">*</sup></label>
                                                    <input type="number" step="0.01" class="form-control" wire:model.live="price">
                                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 mt-3">
                                                <div class="form-group">
                                                    <label>Quantity Available<sup class="text-danger">*</sup></label>
                                                    <input type="number" class="form-control" wire:model.live="qty">
                                                    <span style="font-size: 11px;">Leave at 0 for infinite quantity</span>
                                                    @error('qty') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-3">
                                                <div class="form-group">
                                                    <label>Product Description<sup class="text-danger">*</sup></label>
                                                    <textarea class="form-control" wire:model.live="description" cols="30" rows="5"></textarea>
                                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-3">
                                                <div class="form-group">
                                                    <label>Product Specifications<sup class="text-danger">*</sup></label>
                                                    <textarea class="form-control" wire:model.live="specifications" cols="30" rows="5"></textarea>
                                                    @error('specifications') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mt-3">
                                                <div class="form-group">
                                                    <label>Product Features<sup class="text-danger">*</sup></label>
                                                    <textarea class="form-control" wire:model.live="features" cols="30" rows="5"></textarea>
                                                    @error('features') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Return Policy</label>
                                                    <textarea class="form-control" wire:model.live="returnPolicy" cols="30" rows="5"></textarea>
                                                    <small>Leave blank to apply store-level Refund policy to product</small>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Refund Policy</label>
                                                    <textarea class="form-control" wire:model.live="refundPolicy" cols="30" rows="5"></textarea>
                                                    <small>Leave blank to apply store-level Refund policy to product</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center mb-5">
                                        <button type="submit" class="btn btn-outline-primary">
                                        <span>
                                        Update Product
                                            <div wire:loading>
                                                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                            </div>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label" for="checkAll">
                                        S.L
                                    </label>
                                </div>
                            </th>
                            <th scope="col">PRODUCT ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">CATEGORY</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">HIGHLIGHTED</th>
                            <th scope="col">FEATURED</th>
                            <th scope="col">DATE ADDED</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $index=> $product)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label" for="check1">
                                            {{$products->firstItem()+$index}}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            #{{$product->reference}}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{$product->featuredImage}}" class="lightboxed">
                                        <img src="{{$product->featuredImage}}" style="width: 50px;" alt="Images">
                                    </a>
                                    {{$product->name}}
                                </td>
                                <td>
                                    {{$injected->fetchCategoryById($product->category)->categoryName??'N/A'}}
                                </td>
                                <td class="bold">
                                    {{$product->currency}} {{number_format($product->amount,2)}}
                                </td>
                                <td class="bold">
                                    {{$product->quantity}}
                                </td>
                                <td class="status">
                                    @if($product->highlighted==1)
                                        <i class="ri-checkbox-circle-line"></i>
                                        Highlighted
                                    @else
                                        <i class="ri-alert-line text-danger"></i>
                                        Not highlighted
                                    @endif
                                </td>
                                <td class="status">
                                    @if($product->featured==1)
                                        <i class="ri-checkbox-circle-line"></i>
                                        Featured
                                    @else
                                        <i class="ri-alert-line text-danger"></i>
                                        Not Featured
                                    @endif
                                </td>
                                <td>
                                    {{date('d M, Y - h:i A')}}
                                </td>
                                <td class="status">
                                    @if($product->status==1)
                                        <i class="ri-checkbox-circle-line"></i>
                                        Active
                                    @else
                                        <i class="ri-alert-line text-danger"></i>
                                        Inactive
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item cpy"
                                                   data-clipboard-text="Hey guys,checkout my new product: {{$product->name}} on {{$siteName}} in the catalog {{$injected->fetchCategoryById($product->category)->categoryName??'N/A'}}
                                                       {{route('merchant.store.product.detail',['subdomain'=>$store->slug,'id'=>$product->reference])}}">
                                                    Share
                                                    <i class="ri-share-forward-2-fill"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" wire:click="edit({{$product->id}})">
                                                    Edit
                                                    <i class="ri-edit-2-line"></i>
                                                </a>
                                            </li>
                                            @if($product->status!=1)
                                                <li>
                                                    <a class="dropdown-item" wire:click="updateProductStatus({{$product->id}},1)">
                                                        Activate
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" wire:click="updateProductStatus({{$product->id}},2)">
                                                        Deactivate
                                                        <i class="ri-alert-line text-danger"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($product->featured!=1)
                                                <li>
                                                    <a class="dropdown-item" wire:click="markProductAsFeatured({{$product->id}},1)">
                                                        Mark Featured
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" wire:click="markProductAsFeatured({{$product->id}},2)">
                                                        Remove Featuring
                                                        <i class="ri-alert-line text-danger"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($product->highlighted!=1)
                                                <li>
                                                    <a class="dropdown-item" wire:click="highlightProduct({{$product->id}},1)">
                                                        Mark Highlighted
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" wire:click="highlightProduct({{$product->id}},2)">
                                                        Remove Highlighting
                                                        <i class="ri-alert-line text-danger"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" wire:click="delete({{$product->id}})">
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
                    {{$products->links()}}
                </div>
            </div>
        </div>
    @endif
</div>
