<div>
    <div class="container py-4">
        <div class="row">
            <!-- Product Info -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                               <span> Product Information</span>
                                <a href="{{ route('mobile.user.store.catalog.products.edit',['ref'=>$product->reference]) }}"
                                   class="form-control form-control-sm w-auto">
                                    <i class="fa fa-edit"></i> Edit Product
                                </a>
                            </div>
                            <div class="card-body ">

                                <div class="d-flex flex-wrap gap-4">
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Product</p>
                                        <strong>{{ $product->name }}</strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Reference</p>
                                        <strong>{{ $product->reference }}</strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Category</p>
                                        <strong>{{ $product->productCategory->categoryName }}</strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Manufacturer</p>
                                        <strong>{{ $product->manufacturer }}</strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Brand</p>
                                        <strong>{{ $product->brand }}</strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Price</p>
                                        <strong>{{ $product->currency }} {{ number_format($product->amount, 2) }}</strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Stock</p>
                                        <strong>
                                            @if($product->quantity >0)
                                                {{ $product->quantity }} available
                                            @else
                                                 <span class="badge bg-danger">Out of stock</span>
                                            @endif
                                        </strong>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Status</p>
                                        <span class="badge bg-{{ $product->status == 1 ? 'success' : 'danger' }}">
                                            {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Highlighted</p>
                                        @if($product->highlighted == 1)
                                            <i class="fa fa-check-square text-success"></i> <strong>Highlighted</strong>
                                        @else
                                            <i class="fa fa-warning text-danger"></i> <strong>Not Highlighted</strong>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">Featured</p>
                                        @if($product->featured == 1)
                                            <i class="fa fa-check-circle text-success"></i> <strong>Featured</strong>
                                        @else
                                            <i class="fa fa-sad-tear text-danger"></i> <strong>Not Featured</strong>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">
                                            <strong>Description</strong>
                                        </p>
                                       <span>
                                           {!! $product->description !!}
                                       </span>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">
                                            <strong>Specifications</strong>
                                        </p>
                                       <span>
                                           {!! $product->specifications !!}
                                       </span>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <p class="text-muted mb-1">
                                            <strong>Features</strong>
                                        </p>
                                       <span>
                                           {!! $product->keyFeatures !!}
                                       </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Images & Stock Alert -->
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span>Product Images</span>
                        <a href="#addImage" class="form-control form-control-sm w-auto" data-bs-toggle="modal">
                            <i class="fa fa-plus-square"></i> Add Image
                        </a>
                        <div wire:loading wire:target="deleteImage" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ $product->featuredImage }}" data-lightbox="product-gallery">
                            <img src="{{ $product->featuredImage }}" class="img-fluid rounded" alt="Featured Image">
                        </a>
                        <div class="d-flex justify-content-center gap-2 mt-2 product-images">
                            @foreach($product->images as $image)
                                <div class="position-relative">
                                    <a href="{{ $image->image }}" data-lightbox="product-gallery">
                                        <img src="{{ $image->image }}" class="border img-thumbnail" alt="Product Image" width="80">
                                    </a>
                                    <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-1 delete-image" wire:click="deleteImage('{{ $image->id }}')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Product Variants -->
                <div class="card shadow-sm mt-3 mb-3">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Product Variants</h5>
                        <div>
                            <div wire:loading wire:target="deleteSizeVariant, deleteColorVariant,toggleSizeForm,toggleColorForm" class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Size Variants -->
                            <div class="col-md-6">
                                <h6>Size Variants</h6>
                                <ul class="list-group">
                                    @forelse($product->sizes as $size)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $size->name }}
                                            <button wire:click="deleteSizeVariant({{ $size->id }})" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No size variants available</li>
                                    @endforelse
                                </ul>
                                <!-- Show Add Size Form -->
                                @if(!$showSizeForm)
                                    <button wire:click="toggleSizeForm" class="btn btn-outline-primary btn-auto">
                                        <i class="ri-add-line"></i> Add Size Variant
                                    </button>
                                @else
                                    <!-- Add Size Variant Form -->
                                    <div class="mt-2">
                                        <input type="text" class="form-control mb-2" wire:model="sizeName" placeholder="Enter size name">
                                        @error('sizeName') <span class="text-danger">{{ $message }}</span> @enderror
                                        <div class="col-12 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-3">
                                                <button type="button" wire:click="saveSizeVariant" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                                    <span wire:loading.remove>Save</span>
                                                    <span wire:loading>Processing...</span>
                                                </button>
                                                <button type="button" wire:click="toggleSizeForm" class="btn btn-outline-secondary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                                    <span wire:loading.remove>Cancel</span>
                                                    <span wire:loading>Processing...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Color Variants -->
                            <div class="col-md-6">
                                <h6>Color Variants</h6>
                                <ul class="list-group">
                                    @forelse($product->colors as $color)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $color->name }}
                                            <button wire:click="deleteColorVariant({{ $color->id }})" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-trash-can"></i>
                                            </button>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted">No color variants available</li>
                                    @endforelse
                                </ul>
                                <!-- Show Add Color Form -->
                                @if(!$showColorForm)
                                    <button wire:click="toggleColorForm" class="btn btn-outline-primary btn-auto">
                                        <i class="ri-add-line"></i> Add Color Variant
                                    </button>
                                @else
                                    <!-- Add Color Variant Form -->
                                    <div class="mt-2">
                                        <input type="text" class="form-control mb-2" wire:model="colorName" placeholder="Enter color name">
                                        @error('colorName') <span class="text-danger">{{ $message }}</span> @enderror
                                        <div class="col-12 text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-3">
                                                <button type="button" wire:click="saveColorVariant" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                                    <span wire:loading.remove>Save</span>
                                                    <span wire:loading>Processing...</span>
                                                </button>
                                                <button type="button" wire:click="toggleColorForm" class="btn btn-outline-secondary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                                    <span wire:loading.remove>Cancel</span>
                                                    <span wire:loading>Processing...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-2">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Product Actions</h5>
                    </div>
                    <div class="card-body d-flex flex-wrap gap-2">
                        <div class="scrollable-table-container d-flex gap-3">
                            <div>
                                <div wire:loading wire:target="editVariants, updateStatus,markFeatured,removeFeatured,markHighlighted,removeHighlighted,deleteProduct" class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <!-- Activate/Deactivate -->
                            @if($product->status != 1)
                                <button wire:click="updateStatus(1)" class="btn btn-outline-success btn-sm btn-auto">
                                    <i class="ri-checkbox-circle-fill"></i> Activate
                                </button>
                            @else
                                <button wire:click="updateStatus(2)" class="btn btn-outline-danger btn-sm btn-auto">
                                    <i class="ri-alert-line"></i> Deactivate
                                </button>
                            @endif

                            <!-- Feature/Unfeature -->
                            @if($product->featured != 1)
                                <button wire:click="markFeatured" class="btn btn-outline-success btn-sm btn-auto">
                                    <i class="ri-checkbox-circle-fill"></i> Mark Featured
                                </button>
                            @else
                                <button wire:click="removeFeatured" class="btn btn-outline-danger btn-auto">
                                    <i class="ri-alert-line"></i> Remove Featuring
                                </button>
                            @endif

                            <!-- Highlight/Unhighlight -->
                            @if($product->highlighted != 1)
                                <button wire:click="markHighlighted" class="btn btn-outline-success btn-auto">
                                    <i class="ri-checkbox-circle-fill"></i> Mark Highlighted
                                </button>
                            @else
                                <button wire:click="removeHighlighted" class="btn btn-outline-danger btn-auto">
                                    <i class="ri-alert-line"></i> Remove Highlighting
                                </button>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span>Stock Alert</span>
                        <i class="fas fa-bell text-warning"></i>
                    </div>
                    <div class="card-body text-center">
                        <div class="alert alert-{{ $product->stockAlert ? 'success' : 'danger' }} d-flex align-items-center justify-content-center">
                            <i class="fas {{ $product->stockAlert ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-2"></i>
                            <span>Stock Alert: <strong>{{ $product->stockAlert ? 'Enabled' : 'Disabled' }}</strong></span>
                        </div>
                        <h5 class="mb-0 text-muted">Reorder Level</h5>
                        <p class="fs-4 fw-bold text-muted">{{ $product->alertQuantity }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-dark text-white">
                        <h5 class="mb-0">Orders Containing This Product</h5>
                        <select class="form-select form-select-sm w-auto" wire:model.live="orderStatusFilter">
                            <option value="all">All Status</option>
                            <option value="1">Completed</option>
                            <option value="2">Pending Payment</option>
                            <option value="3">Cancelled</option>
                            <option value="4">Processing</option>
                            <option value="5">Incomplete Payment</option>
                            <option value="6">In Escrow</option>
                            <option value="7">Under Review</option>
                        </select>
                        <div wire:loading wire:target="orderStatusFilter" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    @if($orders->count())
                        <div class="scrollable-table-container">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @foreach($order->breakdowns as $item)
                                        @if($item->product == $product->id)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $order->reference }}</span>
                                                </td>
                                                <td>{{ $order->customers->name ?? 'Guest' }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ currencySign($order->currency) }} {{ number_format($item->totalAmount, 2) }}</td>
                                                <td>
                                                    @switch($order->status)
                                                        @case(1) <span class="badge bg-success">Completed</span> @break
                                                        @case(2) <span class="badge bg-info">Pending</span> @break
                                                        @case(3) <span class="badge bg-danger">Cancelled</span> @break
                                                        @case(4) <span class="badge bg-primary">Processing</span> @break
                                                        @case(5) <span class="badge bg-warning text-white">Incomplete</span> @break
                                                        @case(6) <span class="badge bg-dark">In Escrow</span> @break
                                                        @default <span class="badge bg-secondary">Under Review</span>
                                                    @endswitch
                                                </td>
                                                <td>{{ $order->created_at->format('d M, Y - h:i A') }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <a href="{{ url('/') }}" >
                                                            <i class="fa fa-arrow-circle-right"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <!-- Pagination -->
                            <div class="mt-2">
                                <div wire:loading wire:target="nextPage, previousPage, gotoPage"
                                     class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    @else
                        <p>No Orders found</p>
                    @endif
                </div>

            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="addImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="submit-property-form" id="processForm" wire:submit.prevent="uploadImage"
                          enctype="multipart/form-data">
                        <div class="row g-3">
                            <!-- Product Images Upload -->
                            <div class="col-lg-12">
                                <label class="form-label">Product Images <sup class="text-danger">*</sup></label>
                                <div class="file-upload" wire:ignore.self>
                                    <input type="file" id="productFiles" accept="image/*" multiple onchange="previewProductImages(event)"
                                    wire:model="file" wire:ignore.self>
                                    <label for="productFiles">
                                        <i class="fa fa-file-image-o"></i> Upload Photos
                                    </label>
                                    <div id="productImagePreviewContainer" class="image-preview-container" wire:ignore>
                                        <img id="previewImageTemplate" class="image-preview" style="display: none;" wire:ignore.self/>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Upload Images</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
