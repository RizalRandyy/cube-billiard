<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\PoolTable;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_table = PoolTable::count();

        $total_transaction_today = Transaction::where('payment_status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $earnings_today = Transaction::where('payment_status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');

        $total_earnings_month = Transaction::where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $today = Carbon::today();
        $start_hour = 9;
        $end_hour = 21;
        $slot_per_table = $end_hour - $start_hour; // 12 jam operasional
        $total_available_slots = $total_table * $slot_per_table;

        // Hitung jumlah booking 1 jam hari ini 
        $total_booked_slots = Booking::withTrashed()
            ->whereDate('booking_date', $today)
            ->where('status', 'paid')
            ->count();

        // Hitung persentase slot yang terisi
        $percent_filled_today = $total_available_slots > 0
            ? round(($total_booked_slots / $total_available_slots) * 100, 2)
            : 0;

        // Total booking hari ini
        $total_booking_today = $total_booked_slots;

        // Data booking 7 hari terakhir
        $bookings_last_7_days = collect([]);
        foreach (range(6, 0) as $i) {
            $date = Carbon::today()->subDays($i)->toDateString();

            $count = Booking::withTrashed()->where('booking_date', $date)
                ->where('status', 'paid')
                ->count();

            $bookings_last_7_days->push([
                'date' => Carbon::parse($date)->format('d M'),
                'count' => $count,
            ]);
        }

        // Donut Chart
        $earnings_yesterday = Transaction::where('payment_status', 'paid')
            ->whereDate('created_at', Carbon::yesterday())
            ->sum('amount');

        $donut_chart_data = [
            'today' => $earnings_today,
            'yesterday' => $earnings_yesterday,
        ];

        return view('admin.dashboard', compact(
            'total_table',
            'total_transaction_today',
            'earnings_today',
            'total_booking_today',
            'total_earnings_month',
            'total_booked_slots',
            'percent_filled_today',
            'bookings_last_7_days',
            'donut_chart_data'
        ));
    }
}
