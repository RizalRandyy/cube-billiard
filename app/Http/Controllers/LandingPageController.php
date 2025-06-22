<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use App\Models\BookingGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{

    public function index()
    {
        $bookings = Booking::whereHas('bookingGroup', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $unavailableBookings = Booking::withTrashed()
            ->whereHas('bookingGroup.transactions', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->get(['pool_table_id', 'booking_date', 'start_time', 'end_time']); // Ambil kolom

        return view('landing-page', compact('bookings', 'unavailableBookings'));
    }

    public function gallery()
    {
        return view('user.gallery');
    }

    public function paymentHistory()
    {
        return view('user.transactions.index');
    }

    public function getPaymentHistory(Request $request)
    {
        $query = Transaction::with('bookingGroup.user')
            ->whereHas('bookingGroup', function ($q) {
                $q->where('user_id', Auth::id());
            });

        if ($request->has('search')) {
            $query->whereHas('bookingGroup.user', function ($sub) use ($request) {
                $sub->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereDate('paid_at', 'like', '%' .  $request->search . '%');
            });
        }

        $transactions = $query->paginate(5);

        return response()->json($transactions);
    }

    public function show(Transaction $transaction)
    {
        $bookingGroupId = $transaction->booking_group_id;

        $bookingGroup = BookingGroup::where('id', $bookingGroupId)->first();

        return view('user.transactions.show', compact('bookingGroupId', 'bookingGroup', 'transaction'));
    }
}
