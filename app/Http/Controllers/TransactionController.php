<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\BookingGroup;
use Illuminate\Http\Request;
use App\Services\MidtransService;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('admin.transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    public function getTransactions(Request $request)
    {
        $period = $request->query('period');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Transaction::with('bookingGroup.user');

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_group_id', 'like', '%' . $request->search . '%')
                    ->orWhere('payment_status', 'like', '%' . $request->search . '%')
                    ->orWhereDate('paid_at', 'like', '%' .  $request->search . '%')
                    ->orWhereHas('bookingGroup.user', function ($sub) use ($request) {
                        $sub->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($period == 'day') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($period == 'month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($period == 'custom' && $startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $transactions = $query->paginate(5);

        return response()->json($transactions);
    }


    public function initiateTransaction(Request $request)
    {
        // Ambil BookingGroup terbaru milik user
        $bookingGroup = BookingGroup::where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$bookingGroup) {
            return back()->with('error', 'Belum ada booking.');
        }

        $bookings = Booking::whereHas('bookingGroup', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('poolTable')->get(); // pastikan eager loading relasi

        $total_table_price = 0;

        foreach ($bookings as $booking) {
            if ($booking->poolTable) {
                $total_table_price += $booking->poolTable->price_per_hour;
            }
        }

        // Ambil transaksi terakhir yang masih pending
        $transaction = Transaction::where('booking_group_id', $bookingGroup->id)
            ->where('payment_status', 'pending')
            ->latest()
            ->first();

        // Cek apakah transaksi sudah expired dari Midtrans
        if ($transaction) {

            $transaction->update([
                'amount' => $total_table_price,
                'midtrans_order_id' => 'CUBE-' . Str::uuid(),
                'snap_token' => null,
            ]);

            $status = app(MidtransService::class)->checkTransactionStatus($transaction->midtrans_order_id);

            if (in_array($status['transaction_status'], ['expire', 'cancel', 'deny'])) {
                // Tandai transaksi lama tidak aktif
                $transaction->update([
                    'payment_status' => 'failed',
                    'is_latest' => false,
                ]);

                // Set transaksi ke null agar buat baru di bawah
                $transaction = null;
            }
        }

        // Jika belum ada transaksi (baru atau karena yang lama gagal), buat baru
        if (!$transaction) {
            $transaction = Transaction::create([
                'booking_group_id' => $bookingGroup->id,
                'payment_status' => 'pending',
                'midtrans_order_id' => 'CUBE-' . Str::uuid(),
                'payment_type' => '-',
                'amount' => $total_table_price,
                'is_latest' => true,
            ]);
        }

        // Dapatkan Snap Token (otomatis buat & simpan jika belum ada)
        $snapToken = app(MidtransService::class)->createSnapToken($transaction);

        return response()->json(['snapToken' => $snapToken, 'transaction' => $transaction]);
    }

    public function updateTransaction(Request $request, $id)
    {
        // Cari transaksi
        $transaction = Transaction::findOrFail($id);

        // Update data
        if ($request->input('transaction_status') === 'settlement') {
            $transaction->update([
                'payment_status' => $request->input('payment_status'),
                'payment_type' => $request->input('payment_type'),
                'paid_at' => now(),
            ]);

            // Ambil semua bookings berdasarkan booking_group_id dari transaction
            $bookings = Booking::where('booking_group_id', $transaction->booking_group_id)->get();

            foreach ($bookings as $booking) {
                $booking->update([
                    'status' => 'paid',
                ]);

                $booking->delete();
            }
        }

        return response()->json(['message' => 'Transaksi berhasil diupdate'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $bookingGroupId = $transaction->booking_group_id;

        $bookingGroup = BookingGroup::where('id', $bookingGroupId)->first();

        return view('admin.transactions.show', compact('bookingGroupId', 'bookingGroup', 'transaction'));
    }

    public function getBookedTablesUser(Request $request, $booking_group_id)
    {
        $query = Booking::where('booking_group_id', $booking_group_id)->whereIn('status', ['pending', 'paid'])->with('poolTable');

        if ($request->has('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('booking_date', 'like', '%' . $search . '%')
                    ->orWhereHas('poolTable', function ($sub) use ($search) {
                        $sub->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // dd($query);
        $bookings = $query->withTrashed()->paginate(5);

        return response()->json($bookings);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function handleCallback(Request $request)
    {
        // return response()->json(['OK', 200]);
        // $orderId = $request->input('order_id');
        // $transactionStatus = $request->input('transaction_status');
        // $paymentType = $request->input('payment_type');

        // // Cari transaksi berdasarkan order_id, karena Midtrans kirim order_id
        // $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        // if (!$transaction) {
        //     \Log::warning("Transaction not found for order ID: {$orderId}");
        //     return response()->json(['error' => 'Transaction not found'], 404);
        // }

        // // Update hanya jika status transaksi settlement
        // if ($transactionStatus === 'settlement') {
        //     $transaction->update([
        //         'payment_status' => 'paid',
        //         'payment_type' => $paymentType,
        //         'paid_at' => now(),
        //     ]);

        //     // Ambil semua bookings berdasarkan booking_group_id dari transaction
        //     $bookings = Booking::where('booking_group_id', $transaction->booking_group_id)->get();

        //     $total_table_price = 0;

        //     foreach ($bookings as $booking) {
        //         $booking->update([
        //             'status' => 'paid',
        //         ]);

        //         $booking->delete();
        //     }
        // }

        // \Log::info('Midtrans callback received', compact('orderId', 'transactionStatus', 'paymentType'));

        // return response()->json(['message' => 'Callback handled'], 200);
    }
}
