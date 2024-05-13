@extends('dashboard.layout.base')
@section('content')

    <div class="container-fluid" style="margin-bottom: 5rem;">

        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-apps-2-fill"></i> Product Categories
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Manage your store catalog categories  - <i class="ri-information-fill" data-bs-toggle="tooltip"
                        title="you need to add categories first before adding products else, your
                        product may not be well organized on your storefront"></i>
                    </p>
                </div>
                <a href="{{route('user.stores.catalog.category')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <div class="flex-grow-1 mb-3 mb-md-0">
                    <h5 class="card-title">
                        <i class="ri-function-fill"></i> Product Catalog
                    </h5>
                    <p class="card-text" style="word-break: break-word;">
                        Manage your store products
                    </p>
                </div>
                <a href="{{route('user.stores.catalog.products')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                    Manage
                </a>
            </div>
        </div>


    </div>


@endsection
