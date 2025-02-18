<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InstagramCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postId;
    protected $postLink;
    protected $accessToken;
    protected $comments;
    protected $commentIndex;

    /**
     * Create a new job instance.
     */
    public function __construct($postId, $postLink, $accessToken, $comments = [], $commentIndex = 0)
    {
        $this->postId = $postId;
        $this->postLink = $postLink;
        $this->accessToken = $accessToken;
        $this->comments = $comments ?: [
            "🔗 View the full post here: {$postLink}",
            "📢 Check out our latest deals! #beauty #Fashion #Style",
            "🔥 Follow us for more amazing fashion & beauty stores and service providers!"
        ];
        $this->commentIndex = $commentIndex;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->commentIndex >= count($this->comments)) {
            return; // No more comments to post
        }

        try {
            // Post the current comment
            $commentResponse = Http::post("https://graph.facebook.com/v22.0/{$this->postId}/comments", [
                'message' => $this->comments[$this->commentIndex],
                'access_token' => $this->accessToken
            ]);

            $commentResult = $commentResponse->json();

            if (isset($commentResult['id'])) {
                Log::info("Instagram comment posted: {$this->comments[$this->commentIndex]}");
            } else {
                Log::error("Error posting Instagram comment: " . json_encode($commentResult));
            }

            // Schedule the next comment (without blocking)
            if ($this->commentIndex < count($this->comments) - 1) {
                InstagramCommentJob::dispatch(
                    $this->postId,
                    $this->postLink,
                    $this->accessToken,
                    $this->comments,
                    $this->commentIndex + 1
                )->delay(now()->addMinutes()); // Wait 2 minutes before next comment
            }

        } catch (\Exception $e) {
            Log::error("Instagram comment job failed: " . $e->getMessage());
        }
    }
}
