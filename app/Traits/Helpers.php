<?php

namespace App\Traits;

use App\Custom\Flutterwave;
use App\Custom\NombaPayment;
use App\Models\Department;
use App\Models\GeneralSetting;
use App\Models\Login;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserSetting;
use App\Models\UserSkill;
use App\Models\UserStoreThemeSetting;
use App\Notifications\CustomNotificationMail;
use App\Notifications\StaffCustomNotification;
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
            default:
            $url = route('user.dashboard');
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
                $name = 'Merchant';
                break;
            default:
                $name = 'User';
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
    //send mail to department
    public function sendDepartmentMail($departmentSlug,$message,$title)
    {
        $department = Department::where('slug',$departmentSlug)->first();
        if (!empty($department)) {
            $department->notify(new StaffCustomNotification($department, $message, $title));
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
    public function generateUniqueSlug($table ,$title, $separator = '-')
    {
        $slug = Str::slug($title, $separator);
        $originalSlug = $slug;
        $count = 1;

        while (DB::table($table)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . $separator . $count;
            $count++;
        }
        return $slug;

    }
    //update user store theme settings
    public function updateStoreThemeSettting($store,$theme)
    {
        UserStoreThemeSetting::updateOrCreate([
            'store'=>$store->id
        ],[
            'textFont'=>$theme->textFont,'textColor'=>$theme->textColor,
            'primaryColor'=>$theme->primaryColor,'footerText'=>$theme->footerText,
            'footerScript'=>$theme->footerScript,'headerTextColor'=>$theme->headerTextColor,
            'tracking'=>$theme->tracking,'perkSection'=>$theme->perkSection,
            'perkTitle'=>$theme->perkTitle,'perkContent'=>$theme->perkContent,
            'perkIcon'=>$theme->perkIcon,'workingDay'=>$theme->workingDay
        ]);
    }
    /**
     * Validates bank account details by verifying the account number and bank code.
     *
     * This method dynamically selects the appropriate payment provider (Nomba for NGN or Flutterwave for other currencies)
     * to validate the provided bank account details. It sends a request to the selected provider and
     * standardizes the response to ensure consistency across different providers.
     *
     * @param string $bank The bank code or identifier of the bank to validate against.
     * @param string $accountNumber The bank account number to be validated.
     * @param string $default The currency code used to determine the payment provider (defaults to 'NGN').
     *
     * @return array
     *         Returns a structured array with the validation result:
     *         - 'success' (boolean): Indicates if the validation was successful.
     *         - 'account' (array|null): Contains 'account_number' and 'account_name' if validation is successful.
     *         - 'message' (string): Descriptive message about the result.
     *
     * Success Response Example:
     * [
     *     'success' => true,
     *     'account' => [
     *         'account_number' => '1234567890',
     *         'account_name' => 'John Doe'
     *     ],
     *     'message' => 'Retrieve'
     * ]
     *
     * Failure Response Example:
     * [
     *     'success' => false,
     *     'message' => 'Invalid account details received.'
     * ]
     */
    public function validateBankDetails(string $bank, string $accountNumber, string $default = 'NGN')
    {
        // Determine the payment provider based on the currency (Nomba for NGN, Flutterwave for others)
        $provider = $default === 'NGN' ? new NombaPayment() : new Flutterwave();

        // Prepare request payload depending on the provider's expected structure
        $data = $default === 'NGN'
            ? ['bankCode' => $bank, 'accountNumber' => $accountNumber]
            : ['account_number' => $accountNumber, 'account_bank' => $bank];

        // Call the appropriate method to fetch account details
        $response = $default === 'NGN'
            ? $provider->retrieveAccountDetail($data)  // For Nomba (NGN)
            : $provider->verifyAccountNumber($data);   // For Flutterwave (other currencies)

        if ($response && $response->ok()) {
            // Extract and normalize account details from the response
            $responseData = $response->json()['data'] ?? [];
            $accountDetails = [
                'account_number' => $responseData['accountNumber'] ?? $responseData['account_number'] ?? null,
                'account_name'   => $responseData['accountName'] ?? $responseData['account_name'] ?? null,
            ];

            // Ensure both account number and account name are present
            if (!empty($accountDetails['account_number']) && !empty($accountDetails['account_name'])) {
                return [
                    'success' => true,
                    'account' => $accountDetails,
                    'message' => 'Retrieve'
                ];
            }

            // Return failure if the required account details are missing
            return [
                'success' => false,
                'message' => 'Invalid account details received.'
            ];
        }

        // Return failure if the API request itself failed
        return [
            'success' => false,
            'message' => 'Unable to validate account.'
        ];
    }

}
