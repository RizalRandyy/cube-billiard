<?php

namespace App\Http\Controllers;

use App\Models\Booking;

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
}
