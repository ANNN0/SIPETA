<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        $fproducts = Product::where('featured', 1)->get()->take(8);
        $lproducts = Product::orderBy('created_at', 'DESC')->get()->take(8); // Latest products

        $testimonials = Contact::where('message_type', 'testimonial')
            ->where('is_approved', true)
            ->whereNotNull('rating')
            ->latest('approved_at')
            ->take(3)
            ->get()
            ->map(function ($testimonial) {
                // Try to find matching user by email to get profile photo
                $testimonial->user = \App\Models\User::where('email', $testimonial->email)->first();
                return $testimonial;
            });

        return view('index', compact('slides', 'categories', 'sproducts', 'fproducts', 'lproducts', 'testimonials'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
            'message_type' => 'required|in:pertanyaan,keluhan,testimonial,saran',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Contact::create($validated);

        return redirect()->route('home.contact')->with('success', 'Pesan Anda telah berhasil dikirim! Terima kasih.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }

    public function about()
    {
        return view('about');
    }
}
