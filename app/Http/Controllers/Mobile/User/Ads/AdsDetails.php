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

        $adUrl = route('mobile.marketplace.detail', [
            'slug' => textToSlug($ad->title),
            'id' => $ad->reference
        ]);

        // Generate raw share links
        $shareLinks = \Share::page($adUrl,"I just posted {$ad->title} on {$web->name}")
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->getRawLinks();

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
            'shareLinks'    =>$shareLinks
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

    public function upload(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'photos.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120'
        ]);

        //check user owns ad
        $ad = UserAd::where([
            'id' => $id,'user' => $user->id
        ])->first();
        if(!$ad){
            return response()->json([
                'success' => false,
                'message' => 'You cannot upload an image into an ad you do not own.'
            ], 400);
        }

        $uploadedPhotos = [];

        if ($request->hasFile('photos')) {

            foreach ($request->file('photos') as $index => $item) {
                $result = googleUpload($item);
                $fileName = $result['link'];

                $photoEntry = UserAdPhoto::create([
                    'ad'=>$id,'photo'=>$fileName
                ]);

                $uploadedPhotos[] = $photoEntry;
            }

            return response()->json([
                'success' => true,
                'message' => 'Images uploaded successfully!',
                'photos' => $uploadedPhotos
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No images uploaded.'
        ], 400);
    }
}
