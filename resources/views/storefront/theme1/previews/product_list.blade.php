@inject('options','App\Custom\Storefront')
@foreach($products as $product)
    <div class="col">
        <div class="card border shadow-none">
            <div class="position-relative overflow-hidden">
                <div class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#QuickViewModal" data-reference="{{$product->reference}}" data-action="{{route('merchant.store.product.quick-view',['subdomain'=>$subdomain,'id'=>$product->reference])}}"><i class="bi bi-zoom-in"></i></a>
                </div>
                <a href="{{route('merchant.store.product.detail',['subdomain'=>$subdomain,'id'=>$product->reference])}}">
                    <img src="{{$product->featuredImage}}" class="card-img-top" alt="...">
                </a>
            </div>
            <div class="card-body border-top">
                <h5 class="mb-0 fw-bold product-short-title">{{$product->name}}</h5>
                <p class="mb-0 product-short-name">{{$options->fetchStoreCategoryById($product->category)->categoryName??'Default'}}</p>
                <div class="product-price d-flex align-items-center gap-2 mt-2">
                    <div class="h6 fw-bold">{{$product->currency}}{{$product->amount}}</div>
                </div>
            </div>
        </div>
    </div>
@endforeach
