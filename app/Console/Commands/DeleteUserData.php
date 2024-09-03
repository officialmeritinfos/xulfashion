<?php

namespace App\Console\Commands;

use App\Custom\GoogleUpload;
use App\Models\AccountFunding;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use App\Models\UserAdView;
use App\Models\UserBank;
use App\Models\UserDeposit;
use App\Models\UserDevice;
use App\Models\UserSetting;
use App\Models\UserStore;
use App\Models\UserStoreCatalogCategory;
use App\Models\UserStoreCoupon;
use App\Models\UserStoreCustomer;
use App\Models\UserStoreInvoice;
use App\Models\UserStoreNewsletter;
use App\Models\UserStoreOrder;
use App\Models\UserStoreOrderBreakdown;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use App\Models\UserStoreSetting;
use App\Models\UserStoreSubscriber;
use App\Models\UserStoresView;
use App\Models\UserStoreThemeSetting;
use App\Models\UserStoreVerification;
use App\Models\UserVerification;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DeleteUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-user-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes User who requested for account removal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            //fetch user
            $users = User::where('requestedForAccountDeletion',1)->where('timeToDeleteAccount','<=',time())->get();
            foreach ($users as $user) {
                //check if user has ads
                $ads = UserAd::where('user',$user->id)->get();
                if ($ads->count()>0){
                    $this->deleteUserAds($user);
                }
                //check if user has store
                $stores = UserStore::where('user',$user->id)->get();
                if ($stores->count()>0){
                    $this->deleteUserStore($user);
                }
                $this->deleteUser($user);
            }
        }catch (\Exception $exception){
            Log::info('An error occurred while removing accounts '. $exception->getMessage());
        }
    }
    //delete user ads
    public function deleteUserAds(User $user)
    {
        $google = new GoogleUpload();

        $ads = UserAd::where('user',$user->id)->get();

        foreach ($ads as $ad) {
            //fetch all the ads details
            UserAdView::where('ad',$ad->reference)->delete();
            $photos = UserAdPhoto::where('ad',$ad->id)->get();
            foreach ($photos as $photo) {
                $google->deleteUpload($photo->photo);
                $photo->forceDelete();
            }
            $google->deleteUpload($ad->featuredImage);
            $ad->forceDelete();
        }
    }
    //delete user store
    public function deleteUserStore(User $user)
    {
        $google = new GoogleUpload();
        $stores = UserStore::where('user',$user->id)->get();
        foreach ($stores as $store) {
            $google->deleteUpload($store->logo);
            UserStoresView::where('store',$store->reference)->delete();
            UserStoreCatalogCategory::where('store',$store->id)->delete();
            UserStoreCoupon::where('store',$store->id)->forceDelete();
            UserStoreCustomer::where('store',$store->id)->forceDelete();
            UserStoreInvoice::where('store',$store->id)->forceDelete();
            UserStoreNewsletter::where('store',$store->id)->forceDelete();
            UserStoreOrder::where('store',$store->id)->forceDelete();
            UserStoreOrderBreakdown::where('store',$store->id)->delete();
            UserStoreOrderBreakdown::where('store',$store->id)->delete();
            $products = UserStoreProduct::where('store',$store->id)->get();
            if ($products->count()>0){
                foreach ($products as $product) {
                    $google->deleteUpload($product->featuredImage);
                    UserStoreProductColorVariation::where('product',$product->id)->delete();
                    UserStoreProductSizeVariation::where('product',$product->id)->delete();
                    $images = UserStoreProductImage::where('product',$product->id)->get();
                    if ($images->count()>0){
                        foreach ($images as $image) {
                            $google->deleteUpload($image->image);
                            $image->delete();
                        }
                    }
                    $product->forceDelete();
                }
            }
            UserStoreSetting::where('store',$store->id)->delete();
            UserStoreSubscriber::where('store',$store->id)->delete();
            UserStoreThemeSetting::where('store',$store->id)->delete();
            $verification = UserStoreVerification::where('store',$store->id)->first();
            if (!empty($verification)){
                $google->deleteUpload($verification->certificate);
                $google->deleteUpload($verification->addressProof);
                $verification->delete();
            }

            //finally delete store
            $store->forceDelete();
        }
    }

    public function deleteUser(User $user)
    {
        $google = new GoogleUpload();
        AccountFunding::where('user',$user->id)->delete();
        Transaction::where('user',$user->id)->delete();
        UserActivity::where('user',$user->id)->delete();
        UserBank::where('user',$user->id)->delete();
        UserDeposit::where('user',$user->id)->delete();
        UserDevice::where('user',$user->id)->delete();
        UserSetting::where('user',$user->id)->delete();
        $verification = UserVerification::where('user',$user->id)->first();
        if (!empty($verification)){
            $google->deleteUpload($verification->frontImage);
            (!empty($verification->backImage))?$google->deleteUpload($verification->backImage):'';
            $google->deleteUpload($verification->utilityBill);
            $verification->delete();
        }
        (!empty($user->photo))?$google->deleteUpload($user->photo):'';

        $user->forceDelete();
    }
}
