<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ProductRating;
use App\Models\UserStore;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function quickView(Request $request,$subdomain,$reference)
    {
        $store = UserStore::where('slug',$subdomain)->first();

        if (empty($store)){
            return $this->sendError('store.error',['error'=>'Store not found']);
        }

        $product = UserStoreProduct::where([
            'store'=>$store->id,'reference'=>$reference,
            'status'=>1
        ])->first();

        if (empty($product)){
            return $this->sendError('product.error',['error'=>'Product not found']);
        }

        $images = UserStoreProductImage::where('product',$product->id)->get();
        $colors = UserStoreProductColorVariation::where('product',$product->id)->get();
        $sizes = UserStoreProductSizeVariation::where('product',$product->id)->get();

        // Fetch average rating and total ratings
        $ratingsData = ProductRating::where('product', $product->id)
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as total_ratings')
            ->first();

        $averageRating = $ratingsData->average_rating ?? 0;
        $totalRatings = $ratingsData->total_ratings;

        return view('storefront.theme1.previews.product_modal_overview', compact('store', 'product', 'images', 'colors', 'sizes','averageRating', 'totalRatings'));
    }
    //add to cart
    public function addToCart(Request $request, $subdomain,$productReference)
    {
        try {
            // Get the store
            $store = UserStore::where('slug', $subdomain)->firstOrFail();
            // Get the product
            $product = UserStoreProduct::where('store', $store->id)
                ->where('reference', $productReference)
                ->where('status', 1)
                ->firstOrFail();

            // Determine if the product has sizes and colors
            $hasSizes = $product->sizes()->exists();
            $hasColors = $product->colors()->exists();

            // Validate input
            $validated = Validator::make($request->all(),[
                'quantity' => 'required|integer|min:1',
                'size' => $hasSizes ? 'required|exists:user_store_product_size_variations,id' : 'nullable',
                'color' => $hasColors ? 'required|exists:user_store_product_color_variations,id' : 'nullable',
            ])->stopOnFirstFailure();

            if ($validated->fails()){
                return $this->sendError('validation.error',['error'=>$validated->errors()->all()]);
            }

            $availableStock = $product->quantity;

            if ($request->quantity > $availableStock) {
                return $this->sendError('validation.error', ['error' => ['Requested quantity exceeds available stock.']]);
            }

            // Retrieve existing cart from session or initialize a new one
            $cart = session()->get('cart', []);

            // Generate a unique cart item ID based on product, size, and color
            $cartItemId = $product->id . '-' . ($request->size ?? 'no-size') . '-' . ($request->color ?? 'no-color');

            // Get size and color names for display purposes
            $sizeName = $hasSizes ? UserStoreProductSizeVariation::find($request->size)->name : null;
            $colorName = $hasColors ? UserStoreProductColorVariation::find($request->color)->name : null;

            // Add to cart or update quantity if already exists
            if (isset($cart[$cartItemId])) {

                $newQuantity = $cart[$cartItemId]['quantity'] + $request->quantity;
                if ($newQuantity > $availableStock) {
                    return $this->sendError('validation.error', ['error' => ['Requested quantity exceeds available stock.']]);
                }
                $cart[$cartItemId]['quantity'] = $newQuantity;
            } else {
                $cart[$cartItemId] = [
                    'product_id' => $product->id,
                    'size_id' => $request->size ?? null,
                    'size_name' => $sizeName,
                    'color_id' => $request->color ?? null,
                    'color_name' => $colorName,
                    'quantity' => $request->quantity,
                    'price' => $product->amount,
                    'currency'=>$product->currency
                ];
            }
            // Save cart back to session
            session()->put('cart', $cart);
            return $this->sendResponse([
                'redirectTo'=>url()->previous()
            ],'Product added to cart');
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return $this->sendError('cart.error',['error'=>'An error occurred while adding the product to the cart.']);
        }
    }
    //remove from cart
    public function removeFromCart(Request $request, $subdomain,$product,$size,$color)
    {
        try {
            // Retrieve existing cart from session
            $cart = session()->get('cart', []);
            $productId = $product;
            $sizeId = $size;
            $colorId = $color;

            // Generate the composite cart item ID
            $cartItemId = $productId . '-' . $sizeId . '-' . $colorId;

            // Remove the item if it exists in the cart
            if (isset($cart[$cartItemId])) {
                unset($cart[$cartItemId]);
            }

            // Save cart back to session
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'itemCount' => count($cart)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from cart'
            ]);
        }
    }
    //update cart
    public function updateCart(Request $request,$subdomain)
    {
        // Get the store
        $store = UserStore::where('slug', $subdomain)->firstOrFail();

        //validate data
        $validated = Validator::make($request->all(),[
            'product' => 'required|exists:user_store_products,id',
            'quantity' => 'required|integer|min:1',
        ])->stopOnFirstFailure();

        if ($validated->fails()){
            return $this->sendError('validation.error',['error'=>$validated->errors()->all()]);
        }

        // Retrieve existing cart from session
        $cart = session()->get('cart', []);

        foreach ($cart as $cartItemId => &$item) {
            if ($item['product_id'] == $request->product) {
                $item['quantity'] = $request->quantity;
                break;
            }
        }

        // Save cart back to session
        session()->put('cart', $cart);

        return response()->json(['message' => 'Cart updated']);
    }
    //get cart items
    public function getCartItems($subdomain)
    {
        $cart = session()->get('cart', []);


        $items = [];

        foreach ($cart as $key => $item) {
            $product = UserStoreProduct::find($item['product_id']);
            $currency = Country::where('currency',$item['currency'])->first();
            $items[] = [
                'product_id' => $item['product_id'],
                'productRef' => $product->reference,
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'currency' => $item['currency'],
                'sign'      => $currency->currency_symbol,
                'image_url' => $product->featuredImage,
                'size_name' => $item['size_name'] ?? null,
                'color_name' => $item['color_name'] ?? null,
                'size_id'   =>$item['size_id'] ?? null,
                'color_id'  =>$item['color_id'] ?? null
            ];
        }

        $view =  view('storefront.theme1.previews.cart_modal_overview',['cartItems' => $items])->render();
        return response()->json(['success' => true, 'html' => $view,'itemCount' => count($items)]);
    }

    public function getCartItemCount()
    {
        $cart = Session::get('cart', []);
        $itemCount = count($cart);
        return response()->json(['itemCount' => $itemCount]);
    }
}
