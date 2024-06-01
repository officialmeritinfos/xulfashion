<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreProduct;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;

class CatalogController extends BaseController
{
    use Themes,Helpers;
    //shop
    public function shop(Request $request, $store)
    {
        $userStore = UserStore::where('slug', $store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store', $userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $web = GeneralSetting::find(1);

        $search = $request->get('search');

        $productQuery = UserStoreProduct::where(['status' => 1, 'store' => $userStore->id])->orderBy('id', 'desc');

        $products = $productQuery->paginate(20);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('storefront.' . $themeLocation . '.previews.product_list', compact('products'))->render(),
                'nextPage' => $products->currentPage() + 1,
                'hasMorePages' => $products->hasMorePages()
            ]);
        }

        $data = [
            'userStore' => $userStore,
            'storeSetting' => $storeSettings,
            'web' => $web,
            'siteName' => $web->name,
            'pageName' => 'Shop',
            'products' => $products,
        ];
        return view('storefront.'.$themeLocation.'.shop')->with($data);
    }
    //shop search page
    public function shopSearchPage(Request $request,$store)
    {
        $userStore = UserStore::where('slug', $store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store', $userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $web = GeneralSetting::find(1);

        $search = $request->get('search');

        $query = UserStoreProduct::where(['status' => 1, 'store' => $userStore->id])
            ->where('name', 'like', '%'.$request->search.'%')
            ->orderBy('id', 'desc');
        $products = $query->paginate(2);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('storefront.' . $themeLocation . '.previews.product_list', compact('products'))->render(),
                'nextPage' => $products->currentPage() + 1,
                'hasMorePages' => $products->hasMorePages()
            ]);
        }

        $data = [
            'userStore' => $userStore,
            'storeSetting' => $storeSettings,
            'web' => $web,
            'siteName' => $web->name,
            'pageName' => 'Search Result',
            'products' => $products,
            'query'    =>$request->get('search')
        ];
        return view('storefront.'.$themeLocation.'.shop_search')->with($data);
    }
    //category
    public function category(Request $request,$store,$categoryId)
    {
        $userStore = UserStore::where('slug', $store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store', $userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $web = GeneralSetting::find(1);

        $category = UserStoreCatalogCategory::where([
            'store'=>$userStore->id,'id'=>$categoryId,'status'=>1
        ])->firstOrFail();


        $productQuery = UserStoreProduct::where(['status' => 1, 'store' => $userStore->id,'category'=>$category->id])->orderBy('id', 'desc');

        $products = $productQuery->paginate(20);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('storefront.' . $themeLocation . '.previews.product_list', compact('products'))->render(),
                'nextPage' => $products->currentPage() + 1,
                'hasMorePages' => $products->hasMorePages()
            ]);
        }

        $data = [
            'userStore' => $userStore,
            'storeSetting' => $storeSettings,
            'web' => $web,
            'siteName' => $web->name,
            'pageName' => $category->categoryName.' Catalog',
            'products' => $products,
            'category'=>$category
        ];
        return view('storefront.'.$themeLocation.'.category')->with($data);
    }
    //catalog
    public function catalog(Request $request,$store)
    {
        $userStore = UserStore::where('slug', $store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store', $userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);
        $web = GeneralSetting::find(1);



        $data = [
            'userStore' => $userStore,
            'storeSetting' => $storeSettings,
            'web' => $web,
            'siteName' => $web->name,
            'pageName' => 'Catalogs',
            'categories'=>UserStoreCatalogCategory::where('store',$userStore->id)->where('status',1)->get()
        ];
        return view('storefront.'.$themeLocation.'.catalog')->with($data);
    }
}
