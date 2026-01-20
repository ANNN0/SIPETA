<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Handle Midtrans notification/webhook
     */
    public function notification(Request $request)
    {
        try {
            $notification = new Notification();

            $transaction_status = $notification->transaction_status;
            $payment_type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud_status = $notification->fraud_status;

            // Find transaction
            $transaction = Transaction::where('payment_id', $order_id)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Update payment data
            $transaction->payment_data = json_encode($notification->getResponse());
            $transaction->payment_type = $payment_type;

            // Handle transaction status
            if ($transaction_status == 'capture') {
                if ($payment_type == 'credit_card') {
                    if ($fraud_status == 'accept') {
                        $transaction->status = 'approved';
                        $transaction->order->status = 'ordered';
                    }
                }
            } elseif ($transaction_status == 'settlement') {
                $transaction->status = 'approved';
                $transaction->order->status = 'ordered';
            } elseif ($transaction_status == 'pending') {
                $transaction->status = 'pending';
            } elseif ($transaction_status == 'deny') {
                $transaction->status = 'declined';
            } elseif ($transaction_status == 'expire') {
                $transaction->status = 'declined';
            } elseif ($transaction_status == 'cancel') {
                $transaction->status = 'declined';
            }

            $transaction->save();
            $transaction->order->save();

            return response()->json(['message' => 'Notification handled'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle payment finish (redirect after payment)
     */
    public function finish(Request $request)
    {
        $order_id = $request->order_id;
        $transaction = Transaction::where('order_id', $order_id)->first();

        if ($transaction) {
            // Fallback: If payment_type is still empty (webhook hasn't arrived), try to fetch from Midtrans API
            if (empty($transaction->payment_type)) {
                try {
                    // Use the payment_id (Midtrans transaction ID) not the order_id
                    $midtrans_order_id = $transaction->payment_id;
                    $status = \Midtrans\Transaction::status($midtrans_order_id);

                    if ($status) {
                        // Midtrans status can return an object or array depending on the environment
                        $p_type = is_object($status) ? ($status->payment_type ?? null) : ($status['payment_type'] ?? null);
                        $t_status = is_object($status) ? ($status->transaction_status ?? '') : ($status['transaction_status'] ?? '');

                        if ($p_type) {
                            $transaction->payment_type = $p_type;
                            $transaction->payment_data = json_encode($status);

                            // Also update status if settlement/capture
                            if ($t_status == 'settlement' || $t_status == 'capture') {
                                $transaction->status = 'approved';
                                $transaction->order->status = 'ordered';
                                $transaction->order->save();
                            }

                            $transaction->save();
                        }
                    }
                } catch (\Exception $e) {
                    // Log error but don't break the flow
                    Log::error('Failed to fetch Midtrans status for payment_id: ' . $transaction->payment_id . ' - ' . $e->getMessage());
                }
            }

            // Redirect to order status tracking page
            return redirect()->route('order.status', ['order' => $transaction->order_id])
                ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
        }

        return redirect()->route('home.index')->with('error', 'Transaksi tidak ditemukan.');
    }

    /**
     * Handle unfinish payment
     */
    public function unfinish(Request $request)
    {
        return redirect()->route('cart.checkout')->with('warning', 'Pembayaran belum selesai. Silakan coba lagi.');
    }

    /**
     * Handle payment error
     */
    public function error(Request $request)
    {
        return redirect()->route('cart.checkout')->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
    }
}
