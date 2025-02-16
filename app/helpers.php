<?php

use App\Models\Department;
use App\Models\Fiat;
use App\Models\State;
use App\Models\TicketCart;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserDevice;
use App\Models\UserStoreProduct;
use App\Notifications\StaffCustomNotification;
use Carbon\Carbon;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Kreait\Firebase\Factory;
use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Image;

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
        if ($n>0) {
            // Define suffixes and corresponding multipliers
            $suffixes = [
                12 => 'T',  // Trillion
                9 => 'B',  // Billion
                6 => 'M',  // Million
                3 => 'K',  // Thousand
                0 => ''    // No suffix
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
        }else{
            return  number_format($n, $precision);
        }
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

if (!function_exists('getStateFromCountryIso3')){
    /**
     * Retrieve a state by its ISO2 code and country code.
     *
     * This function takes a state ISO2 code and a country code as input and retrieves
     * the corresponding state record from the database using the State model. It returns
     * the first matching state found or null if no matching state is found.
     *
     * @param string $stateIso2 The ISO2 code of the state to retrieve.
     * @param string $countryCodeIso3 The country code associated with the state.
     * @return \App\Models\State|null The state object if found, or null if not found.
     */
    function getStateFromCountryIso3($stateIso2,$countryCodeIso3)
    {
        $country = \App\Models\Country::select('iso2')->where('iso3',$countryCodeIso3)->first();
        return State::where([
            'iso2'=>$stateIso2,
            'country_code'=>$country->iso2
        ])->first();
    }
}
if (!function_exists('getCountryFromIso3')){
    /**
     * Get the country details based on its ISO3 code.
     *
     * @param string $countryCodeIso3 The ISO3 code of the country.
     * @return \App\Models\Country|null The Country model instance if found, otherwise null.
     */
    function getCountryFromIso3($countryCodeIso3)
    {
        return \App\Models\Country::where('iso3',$countryCodeIso3)->first();

    }
}
if (!function_exists('getCountryFromIso2')){
    /**
     * Get the country details based on its ISO3 code.
     *
     * @param string $countryCodeIso2 The ISO3 code of the country.
     * @return \App\Models\Country|null The Country model instance if found, otherwise null.
     */
    function getCountryFromIso2($countryCodeIso2)
    {
        return \App\Models\Country::where('iso2',$countryCodeIso2)->first();

    }
}
if (!function_exists('checkIfAccessorIsMobile')){
    /**
     * Check if the accessor is using a mobile device.
     *
     * @return bool True if the accessor is using a mobile device, otherwise false.
     */
    function checkIfAccessorIsMobile()
    {
        $agent = new Agent();
        return $agent->isMobile();
    }
}
if (!function_exists('merchantType')){
    /**
     * Get the merchant type based on the provided type code.
     *
     * @param int $type The type code of the merchant.
     * @return string The corresponding merchant type as a string.
     */
    function merchantType($type)
    {
        switch ($type){
            case 1:
                $text='Fashion Retailer';
                break;
            case 2:
                $text='Fashion Designer';
                break;
            case 3:
                $text='Manufacturer';
                break;
            case 4:
                $text='Model';
                break;
            case 5:
                $text='Fashion School';
                break;
            case 6:
                $text = 'Beauty Specialist';
                break;
            case 7:
                $text = 'Cosmetics Brand';
                break;
            case 8:
                $text = 'Beauty School';
                break;
            case 9:
                $text = 'Event Organizer';
                break;
            default:
                $text='Unknown';
                break;
        }
        return $text;
    }
}

if (!function_exists('storeCategoryById')) {
    /**
     * Retrieve the store category by its ID.
     *
     * @param int $id The ID of the store category.
     * @return \App\Models\UserStoreCatalogCategory|null The category instance if found, otherwise null.
     */
    function storeCategoryById($id)
    {
        return \App\Models\UserStoreCatalogCategory::where('id',$id)->first();
    }
}
if (!function_exists('sendDepartmentMail')) {
    /**
     * Send an email notification to a specific department.
     *
     * @param string $departmentSlug The slug of the department.
     * @param string $message The message content for the email.
     * @param string $title The subject/title of the email.
     * @return void
     */
    function sendDepartmentMail($departmentSlug,$message,$title)
    {
        $department = Department::where('slug',$departmentSlug)->first();
        if (!empty($department)) {
            $department->notify(new StaffCustomNotification($department, $message, $title));
        }
    }
}
if (!function_exists('getMobileType')) {
    /**
     * Retrieve the mobile agent instance to check for device details.
     *
     * @return Jenssegers\Agent\Agent The mobile agent instance.
     */
    function getMobileType()
    {
        return new Agent();
    }
}
if (!function_exists('sendPushNotification')) {
    /**
     * Send a push notification to the specified user.
     *
     * @param \App\Models\User $user The user to send the notification to.
     * @param string $title The title of the notification.
     * @param string $message The body content of the notification.
     * @param string $url (Optional) The URL to open when the notification is clicked.
     * @return void
     */
    function sendPushNotification($user,$title,$message,$url='')
    {
        $firebase = (new Factory)->withServiceAccount(config('firebase.projects.app.credentials'));
        $messaging = $firebase->createMessaging();

        $tokens = UserDevice::where('user',$user->id)->get();
        if ($tokens->count()>0){
            foreach ($tokens as $token) {
                $messages = \Kreait\Firebase\Messaging\CloudMessage::fromArray([
                    'token' => $token->token,
                    'data' => [
                        'title' => $title,
                        'body' => $message,
                        'icon'=>asset('home/image/xulfashion_client.png'),
                        'click_action'=>empty($url)?route('mobile.marketplace.categories'):$url
                    ],
                ]);
                $messaging->send($messages);
            }
        }
    }
}

if (!function_exists('completedProfileMobile')) {
    /**
     * Check if the logged-in user's profile is completed. If not, redirect to complete profile.
     *
     * @param string $intendedRoute The intended route the user is trying to access.
     * @return string The route to complete the profile if incomplete, or the intended route if completed.
     */
    function completedProfileMobile($intendedRoute)
    {
        // Check if the user is logged in
        if (auth()->check()) {
            // Get the logged-in user
            $user = auth()->user();
            // Check if the profile is completed
            if ($user->completedProfile == 1) {
                // Return the intended route if profile is completed
                return route($intendedRoute);
            } else {
                session([
                    'redirect'=>route($intendedRoute)
                ]);
                // Return the profile completion route if not completed
                if (!$user->google_id){
                    return route('mobile.user.profile.settings.complete-profile');
                }else{
                    return route('mobile.user.profile.settings.complete-profile.socialite');
                }

            }
        }
    }
}

if (!function_exists('serviceTypeById')) {
    /**
     * Retrieve the service type by its ID.
     *
     * @param int $id The ID of the service type.
     * @return \App\Models\ServiceType|null The service type instance if found, otherwise null.
     */
    function serviceTypeById($id)
    {
        return \App\Models\ServiceType::where('id',$id)->first();
    }
}
if (!function_exists('trendingInCategory')) {
    /**
     * Retrieve the top trending ads within a specific category.
     *
     * @param int $id The ID of the service type (category).
     * @return \Illuminate\Database\Eloquent\Collection The collection of top 15 trending ads.
     */
    function trendingInCategory($id)
    {
        return \App\Models\UserAd::where([
            'serviceType'=>$id,'status' => 1
        ])->orderBy('numberOfViews','desc')->orderBy('created_at','desc')->take(20)->get();
    }
}

if (!function_exists('userById')) {
    /**
     * Retrieve the user by their ID.
     *
     * @param int $id The ID of the user.
     * @return \App\Models\User|null The user instance if found, otherwise null.
     */
    function userById($id)
    {
        return \App\Models\User::where('id',$id)->first();
    }
}

if (!function_exists('adsInService')) {
    /**
     * Get the number of ads within a specific service.
     *
     * @param int $id The ID of the service type.
     * @return int The count of ads within the service.
     */
    function adsInService($id)
    {
        return \App\Models\UserAd::where('serviceType',$id)->count();
    }
}
if (!function_exists('activeAdsInService')) {
    /**
     * Get the number of ads within a specific service that are active
     *
     * @param int $id The ID of the service type.
     * @return int The count of ads within the service.
     */
    function activeAdsInService($id)
    {
        return \App\Models\UserAd::where('serviceType',$id)->where('status',1)->count();
    }
}
if (!function_exists('shortenText')) {
    /**
     * Shorten a given text to a specified word length.
     *
     * @param string $text The text to shorten.
     * @param int $length The maximum number of words to allow.
     * @return string The shortened text.
     */
    function shortenText($text,$length)
    {
        return \Illuminate\Support\Str::words($text,$length);
    }
}
if (!function_exists('numberOfProductsInCategory')) {
    /**
     * Get the number of products within a specific category.
     *
     * @param int $category The category ID to count products for.
     * @return int|null The count of products in the category.
     */
    function numberOfProductsInCategory($category)
    {
        return UserStoreProduct::where('category', $category)->count();
    }
}

if (!function_exists('scheduleUserNotification')) {
    /**
     * Schedule a notification for a specific user.
     *
     * This function creates a user notification with the specified title, content, and optional URL.
     * The notification is set with a default status of 2.
     *
     * @param int $user The ID of the user to notify.
     * @param string $title The title of the notification.
     * @param string $content The content or message of the notification.
     * @param string|null $url Optional URL associated with the notification.
     * @return void
     */
    function scheduleUserNotification($user,$title,$content,$url=null)
    {
        \App\Models\UserNotification::create([
            'user' => $user,'title' => $title,'content' => $content,'status' => 2,'url' => $url
        ]);
    }
}
if (!function_exists('averageMerchantRatings')) {
    /**
     * Calculate the average rating for a merchant.
     *
     * This function calculates the average rating for a merchant based on approved reviews
     * with a status of 1.
     *
     * @param int $user The ID of the merchant user.
     * @return float|null The average rating for the merchant, or null if there are no ratings.
     */
    function averageMerchantRatings($user)
    {
        return \App\Models\UserAdReview::where([
            'merchant'=>$user,'status'=>1
        ])->avg('rating');
    }
}
if (!function_exists('eventCategoryById')) {
    function eventCategoryById($id)
    {
        return \App\Models\EventCategory::where('id',$id)->first();
    }
}
if (!function_exists('eventType')) {
    function eventType($id)
    {
        switch ($id){
            case 1:
                $type = "Live Event";
                break;
            default:
                $type = "Online Event";
                break;
        }
        return $type;
    }
}
if (!function_exists('mergeDateAndTime')) {
    function mergeDateAndTime($date,$time)
    {
        return strtotime("$date $time");
    }
}
if (!function_exists('getDateAndTime')) {
    function getDateAndTime($timestamp)
    {
        return Carbon::createFromTimestamp($timestamp);
    }
}
if (!function_exists('eventEndTime')) {
    function eventEndTime(\App\Models\UserEvent $event)
    {
        if ($event->eventScheduleType==1){
            return $event->endDate.' '.$event->endTime;
        }else{
            if ($event->recurrenceEndType==1){
                return $event->recurrenceEndDate.' '.$event->recurrenceEndTime;
            }else{
                return "Ends after ".$event->recurrenceEndCount." Occurrences";
            }
        }
    }
}
if (!function_exists('extractIntervalFromRecurrenceInterval')) {
    function extractIntervalFromRecurrenceInterval($text)
    {
        if (!is_string($text) || empty($text)) {
            return null; // Return null for invalid or empty input
        }

        $arr = explode(' ', $text);

        // Ensure the first part is numeric
        return isset($arr[0]) && is_numeric($arr[0]) ? (int)$arr[0] : null;
    }
}
if (!function_exists('extractPeriodFromRecurrenceInterval')) {
    function extractPeriodFromRecurrenceInterval($text)
    {
        if (!is_string($text) || empty($text)) {
            return null;
        }

        $arr = explode(' ', $text);

        // Ensure the second part exists
        return isset($arr[1]) ? strtolower($arr[1]) : null;
    }
}
if (!function_exists('handleTicketEndTime')) {
    function handleTicketEndTime(\App\Models\UserEvent $event)
    {
        if ($event->eventScheduleType==1){
            return $event->endTime;
        }else{
            if ($event->recurrenceEndType==1){
                return $event->recurrenceEndTime;
            }else{
                return "Ends after ".$event->recurrenceEndCount*extractIntervalFromRecurrenceInterval($event->recurrenceInterval)." ".extractPeriodFromRecurrenceInterval($event->recurrenceInterval);
            }
        }
    }
}

if (!function_exists('handleTicketEndDate')) {
    function handleTicketEndDate(\App\Models\UserEvent $event)
    {
        if ($event->eventScheduleType==1){
            return $event->endDate;
        }else{
            if ($event->recurrenceEndType==1){
                return $event->recurrenceEndDate;
            }else{
                return "Ends after ".$event->recurrenceEndCount*extractIntervalFromRecurrenceInterval($event->recurrenceInterval)." ".extractPeriodFromRecurrenceInterval($event->recurrenceInterval);
            }
        }
    }
}

if (!function_exists('fetchEventIntervalById')) {
    function fetchEventIntervalById($id)
    {
        return \App\Models\EventInterval::where('id',$id)->first();
    }
}
if (!function_exists('formatOnlyDateToReadableDate')) {
    /**
     * Formats a date into a human-readable string with the day suffix.
     *
     * This function converts a given date string to the format "Saturday, November 23rd 2024"
     * with a proper suffix for the day (st, nd, rd, th) and applies the specified time zone.
     *
     * @param string $date The date string to format.
     * @param string $timeZone Optional. The time zone to use for formatting. Default is 'UTC'.
     * @return string|null The formatted date string or null on error.
     *
     * @throws Exception If the date is invalid or cannot be parsed.
     */
    function formatOnlyDateToReadableDate(string $date, string $timeZone = 'UTC'): ?string
    {
        try {
            $d = new DateTime($date, new DateTimeZone($timeZone));
            $s = ['th','st','nd','rd','th','th','th','th','th','th'];
            return $d->format("l, F j") . ($d->format('j') % 100 >= 11 && $d->format('j') % 100 <= 13 ? 'th' : $s[$d->format('j') % 10]) . $d->format(', Y');
        } catch (Exception $e) {
            return null;
        }
    }
}
if (!function_exists('eventShowCaseTimeFormat')) {
    /**
     * Generates a formatted time range for an event, applying the specified timezone.
     *
     * For single events, this function returns the start and end times in the format "hh:mm AM/PM - hh:mm AM/PM".
     * For recurring events, it either displays a time range with a readable end date or notes the number of occurrences.
     * When the recurrence end type is date-based, it leverages `formatOnlyDateToReadableDate` for a human-readable date format.
     *
     * @param \App\Models\UserEvent $event The event instance containing details like timezone, schedule, and recurrence.
     * @return string The formatted event time range or recurrence information.
     *
     * @see formatOnlyDateToReadableDate() For date formatting in recurrence end dates.
     */

    function eventShowCaseTimeFormat(\App\Models\UserEvent $event): string
    {
        $timezone = new DateTimeZone($event->eventTimeZone);

        if ($event->eventScheduleType == 1) {
            // Single event with specific start and end times
            $start = new DateTime("{$event->startDate} {$event->startTime}", $timezone);
            $end = new DateTime("{$event->endDate} {$event->endTime}", $timezone);

            return $start->format('h:i A') . ' - ' . $end->format('h:i A');
        } else {
            // Recurring event
            $start = new DateTime("{$event->startDate} {$event->startTime}", $timezone);

            if ($event->recurrenceEndType == 1) {
                $end = new DateTime("{$event->recurrenceEndDate} {$event->recurrenceEndTime}", $timezone);
                return $start->format('h:i A') . ' - ' . formatOnlyDateToReadableDate($event->endDate, $event->eventTimeZone) . ' ' . $end->format('h:i A');
            } else {
                return $start->format('h:i A') . " till " . $event->recurrenceEndCount . " Occurrences";
            }
        }
    }
}
if (!function_exists('displayEventStartDate')) {
    /**
     * Formats and returns the start date of an event in a readable format.
     *
     * This function converts the event's start date to a readable date format,
     * adjusted to the event's timezone.
     *
     * @param \App\Models\UserEvent $event The event model instance, containing the start date and timezone information.
     * @return string A formatted string of the event's start date in a readable format, adjusted to the event's timezone.
     */
    function displayEventStartDate(\App\Models\UserEvent $event): string
    {
        return formatOnlyDateToReadableDate($event->startDate, $event->eventTimeZone);
    }
}
if (!function_exists('displayEventStartTime')) {
    /**
     * Formats and returns the start and end time range of an event in a readable format.
     *
     * This function takes an event model instance and formats its start and end times
     * into a readable time range string, adjusted for the event's timezone.
     *
     * @param \App\Models\UserEvent $event The event model instance containing the start date, start time,
     *                                     end date, end time, and timezone information.
     * @return string A formatted string showing the event's start and end times in a readable format,
     *                adjusted to the event's timezone.
     */
    function displayEventStartTime(\App\Models\UserEvent $event): string
    {
        $timezone = new DateTimeZone($event->eventTimeZone);

        // Single event with specific start and end times
        $start = new DateTime("{$event->startDate} {$event->startTime}", $timezone);

        return $start->format('h:i A') ;
    }
}

if (!function_exists('displayEventEndDate')) {
    function displayEventEndDate(\App\Models\UserEvent $event): string
    {
        return formatOnlyDateToReadableDate($event->endDate, $event->eventTimeZone);
    }
}
if (!function_exists('displayEventEndTime')) {

    function displayEventEndTime(\App\Models\UserEvent $event): string
    {
        $timezone = new DateTimeZone($event->eventTimeZone);

        // Single event with specific start and end times
        $end = new DateTime("{$event->endDate} {$event->endTime}", $timezone);

        return $end->format('h:i A') ;
    }
}
if (!function_exists('displayEventEndPeriod')) {
    /**
     * Generates a formatted time range for an event, applying the specified timezone.
     *
     * For single events, this function returns the start and end times in the format "hh:mm AM/PM - hh:mm AM/PM".
     * For recurring events, it either displays a time range with a readable end date or notes the number of occurrences.
     * When the recurrence end type is date-based, it leverages `formatOnlyDateToReadableDate` for a human-readable date format.
     *
     * @param \App\Models\UserEvent $event The event instance containing details like timezone, schedule, and recurrence.
     * @return string The formatted event time range or recurrence information.
     *
     * @see formatOnlyDateToReadableDate() For date formatting in recurrence end dates.
     */

    function displayEventEndPeriod(\App\Models\UserEvent $event): string
    {
        $timezone = new DateTimeZone($event->eventTimeZone);

        if ($event->eventScheduleType == 1) {
            // Single event with specific start and end times
            $end = new DateTime("{$event->recurrenceEndDate} {$event->recurrenceEndTime}", $timezone);
            return formatOnlyDateToReadableDate($event->endDate, $event->eventTimeZone) . ' -  ' . $end->format('h:i A');
        } else {
            // Recurring event
            if ($event->recurrenceEndType == 1) {
                $end = new DateTime("{$event->recurrenceEndDate} {$event->recurrenceEndTime}", $timezone);
                return formatOnlyDateToReadableDate($event->endDate, $event->eventTimeZone) . ' -  ' . $end->format('h:i A');
            } else {
                return "Ends after ".$event->recurrenceEndCount*extractIntervalFromRecurrenceInterval($event->recurrenceInterval)." ".extractPeriodFromRecurrenceInterval($event->recurrenceInterval);
            }
        }
    }
}

if (!function_exists('eventShowCaseFullDateFormat')) {
    /**
     * Formats and returns the full date and time range for an event.
     *
     * This function provides a readable date and time format for both single and recurring events,
     * taking into account the event's timezone, start and end dates, and recurrence details.
     * For single events, it displays the start and end times on the event date.
     * For recurring events, it displays the recurrence end date or count as applicable.
     *
     * @param \App\Models\UserEvent $event The event model instance, containing start and end dates,
     *                                     event timezone, schedule type, and recurrence details.
     * @return string A formatted string showing the event's full date and time range,
     *                adjusted to the event's timezone.
     * @see formatOnlyDateToReadableDate() For date formatting in recurrence end dates.
     */

    function eventShowCaseFullDateFormat(\App\Models\UserEvent $event): string
    {
        $timezone = new DateTimeZone($event->eventTimeZone);

        if ($event->eventScheduleType == 1) {
            // Single event with specific start and end times
            $start = new DateTime("{$event->startDate} {$event->startTime}", $timezone);
            $end = new DateTime("{$event->endDate} {$event->endTime}", $timezone);

            return formatOnlyDateToReadableDate($event->startDate, $event->eventTimeZone).' '.$start->format('h:i A') .
                ' - ' . formatOnlyDateToReadableDate($event->endDate, $event->eventTimeZone) .' '. $end->format('h:i A');
        } else {
            // Recurring event
            $start = new DateTime("{$event->startDate} {$event->startTime}", $timezone);

            if ($event->recurrenceEndType == 1) {
                $end = new DateTime("{$event->recurrenceEndDate} {$event->recurrenceEndTime}", $timezone);
                return formatOnlyDateToReadableDate($event->startDate, $event->eventTimeZone).' '.$start->format('h:i A') .
                    ' - ' . formatOnlyDateToReadableDate($event->endDate, $event->eventTimeZone) .' '. $end->format('h:i A');
            } else {
                $intervalValue = extractIntervalFromRecurrenceInterval($event->recurrenceInterval);
                $intervalPeriod = extractPeriodFromRecurrenceInterval($event->recurrenceInterval);

                $occurrences = $event->recurrenceEndCount;

                // Convert to a valid DateInterval spec
                $intervalPeriodShort = strtoupper(substr($intervalPeriod, 0, 1));
                $dateIntervalSpec = 'P' . ($intervalValue * $occurrences) . $intervalPeriodShort;
                // Add the interval to the start date
                $end = clone $start;
                $end->add(new DateInterval($dateIntervalSpec));

                return formatOnlyDateToReadableDate($event->startDate, $event->eventTimeZone) . ' ' . $start->format('h:i A') .
                    ' - ' . formatOnlyDateToReadableDate($end->format('Y-m-d'), $event->eventTimeZone) . ' ' . $end->format('h:i A');

            }
        }
    }
}

if (!function_exists('displayChargeOnTicketIfAny')) {
    function displayChargeOnTicketIfAny($id): ?string
    {

        $ticket = \App\Models\UserEventTicket::find($id);

        // If the ticket is free, return null (no charge applies)
        if (!$ticket || $ticket->isFree()) {
            return null;
        }

        // If guests do not pay the fee, return null
        if ($ticket->guestsShouldPayFee != 1) {
            return null;
        }

        // Retrieve event and currency details
        $event = \App\Models\UserEvent::find($ticket->event_id);
        $fiat = Fiat::where('code', $event->currency)->first();

        if (!$event || !$fiat) {
            return null; // Prevents errors if event or fiat details are missing
        }

        // Determine ticket price (group or individual)
        $price = ($ticket->ticketType === 'group') ? $ticket->groupPrice : $ticket->price;

        // Calculate fixed and dynamic charges
        $fixedCharge = $fiat->hasTicketFixedCharge ? $fiat->ticketFixedCharge : 0;
        $dynamicCharge = $price * ($fiat->ticketCharge / 100);
        $totalCharge = $fixedCharge + $dynamicCharge;

        // Return formatted charge message
        return " includes " . $fiat->sign . number_format($totalCharge, 2) . ' fee';

    }
}
if (!function_exists('calculateTotalCostOnTicket')) {
    function calculateTotalCostOnTicket($id){
        $ticket = \App\Models\UserEventTicket::find($id);

        // If the ticket is free, return 0
        if (!$ticket || $ticket->isFree()) {
            return 0;
        }

        // Retrieve event and currency details
        $event = \App\Models\UserEvent::find($ticket->event_id);
        $fiat = Fiat::where('code', $event->currency)->first();

        if (!$event || !$fiat) {
            return 0; // Prevent errors if event or currency details are missing
        }

        // Determine ticket price (group or individual)
        $price = ($ticket->ticketType === 'group') ? $ticket->groupPrice : $ticket->price;

        // Calculate fixed and dynamic charges
        $fixedCharge = $fiat->hasTicketFixedCharge ? $fiat->ticketFixedCharge : 0;
        $dynamicCharge = $price * ($fiat->ticketCharge / 100);
        $totalCharge = $fixedCharge + $dynamicCharge;

        // If guests pay the fee, return price + charge
        if ($ticket->guestsShouldPayFee == 1) {
            return $price + $totalCharge;
        }

        // Otherwise, charge is deducted from the ticket price
        return ($price < $fiat->ticketAmountToAddToCharge) ? $price + $totalCharge : $price;

    }
}

if (!function_exists('calculateCostOnTicketWithoutCharge')) {
    function calculateCostOnTicketWithoutCharge($id,$quantity): float|int
    {
        $ticket = \App\Models\UserEventTicket::find($id);
        // Return 0 if the ticket is free
        if ($ticket->isFree()) {
            return 0;
        }
        // Determine ticket price (group or individual)
        $price = ($ticket->ticketType === 'group') ? $ticket->groupPrice : $ticket->price;

        // If guests should pay, return total price directly
        if ($ticket->guestsShouldPayFee == 1) {
            return $price * $quantity;
        }

        // Fetch event and currency details
        $event = \App\Models\UserEvent::find($ticket->event_id);
        $fiat = Fiat::where('code', $event->currency)->first();

        if (!$fiat) {
            return $price * $quantity; // Fallback in case fiat details are missing
        }

        // Calculate charges
        $fixedCharge = $fiat->hasTicketFixedCharge ? $fiat->ticketFixedCharge : 0;
        $dynamicCharge = $price * ($fiat->ticketCharge / 100);
        $charge = $fixedCharge + $dynamicCharge;

        // Determine final cost without additional charge
        return ($price < $fiat->ticketAmountToAddToCharge)
            ? $price * $quantity
            : ($price - $charge) * $quantity;
    }
}
if (!function_exists('calculateChargeOnTicket')) {
    function calculateChargeOnTicket($id,$quantity): float|int
    {
        $ticket = \App\Models\UserEventTicket::find($id);

        // If the ticket is free, no charge applies
        if (!$ticket || $ticket->isFree()) {
            return 0;
        }

        // Fetch event and currency details
        $event = \App\Models\UserEvent::find($ticket->event_id);
        $fiat = Fiat::where('code', $event->currency)->first();

        if (!$event || !$fiat) {
            return 0; // Fallback in case event or fiat details are missing
        }


        // Determine ticket price (group or individual)
        $price = ($ticket->ticketType === 'group') ? $ticket->groupPrice : $ticket->price;

        // Calculate fixed and dynamic charges
        $fixedCharge = $fiat->hasTicketFixedCharge ? $fiat->ticketFixedCharge : 0;
        $dynamicCharge = $price * ($fiat->ticketCharge / 100);
        $totalCharge = $fixedCharge + $dynamicCharge;

        return $totalCharge*$quantity;
    }
}

if (!function_exists('calculateTicketCart')) {
    function calculateTicketCart(){
        $cart =  TicketCart::firstOrCreate(['user_id' => Auth::id()]);

        return $cart->items->sum(function ($item) {
            return calculateTotalCostOnTicket($item->user_event_ticket_id) * $item->quantity;
        });
    }
}
if (!function_exists('calculateTicketCartCharge')) {
    function calculateTicketCartCharge(){
        $cart =  TicketCart::firstOrCreate(['user_id' => Auth::id()]);

        return $cart->items->sum(function ($item) {
            return calculateChargeOnTicket($item->user_event_ticket_id,$item->quantity);
        });
    }
}
if (!function_exists('calculateTicketCartCostOnly')) {
    function calculateTicketCartCostOnly(){
        $cart =  TicketCart::firstOrCreate(['user_id' => Auth::id()]);

        return $cart->items->sum(function ($item) {
            return calculateCostOnTicketWithoutCharge($item->user_event_ticket_id,$item->quantity);
        });
    }
}

if (!function_exists('determineEventEndDate')) {
    /**
     * Determine the end date of an event based on its schedule type and recurrence settings.
     *
     * This function calculates the end date for both single and recurring events. For single events,
     * it uses the provided end date and time. For recurring events, it calculates the end date based
     * on the recurrence interval and the number of occurrences or a specific recurrence end date.
     *
     * @param \App\Models\UserEvent $event The event model containing event details.
     * @param bool $returnAsString Optional. If true, the function returns the end date as a formatted string (Y-m-d H:i:s).
     *                             Defaults to false, which returns a DateTime object or null.
     *
     * @return \DateTime|string|null Returns the calculated end date as a DateTime object,
     *                               a formatted string if $returnAsString is true, or null if no end date can be determined.
     *
     * @throws \Exception If invalid DateTime or DateInterval specifications are encountered.
     *
     * Example usage:
     * $endDate = determineEventEndDate($event, true);
     * echo $endDate ?: 'No end date available.';
     */
    function determineEventEndDate(\App\Models\UserEvent $event, $returnAsString = false): DateTime|string|null
    {
        $timezone = new DateTimeZone($event->eventTimeZone);
        $startDate = new DateTime("{$event->startDate} {$event->startTime}", $timezone);

        $endDate = null;

        if ($event->eventScheduleType == 1) {
            // Single event, return the provided end date and time
            $endDate = new DateTime("{$event->endDate} {$event->endTime}", $timezone);
        } elseif ($event->recurrenceEndType == 1) {
            // End by a specific date
            $endDate = new DateTime("{$event->recurrenceEndDate} {$event->recurrenceEndTime}", $timezone);
        } elseif ($event->recurrenceEndType == 2 && $event->recurrenceEndCount) {
            // End after a certain number of occurrences
            $intervalValue = extractIntervalFromRecurrenceInterval($event->recurrenceInterval);
            $intervalPeriod = extractPeriodFromRecurrenceInterval($event->recurrenceInterval);
            $occurrences = $event->recurrenceEndCount;

            // Convert to a valid DateInterval spec
            $intervalPeriodShort = strtoupper(substr($intervalPeriod, 0, 1));
            $dateIntervalSpec = 'P' . ($intervalValue * $occurrences) . $intervalPeriodShort;

            // Add the interval to the start date
            $endDate = clone $startDate;
            $endDate->add(new DateInterval($dateIntervalSpec));
        }

        if ($returnAsString && $endDate instanceof DateTime) {
            return $endDate->format('Y-m-d H:i:s');
        }

        return $endDate;
    }
}
if (!function_exists('generateGoogleCalendarLink')) {
    /**
     * Generate a Google Calendar link for an event.
     *
     * This function creates a Google Calendar URL that allows users to add an event to their Google Calendar.
     * It includes the event's start and end date, title, description, and location.
     *
     * @param \App\Models\UserEvent $event The event for which to generate the Google Calendar link.
     *
     * @return string The generated Google Calendar URL.
     *
     * @throws \Exception If the event's date or time data is invalid.
     */
    function generateGoogleCalendarLink(\App\Models\UserEvent $event): string
    {

        $startDateTime = new DateTime("{$event->startDate} {$event->startTime}", new DateTimeZone($event->eventTimeZone));
        $endDateTime = determineEventEndDate($event);

        $details = $event->description;

        // Add platform and link to event details
        if ($event->eventType != 1) {
            $details .= "\nPlatform: " . $event->platform;
            $details .= "\nEvent Link: " . $event->link;
        }

        $params = [
            'action' => 'TEMPLATE',
            'text' => $event->title,
            'details' => $details,
            'location' => $event->eventType!=1 ? 'Online Event' :$event->location.','.getStateFromIso2($event->state,$event->country)->name.' '.getCountryFromIso2($event->country)->name,
            'dates' => $startDateTime->format('Ymd\THis\Z') . '/' . $endDateTime->format('Ymd\THis\Z'),
        ];
        return 'https://www.google.com/calendar/render?' . http_build_query($params);
    }
}

if (!function_exists('merchantTotalAvailableBalance')){
    function merchantTotalAvailableBalance(\App\Models\User $user): string
    {
        $accountBalance = $user->accountBalance;
        $referralBalance = $user->referralBalance;
        $totalEventBalance = \App\Models\UserEvent::where('user',$user->id)->sum('currentBalance');

        return bcadd($accountBalance+$referralBalance,$totalEventBalance,2);
    }
}

if (!function_exists('calculateChargeRate')){
    function calculateChargeRate($charge)
    {
        $web = \App\Models\GeneralSetting::find(1);
        if ($web->hasPromo==true){
            $rateToCharge = (100 - $web->promoRate)/100;
            return $charge*$rateToCharge;
        }
        return $charge;
    }
}

if (!function_exists('formatContactToWhatsapp')) {
    /**
     * Formats a phone number into a WhatsApp-compatible format.
     *
     * @param string $contact   The phone number to format.
     * @param string $country   The country ISO code (default: 'NGA').
     * @return string|null      Returns a formatted WhatsApp number or null if invalid.
     */
    function formatContactToWhatsapp($contact, $country = 'NGA')
    {
        // Fetch country details based on ISO2 or ISO3 code
        $countryMain = \App\Models\Country::where('iso3', $country)->orWhere('iso2', $country)->first();

        // Ensure a valid country was found
        if (!$countryMain) {
            return null; // Return null if country is not found
        }

        // Extract phone country code (without '+')
        $phoneCode = str_replace('+', '', optional($countryMain)->phonecode);

        // Remove all non-numeric characters from the contact number
        $cleanContact = preg_replace('/\D/', '', $contact);

        // Remove the country code if it already exists in the contact number
        if (strpos($cleanContact, $phoneCode) === 0) {
            $cleanContact = substr($cleanContact, strlen($phoneCode));
        }

        // Construct the final WhatsApp-compatible contact
        return $phoneCode . $cleanContact;
    }
}


if (!function_exists('has_reached_daily_ad_limit')) {
    function has_reached_daily_ad_limit($userId, $limit = 10)
    {
        $adsToday = \App\Models\UserAd::where('user', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();
        return $adsToday >= $limit;
    }
}

if (!function_exists('watermark_image')) {
    function watermark_image($imageUrl)
    {
        if (!$imageUrl) {
            return asset('placeholder-image.jpg'); // Return default if no image
        }

        try {
            // Fetch the image directly from Google Cloud Storage (GCS)
            $response = Http::withHeaders([
                'Accept' => 'image/*'
            ])->get($imageUrl);

            // Ensure the response is valid
            if (!$response->successful() || empty($response->body())) {
                Log::error("Image request failed with status: " . $response->status());
                return asset('placeholder-image.jpg');
            }

            // Read image content directly into memory
            $imageContent = $response->body();

            // Create an in-memory image processing instance
            // Convert to Base64 for direct display in browser
            return Image::useImageDriver(ImageDriver::Gd)->load($imageContent)
                ->watermark(public_path('logo-white.png'));

        } catch (\Exception $e) {
            Log::error("Image processing error: " . $e->getMessage());
            return asset('placeholder-image.jpg');
        }
    }
}
