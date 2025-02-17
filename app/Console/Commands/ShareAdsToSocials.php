<?php

namespace App\Console\Commands;

use App\Jobs\ShareAdJob;
use App\Models\UserAd;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ShareAdsToSocials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:share-ads-to-socials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically share new Ads to social media';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ads = UserAd::where([
            'status' => 1,
            'shared' => false
        ])
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->latest()
            ->limit(10)
            ->get();

        if ($ads->isEmpty()){
            return;
        }

        foreach ($ads as $ad) {
            // Generate Ad URL correctly
            $adUrl = route('mobile.marketplace.detail', [
                'slug' => textToSlug($ad->title),
                'id' => $ad->reference
            ]);

            $message = "**{$ad->title}**\n\n";
            $message .= "{$ad->description}\n\n";
            $message .= "📌 **Posted By:** {$ad->companyName}\n\n";
            $message .= "🔗 View here: {$adUrl} (Copy & Paste)";

            // Use direct image link
            $imageUrl = $ad->featuredImage;

            // Generate hashtags directly from title & description
            $hashtags = $this->generateHashtags($ad->title, $ad->description);

            // Dispatch job to default queue
            ShareAdJob::dispatch($message, $imageUrl, $hashtags);
            // Mark as shared
            $ad->update(['shared' => true]);
        }
    }

    /**
     * Generate hashtags from the title & description.
     */
    private function generateHashtags($title, $description)
    {
        // Expanded base hashtags
        $baseHashtags = [
            '#Xulfashion', '#fashion', '#style', '#trending', '#shopnow', '#fashionista',
            '#streetwear', '#luxuryfashion', '#menswear', '#womenswear', '#shoes', '#sneakers',
            '#accessories', '#handbags', '#designers', '#couture', '#outfits', '#elegance',
            '#instafashion', '#ootd', '#onlineshopping', '#wearable', '#trendsetter'
        ];

        // Extract unique words from title & description
        $text = strtolower($title . ' ' . $description);
        preg_match_all('/\b[a-zA-Z]{4,15}\b/', $text, $words);

        // Remove common words
        $commonWords = ['with', 'from', 'your', 'this', 'that', 'here', 'for', 'and', 'the', 'new', 'best', 'shop', 'buy', 'sale', 'hot'];
        $filteredWords = array_diff(array_unique($words[0]), $commonWords);

        // Convert words to hashtags
        $dynamicHashtags = array_map(fn($word) => '#' . ucfirst($word), array_slice($filteredWords, 0, 5));

        // Merge with base hashtags
        return array_merge($baseHashtags, $dynamicHashtags);
    }
}
