@extends('dashboard.layout.base')
@section('content')

    <div class="product-area ">
        <div class="container-fluid">
            <div class="order-details-area row">
                <div class="col-lg-12 col-sm-12">
                    <div class="add-new-orders">
                        <a href="#addProductImage" data-bs-toggle="modal" class="new-orders">
                            Add New Images
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
                        <th scope="col">IMAGE</th>
                        <th scope="col">DATE ADDED</th>
                        <th scope="col">ACTION</th>
                    </tr>
                    </thead>
                    <tbody class="searches">
                    @foreach($images as $image)
                        <tr>
                            <td>
                                <a href="{{$image->image}}" class="lightboxed">
                                    <img src="{{$image->image}}" style="width: 50px;" alt="Images">
                                </a>
                            </td>
                            <td>
                                {{date('d M, Y - h:i A')}}
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                        <li>
                                            <a class="dropdown-item" href="{{route('user.stores.catalog.product.image.delete',['ref'=>$product->reference,'id'=>$image->id])}}">
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
                {{$images->links()}}
            </div>
        </div>
    </div>

    @push('js')

        <!-- Modal -->
        <div class="modal fade" id="addProductImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">New Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="submit-property-form" id="processForm" action="{{route('user.stores.catalog.product.image.new.process',['id'=>$product->reference])}}" method="post"
                        enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="inputTitle" class="form-label">Product Image<sup class="text-danger">*</sup></label>
                                    <input type="file" class="form-control" id="inputTitle" name="file[]" multiple accept="image/*">
                                    <small>Multiple file selection allowed</small>
                                </div>
                                <div class="col-md-12" style="display: none;">
                                    <label for="inputTitle" class="form-label">Category Name<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="inputTitle" name="product"  value="{{$product->reference}}"/>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="default-btn submit">Add Image</button>
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
