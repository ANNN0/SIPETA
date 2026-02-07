<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $uploadResult = Cloudinary::uploadApi()->upload($uploadedFile->getRealPath(), [
                'folder' => 'reviews'
            ]);
            $imageName = $uploadResult['secure_url'];
        }

        // Check for existing review to handle image persistence
        $existingReview = ProductReview::where('product_id', $request->product_id)
            ->where('reviewer_email', $request->email)
            ->first();

        if ($imageName) {
            // New image uploaded, nothing special needed
        } elseif ($existingReview && $existingReview->image) {
            // Keep existing image if no new one uploaded
            $imageName = $existingReview->image;
        }

        ProductReview::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'reviewer_email' => $request->email,
            ],
            [
                'reviewer_name' => $request->name,
                'rating' => $request->rating,
                'review_text' => $request->review,
                'image' => $imageName,
                'is_approved' => 1,
            ]
        );

        return redirect()->back()->with('review_success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');
    }
}
