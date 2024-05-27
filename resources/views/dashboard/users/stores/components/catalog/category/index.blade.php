@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="order-details-area mb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>

                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <button data-bs-toggle="modal" data-bs-target="#newCategory" class="new-orders">
                            Add New Category
                            <i class="ri-add-circle-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="latest-transaction-area">
                <div class="table-responsive" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">NAME</th>
                            <th scope="col">PHOTO</th>
                            <th scope="col">IS DEFAULT</th>
                            <th scope="col">DATE</th>
                            <th scope="col">NUMBER OF PRODUCTS</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody class="searches">
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        {{ucfirst($category->categoryName)}}
                                    </td>
                                    <td>
                                        <img src="{{$category->photo??asset('customcategory.jpg')}}" style="width: 150px;">
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
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <a class="dropdown-item cpy"
                                                       data-clipboard-text="Hey guys,checkout my new catalog on {{$siteName}} for {{$category->categoryName}}
                                                   {{route('merchant.store.category',['subdomain'=>$store->slug,'id'=>$category->id])}}">
                                                        Share
                                                        <i class="ri-share-forward-2-fill"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.category.edit',['id'=>$category->id])}}">
                                                        Edit
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>
                                                @if($category->isDefault!=1)
                                                    <li>
                                                        <a class="dropdown-item" href="{{route('user.stores.catalog.category.delete',['id'=>$category->id])}}">
                                                            Delete
                                                            <i class="ri-delete-bin-6-line"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')

        <!-- Modal -->
        <div class="modal fade" id="newCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="submit-property-form" id="processForm" action="{{route('user.stores.catalog.category.new.process')}}" method="post">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputTitle" class="form-label">Category Name<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="inputTitle" name="name" >
                                </div>
                                <div class="col-md-12">
                                    <label for="inputTitle" class="form-label">Category Photo<sup class="text-danger">*</sup></label>
                                    <input type="file" class="form-control" id="inputTitle" name="photo" >
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="default-btn submit">Add Category</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
