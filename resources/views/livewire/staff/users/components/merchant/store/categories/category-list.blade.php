<div>
    @inject('injected','App\Custom\Regular')
    <div class="row gy-4 mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center justify-content-center gap-2">
                        <button wire:click="toggleNewForm" class="btn btn-sm btn-primary-600 radius-8 d-inline-flex align-items-center gap-1">
                            <i class="ri-add-circle-line"></i>
                            Add New Category
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($showAddNewForm)
                        <form wire:submit.prevent="submit" class="row g-3">
                            <div class="col-md-6 mt-3">
                                <label for="address" class="form-label">Category Name</label>
                                <input class="form-control form-control-lg" id="address" wire:model.live="name" />
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="addressProof" class="form-label">Proof of Address</label>
                                <input type="file" class="form-control" id="addressProof" wire:model.live="photo">
                                @error('photo') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mt-5 text-center">
                                <button class="btn btn-outline-primary text-sm btn-sm radius-8">
                                    <span>
                                        Submit
                                        <div wire:loading>
                                            <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                        </div>
                                    </span>
                                </button>
                            </div>

                        </form>
                    @endif
                        @if($showEditForm)
                            <form wire:submit.prevent="submitEdit" class="row g-3 mb-5">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label for="address" class="form-label">Category Name</label>
                                        <input class="form-control form-control-lg" id="address" wire:model.live="name" />
                                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="addressProof" class="form-label">Proof of Address</label>
                                        <input type="file" class="form-control" id="addressProof" wire:model.live="photo">
                                        @error('photo') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3 text-center mb-5">
                                    <button type="submit" class="btn btn-outline-primary text-sm btn-sm radius-8">
                                                <span>
                                                    Submit
                                                    <div wire:loading>
                                                        <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                    </div>
                                                </span>
                                    </button>
                                </div>

                            </form>
                        @endif
                    @if(!$showAddNewForm)
                        <div class="table-responsive">
                            <table class="table bordered-table mb-0">
                                <thead>
                                <tr>
                                    <th scope="col"> S/L</th>
                                    <th scope="col">NAME</th>
                                    <th scope="col">PHOTO</th>
                                    <th scope="col">IS DEFAULT</th>
                                    <th scope="col">DATE</th>
                                    <th scope="col">NUMBER OF PRODUCTS</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $index=>$category)
                                    <tr>
                                        <td>{{$categories->firstItem()+$index}}</td>
                                        <td>
                                            {{ucfirst($category->categoryName)}}
                                        </td>
                                        <td>
                                            <img src="{{$category->photo??asset('customcategory.jpg')}}" class="lightboxed w-80-px h-80-px radius-8 object-fit-cover">
                                        </td>
                                        <td>
                                            @if($category->isDefault==1)
                                                <span class="badge bg-primary">
                                                Default
                                            </span>
                                            @else
                                                <span class="badge bg-info">
                                                Not Default
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{date('F d, Y', strtotime($category->created_at))}}
                                        </td>
                                        <td class="bold">
                                            {{$injected->numberOfProductInStoreCategory($store->id,$category->id)}}
                                        </td>
                                        <td class="status">
                                            @switch($category->status)
                                                @case(1)
                                                    <span class="badge bg-success">
                                                    Active
                                                </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-danger">
                                                    Inactive
                                                </span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($staff->can('update UserStoreCatalogCategory'))
                                                <button wire:click="edit({{$category->id}})" class="btn btn-sm btn-outline-primary">
                                                    Edit
                                                </button>
                                            @endif

                                            @if($staff->can('delete UserStoreCatalogCategory'))
                                                <button wire:click="delete({{$category->id}})" class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{$categories->links()}}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
