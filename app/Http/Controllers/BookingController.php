<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingGroup;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validated = $request->validate([
            'pool_table_id' => 'required|exists:pool_tables,id',
            'booking_date' => 'required|date',
            'selected_time' => 'required|array',
            'selected_time.*' => 'required|string',
        ]);

        // Cari BookingGroup yang belum dibayar
        $bookingGroup = BookingGroup::where('user_id', auth()->id())
            ->whereDoesntHave('transactions', function ($q) {
                $q->where('payment_status', 'paid');
            })
            ->latest()
            ->first();

        // Jika tidak ada, buat baru
        if (!$bookingGroup) {
            $bookingGroup = BookingGroup::create([
                'user_id' => auth()->id()
            ]);
        }

        // Loop semua jam yang dipilih
        foreach ($validated['selected_time'] as $timeRange) {
            // Misalnya "09:00 - 10:00"
            $parts = explode(' - ', $timeRange);

            if (count($parts) !== 2) {
                continue; // Lewatkan jika format salah
            }

            $startTime = trim($parts[0]);
            $endTime = trim($parts[1]);

            // Buat satu Booking
            Booking::create([
                'pool_table_id' => $validated['pool_table_id'],
                'booking_group_id' => $bookingGroup->id, // Gunakan ID dari group yang tadi
                'booking_date' => $validated['booking_date'],
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => 'pending',
            ]);
        }


        return redirect()->back()->with('success', 'Booking berhasil dibuat!');
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
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('/')->with('success', 'Booking berhasil dihapus');
    }
}
