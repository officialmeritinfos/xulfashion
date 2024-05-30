<?php

namespace App\Custom;

use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use Illuminate\Support\Facades\DB;

class Storefront
{
    public function fetchStoreCategoryById($id)
    {
        return UserStoreCatalogCategory::where('id',$id)->first();
    }
    //best selling product
    public function mostOrderProducts($store)
    {
        $mostPurchasedProducts = UserStoreOrderBreakdown::select('product', DB::raw('SUM(quantity) as total_quantity'))
            ->where('store', $store)
            ->groupBy('product')
            ->orderBy('total_quantity', 'desc')
            ->take(30)
            ->get();

        // Retrieve the product details
        $products = [];
        foreach ($mostPurchasedProducts as $item) {
            $product = UserStoreProduct::find($item->product);
            $products[] = [
                'product' => $product->name,
                'quantity' => $item->total_quantity,
                'amount'=>$product->amount,
                'featuredImage'=>$product->featuredImage,
                'currency'=>$product->currency,
                'reference'=>$product->reference
            ];
        }

        return $products;
    }
    //best selling category
    public function mostOrderCategory($store)
    {
        $mostPurchasedProducts = UserStoreOrderBreakdown::select('product', DB::raw('SUM(quantity) as total_quantity'))
            ->where('store', $store)
            ->groupBy('product')
            ->orderBy('total_quantity', 'desc')
            ->take(30)
            ->get();

        // Retrieve the product details
        $products = [];
        foreach ($mostPurchasedProducts as $item) {
            $product = UserStoreProduct::find($item->product);
            $category = UserStoreCatalogCategory::find($product->category);
            $products[] = [
                'name' => $category->categoryName,
                'photo'=>$category->photo,
                'quantity' => $item->total_quantity,
                'id' => $category->id,
            ];
        }

        return $products;
    }
    //number of products in a category
    public function numberOfProductsInCategory($category)
    {
        return UserStoreProduct::where('category',$category)->count();
    }
    //fetch product by Id
    public function fetchProductById($id)
    {
        return UserStoreProduct::where('id',$id)->first();
    }
}
