<div>

    {{--    Show Catalog form for new --}}
    @if($showNew)
        <div class="row">
            <div class="main mt-2 mb-2">
                <div class="container-fluid text-center">
                    <button type="button" wire:click="toggleNewCategory" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Cancel</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Add New Catalog</h4>
                </div>
                <div class="card-body">
                    <form id="processForm" wire:submit.prevent="addNewCatalog">
                        @include('notifications')
                        @if($errors->has('form_error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('form_error') }}
                            </div>
                        @endif
                        <div class="row g-4">
                            <!-- Store Name -->
                            <div class="col-md-12">
                                <label for="inputTitle" class="form-label">Catalog Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputTitle" wire:model.live.debounce.250ms="name"
                                       placeholder="e.g., Men's Wears" >
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Store Logo Upload -->
                            <div class="col-lg-12">
                                <label>Catalog Image <sup class="text-danger">*</sup></label>
                                <div class="file-upload">
                                    <input type="file" id="file" accept="image/*" onchange="previewImage(event)"
                                           wire:model.live.debounce.250ms="file">
                                    <label for="file">
                                        <i class="fa fa-file-image-o"></i> Upload image
                                    </label>
                                    <img id="imagePreview" class="image-preview" style="display: none;" wire:ignore.self/>
                                </div>
                                @error('file') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mt-4 mb-3">
                                <label>Catalog Visibility <sup class="text-danger">*</sup></label>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" wire:model="categoryStatus" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Visible</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="categoryStatus" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">Hidden</label>
                                </div>
                                @error('categoryStatus') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Create Catalog</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{--    Show Catalog form for edit --}}
    @if($showEdit)
        <div class="row">
            <div class="main mt-2 mb-2">
                <div class="container-fluid text-center">
                    <button type="button" wire:click="cancelEdit" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Cancel</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Update Catalog</h4>
                </div>
                <div class="card-body">
                    <form id="processForm" wire:submit.prevent="updateCatalog">
                        @include('notifications')
                        @if($errors->has('form_error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('form_error') }}
                            </div>
                        @endif
                        <div class="row g-4">
                            <!-- Store Name -->
                            <div class="col-md-12">
                                <label for="inputTitle" class="form-label">Catalog Name <sup class="text-danger">*</sup></label>
                                <input type="text" class="form-control" id="inputTitle" wire:model.live.debounce.250ms="name"
                                       placeholder="e.g., Men's Wears" >
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Store Logo Upload -->
                            <div class="col-lg-12">
                                <label>Catalog Image <sup class="text-danger">*</sup></label>
                                <div class="file-upload">
                                    <input type="file" id="file" accept="image/*" onchange="previewImage(event)"
                                           wire:model.live.debounce.250ms="file">
                                    <label for="file">
                                        <i class="fa fa-file-image-o"></i> Upload image
                                    </label>
                                    <img id="imagePreview" class="image-preview" style="display: none;" wire:ignore.self/>
                                </div>
                                @error('file') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-4 mb-3">
                                <label>Catalog Visibility <sup class="text-danger">*</sup></label>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" wire:model="categoryStatus" id="inlineRadio1" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Visible</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" wire:model="categoryStatus" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="inlineRadio2">Hidden</label>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 text-center">
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit" class="btn btn-outline-primary mt-0 w-50 submit mb-3 btn-auto" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Update Catalog</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    {{--    Show Catalog categories--}}
    @if(!$showEdit && !$showNew)
        <div class="row">
            <div class="main mt-2 mb-2">
                <div class="container-fluid text-center">
                    <button type="button" wire:click="toggleNewCategory" class="btn theme-btn w-100 mt-3 mb-3 btn-auto" role="button"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>Add Catalog</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Catalog Category</h5>
            </div>
        </div>

        {{-- Search & Export --}}
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="icon-field">
                        <input type="text" class="form-control form-control-sm w-auto"
                               placeholder="Search by name" wire:model.live.debounce.250ms="search">
                        <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <select class="form-select form-select-sm w-auto" wire:model.live="listPerPage">
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div wire:loading wire:target="listPerPage, search,editCategory,deleteCategory,shareCategory" class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="card-body">
                @if($categories->count())
                    <div class="scrollable-table-container">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>NAME</th>
                                <th>PHOTO</th>
                                <th>PRODUCTS</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        {{ ucfirst($category->categoryName) }}
                                    </td>
                                    <td>
                                        <img src="{{ $category->photo??asset('customcategory.jpg') }}" alt="" class="img-thumbnail" width="50" />
                                    </td>
                                    <td>
                                        {{ $category->products->count() }}
                                    </td>
                                    <td>
                                        @if($category->status!=1)
                                            <span class="badge bg-primary">
                                            Inactive
                                        </span>
                                        @else
                                            <span class="badge bg-success">
                                            Active
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <!-- Share Icon -->
                                            <i class="fas fa-share-alt text-primary"
                                               wire:click="shareCategory('{{ $category->id }}')"
                                               wire:loading.attr="disabled"
                                               wire:target="shareCategory('{{ $category->id }}')"
                                               livewire:offline.attr="disabled"
                                               style="cursor: pointer; font-size: 18px;"></i>

                                            <!-- Edit Icon -->
                                            <i class="fas fa-edit text-warning"
                                               wire:click="editCategory('{{ $category->id }}')"
                                               wire:loading.attr="disabled"
                                               wire:target="editCategory('{{ $category->id }}')"
                                               livewire:offline.attr="disabled"
                                               style="cursor: pointer; font-size: 18px;"></i>

                                            <!-- Delete Icon -->
                                            @if($category->isDefault != 1)
                                                <i class="fa fa-trash text-danger"
                                                   wire:click="deleteCategory('{{ $category->id }}')"
                                                   wire:loading.attr="disabled"
                                                   wire:target="deleteCategory('{{ $category->id }}')"
                                                   livewire:offline.attr="disabled"
                                                   style="cursor: pointer; font-size: 18px;"></i>
                                            @endif
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        {{ $categories->links() }}
                    </div>
                @else
                    <p>No Category found</p>
                @endif
            </div>
        </div>
    @endif


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
