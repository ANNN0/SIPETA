<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();

        // Calculate organic vs non-organic rupiah subtotals
        $organicSubtotal = 0;
        $nonOrganicSubtotal = 0;

        foreach ($items as $item) {
            $status = strtolower(trim($item->model->organic_status ?? ''));
            $itemTotal = $item->price * $item->qty;

            if ($status == 'organik') {
                $organicSubtotal += $itemTotal;
            } elseif ($status == 'non-organik') {
                $nonOrganicSubtotal += $itemTotal;
            }
        }

        return view('cart', compact('items', 'organicSubtotal', 'nonOrganicSubtotal'));
    }

    public function getDrawerContent()
    {
        return view('components.cart-drawer-content')->render();
    }

    public function add_to_cart(Request $request)
    {
        // Validate request including unit_id
        $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_id' => 'required|exists:units,id'
        ]);

        $product = \App\Models\Product::find($request->id);

        // Verify unit belongs to this product
        $unitPrice = $product->unitPrices()->where('unit_id', $request->unit_id)->first();

        if (!$unitPrice) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Invalid unit selected for this product'], 400);
            }
            return back()->with('error', 'Invalid unit selected for this product');
        }

        // Get unit details
        $unit = \App\Models\Unit::find($request->unit_id);

        // Calculate price (sale price or regular price)
        $price = $unitPrice->sale_price ?: $unitPrice->regular_price;

        // Add to cart with unit information (old syntax with associate)
        Cart::instance('cart')->add(
            $product->id,
            $product->name,
            $request->quantity,
            $price,
            [
                'unit_id' => $request->unit_id,
                'unit_symbol' => $unit->symbol,
                'unit_name' => $unit->name,
                'image' => $product->image
            ]
        )->associate('App\Models\Product');

        // Return JSON for AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => Cart::instance('cart')->count() // Unique items count (not total qty)
            ]);
        }

        // Redirect back (refresh current page) for normal requests
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => Cart::instance('cart')->content()->count(),
                'cart_total' => floatval(str_replace(',', '', Cart::instance('cart')->total())),
                'new_qty' => $qty
            ]);
        }

        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;

        $itemRemoved = false;
        if ($qty <= 0) {
            Cart::instance('cart')->remove($rowId);
            $itemRemoved = true;
        } else {
            Cart::instance('cart')->update($rowId, $qty);
        }

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => Cart::instance('cart')->content()->count(),
                'cart_total' => floatval(str_replace(',', '', Cart::instance('cart')->total())),
                'new_qty' => $itemRemoved ? 0 : $qty,
                'item_removed' => $itemRemoved
            ]);
        }

        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Item removed successfully']);
        }

        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            // Convert subtotal to float by removing commas
            $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $cartSubtotal)
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon code!');
            } else {
                Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value
                ]);
                $this->calculateDiscount();
                return redirect()->back()->with('success', 'Coupon applied successfully!');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid coupon code!');
        }
    }

    public function calculateDiscount()
    {
        // Convert subtotal to float by removing commas
        $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

        $discount = 0;
        if (Session::has('coupon')) {
            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = ($subtotal * Session::get('coupon')['value']) / 100;
            }
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format(floatval($discount), 2, '.', ''),
            'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
            'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
            'total' => number_format(floatval($totalAfterDiscount), 2, '.', '')
        ]);
    }

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return back()->with('success', 'Coupon has been removed!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $items = Cart::instance('cart')->content();
        $organicSubtotal = 0;
        $nonOrganicSubtotal = 0;

        foreach ($items as $item) {
            $status = strtolower(trim($item->model->organic_status ?? ''));
            $itemTotal = $item->price * $item->qty;

            if ($status == 'organik') {
                $organicSubtotal += $itemTotal;
            } elseif ($status == 'non-organik') {
                $nonOrganicSubtotal += $itemTotal;
            }
        }

        $addresses = Address::where('user_id', Auth::user()->id)->get();
        $defaultAddress = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();

        return view('checkout.checkout', compact('addresses', 'defaultAddress', 'organicSubtotal', 'nonOrganicSubtotal'));
    }

    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;

        // Check if user selected an existing address
        if ($request->has('address_id')) {
            $address = Address::where('user_id', $user_id)->where('id', $request->address_id)->first();
        } else {
            $address = null;
        }

        // If no address selected or found, create new one from form data
        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|string|min:10|max:20',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = 'Indonesia';
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }

        $this->setAmountForCheckout();

        $order = new Order();
        $order->user_id = $user_id;
        $subtotal_raw = Session::get('checkout')['subtotal'];
        $discount_raw = Session::get('checkout')['discount'];
        $tax_raw = Session::get('checkout')['tax'];
        $total_raw = Session::get('checkout')['total'];

        $order->subtotal = str_replace(',', '', $subtotal_raw);
        $order->discount = str_replace(',', '', $discount_raw);
        $order->tax = str_replace(',', '', $tax_raw);
        $order->total = str_replace(',', '', $total_raw);

        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;

        $order->save();

        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;

            // Save unit information from cart options
            if (isset($item->options->unit_id)) {
                $orderItem->unit_id = $item->options->unit_id;
            }
            if (isset($item->options->unit_symbol)) {
                $orderItem->unit_symbol = $item->options->unit_symbol;
            }

            $orderItem->save();
        }

        // Handle payment modes
        if ($request->mode == "card") {  // Card/Digital payment via Midtrans
            // Midtrans Snap Payment
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            // Prepare transaction details
            $payment_id = 'ORDER-' . $order->id . '-' . time();

            $transaction_details = [
                'order_id' => $payment_id,
                'gross_amount' => (int) str_replace(',', '', $total_raw),
            ];

            // Item details
            $item_details = [];
            foreach (Cart::instance('cart')->content() as $item) {
                $item_details[] = [
                    'id' => $item->id,
                    'price' => (int) $item->price,
                    'quantity' => $item->qty,
                    'name' => $item->name,
                ];
            }

            // Add tax as item
            if ($tax_raw > 0) {
                $item_details[] = [
                    'id' => 'TAX',
                    'price' => (int) str_replace(',', '', $tax_raw),
                    'quantity' => 1,
                    'name' => 'Pajak (PPN)',
                ];
            }

            // Customer details
            $customer_details = [
                'first_name' => $address->name,
                'email' => Auth::user()->email,
                'phone' => $address->phone,
                'billing_address' => [
                    'first_name' => $address->name,
                    'phone' => $address->phone,
                    'address' => $address->address,
                    'city' => $address->city,
                    'postal_code' => $address->zip,
                    'country_code' => 'IDN'
                ],
                'shipping_address' => [
                    'first_name' => $address->name,
                    'phone' => $address->phone,
                    'address' => $address->address,
                    'city' => $address->city,
                    'postal_code' => $address->zip,
                    'country_code' => 'IDN'
                ]
            ];

            // Transaction params
            $transaction_params = [
                'transaction_details' => $transaction_details,
                'item_details' => $item_details,
                'customer_details' => $customer_details,
                'callbacks' => [
                    'finish' => route('payment.finish'),
                    'unfinish' => route('payment.unfinish'),
                    'error' => route('payment.error')
                ]
            ];

            try {
                $snap_token = \Midtrans\Snap::getSnapToken($transaction_params);

                // Create transaction record
                $transaction = new Transaction();
                $transaction->user_id = $user_id;
                $transaction->order_id = $order->id;
                $transaction->mode = 'midtrans';
                $transaction->status = 'pending';
                $transaction->snap_token = $snap_token;
                $transaction->payment_id = $payment_id;
                $transaction->save();

                // Clear cart and checkout data
                Cart::instance('cart')->destroy();
                Session::forget('checkout');
                Session::forget('coupon');
                Session::forget('discounts');

                // Return JSON response with snap token for AJAX
                return response()->json([
                    'success' => true,
                    'snap_token' => $snap_token,
                    'order_id' => $order->id
                ]);
            } catch (\Exception $e) {
                // Delete order if payment failed
                $order->delete();
                return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
            }
        } elseif ($request->mode == "cod") {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = "pending";
            $transaction->save();

            Cart::instance('cart')->destroy();
            Session::forget('checkout');
            Session::forget('coupon');
            Session::forget('discounts');
            Session::put('order_id', $order->id);
            return redirect()->route('cart.order.confirmation');
        }
    }

    public function setAmountForCheckout()
    {
        // If cart is empty, forget checkout session
        if (Cart::instance('cart')->content()->count() == 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
    }

    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));

            // Calculate organic vs non-organic rupiah subtotals for the order
            $organicSubtotal = 0;
            $nonOrganicSubtotal = 0;

            foreach ($order->orderItems as $item) {
                $status = strtolower(trim($item->product->organic_status ?? ''));
                $itemTotal = $item->price * $item->quantity;

                if ($status == 'organik') {
                    $organicSubtotal += $itemTotal;
                } elseif ($status == 'non-organik') {
                    $nonOrganicSubtotal += $itemTotal;
                }
            }

            return view('checkout.order-confirmation', compact('order', 'organicSubtotal', 'nonOrganicSubtotal'));
        }
        return redirect()->route('cart.index');
    }

    /**
     * Display order status tracking page
     */
    public function order_status(Order $order)
    {
        // Eager load order items with products
        $order->load('orderItems.product', 'transaction');

        return view('checkout.order-status', compact('order'));
    }
}
