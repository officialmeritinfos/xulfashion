<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Fiat;
use App\Models\GeneralSetting;
use App\Models\UserStore;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreProduct;
use App\Models\UserStoreSetting;
use App\Traits\Helpers;
use App\Traits\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CartController extends BaseController
{
    use Themes,Helpers;
    //landing page
    //cart page
    public function cart($store)
    {
        $userStore = UserStore::where('slug',$store)->firstOrFail();
        $storeSettings = UserStoreSetting::where('store',$userStore->id)->first();
        $themeLocation = $this->fetchThemeViewLocation($userStore->theme);

        $web = GeneralSetting::find(1);

        $data=[
            'userStore'       =>$userStore,
            'storeSetting'    =>$storeSettings,
            'web'             =>$web,
            'siteName'        =>$web->name,
            'pageName'        =>'Cart',
        ];
        return view('storefront.'.$themeLocation.'.cart')->with($data);
    }

    //cart item for cart page
    public function getCartItemCarts($subdomain)
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

        $view =  view('storefront.theme1.previews.cart_overview',['cartItems' => $items])->render();
        return response()->json(['success' => true, 'html' => $view,'itemCount' => count($items)]);
    }
    //order summary
    public function getCartSummary($subdomain)
    {
        try {
            $cart = session()->get('cart', []);
            $couponData = session()->get('coupon', ['coupon_discount' => 0]);

            $store = UserStore::where('slug', $subdomain)->first();
            if (!$store) {
                return response()->json(['success' => false, 'message' => 'Store not found.']);
            }

            $storeFiat = Fiat::where('code', $store->currency)->first();

            $bagTotal = 0;
            foreach ($cart as $item) {
                $bagTotal += $item['quantity'] * $item['price'];
            }

            $couponDiscount = $couponData['coupon_discount'];
            $totalAmount = $bagTotal - $couponDiscount;

            $view = view('storefront.theme1.previews.order_summary', [
                'bagTotal' => $bagTotal,
                'discount' => $couponDiscount,
                'totalAmount' => $totalAmount,
                'sign' => $storeFiat->sign,
                'hasCoupon' => session()->has('coupon'),
                'couponCode' => session('coupon.couponCode', '')
            ])->render();

            return response()->json(['success' => true, 'html' => $view]);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while fetching the order summary.']);
        }
    }
    //add discount
    public function addCoupon(Request $request,$subdomain)
    {
        try {
            $store = UserStore::where('slug',$subdomain)->first();

            if (empty($store)){
                return $this->sendError('store.error',['error'=>'Store not found']);
            }

            //let us check if a coupon has been added to the coupon
            if (session()->has('coupon')) {
                return $this->sendError('coupon.error', ['error' => 'A coupon has already been applied.']);
            }

            // Validate input
            $validated = Validator::make($request->all(),[
                'coupon' => ['required','string',Rule::exists('user_store_coupons','code')->where('store',$store->id)],
            ])->stopOnFirstFailure();

            if ($validated->fails()){
                return $this->sendError('validation.error',['error'=>$validated->errors()->all()]);
            }

            $input = $validated->validated();
            //coupon
            $coupon = UserStoreCoupon::where([
                'code'=>$input['coupon'],'store'=>$store->id
            ])->first();
            //check coupon validity
            $cart = session()->get('cart', []);
            $couponDiscount = session()->get('coupon_discount', 0);
            $bagTotal = 0;
            foreach ($cart as $item) {

                $bagTotal += $item['quantity'] * $item['price'];
            }
            switch ($coupon->couponType){
                case 1:
                    $discount = $bagTotal*($coupon->discount/100);
                    break;
                default:
                    $discount = $coupon->discount;
            }
            // Usage limit
            if ($coupon->limitedByUse == 1 && $coupon->useLimit == $coupon->numberOfUsage) {
                return $this->sendError('coupon.error', ['error' => 'Usage limit for coupon already reached.']);
            }

            // Coupon deactivated by deadline
            if ($coupon->deactivateByDate == 1 && $coupon->usageDeadline < time()) {
                return $this->sendError('coupon.error', ['error' => 'Coupon already expired.']);
            }

            $couponData =[
                'coupon_discount'=>$discount,
                'hasCoupon'=>true,
                'couponCode'=>$coupon->code,
                'couponId'=>$coupon->id
            ];
            session()->put('coupon',$couponData);

            return response()->json(['success' => true]);

        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return $this->sendError('cart.error',['error'=>'An error occurred while adding the coupon to the cart.']);
        }
    }
    //remove coupon
    public function removeCoupon(Request $request, $subdomain)
    {
        try {
            session()->forget('coupon');
            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->sendError('cart.error', ['error' => 'An error occurred while removing the coupon from the cart.']);
        }
    }
    //process checkout but first check if there exists any order
}
