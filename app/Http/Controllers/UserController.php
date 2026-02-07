<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function index()
    {
        return view('user.user');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->with(['orderItems.product', 'orderItems.unit', 'transaction', 'returnRequest'])
            ->orderBy('created_at', 'DESC')
            ->paginate(5);
        return view('user.orders.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();

        if ($order) {
            $orderItems = OrderItem::where('order_id', $order->id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order->id)->first();
            return view('user.orders.order-details', compact('order', 'orderItems', 'transaction'));
        } else {
            return redirect()->route('login');
        }
    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('success', 'Order canceled successfully');
    }

    public function order_delete($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->firstOrFail();

        if ($order->status == 'canceled' || $order->status == 'delivered') {
            $order->delete();
            return back()->with('success', 'Pesanan berhasil dihapus dari riwayat.');
        }

        return back()->with('error', 'Hanya pesanan yang sudah dibatalkan atau terkirim yang dapat dihapus.');
    }

    /**
     * Get invoice data for AJAX modal
     */
    public function getInvoiceData($order_id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $order_id)
            ->with(['orderItems.product', 'orderItems.unit', 'transaction'])
            ->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Format payment method label
        $paymentMethod = 'N/A';
        if ($order->transaction) {
            if ($order->transaction->mode == 'midtrans' && $order->transaction->payment_type) {
                $pType = $order->transaction->payment_type;
                $pData = json_decode($order->transaction->payment_data, true);

                if ($pType == 'bank_transfer' && isset($pData['va_numbers'][0]['bank'])) {
                    $paymentMethod = strtoupper($pData['va_numbers'][0]['bank']) . ' Virtual Account';
                } elseif ($pType == 'bank_transfer' && isset($pData['permata_va_number'])) {
                    $paymentMethod = 'Permata Virtual Account';
                } elseif ($pType == 'qris') {
                    $paymentMethod = 'QRIS';
                } elseif ($pType == 'gopay') {
                    $paymentMethod = 'GoPay';
                } elseif ($pType == 'shopeepay') {
                    $paymentMethod = 'ShopeePay';
                } elseif ($pType == 'cstore') {
                    $paymentMethod = strtoupper($pData['store'] ?? 'Mini Market');
                } elseif ($pType == 'echannel') {
                    $paymentMethod = 'Mandiri Bill Payment';
                } else {
                    $paymentMethod = str_replace('_', ' ', ucwords($pType));
                }
            } else {
                $paymentMethod = strtoupper($order->transaction->mode);
            }
        }

        // Format order items
        $items = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->product->name,
                'image' => $item->product->image,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'unit_symbol' => $item->unit_symbol ?? ($item->unit->symbol ?? 'pcs'),
                'subtotal' => $item->price * $item->quantity,
            ];
        });

        return response()->json([
            'order_id' => $order->id,
            'order_id_formatted' => 'SPT' . $order->created_at->format('ymd') . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'order_date' => $order->created_at->translatedFormat('d F Y, H:i'),
            'status' => $order->status,
            'items' => $items,
            'shipping' => [
                'name' => $order->name,
                'phone' => $order->phone,
                'address' => $order->address,
                'city' => $order->city,
                'state' => $order->state,
                'zip' => $order->zip,
            ],
            'payment' => [
                'method' => $paymentMethod,
                'status' => $order->transaction->status ?? 'pending',
            ],
            'summary' => [
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'discount' => $order->discount,
                'total' => $order->total,
            ],
        ]);
    }

    /**
     * Download invoice as PDF
     */
    public function downloadInvoicePdf($order_id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $order_id)
            ->with(['orderItems.product', 'orderItems.unit', 'transaction'])
            ->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        // Format payment method label
        $paymentMethod = 'N/A';
        if ($order->transaction) {
            if ($order->transaction->mode == 'midtrans' && $order->transaction->payment_type) {
                $pType = $order->transaction->payment_type;
                $pData = json_decode($order->transaction->payment_data, true);

                if ($pType == 'bank_transfer' && isset($pData['va_numbers'][0]['bank'])) {
                    $paymentMethod = strtoupper($pData['va_numbers'][0]['bank']) . ' Virtual Account';
                } elseif ($pType == 'bank_transfer' && isset($pData['permata_va_number'])) {
                    $paymentMethod = 'Permata Virtual Account';
                } elseif ($pType == 'qris') {
                    $paymentMethod = 'QRIS';
                } elseif ($pType == 'gopay') {
                    $paymentMethod = 'GoPay';
                } elseif ($pType == 'shopeepay') {
                    $paymentMethod = 'ShopeePay';
                } elseif ($pType == 'cstore') {
                    $paymentMethod = strtoupper($pData['store'] ?? 'Mini Market');
                } elseif ($pType == 'echannel') {
                    $paymentMethod = 'Mandiri Bill Payment';
                } else {
                    $paymentMethod = str_replace('_', ' ', ucwords($pType));
                }
            } else {
                $paymentMethod = strtoupper($order->transaction->mode);
            }
        }

        // Format order items
        $items = $order->orderItems->map(function ($item) {
            return [
                'name' => $item->product->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'unit_symbol' => $item->unit_symbol ?? ($item->unit->symbol ?? 'pcs'),
                'subtotal' => $item->price * $item->quantity,
            ];
        })->toArray();

        $data = [
            'order_id_formatted' => 'SPT' . $order->created_at->format('ymd') . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'order_date' => $order->created_at->translatedFormat('d F Y, H:i'),
            'items' => $items,
            'shipping' => [
                'name' => $order->name,
                'phone' => $order->phone,
                'address' => $order->address,
                'city' => $order->city,
                'state' => $order->state,
                'zip' => $order->zip,
            ],
            'payment' => [
                'method' => $paymentMethod,
                'status' => $order->transaction->status ?? 'pending',
            ],
            'summary' => [
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'discount' => $order->discount,
                'total' => $order->total,
            ],
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', $data);
        $pdf->setPaper('A5', 'portrait');

        $filename = 'Invoice-' . $data['order_id_formatted'] . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Show return request form
     */
    public function returnRequest($order_id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $order_id)
            ->where('status', 'delivered') // Only allow return for delivered orders
            ->with(['orderItems.product', 'orderItems.unit'])
            ->first();

        if (!$order) {
            return redirect()->route('user.orders')->with('error', 'Pesanan tidak ditemukan atau tidak dapat dikembalikan.');
        }

        $orderItems = $order->orderItems;
        $order_id_formatted = 'SPT' . $order->created_at->format('ymd') . str_pad($order->id, 4, '0', STR_PAD_LEFT);

        return view('user.orders.return-request', compact('order', 'orderItems', 'order_id_formatted'));
    }

    /**
     * Submit return request
     */
    public function submitReturnRequest(Request $request, $order_id)
    {
        $request->validate([
            'reason' => 'required|string|in:damaged,not_as_described,wrong_item,changed_mind,other',
            'description' => 'required|string|max:500',
            'solution' => 'required|string|in:refund,exchange',
            'photos.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:10240', // 10MB
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'sender_address' => 'required|string',
            'sender_city' => 'required|string|max:100',
            'sender_state' => 'required|string|max:100',
            'sender_zip' => 'required|string|max:10',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->where('id', $order_id)
            ->where('status', 'delivered')
            ->first();

        if (!$order) {
            return redirect()->route('user.orders')->with('error', 'Pesanan tidak ditemukan atau tidak dapat dikembalikan.');
        }

        // Check if return request already exists
        $existingRequest = \App\Models\ReturnRequest::where('order_id', $order_id)->first();
        if ($existingRequest) {
            return redirect()->route('user.orders')->with('error', 'Pengajuan pengembalian untuk pesanan ini sudah ada.');
        }

        // Handle file uploads
        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/returns'), $filename);
                $photos[] = 'uploads/returns/' . $filename;
            }
        }

        // Create return request
        \App\Models\ReturnRequest::create([
            'order_id' => $order_id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'description' => $request->description,
            'solution' => $request->solution,
            'photos' => $photos,
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'sender_address' => $request->sender_address,
            'sender_city' => $request->sender_city,
            'sender_state' => $request->sender_state,
            'sender_zip' => $request->sender_zip,
            'status' => 'pending',
        ]);

        return redirect()->route('user.orders')->with('success', 'Pengajuan pengembalian berhasil dikirim. Mohon tunggu konfirmasi dari admin.');
    }

    public function address()
    {
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('user.address.addresses', compact('addresses'));
    }

    public function address_add()
    {
        return view('user.address.add-addresses');
    }

    public function address_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'zip' => 'required|string|max:10',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
        ]);

        $address = new Address();
        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = $request->country ?? 'Indonesia';
        $address->type = $request->type ?? 'home';

        $existingAddresses = Address::where('user_id', Auth::user()->id)->count();
        if ($existingAddresses == 0 || $request->has('isdefault')) {
            Address::where('user_id', Auth::user()->id)->update(['isdefault' => false]);
            $address->isdefault = true;
        }

        $address->save();

        $address->save();

        if ($request->origin == 'checkout') {
            return redirect()->route('cart.checkout')->with('success', 'Address added successfully');
        }

        return redirect()->route('user.addresses')->with('success', 'Address added successfully');
    }

    public function address_edit($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        return view('user.address.edit-addreses', compact('address'));
    }

    public function address_update(Request $request)
    {
        $request->validate([
            'address_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'zip' => 'required|string|max:10',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'locality' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
        ]);

        $address = Address::where('user_id', Auth::user()->id)->where('id', $request->address_id)->firstOrFail();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = $request->country ?? 'Indonesia';
        $address->type = $request->type ?? 'home';

        if ($request->has('isdefault')) {
            Address::where('user_id', Auth::user()->id)->update(['isdefault' => false]);
            $address->isdefault = true;
        }

        $address->save();

        return redirect()->route('user.addresses')->with('success', 'Address updated successfully');
    }

    public function address_delete($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        $address->delete();

        return redirect()->route('user.addresses')->with('success', 'Address deleted successfully');
    }

    public function account_update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = Carbon::now()->timestamp . '.' . $image->extension();
            $publicId = pathinfo($file_name, PATHINFO_FILENAME);

            $result = Cloudinary::uploadApi()->upload($image->getRealPath(), [
                'folder' => 'users',
                'public_id' => $publicId
            ]);

            $user->image = $result['secure_url'];
        }

        $user->save();

        return redirect()->route('user.account.details')->with('success', 'Account updated successfully');
    }

    public function account_settings()
    {
        $user = Auth::user();
        return view('user.account.settings-account', compact('user'));
    }

    public function account_settings_update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('user.account.settings')->with('success', 'Password updated successfully');
    }

    public function account_details()
    {
        $user = Auth::user();
        return view('user.account.details-account', compact('user'));
    }

    public function wishlist()
    {
        $items = Cart::instance('wishlist')->content();

        $productIds = $items->pluck('id');
        $products = \App\Models\Product::whereIn('id', $productIds)->get();

        return view('user.whistlist.wishlist', compact('items', 'products'));
    }
}
