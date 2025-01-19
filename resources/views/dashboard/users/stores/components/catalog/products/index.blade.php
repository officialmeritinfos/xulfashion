@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="product-area ">
        <div class="container-fluid">
            <div class="order-details-area row">
                <div class="col-lg-4 col-sm-4">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div class="add-new-orders">
                        <a href="{{route('user.stores.catalog.products.new')}}" class="new-orders">
                            Add New Product
                            <i class="ri-add-circle-line"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <div class="add-new-orders">
                        <a href="{{route('user.stores.catalog.products.deleted')}}" class="btn btn-danger">
                            Trashed
                            <i class="ri-delete-bin-6-line"></i>
                        </a>
                    </div>
                </div>
            </div>


        </div>
        <div class="latest-transaction-area">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
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
                    <tbody class="searches">
                        @foreach($products as $product)
                            <tr>
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
                                                <span class="dropdown-item cpy text-warning"
                                                   data-clipboard-text="Hey guys,checkout my new product: {{$product->name}} on {{$siteName}} in the catalog {{$injected->fetchCategoryById($product->category)->categoryName??'N/A'}}
                                                   {{route('merchant.store.product.detail',['subdomain'=>$store->slug,'id'=>$product->reference])}}">
                                                    Share
                                                    <i class="ri-share-forward-2-fill"></i>
                                                </span>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.catalog.product.edit',['id'=>$product->reference])}}">
                                                    Edit
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.catalog.product.edit.image',['id'=>$product->reference])}}">
                                                    Edit Product Images
                                                    <i class="ri-image-edit-line"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.catalog.product.edit.specs',['id'=>$product->reference])}}">
                                                    Edit Product Variants
                                                    <i class="ri-edit-circle-line"></i>
                                                </a>
                                            </li>
                                            @if($product->status!=1)
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.product.edit.status',['id'=>$product->reference,'status'=>1])}}">
                                                        Activate
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.product.edit.status',['id'=>$product->reference,'status'=>2])}}">
                                                        Deactivate
                                                        <i class="ri-alert-line text-danger"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($product->featured!=1)
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.product.featured',['id'=>$product->reference])}}">
                                                        Mark Featured
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.product.featured.remove',['id'=>$product->reference])}}">
                                                        Remove Featuring
                                                        <i class="ri-alert-line text-danger"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($product->highlighted!=1)
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.product.highlight',['id'=>$product->reference])}}">
                                                        Mark Highlighted
                                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li>
                                                    <a class="dropdown-item" href="{{route('user.stores.catalog.product.highlight.remove',['id'=>$product->reference])}}">
                                                        Remove Highlighting
                                                        <i class="ri-alert-line text-danger"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.stores.catalog.product.delete',['id'=>$product->reference])}}">
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

@endsection
