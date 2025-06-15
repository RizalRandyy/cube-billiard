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
      ],
    ];

    $snapToken = Snap::getSnapToken($params);

    // Simpan snap_token ke database
    $transaction->update(['snap_token' => $snapToken]);

    return $snapToken;
  }

  public function checkTransactionStatus($orderId)
  {
    try {
      // Atur config Midtrans
      Config::$serverKey = config('midtrans.server_key');
      Config::$isProduction = config('midtrans.is_production', false);
      Config::$isSanitized = true;
      Config::$is3ds = true;

      $status = \Midtrans\Transaction::status($orderId);

      return [
        'transaction_status' => $status->transaction_status,
        'status_message' => $status->status_message,
      ];
    } catch (\Exception $e) {
      \Log::error("Midtrans status check failed: " . $e->getMessage());
      return [
        'transaction_status' => 'error',
        'status_message' => 'Could not check status',
      ];
    }
  }
}
