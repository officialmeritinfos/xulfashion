<?php

namespace App\Livewire\Mobile\Users\Store\Components\Actions\Products;

use App\Jobs\UploadStoreProductPhotosJob;
use App\Models\GeneralSetting;
use App\Models\UserStoreOrder;
use App\Models\UserStoreProduct;
use App\Models\UserStoreProductColorVariation;
use App\Models\UserStoreProductImage;
use App\Models\UserStoreProductSizeVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Tests\Integration\Queue\Order;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination,WithFileUploads,LivewireAlert;

    public $product;
    public $user;
    public $store;
    public $file = [];
    public $orderStatusFilter = 'all';
    public $ordersPerPage = 10;
    public $sizeName;
    public $colorName;
    public $showSizeForm = false;
    public $showColorForm = false;

    protected $listeners = [
        'deleteConfirmed',
        'productDeleteConfirm'=>'deleteProductConfirmed'
    ];
    public function mount($product)
    {
        $this->product = UserStoreProduct::where('id',$product)->with('productCategory','colors','sizes','images','stores')->first();
        $this->user = auth()->user();
        $this->store = $this->product->stores;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="skeleton-gradient">
                        <stop offset="0%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="50%" stop-color="#e0e0e0">
                            <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="100%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                    </linearGradient>
                </defs>

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>
        </div>
        HTML;
    }

    //delete image
    public function deleteImage($id)
    {
        try {
            $product = UserStoreProductImage::where([
                'id' => $id,'product' => $this->product->id
            ])->first();

            if (!$product){
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Product Image not found',
                    'width' => '400',
                ]);
                return;
            }

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete this image?',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteConfirmed',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete a store product image');
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while deleting product image.',
                'width' => '400',
            ]);
            return;
        }
    }
    //delete confirmed
    public function deleteConfirmed($data)
    {
        $id = $data['id'] ?? null;

        if ($id) {
            $product = UserStoreProductImage::where([
                'id' => $id,
                'product' => $this->product->id,
            ])->first();

            if ($product) {
                $product->delete();

                $this->alert('success', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => 'Product Image has been deleted.',
                    'width' => '400',
                ]);
            }
        }
        $this->dispatch('render');

    }
    //upload image
    public function uploadImage()
    {
        $web = GeneralSetting::find(1);
        $maxImages = $web->fileUploadAllowed; // Maximum allowed images per product

        $this->validate([
            'file' => ['nullable', 'array', 'max:' . $maxImages],
            'file.*' => ['nullable', 'mimes:jpeg,png,jpg,gif,svg,webp,avif', 'max:5120'],
        ], [
            'file.max' => "You can only upload a maximum of {$maxImages} images.",
            'file.*.image' => 'Each file must be an image.',
            'file.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg, webp, avif.',
            'file.*.max' => 'Each image may not be larger than 5MB.',
        ]);


        try {
            // Count current images
            $existingImages = $this->product->images->count();
            $newImagesCount = count($this->file);

            // Ensure the total does not exceed 5
            if (($existingImages + $newImagesCount) > $maxImages) {
                $this->alert('error', '', [
                    'position' => 'top-end',
                    'timer' => 5000,
                    'toast' => true,
                    'text' => "You can only upload {$maxImages} images in total. You already have {$existingImages}.",
                    'width' => '400',
                ]);
                return;
            }

            $photoPaths = [];
            foreach ($this->file as $photo) {
                $path = $photo->store('temp_photos'); // Store in storage/app/temp_photos
                $photoPaths[] = $path;
            }

            // Dispatch queue job for processing
            UploadStoreProductPhotosJob::dispatch($this->product->id, $photoPaths);

            // ✅ Dispatch event to close modal
            $this->dispatch('closeModal');

            // Reset input
            $this->file = [];
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product images queued for uploaded successfully.',
                'width' => '400',
            ]);

            $this->dispatch('render'); // Refresh component
            return;

        }catch (\Exception $exception){
            logger("Error uploading product images: {$exception->getMessage()}");

            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while uploading images. Please try again.',
                'width' => '400',
            ]);
            return;
        }
    }
    public function editVariants()
    {
        return redirect()->route('mobile.user.store.catalog.products.edit.variant', ['ref' => $this->product->reference]);
    }
    public function updateStatus($status)
    {
        $this->product->update(['status' => $status]);
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product Status successfully updated.',
            'width' => '400',
        ]);
    }

    public function markFeatured()
    {
        $this->product->update(['featured' => 1]);
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product successfully marked as featured.',
            'width' => '400',
        ]);
    }

    public function removeFeatured()
    {
        $this->product->update(['featured' => 2]);
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product featuring successfully removed.',
            'width' => '400',
        ]);
    }

    public function markHighlighted()
    {
        //another is highlighted
        $highlighted = UserStoreProduct::where([
            'store'=>$this->store->id,'highlighted'=>1
        ])->where('id','!=',$this->product->id)->first();

        if (!empty($highlighted)){
            $highlighted->update(['highlighted' => 2]);
        }

        $this->product->update(['highlighted' => 1]);

        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product successfully marked as highlighted.',
            'width' => '400',
        ]);
    }

    public function removeHighlighted()
    {
        $this->product->update(['highlighted' => 2]);
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Product highlight successfully removed.',
            'width' => '400',
        ]);
    }
    public function deleteSizeVariant($id)
    {
        DB::beginTransaction();
        try {
            UserStoreProductSizeVariation::where([
                'product' => $this->product->id,
                'id' => $id
            ])->delete();
            DB::commit();
            $this->product = $this->product->refresh();
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product size variant successfully deleted.',
                'width' => '400',
            ]);
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            logger("Error delete product size: {$exception->getMessage()}");
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => "{$exception->getMessage()}",
                'width' => '400',
            ]);
            return;
        }
    }

    public function deleteColorVariant($id)
    {
        DB::beginTransaction();
        try {
            UserStoreProductColorVariation::where([
                'product' => $this->product->id,
                'id' => $id
            ])->delete();
            DB::commit();
            $this->product = $this->product->refresh();
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Product color variant successfully deleted.',
                'width' => '400',
            ]);
            return;
        }catch (\Exception $exception){
            DB::rollBack();
            logger("Error delete product color: {$exception->getMessage()}");
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => "{$exception->getMessage()}",
                'width' => '400',
            ]);
            return;
        }
    }
    // Toggle Size Form Visibility
    public function toggleSizeForm()
    {
        $this->showSizeForm = !$this->showSizeForm;
        $this->sizeName = '';
    }

    // Toggle Color Form Visibility
    public function toggleColorForm()
    {
        $this->showColorForm = !$this->showColorForm;
        $this->colorName = '';
    }
    // Save New Size Variant with DB Transaction
    public function saveSizeVariant()
    {
        $this->validate([
            'sizeName' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            UserStoreProductSizeVariation::create([
                'product' => $this->product->id,
                'name' => $this->sizeName,
            ]);

            DB::commit();
            $this->toggleSizeForm();
            $this->product = $this->product->refresh();
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => "Size variant successfully added.",
                'width' => '400',
            ]);
            $this->dispatch('render');
            return;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => "Failed to add size variant. Please try again.",
                'width' => '400',
            ]);
        }
    }
    // Save New Color Variant with DB Transaction
    public function saveColorVariant()
    {
        $this->validate([
            'colorName' => 'required|string|max:150',
        ]);

        DB::beginTransaction();
        try {
            UserStoreProductColorVariation::create([
                'product' => $this->product->id,
                'name' => $this->colorName,
            ]);

            DB::commit();
            $this->toggleColorForm();
            $this->product = $this->product->refresh();
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => "Color variant successfully added.",
                'width' => '400',
            ]);
            $this->dispatch('render');
            return;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => "Failed to add color variant. Please try again.",
                'width' => '400',
            ]);
        }
    }
    public function render()
    {
        $query = UserStoreOrder::whereHas('breakdowns', function ($q) {
            $q->where('product', $this->product->id);
        })->with(['breakdowns.products'])->orderBy('created_at', 'desc');

        if ($this->orderStatusFilter !== 'all') {
            $query->where('status', $this->orderStatusFilter);
        }
        $orders = $query->paginate($this->ordersPerPage);

        return view('livewire.mobile.users.store.components.actions.products.detail',[
            'orders' => $orders
        ]);
    }
}
