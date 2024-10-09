<?php

namespace App\Http\Controllers\Mobile\User\Ads;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserAd;
use App\Models\UserAdPhoto;
use App\Models\UserAdReview;
use App\Models\UserAdView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdsDetails extends BaseController
{
    //landing page
    public function landingPage(Request $request, $adRef)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $ad = UserAd::where([
            'user' => $user->id,'reference' => $adRef
        ])->firstOrFail();

        return view('mobile.users.ads.details')->with([
            'pageName'  =>'Ad: '.$ad->title,
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'ad'        =>$ad,
            'views'     =>UserAdView::where('ad',$ad->reference)->paginate(15),
            'photos'    =>UserAdPhoto::where('ad',$ad->id)->get(),
            'reviews'   =>UserAdReview::where([
                'status'=>1,'merchant'=>$user->id
            ])->paginate(),
            'averageRating'=>UserAdReview::where([
                'merchant'=>$user->id,'status'=>1
            ])->avg('rating'),
            'totalRatings'=>UserAdReview::where([
                'merchant'=>$user->id,'status'=>1
            ])->count()
        ]);
    }
}
