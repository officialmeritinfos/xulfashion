<?php

namespace App\Http\Controllers\Mobile\User\Store\Actions\Product;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends BaseController
{
    //landing page
    public function landingPage($id)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();

        $store = UserStore::where('user',$user->id)->firstOrFail();

        $product = UserStoreProduct::where([
            'store' => $store->id,
            'reference' => $id
        ])->firstOrFail();

        return view('mobile.users.store.actions.products.details')->with([
            'web' => $web,
            'user' => $user,
            'siteName'=>$web->name,
            'pageName' => "{$product->name}",
            'store' => $store,
            'product' => $product
        ]);
    }

}
