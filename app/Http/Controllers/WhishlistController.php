<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WhishlistController extends Controller
{

    public function index()
    {
        $items = Cart::instance('wishlist')->content();

        // Extract product IDs dari cart items
        $productIds = $items->pluck('id')->toArray();

        // Fetch lengkap product data dengan relationships
        $products = \App\Models\Product::whereIn('id', $productIds)
            ->with(['category', 'region', 'farmer', 'reviews', 'primaryUnitPrice.unit'])
            ->get()
            ->keyBy('id');

        return view('wishlist', compact('items', 'products'));
    }

    public function add_to_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }

    public function empty_wishlist()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back();
    }

    public function move_to_cart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price)->associate('App\Models\Product');
        return redirect()->back();
    }
}
