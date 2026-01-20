<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function show($slug)
    {
        $farmer = Farmer::where('slug', $slug)
            ->with(['region', 'products'])
            ->firstOrFail();

        // Calculate farmer statistics
        $statistics = [
            'products_count' => $farmer->products->count(),
            'avg_rating' => $farmer->products->avg('rating') ?? 0,
            'total_reviews' => $farmer->products->sum(function ($product) {
                return $product->approvedReviews->count();
            }),
            'member_since' => $farmer->created_at->format('M Y'),
        ];

        return view('farmer-profile', compact('farmer', 'statistics'));
    }
}
