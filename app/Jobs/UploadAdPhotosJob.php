<?php

namespace App\Jobs;

use App\Custom\GoogleUpload;
use App\Models\UserAdPhoto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadAdPhotosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $adId;
    protected $photoPaths;

    /**
     * Create a new job instance.
     */
    public function __construct($adId, $photoPaths)
    {
        $this->adId = $adId;
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
                Log::info("Processing photo {$index} for ad ID: {$this->adId}");

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
                    Log::error("Photo {$index} upload failed for ad ID: {$this->adId}");
                    continue;
                }

                // Save to database
                $uploadedPhotos[] = ['ad' => $this->adId, 'photo' => $result['link']];
                Log::info("Photo {$index} uploaded successfully for ad ID: {$this->adId}");

                // Delete the temporary file after successful upload
                Storage::delete($path);

            } catch (\Exception $e) {
                Log::error("Error uploading photo {$index} for ad ID: {$this->adId} - " . $e->getMessage());
                continue;
            }
        }

        // Save all uploaded photos to the database
        if (!empty($uploadedPhotos)) {
            try {
                UserAdPhoto::insert($uploadedPhotos);
                Log::info("All uploaded photos saved successfully for ad ID: {$this->adId}");
            } catch (\Exception $e) {
                Log::error("Failed to save uploaded photos in DB for ad ID: {$this->adId} - " . $e->getMessage());
            }
        }
    }
}
