<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDevice;
use App\Notifications\PushDemo;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PushController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Store the PushSubscription.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        try{

            UserDevice::updateOrCreate([
                'user'=>$request->user()->id,
                'token'=>$request->token
            ]);
            //$request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

}
