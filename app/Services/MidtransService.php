<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransService
{
  public function createSnapToken(Transaction $transaction)
  {
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production', false); // lebih fleksibel
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Kalau sudah punya snap_token, pakai ulang
    if (!empty($transaction->snap_token)) {
      return $transaction->snap_token;
    }

    $params = [
      'transaction_details' => [
        'order_id' => $transaction->midtrans_order_id,
        'gross_amount' => $transaction->amount,
      ],
      'customer_details' => [
        'first_name' => $transaction->bookingGroup->user->name,
        'email' => $transaction->bookingGroup->user->email,
      ]
    ];

    $snapToken = Snap::getSnapToken($params);

    // Simpan snap_token ke database
    $transaction->update(['snap_token' => $snapToken]);

    return $snapToken;
  }


// public function handleCallback(Request $request)
//   {
//     try {
//       $notification = new \Midtrans\Notification();

//       $transaction = $notification->transaction_status;
//       $order_id = $notification->order_id;
//       $status = $notification->transaction_status;

//       Log::info("Midtrans callback received", compact('order_id', 'status'));

//       // Lakukan update transaksi kamu berdasarkan $order_id dan $status...

//       return response()->json(['message' => 'Callback handled'], 200);
//     } catch (\Exception $e) {
//       Log::error('Midtrans callback error', ['error' => $e->getMessage()]);
//       return response()->json(['error' => 'Callback failed'], 500);
//     }
//   }
}
