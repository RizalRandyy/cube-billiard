<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BookingGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::whereHas('bookingGroup', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('poolTable')->get(); // tambahkan bookingGroup agar bisa digunakan nanti

        $latestBooking = Booking::withTrashed()->whereHas('bookingGroup', function ($query) {
            $query->where('user_id', auth()->id());
        })->latest()->with('bookingGroup')->get(); // tambahkan bookingGroup agar bisa digunakan untuk mengambil transaksi

        $total_table_price = 0;

        foreach ($bookings as $booking) {
            if ($booking->poolTable) {
                $total_table_price += $booking->poolTable->price_per_hour;
            }
        }

        // Ambil salah satu bookingGroup untuk mengambil transaksi terkait (hanya 1 transaksi)
        $bookingGroup = $latestBooking->first()->bookingGroup ?? null;

        $transaction = null;
        if ($bookingGroup) {
            $transaction = Transaction::where('booking_group_id', $bookingGroup->id)->latest()->first();
        }

        // dd($transaction);

        return view('user.booking_groups.index', compact('bookings', 'total_table_price', 'transaction'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
