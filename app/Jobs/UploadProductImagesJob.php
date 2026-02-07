<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Laravel\Facades\Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UploadProductImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 300;

    protected $productId;
    protected $mainImagePath;
    protected $galleryImagePaths;

    /**
     * Create a new job instance.
     */
    public function __construct(int $productId, ?string $mainImagePath, array $galleryImagePaths = [])
    {
        $this->productId = $productId;
        $this->mainImagePath = $mainImagePath;
        $this->galleryImagePaths = $galleryImagePaths;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $product = Product::find($this->productId);

            if (!$product) {
                Log::error("Product not found for image upload", ['product_id' => $this->productId]);
                return;
            }

            // Upload main image
            if ($this->mainImagePath && Storage::disk('local')->exists($this->mainImagePath)) {
                $mainImageUrl = $this->compressAndUpload($this->mainImagePath, 'main');
                if ($mainImageUrl) {
                    $product->image = $mainImageUrl;
                }
                // Clean up temp file
                Storage::disk('local')->delete($this->mainImagePath);
            }

            // Upload gallery images
            $galleryUrls = [];
            foreach ($this->galleryImagePaths as $index => $imagePath) {
                if (Storage::disk('local')->exists($imagePath)) {
                    $galleryUrl = $this->compressAndUpload($imagePath, "gallery_{$index}");
                    if ($galleryUrl) {
                        $galleryUrls[] = $galleryUrl;
                    }
                    // Clean up temp file
                    Storage::disk('local')->delete($imagePath);
                }
            }

            if (!empty($galleryUrls)) {
                $product->images = implode(',', $galleryUrls);
            }

            $product->save();

            Log::info("Product images uploaded successfully", [
                'product_id' => $this->productId,
                'main_image' => $product->image,
                'gallery_count' => count($galleryUrls)
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to upload product images", [
                'product_id' => $this->productId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw to trigger retry
            throw $e;
        }
    }

    /**
     * Compress image and upload to Cloudinary
     */
    protected function compressAndUpload(string $storagePath, string $identifier): ?string
    {
        try {
            $fullPath = Storage::disk('local')->path($storagePath);

            // Compress image using Intervention Image
            $image = Image::read($fullPath);

            // Resize if too large (max width 1920px, maintaining aspect ratio)
            $image->scale(width: 1920);

            // Encode with quality compression
            $encoded = $image->toJpeg(quality: 80);

            // Create temporary file for compressed image
            $tempPath = sys_get_temp_dir() . '/' . uniqid('compressed_') . '.jpg';
            $encoded->save($tempPath);

            // Upload to Cloudinary
            $uploadResult = Cloudinary::uploadApi()->upload($tempPath, [
                'folder' => 'products',
                'public_id' => pathinfo($storagePath, PATHINFO_FILENAME) . '_' . $identifier,
                'resource_type' => 'image',
                'overwrite' => true,
            ]);

            // Clean up temp compressed file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }

            return $uploadResult['secure_url'] ?? null;
        } catch (\Exception $e) {
            Log::error("Failed to compress and upload image", [
                'path' => $storagePath,
                'identifier' => $identifier,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("UploadProductImagesJob failed permanently", [
            'product_id' => $this->productId,
            'error' => $exception->getMessage()
        ]);

        // Optionally: Update product status or send notification
        $product = Product::find($this->productId);
        if ($product) {
            // You could add a status field to track failed uploads
            // $product->upload_status = 'failed';
            // $product->save();
        }
    }
}
