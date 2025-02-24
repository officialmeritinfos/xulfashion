<?php

namespace App\Jobs;

use App\Custom\GoogleUpload;
use App\Models\UserStoreProductImage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadStoreProductPhotosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productId;
    protected $photoPaths;

    /**
     * Create a new job instance.
     */
    public function __construct($productId, $photoPaths)
    {
        $this->productId = $productId;
        $this->photoPaths = $photoPaths;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $uploadedPhotos = [];

        $googleDriveService = new GoogleUpload();

        foreach ($this->photoPaths as $index => $path) {
            try {
                // Ensure the file exists before uploading
                if (!Storage::exists($path)) {
                    Log::error("File not found: {$path}");
                    continue;
                }

                // Convert the storage path to an absolute file path
                $absolutePath = storage_path("app/" . $path);

                // Ensure the file path is valid before passing it
                if (!file_exists($absolutePath)) {
                    Log::error("File does not exist at path: {$absolutePath}");
                    continue;
                }

                // Upload the file using Google Drive service
                $result = $googleDriveService->uploadGoogleJob($absolutePath);

                if (!$result || empty($result['link'])) {
                    Log::error("Photo {$index} upload failed for product ID: {$this->productId}");
                    continue;
                }

                // Save to database
                $uploadedPhotos[] = ['product' => $this->productId, 'image' => $result['link']];

                // Delete the temporary file after successful upload
                Storage::delete($path);

            }catch (\Exception $e){
                Log::error("Error uploading photo {$index} for product ID: {$this->productId} - " . $e->getMessage());
                continue;
            }
        }

        // Save all uploaded photos to the database
        if (!empty($uploadedPhotos)) {
            try {
                UserStoreProductImage::insert($uploadedPhotos);
            } catch (\Exception $e) {
                Log::error("Failed to save uploaded photos in DB for product ID: {$this->productId} - " . $e->getMessage());
            }
        }
    }
}
