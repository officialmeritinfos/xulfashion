<?php

namespace App\Custom;

use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleUpload
{
    public function uploadGoogle($file)
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
        $fileName = time().'.'.$file->extension();

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

    public function deleteUpload($link)
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
        }catch (\Exception $exception){
            Log::info($exception->getMessage());
        }
    }

    public function uploadGoogleJob($filePath)
    {

        // Ensure $filePath is a valid file
        if (!file_exists($filePath)) {
            Log::error("File does not exist at: {$filePath}");
            return [
                'done' => false,
                'error' => 'File not found.'
            ];
        }

        // Get file extension
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Get Google Cloud credentials
        $googleConfigFile = file_get_contents(private_path('xulfashion2.json'));
        $storage = new StorageClient([
            'keyFile' => json_decode($googleConfigFile, true)
        ]);

        // Get bucket name from config
        $storageBucketName = config('googlecloud.storage_bucket');
        $bucket = $storage->bucket($storageBucketName);

        // Rename the file
        $fileName = time() . '.' . $fileExtension;

        // Open the file using fopen
        $fileSource = fopen($filePath, 'r');

        // Specify the path in Google Cloud Storage
        $googleCloudStoragePath = 'profile-uploads/' . $fileName;

        // Upload the file
        $request = $bucket->upload($fileSource, [
            'predefinedAcl' => 'publicRead',
            'name' => $googleCloudStoragePath
        ]);

        if ($request) {
            // Delete local file after successful upload
            unlink($filePath);

            return [
                'done' => true,
                'link' => 'https://storage.googleapis.com/xulfashion/profile-uploads/' . $fileName
            ];
        } else {
            Log::error("Google Cloud upload failed.");
            return [
                'done' => false,
                'error' => 'Upload failed.'
            ];
        }
    }

}
