<?php

namespace App\Jobs;

use App\Services\SocialMediaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ShareAdJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $imageUrl;
    protected $hashtags;
    protected $postLink;

    /**
     * Create a new job instance.
     */
    public function __construct($message, $imageUrl,$postLink,$hashtags = [])
    {
        $this->message = $message;
        $this->imageUrl = $imageUrl;
        $this->hashtags = $hashtags;
        $this->postLink = $postLink;
    }

    /**
     * Execute the job.
     */
    public function handle(SocialMediaService $socialMediaService): void
    {
        $socialMediaService->postToAllPlatforms($this->message, $this->imageUrl, $this->hashtags, $this->postLink);
    }
}
