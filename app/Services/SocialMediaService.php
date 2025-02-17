<?php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
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

    public function postToAllPlatforms($message, $imageUrl, $hashtags = [])
    {
        foreach ($this->platforms as $platform) {
            $this->postToPlatform($platform, $message, $imageUrl, $hashtags);
        }
    }

    public function postToPlatform($platform, $message, $imageUrl, $hashtags = [])
    {
        try {
            switch ($platform) {
                case 'facebook':
                    $this->postToFacebook($message, $imageUrl, $hashtags);
                    break;
                case 'twitter':
                    $this->postToTwitter($message, $imageUrl, $hashtags);
                    break;
                case 'instagram':
                    $this->postToInstagram($message, $imageUrl, $hashtags);
                    break;
                default:
                    Log::warning("Platform [$platform] not supported.");
                    break;
            }
        } catch (\Exception $e) {
            Log::error("Error posting to $platform: " . $e->getMessage());
        }
    }

    private function postToInstagram($message, $imageUrl, $hashtags = [])
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
            Http::post("https://graph.facebook.com/v22.0/{$instagramBusinessId}/media_publish", [
                'creation_id' => $result['id'],
                'access_token' => $accessToken
            ]);


        } catch (\Exception $e) {
            Log::error("Instagram post failed: " . $e->getMessage());
        }
    }


}
