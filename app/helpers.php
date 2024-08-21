<?php

use App\Models\State;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserStoreProduct;
use Carbon\Carbon;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

if (!function_exists('maskEmail')) {
    /**
     * Masks the middle part of the username in an email, showing only the first two
     * and the last two characters of the username, along with the domain.
     *
     * This function preserves the first two and last two characters of the user part
     * of the email before the "@" symbol and masks the rest with asterisks. The domain
     * part of the email remains visible.
     *
     * @param string $email The original email address to mask.
     * @return string The email address with the middle part of the username masked.
     * */
    function maskEmail($email)
    {
        return preg_replace_callback('/^(..)(.*)(..)@(.+)$/', function ($matches) {
            return $matches[1] . str_repeat('*', strlen($matches[2])) . $matches[3] . '@' . $matches[4];
        }, $email);
    }
}

if (!function_exists('googleUpload')){
    /**
     * Upload a file to Google Cloud Storage.
     *
     * This function uploads a given file to Google Cloud Storage and returns the public URL
     * if the upload is successful. It uses the credentials stored in a JSON file and the
     * bucket name from the configuration. The file is uploaded to the 'profile-uploads'
     * directory in the bucket.
     *
     * @param \Illuminate\Http\UploadedFile $file The file to be uploaded.
     * @return array An associative array containing the status of the upload and the public URL if successful.
     */
    function googleUpload($file)
    {
        $user = Auth::user();

        //get the credentials in the json file
        $googleConfigFile = file_get_contents(private_path('xulfashion2.json'));
        //create a StorageClient object
        $storage = new StorageClient([
            'keyFile' => json_decode($googleConfigFile, true)
        ]);

        //get the bucket name from the env file
        $storageBucketName = config('googlecloud.storage_bucket');
        //pass in the bucket name
        $bucket = $storage->bucket($storageBucketName);
        $image_path = $file->getRealPath();
        //rename the file
        $fileName = $user->name.'-'.time().'.'.$file->extension();

        //open the file using fopen
        $fileSource = fopen($image_path, 'r');
        //specify the path to the folder and sub-folder where needed
        $googleCloudStoragePath = 'profile-uploads/' . $fileName;

        //upload the new file to google cloud storage
        $request = $bucket->upload($fileSource, [
            'predefinedAcl' => 'publicRead',
            'name' => $googleCloudStoragePath
        ]);

        if ($request){
            return [
                'done'=>true,
                'link'=>'https://storage.googleapis.com/xulfashion/profile-uploads/'.$fileName
            ];
        }else{
            Log::info($request->json());
            return [
                'done'=>false,
            ];
        }
    }
}

if (!function_exists('accountType')){
    /**
     * Determine the account type of the given user.
     *
     * This function checks the account type of the provided user object and returns a string
     * representing the type of account. If the account type is 1, it returns 'User'. For any other
     * account type, it returns 'Merchant'.
     *
     * @param User $user The user object whose account type needs to be determined.
     * @return string The type of account ('User' or 'Merchant').
     */
    function accountType(User $user)
    {
        if (empty($user->accountType)){
            return "Pending Setup";
        }
        switch ($user->accountType){
            case 1:
                $type='Client';
                break;
            default:
                $type = "Merchant";
                break;
        }
        return $type;
    }
}

if (!function_exists('user_activities')){
    /**
     * Retrieve the latest 5 unread user activities for the given user.
     *
     * This function fetches the latest 5 unread activities for a specified user from the UserActivity model.
     *
     * @param User $user The user object whose activities need to be retrieved.
     * @return \Illuminate\Database\Eloquent\Collection The collection of user activities.
     */
    function unread_user_activities(User $user)
    {
        return UserActivity::where('user',$user->id)->latest()->limit(5)->get();
    }
}

