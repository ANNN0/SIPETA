<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

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
        ]);

        ProductReview::create([
            'product_id' => $request->product_id,
            'reviewer_name' => $request->name,
            'reviewer_email' => $request->email,
            'rating' => $request->rating,
            'review_text' => $request->review,
            'is_approved' => 1, // Auto-approve
        ]);

        return redirect()->back()->with('review_success', 'Terima kasih! Ulasan Anda telah berhasil dikirimkan.');
    }
}
