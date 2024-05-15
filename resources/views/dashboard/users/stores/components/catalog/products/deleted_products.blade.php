@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="product-area ">
        <div class="container-fluid">
            <div class="order-details-area row">
                <div class="col-lg-6 col-sm-6">
                    <form class="search-bar d-flex">
                        <i class="ri-search-line"></i>
                        <input class="form-control search" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <a href="{{route('user.stores.catalog.products.new')}}" class="new-orders">
                            Add New Product
                            <i class="ri-add-circle-line"></i>
                        </a>
                    </div>
                </div>
            </div>


        </div>
        <div class="latest-transaction-area">
            <div class="table-responsive h-auto" data-simplebar>
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th scope="col">PRODUCT ID</th>
                        <th scope="col">NAME</th>
                        <th scope="col">CATEGORY</th>
                        <th scope="col">PRICE</th>
                        <th scope="col">QUANTITY</th>
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
                                    <input class="form-check-input" type="checkbox">
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
                                            <a class="dropdown-item" href="{{route('user.stores.catalog.product.restore',['id'=>$product->reference])}}">
                                                Restore Product
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{route('user.stores.catalog.product.p.delete',['id'=>$product->reference])}}">
                                                Permanently Delete
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
