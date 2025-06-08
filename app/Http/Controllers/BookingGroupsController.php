<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
        })->with('poolTable')->get(); // pastikan eager loading relasi

        $total_table_price = 0;

        foreach ($bookings as $booking) {
            if ($booking->poolTable) {
                $total_table_price += $booking->poolTable->price_per_hour;
            }
        }

        return view('user.booking_groups.index', compact('bookings', 'total_table_price'));
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
