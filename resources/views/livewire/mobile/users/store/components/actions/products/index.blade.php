<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Products</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('mobile.user.store.catalog.products.new') }}" class="form-control form-control-sm w-auto">
                    <i class="fa fa-plus-square"></i> Add Product
                </a>
            </div>
        </div>
    </div>

    {{-- Search & Export --}}
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <!-- Search -->
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search by name" wire:model.live.debounce.250ms="search">
                    <span class="icon">
                    <iconify-icon icon="ion:search-outline"></iconify-icon>
                </span>
                </div>
            </div>

            <!-- Status Filter -->
            <select class="form-select form-select-sm w-auto" wire:model.live="statusFilter">
                <option value="all">All Status</option>
                <option value="1">Active</option>
                <option value="2">Inactive</option>
                <option value="featured">Featured</option>
                <option value="highlighted">Highlighted</option>
                <option value="out-of-stock">Out of Stock</option>
            </select>

            <!-- Rows Per Page -->
            <select class="form-select form-select-sm w-auto" wire:model.live="listPerPage">
                <option>1</option>
                <option>5</option>
                <option>10</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
            </select>

            <!-- Loading Spinner -->
            <div wire:loading wire:target="listPerPage, search, editProduct, deleteProduct, shareProduct"
                 class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="card-body">
            @if($products->count())
                <div class="scrollable-table-container">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>NAME</th>
                            <th>PHOTO</th>
                            <th>CATEGORY</th>
                            <th>PRICE</th>
                            <th>STOCK</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ ucfirst($product->name) }}</td>
                                <td>
                                    <img src="{{ $product->featuredImage }}"
                                         alt="Product Image"
                                         class="img-thumbnail" width="50"/>
                                </td>
                                <td>{{ $product->productCategory->categoryName }}</td>
                                <td>{{ currencySign($product->currency) }}{{ number_format($product->amount,2) }}</td>
                                <td>
                                    @if($product->quantity > 0)
                                        {{ $product->quantity }}
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Share Icon -->
                                        <i class="fas fa-share-alt text-warning"
                                           wire:click="shareProduct('{{ $product->id }}')"
                                           wire:loading.attr="disabled"
                                           wire:target="shareProduct('{{ $product->id }}')"
                                           livewire:offline.attr="disabled"
                                           style="cursor: pointer; font-size: 18px;"></i>

                                        <!-- View Icon -->
                                        <a href="{{ route('mobile.user.store.catalog.products.detail',['ref'=>$product->reference]) }}">
                                            <i class="fas fa-eye text-primary"
                                               style="cursor: pointer; font-size: 18px;"></i>
                                        </a>
                                        <!-- Delete Icon -->
                                        <a  wire:click.prevent="deleteProduct({{ $product->id }})">
                                            <i class="fas fa-trash-alt text-danger"
                                               style="cursor: pointer; font-size: 18px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-2">
                    <div wire:loading wire:target="nextPage, previousPage, gotoPage"
                         class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    {{ $products->links() }}
                </div>
            @else
                <p>No Products found</p>
            @endif
        </div>
    </div>


    <!-- Share Modal -->
    <div wire:ignore.self class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-lg" style="border-radius: 12px; padding: 20px;">

                <!-- Modal Header -->
                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                    <h5 class="modal-title fw-bold">Share Now</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Share Options -->
                <div class="text-center mt-3">
                    <p class="text-muted mb-3">Share this link via</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" onclick="shareToSocial('facebook')"
                           class="d-flex align-items-center justify-content-center"
                           style="width: 45px; height: 45px; border-radius: 50%; background-color: #f0f2f5;">
                            <i class="fab fa-facebook-f text-primary"></i>
                        </a>
                        <a href="#" onclick="shareToSocial('twitter')"
                           class="d-flex align-items-center justify-content-center"
                           style="width: 45px; height: 45px; border-radius: 50%; background-color: #e1f5fe;">
                            <i class="fab fa-twitter text-info"></i>
                        </a>
                        <a href="#" onclick="shareToSocial('instagram')"
                           class="d-flex align-items-center justify-content-center"
                           style="width: 45px; height: 45px; border-radius: 50%; background-color: #ffe0f0;">
                            <i class="fab fa-instagram text-danger"></i>
                        </a>
                        <a href="#" onclick="shareToSocial('whatsapp')"
                           class="d-flex align-items-center justify-content-center"
                           style="width: 45px; height: 45px; border-radius: 50%; background-color: #d9fdd3;">
                            <i class="fab fa-whatsapp text-success"></i>
                        </a>
                        <a href="#" onclick="shareToSocial('telegram')"
                           class="d-flex align-items-center justify-content-center"
                           style="width: 45px; height: 45px; border-radius: 50%; background-color: #e3f2fd;">
                            <i class="fab fa-telegram-plane text-primary"></i>
                        </a>
                    </div>
                </div>

                <!-- Copy Link Section -->
                <div class="text-center mt-4">
                    <p class="text-muted">Or copy link</p>
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-link text-secondary"></i>
                        </span>
                        <input type="text" class="form-control text-center border-light" id="shareLink" value="{{ $shareUrl }}" readonly>
                        <span class="input-group-text cpy text-primary" data-clipboard-text="{{ $shareUrl }}" style="cursor:pointer;">
                            <i class="fas fa-copy"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
