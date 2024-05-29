@foreach($cartItems as $item)
    <div class="d-flex align-items-center gap-3" data-product-id="{{ $item['product_id'] }}" data-size-id="{{ $item['size_id'] ?? 'no-size' }}"
         data-color-id="{{ $item['color_id'] ?? 'no-color' }}">
        <div class="bottom-product-img">
            <a href="{{ route('merchant.store.product.detail', ['subdomain'=>$subdomain,'id' => $item['productRef']]) }}">
                <img src="{{ $item['image_url'] }}" width="60" alt="{{ $item['name'] }}">
            </a>
        </div>
        <div class="">
            <h6 class="mb-0 fw-light mb-1">{{ $item['name'] }}</h6>
            @if($item['size_name'])
                <strong>Size:</strong> {{ $item['size_name'] }}<br>
            @endif
            @if($item['color_name'])
                <strong>Color:</strong> {{ $item['color_name'] }}<br>
            @endif
            <p class="mb-0"><strong>{{ $item['quantity'] }} X {{ $item['sign'] }}{{ number_format($item['price'],2) }}</strong></p>
        </div>
        <div class="ms-auto fs-5">
            <a href="javascript:" data-url="{{route('merchant.store.remove.carts',['subdomain'=>$subdomain,'product'=>$item['product_id'],'size'=>$item['size_id'] ?? 'no-size', 'color'=>$item['color_id'] ?? 'no-color'])}}"
               class="link-dark remove-item" ><i class="bi bi-trash text-danger"></i></a>
        </div>
    </div>
    <hr>
@endforeach
