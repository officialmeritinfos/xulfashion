<?php

namespace App\Traits;

use App\Models\GeneralSetting;
use App\Models\Login;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserSetting;
use App\Models\UserSkill;
use App\Notifications\CustomNotificationMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

trait Helpers
{
//generate unique alpha-numeric Id
    public function generateUniqueReference($table,$column,$length=10): string
    {
        $reference = $this::generateRef($length);
        return DB::table($table)->where($column,$reference)->first()?$this->generateUniqueReference($table,$column,$length):$reference;
    }
    //generate unique numeric ID
    public function generateUniqueId($table,$column,$length=10): string
    {
        $id = $this::generateId($length);
        return DB::table($table)->where($column,$id)->first()?$this->generateUniqueId($table,$column,$length):$id;
    }
    //generate 6-code token
    public function generateToken($table,$column): int
    {
        $reference = $this::createCode();
        return DB::table($table)->where($column,$reference)->first() ?
            $this->generateToken($table,$column):$reference;
    }
    //generate numeric ID
    private function generateId($length=10): string
    {
        $id = mt_rand();
        return Str::padLeft($id,$length,'0');
    }
    //generate alpha-numeric id
    private function generateRef($length=10): string
    {
        return Str::random($length);
    }
    //generate unique six code for verification purposes
    private static function createCode(): int
    {
        return rand(100000,999999);
    }
    //get the current time in Date-time string
    public function getCurrentDateTimeString(): string
    {
        return Carbon::now()->toDateTimeString();
    }
    //initialize user settings
    public function initializeUserSettings($user)
    {
        //check if user settings has been initialized
        $settings = UserSetting::where('user',$user->id)->first();
        if (empty($settings)){
            UserSetting::create([
                'user'=>$user->id
            ]);
        }
    }
    //record user activity and send notification
    public function userNotification($user,$title,$content,$ip): void
    {
        $user = User::where('id',$user->id)->first();

        $settings = UserSetting::where('user',$user->id)->first();

        UserActivity::create([
            'user'=>$user->id,
            'title'=>$title,
            'content'=>$content
        ]);
        if ($settings->emailNotification==1){
            //compose the mail to send to user
            $mail = "
                This is to notify you that an activity just took place on your account. If this activity was not
                authorized by you, please change your account password and contact support right away. <br/>
                <p><b>Activity: </b>".$content."</p><br/>
                <p><b>IP: </b>".$ip."</p><br/>
            ";
            //send the mail
            $user->notify(new CustomNotificationMail($user->name,$title,$mail));
        }

    }
    //check where to redirect user to
    public function userDashboard($user): string
    {
        //check the route to redirect user to
        if ($user->completedProfile!=1){
            return route('complete-account-setup');
        }
        //based-off on the account type, lets redirect to the proper dashboard
        switch ($user->accountType){
            case 1:
                $url = route('user.dashboard');
                break;
            case 3:
                $url = route('school.dashboard');
                break;
            default:
                $url = route('parent.dashboard');
                break;
        }
        return $url;
    }
    public function notifyLogin(Request $request,$user)
    {
        $web = GeneralSetting::find(1);
        $agent = new Agent();
        Login::create([
            'user'=>$user->id,
            'agent'=>
                'Platform: '.$agent->platform().'-'.$agent->version($agent->platform()).'; '.
                'browser: '.$agent->browser().'-'.$agent->version($agent->browser()),
            'device'=>$agent->device(),
            'Ip'=>$request->ip()
        ]);
        UserActivity::create([
            'user'=>$user->id,
            'title'=>'Account Access',
            'content'=>'Your account was accessed on '.date('d-m-Y h:i:s a').' from
            Ip '.$request->ip().' on device '.$agent->device()
        ]);
        //send mail to user
        $message = "Your ".$web->name.' account has been accessed from
                    an IP <b>'.$request->ip().'</b> through a <b>'.$agent->device().'</b> on '.date('d-m-Y h:i a');
        $user->notify(new CustomNotificationMail($user->name,'New Account login',$message));
    }
    //work preference
    public function workPreference($id): string
    {
        return match ($id){
            1=>'Hybrid',
            2=>'Part-time',
            3=>'Full-time',
            default=>'Contract'
        };
    }
    //check where to redirect user to
    public function userAccountType($user): string
    {
        //based-off on the account type, lets redirect to the proper dashboard
        switch ($user->accountType){
            case 1:
                $name = 'Tutor';
                break;
            case 3:
                $name = 'Recruiter';
                break;
            default:
                $name = 'Parent';
                break;
        }
        return $name;
    }
    //send admin mail
    public function sendAdminMail($message,$title)
    {
        $admin = User::where('isAdmin',1)->first();
        if (!empty($admin)){
            $admin->notify(new CustomNotificationMail($admin,$title,$message));
        }
    }
    //get greeting
    public function greeting(): string
    {

        $dt = Carbon::parse(date('Y-m-d H:i:s'));
        $hour = $dt->hour;
        if ($hour < 12) {
            $greeting= 'Good morning';
        }elseif ($hour < 16) {
            $greeting= 'Good afternoon';
        }else{
            $greeting='Good evening';
        }

        return $greeting;
    }
    public function shortenNumberToLetter($number): string
    {
        return $this->number_format_short($number);
    }

    function number_format_short($n, $precision = 1): string
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } elseif ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n * 0.001, $precision);
            $suffix = 'K';
        } elseif ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n * 0.000001, $precision);
            $suffix = 'M';
        } elseif ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n * 0.000000001, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n * 0.000000000001, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }
    //replace default Cover letter
    public function replaceCoverLetter($words,$employer,$job,$employee)
    {
        $web = GeneralSetting::find(1);
        $site = $web->name;

        $defaultDum=[
            '{manager}',
            '{jobtitle}',
            '{site}',
            '{name}',
        ];

        $dataReplace =[
            $employer->companyName??'Hiring Manager',
            $job->title,
            $site,
            $employee->name
        ];

        return str_replace($defaultDum,$dataReplace,$words);
    }
}
