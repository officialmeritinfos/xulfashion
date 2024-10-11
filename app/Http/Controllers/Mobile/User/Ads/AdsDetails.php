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

        $reviews = UserAdReview::where(['status'=>1,'merchant'=>$user->id])->with(['reviewers', 'merchants'])->paginate(5);

        if ($request->ajax()) {
            return response()->json([
                'products' => view('mobile.ads.components.review_lists', compact('reviews'))->render(),
                'nextPage' => $reviews->currentPage() + 1,
                'hasMorePages' => $reviews->hasMorePages()
            ]);
        }

        return view('mobile.users.ads.details')->with([
            'pageName'  =>'Ad: '.$ad->title,
            'web'       =>$web,
            'siteName'  =>$web->name,
            'user'      =>$user,
            'ad'        =>$ad,
            'views'     =>UserAdView::where('ad',$ad->reference)->paginate(15),
            'photos'    =>UserAdPhoto::where('ad',$ad->id)->get(),
            'reviews'   =>$reviews,
            'averageRating'=>UserAdReview::where([
                'merchant'=>$user->id,'status'=>1
            ])->avg('rating'),
            'totalRatings'=>UserAdReview::where([
                'merchant'=>$user->id,'status'=>1
            ])->count(),
        ]);
    }
    //delete photo
    public function deletePhoto($adId,$photoId)
    {
        $web = GeneralSetting::find(1);
        $user = Auth::user();
        $ad = UserAd::where([
            'user' => $user->id,'reference' => $adId
        ])->firstOrFail();

        UserAdPhoto::where([
            'ad' => $ad->id,'id' => $photoId
        ])->delete();

        return back()->with('success','Successfully deleted');
    }
}
