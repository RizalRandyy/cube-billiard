<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportTransactionsExcel(Request $request)
    {
        $period = $request->period ?? '';
        $startDate = $request->start_date ?? '';
        $endDate = $request->end_date ?? '';

        // Tentukan nama file berdasarkan filter
        if ($period === 'day') {
            $suffix = 'hari_' . now()->format('dmY');
        } elseif ($period === 'month') {
            $suffix = 'bulan_' . now()->format('mY');
        } elseif ($period === 'custom' && $startDate && $endDate) {
            $suffix = 'tanggal_' . \Carbon\Carbon::parse($startDate)->format('dmY') . '_sampai_' . \Carbon\Carbon::parse($endDate)->format('dmY');
        } else {
            $suffix = 'semua_' . now()->format('dmY');
        }

        $filename = 'laporan_pembayaran_' . $suffix . '.xlsx';

        return Excel::download(new TransactionsExport($period, $startDate, $endDate), $filename);
    }
}
