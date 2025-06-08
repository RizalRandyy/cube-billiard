<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingGroup;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    public function index()
    {
        $bookings = Booking::whereHas('bookingGroup', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('welcome', compact('bookings'));
    }

    public function gallery()
    {
        return view('user.gallery');
    }
}
