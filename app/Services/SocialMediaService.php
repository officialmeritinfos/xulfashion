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
    protected array $platforms = ['instagram', 'twitter'];

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

    private function postToFacebook($message, $imageUrl, $hashtags)
    {


        $pageId = env('FACEBOOK_PAGE_ID');
        $accessToken = env('FACEBOOK_PAGE_ACCESS_TOKEN');

        $fullMessage = $message . "\n\n" . implode(' ', $hashtags); // Append hashtags


        $response = Http::post("https://graph.facebook.com/v22.0/{$pageId}/photos", [
            'caption' => $fullMessage,
            'url' => $imageUrl,
            'access_token' => $accessToken,
        ]);

        if ($response->failed()) {
            throw new \Exception("Facebook API Error: " . $response->body());
        }

        Log::info("Ad successfully posted to Facebook.");
    }

    private function postToTwitter($message, $imageUrl, $hashtags)
    {
        $twitter = new TwitterOAuth(
            env('TWITTER_CONSUMER_KEY'),
            env('TWITTER_CONSUMER_SECRET'),
            env('TWITTER_ACCESS_TOKEN'),
            env('TWITTER_ACCESS_SECRET')
        );

        // Append hashtags to the message
        $fullMessage = $message . "\n\n" . implode(' ', $hashtags);

        // Step 1: Ensure the 'public/twitter' folder exists
        $folderPath = public_path('twitter');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Step 2: Download the image and save it in 'public/twitter/'
        $filename = uniqid('twitter_') . '.jpg';
        $imagePath = $folderPath . '/' . $filename;

        try {
            $response = Http::get($imageUrl);
            if ($response->successful()) {
                file_put_contents($imagePath, $response->body());
            } else {
                throw new \Exception("Failed to download image from URL.");
            }
        } catch (\Exception $e) {
            Log::error("Error downloading image for Twitter: " . $e->getMessage());
            return;
        }

        // Step 3: Validate the downloaded image
        if (!file_exists($imagePath) || filesize($imagePath) == 0) {
            Log::error("Downloaded image is invalid or empty: " . $imagePath);
            return;
        }

        // Step 4: Upload the image to Twitter
        $media = $twitter->upload('media/upload', ['media' => $imagePath]);

        if (!isset($media->media_id_string)) {
            Log::error("Error uploading image to Twitter: " . json_encode($media));
            return;
        }

        // Step 5: Post the tweet with the uploaded media
        $tweet = $twitter->post('statuses/update', [
            'status' => $fullMessage,
            'media_ids' => $media->media_id_string
        ]);

        if (isset($tweet->id)) {
            Log::info("Tweet successfully posted.");
        } else {
            Log::error("Error posting to Twitter: " . json_encode($tweet));
        }

        // Step 6: Delete the image after posting
        if (file_exists($imagePath)) {
            unlink($imagePath);
            Log::info("Deleted Twitter image: " . $imagePath);
        }
    }

    private function postToInstagram($message, $imageUrl, $hashtags = [])
    {
        $instagramBusinessId = env('INSTAGRAM_USER_ID');
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');

        // Resize image before posting
        $resizedImageUrl = $this->resizeImageForInstagram($imageUrl);

        // Extract file path from URL
        $localImagePath = public_path(str_replace(asset('/'), '', $resizedImageUrl));

        // Append hashtags to the message
        $hashtagString = !empty($hashtags) ? "\n\n" . implode(' ', $hashtags) : '';
        $fullCaption = $message . $hashtagString;

        // Step 1: Upload the image to Instagram
        $response = Http::post("https://graph.facebook.com/v22.0/{$instagramBusinessId}/media", [
            'image_url' => $resizedImageUrl,
            'caption' => $fullCaption, // Include hashtags
            'access_token' => $accessToken
        ]);

        $result = $response->json();

        if (isset($result['id'])) {
            // Step 2: Publish the image
            Http::post("https://graph.facebook.com/v22.0/{$instagramBusinessId}/media_publish", [
                'creation_id' => $result['id'],
                'access_token' => $accessToken
            ]);

            Log::info("Product successfully posted to Instagram.");

            // Step 3: Delete the image after posting
            if (file_exists($localImagePath)) {
                unlink($localImagePath);
                Log::info("Deleted Instagram image: " . $localImagePath);
            }
        } else {
            Log::error("Error posting to Instagram: " . json_encode($result));
        }
    }

    /**
     * @throws InvalidImageDriver
     */
    private function resizeImageForInstagram($imageUrl)
    {
        // Define the target width and height based on Instagram's aspect ratio
        $targetWidth = 1080;  // Instagram standard width
        $targetHeight = 1350; // 4:5 aspect ratio height

        // Ensure the instagram folder exists
        $folderPath = public_path('instagram');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Generate a unique filename
        $filename = uniqid('instagram_') . '.jpg';
        $tempPath = $folderPath . '/' . $filename;

        // Step 1: Download the remote Google Cloud image
        try {
            $response = Http::get($imageUrl);
            if ($response->successful()) {
                file_put_contents($tempPath, $response->body());
            } else {
                throw new \Exception("Failed to download image from Google Cloud.");
            }
        } catch (\Exception $e) {
            Log::error("Error downloading image: " . $e->getMessage());
            return $imageUrl; // Return original URL if download fails
        }

        // Step 2: Load image with Spatie Intervention Image (v3.x) & set GD driver
        $image = Image::useImageDriver(ImageDriver::Gd)->loadFile($tempPath);

        // Resize the image to fit within the 4:5 ratio (1080x1350 pixels)
        $image->resize($targetWidth, $targetHeight);

        // Step 4: Save the resized image to 'public/instagram'
        $image->save($tempPath);

        // Return the public URL of the resized image
        return asset('instagram/' . $filename);
    }



}
