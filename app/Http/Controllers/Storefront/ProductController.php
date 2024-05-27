<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use App\Models\UserStore;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use Illuminate\Http\Request;

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
}