if(!function_exists('timeAgoFromCreatedAt')){
    /**
     * Convert a timestamp to a human-readable "time ago" format.
     *
     * This function takes a timestamp value and uses the Carbon library
     * to convert it to a human-readable "time ago" format, such as "5 minutes ago".
     *
     * @param string $value The timestamp value to be converted.
     * @return string The human-readable "time ago" format.
     */
    function timeAgoFromCreatedAt($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}

if (!function_exists('getStateFromIso2')){
    /**
     * Retrieve a state by its ISO2 code and country code.
     *
     * This function takes a state ISO2 code and a country code as input and retrieves
     * the corresponding state record from the database using the State model. It returns
     * the first matching state found or null if no matching state is found.
     *
     * @param string $stateIso2 The ISO2 code of the state to retrieve.
     * @param string $countryCode The country code associated with the state.
     * @return \App\Models\State|null The state object if found, or null if not found.
     */
    function getStateFromIso2($stateIso2,$countryCode)
    {
        return State::where([
            'iso2'=>$stateIso2,
            'country_code'=>$countryCode
        ])->first();
    }
}

if (!function_exists('deleteUploads')){
    /**
     * Delete an uploaded file from Google Cloud Storage.
     *
     * This function deletes a file from Google Cloud Storage based on the provided URL link.
     * It reads the Google Cloud credentials from a JSON file located in the private directory,
     * creates a StorageClient object, and deletes the specified file from the storage bucket.
     *
     * @param string $link The URL link of the file to be deleted.
     * @return boolean
     */
    function deleteUploads($link)
    {
        //get the credentials in the json file
        $googleConfigFile = file_get_contents(private_path('xulfashion2.json'));
        //create a StorageClient object
        $storage = new StorageClient([
            'keyFile' => json_decode($googleConfigFile, true)
        ]);

        //get the bucket name from the env file
        $storageBucketName = config('googlecloud.storage_bucket');
        //pass in the bucket name
        $bucket = $storage->bucket($storageBucketName);

        $url =$link;
        // Parse the URL
        $urlParts = parse_url($url);
        $path = $urlParts['path'];
        $filename = pathinfo($path, PATHINFO_BASENAME);//file name
        try {
            $object = $bucket->object('profile-uploads/'.$filename );
            $object->delete();
            return true;
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
            return false;
        }
    }
}

if (!function_exists('private_path')) {
    /**
     * Get the path to the private folder.
     *
     * @param string $path Optional path to append to the private folder path.
     * @return string
     */
    function private_path($path = '')
    {
        return base_path('privateFolder' . ($path ? DIRECTORY_SEPARATOR . $path : ''));
    }
}


if (!function_exists('membershipSubscriptionType')) {
    /**
     * Get the subscription type text for a given type code.
     *
     * This function takes a subscription type code as input and returns the
     * corresponding subscription type text. It supports monthly, annually, and quarterly types.
     *
     * @param int $type The subscription type code.
     * @return string The text description of the subscription type.
     */
    function membershipSubscriptionType($type)
    {
        $subscriptionTypes = [
            1 => 'Monthly',
            2 => 'Annually',
            3 => 'Quarterly'
        ];

        return $subscriptionTypes[$type] ?? 'Unknown';
    }
}

if (!function_exists('subscriptionStatus')){
    /**
     * Get the subscription status as a string based on the status code.
     *
     * @param int $status The status code for the subscription.
     * @return string The corresponding subscription status ('Active', 'Pending', 'Canceled', 'Processing', or 'Unknown').
     */
    function subscriptionStatus($status)
    {
        $statusType = [
            1=>'Active',
            2=>'Pending',
            3=>'Canceled',
            4=>'Processing'
        ];
        return $statusType[$status]??'Unknown';
    }
}
if (!function_exists('subscriptionPaymentStatus')){
    /**
     * Get the subscription payment status as a string based on the status code.
     *
     * @param int $status The status code for the subscription payment.
     * @return string The corresponding subscription payment status ('Successful', 'Pending', 'Canceled', 'Processing', or 'Unknown').
     */
    function subscriptionPaymentStatus($status)
    {
        $statusType = [
            1=>'Successful',
            2=>'Pending',
            3=>'Canceled',
            4=>'Processing'
        ];
        return $statusType[$status]??'Unknown';
    }
}
if (!function_exists('bookingStatus')){
    /**
     * Get the booking status as a string based on the status code.
     *
     * @param int $status The status code for the booking.
     * @return string The corresponding booking status ('Completed', 'Pending', 'Canceled', 'Processing', or 'Unknown').
     */
    function bookingStatus($status)
    {
        $statusType = [
            1=>'Completed',
            2=>'Pending',
            3=>'Canceled',
            4=>'Processing'
        ];
        return $statusType[$status]??'Unknown';
    }
}

if (!function_exists('bookingPaymentStatus')){
    /**
     * Get the booking payment status as a string based on the status code.
     *
     * @param int $status The status code for the booking payment.
     * @return string The corresponding booking payment status ('Paid', 'Pending', 'Canceled', 'Processing', or 'Unknown').
     */
    function bookingPaymentStatus($status)
    {
        $statusType = [
            1=>'Paid',
            2=>'Pending',
            3=>'Canceled',
            4=>'Processing'
        ];
        return $statusType[$status]??'Unknown';
    }
}
if (!function_exists('shorten_number')){
    /**
     * Formats a number into a short, human-readable string with a suffix (K, M, B, T).
     *
     * @param float|int $n The number to format.
     * @param int $precision The number of decimal places to include in the formatted number.
     * @return string The formatted number with an appropriate suffix.
     */
    function shorten_number($n, $precision = 1)
    {
        // Define suffixes and corresponding multipliers
        $suffixes = [
            12 => 'T',  // Trillion
            9  => 'B',  // Billion
            6  => 'M',  // Million
            3  => 'K',  // Thousand
            0  => ''    // No suffix
        ];

        // Determine the appropriate suffix and formatted number
        foreach ($suffixes as $power => $suffix) {
            if ($n >= pow(10, $power)) {
                $n_format = number_format($n / pow(10, $power), $precision);
                break;
            }
        }

        // Remove unnecessary zeroes after decimal
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }
}

if (!function_exists('currencySign')) {
    /**
     * Retrieves the currency symbol for a given currency code.
     *
     * @param string $currencyCode The currency code to lookup (e.g., 'USD', 'EUR').
     * @return string|null The currency symbol if found, or null if not found.
     */
    function currencySign($currencyCode)
    {
        $currency = \App\Models\Country::where('currency', $currencyCode)->first();

        return $currency ? $currency->currency_symbol : $currencyCode;
    }
}
if (!function_exists('textToSlug')) {
    /**
     * Convert a given text into a URL-friendly "slug".
     *
     * This function generates a slug from the given text by utilizing Laravel's
     * \Illuminate\Support\Str::slug method, if available. If the Str class isn't
     * available, it falls back to a basic slug generation approach using regular expressions.
     *
     * @param string $text The text to be converted into a slug.
     * @return string The generated slug.
     *
     * @throws Exception If the given text cannot be converted to a slug due to an unexpected error.
     *
     * @example
     * textToSlug('Hello World!'); // Returns 'hello-world'
     */
    function textToSlug($text)
    {
        return \Illuminate\Support\Str::slug($text);
    }
}

if (!function_exists('serviceTypeById')) {

    function serviceTypeById($id)
    {
        return \App\Models\ServiceType::where('id',$id)->first();
    }
}
if (!function_exists('trendingInCategory')) {

    function trendingInCategory($id)
    {
        return \App\Models\UserAd::where([
            'serviceType'=>$id,'status' => 1
        ])->orderBy('numberOfViews','desc')->take(10)->get();
    }
}

if (!function_exists('userById')) {

    function userById($id)
    {
        return \App\Models\User::where('id',$id)->first();
    }
}

if (!function_exists('adsInService')) {

    function adsInService($id)
    {
        return \App\Models\UserAd::where('serviceType',$id)->count();
    }
}
if (!function_exists('shortenText')) {

    function shortenText($text,$length)
    {
        return \Illuminate\Support\Str::words($text,$length);
    }
}
if (!function_exists('numberOfProductsInCategory')) {
    function numberOfProductsInCategory($category)
    {
        return UserStoreProduct::where('category', $category)->count();
    }
}

