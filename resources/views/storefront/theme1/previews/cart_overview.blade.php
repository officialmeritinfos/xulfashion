@foreach($cartItems as $item)
    <div class="card rounded-0 mb-3">
        <div class="card-body">
            <div class="d-flex flex-column flex-lg-row gap-3">
                <div class="product-img">
                    <img src="{{ $item['image_url'] }}" width="150" alt="">
                </div>
                <div class="product-info flex-grow-1">
                    <h5 class="fw-bold mb-0">{{ $item['name'] }}</h5>
                    <div class="product-price d-flex align-items-center gap-2 mt-3">
                        <div class="h6 fw-bold">{{ $item['sign'] }}{{ number_format($item['price'],2) }}</div>
                    </div>
                    <div class="mt-3 hstack gap-2">
                        @if($item['size_name'])
                        <button type="button" class="btn btn-sm btn-light border rounded-0"
                                data-bs-toggle="modal" data-bs-target="#SizeModal">Size : {{ $item['size_name'] }}</button>
                        @endif
                        @if($item['color_name'])
                        <button type="button" class="btn btn-sm btn-light border rounded-0"
                                data-bs-toggle="modal" data-bs-target="#SizeModal">Color : {{ $item['color_name'] }}</button>
                        @endif
                        <button type="button" class="btn btn-sm btn-light border rounded-0" data-bs-toggle="modal"
                                data-bs-target="#QtyModal">Qty : {{ $item['quantity'] }}</button>
                    </div>
                </div>
                <div class="d-none d-lg-block vr"></div>
                <div class="d-grid gap-2 align-self-start align-self-lg-center">
                    <button type="button" class="btn btn-ecomm remove-item-cart"
                            data-url="{{route('merchant.store.remove.carts',['subdomain'=>$subdomain,'product'=>$item['product_id'],'size'=>$item['size_id'] ?? 'no-size', 'color'=>$item['color_id'] ?? 'no-color'])}}"
                    ><i class="bi bi-x-lg me-2"></i>Remove</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
