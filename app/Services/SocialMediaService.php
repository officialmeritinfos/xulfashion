<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Jobs\InstagramCommentJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Exceptions\InvalidImageDriver;
use Spatie\Image\Image;

class SocialMediaService
{
    protected array $platforms = ['instagram'];

    public function postToAllPlatforms($message, $imageUrl, $hashtags = [],$postLink)
    {
        foreach ($this->platforms as $platform) {
            $this->postToPlatform($platform, $message, $imageUrl, $hashtags,$postLink);
        }
    }

    public function postToPlatform($platform, $message, $imageUrl, $hashtags = [],$postLink)
    {
        try {
            switch ($platform) {
                case 'facebook':
                    $this->postToFacebook($message, $imageUrl, $hashtags);
                    break;
                case 'instagram':
                    $this->postToInstagram($message, $imageUrl, $hashtags,$postLink);
                    break;
                default:
                    Log::warning("Platform [$platform] not supported.");
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Error posting to $platform: " . $e->getMessage());
        }
    }
    private function postToFacebook($message, $imageUrl, $hashtags = []){

        // Append hashtags to the message
        $hashtagString = !empty($hashtags) ? "\n\n" . implode(' ', $hashtags) : '';
        $fullCaption = $message . $hashtagString;

    }

    private function postToInstagram($message, $imageUrl, $hashtags = [],$postLink)
    {
        $instagramBusinessId = env('INSTAGRAM_USER_ID');
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');

        // Append hashtags to the message
        $hashtagString = !empty($hashtags) ? "\n\n" . implode(' ', $hashtags) : '';
        $fullCaption = $message . $hashtagString;

        try {
            // Step 1: Upload the image to Instagram without resizing
            $response = Http::post("https://graph.facebook.com/v22.0/{$instagramBusinessId}/media", [
                'image_url' => $imageUrl,  // Use the original image
                'caption' => $fullCaption, // Include hashtags
                'access_token' => $accessToken
            ]);

            $result = $response->json();

            // If upload fails, log and skip
            if (!isset($result['id'])) {
                Log::error("Error posting to Instagram: " . json_encode($result));
                return;
            }
            // Step 2: Publish the uploaded image
            $publishResponse  = Http::post("https://graph.facebook.com/v22.0/{$instagramBusinessId}/media_publish", [
                'creation_id' => $result['id'],
                'access_token' => $accessToken
            ]);

            $publishResult = $publishResponse->json();

            if (!isset($publishResult['id'])) {
                Log::error("Error publishing Instagram post: " . json_encode($publishResult));
                return;
            }
            // Step 3: Post multiple follow-up comments with small delays
            $comments = [
                "🔗 View the full post here: {$postLink}",
                "📢 Check out our latest deals! #Fashion #Style",
                "🔥 Follow us for more amazing Beauty and Fashion products and services."
            ];

            foreach ($comments as $index => $commentMessage) {
                // Introduce a small delay (5-10 seconds) to prevent spam detection
//                sleep(rand(5, 10));

                $commentResponse = Http::post("https://graph.facebook.com/v22.0/{$publishResult['id']}/comments", [
                    'message' => $commentMessage,
                    'access_token' => $accessToken
                ]);

                $commentResult = $commentResponse->json();

                if (!isset($commentResult['id'])) {
                    Log::error("Error posting Instagram comment: " . json_encode($commentResult));
                }
            }

            // Step 3: Dispatch only ONE job (which will handle all comments)
//            InstagramCommentJob::dispatch($publishResult['id'], $postLink, $accessToken)->delay(now()->addMinutes(1));


        } catch (\Exception $e) {
            Log::error("Instagram post failed: " . $e->getMessage());
        }
    }


}
