<?php

namespace App\Http\Controllers\Mobile\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\ServiceType;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use Illuminate\Http\Request;

class CatalogController extends BaseController
{
    //list all catalogues in a store
    public function catalogsInStore($storeId)
    {
        $web = GeneralSetting::find(1);

        $store = UserStore::where([
            'reference' => $storeId,'status' => 1
        ])->firstOrFail();


        return view('mobile.ads.store_catalogs')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$store->legalName.' Catalogs'??$store->name.' Catalogs',
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'catalogs'      =>UserStoreCatalogCategory::where([
                'status' => 1,'store' => $store->id
            ])->get(),
            'store'         =>$store
        ]);
    }
    //catalog details
    public function catalogItems(Request $request, $storeId,$catalogId)
    {
        $web = GeneralSetting::find(1);

        $store = UserStore::where([
            'reference' => $storeId,'status' => 1
        ])->firstOrFail();

        $catalog = UserStoreCatalogCategory::where([
            'store' => $store->id,'id' => $catalogId
        ])->firstOrFail();

        $products = UserStoreProduct::where(['store' => $store->id,'category' => $catalog->id])->paginate(30);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.components.product_list', compact('products','catalog','store'))->render(),
                'nextPage' => $products->currentPage() + 1,
                'hasMorePages' => $products->hasMorePages()
            ]);
        }

        return view('mobile.ads.store_catalog_detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$catalog->categoryName.' Products in '.$store->legalName??$store->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'catalog'       =>$catalog,
            'store'         =>$store,
            'products'      =>$products
        ]);
    }
    //catalog details
    public function productDetail(Request $request, $storeId,$productId)
    {
        $web = GeneralSetting::find(1);

        $store = UserStore::where([
            'reference' => $storeId,'status' => 1
        ])->firstOrFail();

        $product = UserStoreProduct::where([
            'store' => $store->id,'reference' => $productId
        ])->firstOrFail();

        $catalog = UserStoreCatalogCategory::where([
            'store' => $store->id,'id' => $product->category
        ])->firstOrFail();

        return view('mobile.ads.store_product_detail')->with([
            'web'           =>$web,
            'siteName'      =>$web->name,
            'pageName'      =>$product->name,
            'serviceTypes'  =>ServiceType::where('status',1)->get(),
            'catalog'       =>$catalog,
            'store'         =>$store,
            'product'       =>$product,
            'photos'        =>UserStoreProductImage::where('product',$product->id)->get(),
            'sizes'         =>UserStoreProductSizeVariation::where('product',$product->id)->get(),
            'colors'        =>UserStoreProductColorVariation::where('product',$product->id)->get()
        ]);
    }
}
