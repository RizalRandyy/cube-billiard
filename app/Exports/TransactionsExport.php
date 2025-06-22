<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $period;
    protected $startDate;
    protected $endDate;

    protected $transactions;

    public function __construct($period, $startDate = null, $endDate = null)
    {
        $this->period = $period;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Transaction::with('bookingGroup.user');

        if ($this->period === 'day') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($this->period === 'month') {
            $query->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year);
        } elseif ($this->period === 'custom' && $this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $this->transactions = $query->get();

        // Mapping data agar hasil export rapi
        return $this->transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'name' => optional($transaction->bookingGroup->user)->name,
                'payment_status' => $transaction->payment_status,
                'midtrans_order_id' => $transaction->midtrans_order_id,
                'payment_type' => $transaction->payment_type,
                'amount' => $transaction->amount,
                'paid_at' => $transaction->paid_at
                    ? \Carbon\Carbon::parse($transaction->paid_at)->format('d-m-Y')
                    : '-',
                'is_latest' => $transaction->is_latest == 1 ? 'ya' : 'tidak',
            ];
        });
    }


    public function headings(): array
    {
        // Judul kolom ditaruh di baris ke-2 karena baris pertama untuk "DATA PEMBAYARAN"
        return ['Id', 'Nama', 'Status Pembayaran', 'Id Midtrans Order', 'Metode Pembayaran', 'Total Pembayaran', 'Tanggal Pembayaran', 'Pembayaran Terakhir'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling untuk judul kolom di baris ke-2
            1 => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EFEEEE'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Sisipkan 2 baris di atas heading
                $sheet->insertNewRowBefore(1, 2);

                // Judul besar
                $sheet->setCellValue('A1', 'LAPORAN PEMBAYARAN');

                // Dapatkan kolom terakhir untuk merge
                $highestColumn = $sheet->getHighestColumn();

                // Merge dan style judul
                $sheet->mergeCells("A1:{$highestColumn}1");
                $sheet->getStyle("A1")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '89D8FC'],
                    ],
                ]);

                // Format periode secara dinamis
                $periodeText = 'Periode: ';
                if ($this->period === 'day') {
                    $periodeText .= now()->translatedFormat('d F Y'); // contoh: 05 April 2025
                } elseif ($this->period === 'month') {
                    $periodeText .= now()->translatedFormat('F Y'); // contoh: April 2025
                } elseif ($this->period === 'custom' && $this->startDate && $this->endDate) {
                    $start = \Carbon\Carbon::parse($this->startDate)->translatedFormat('d F Y');
                    $end = \Carbon\Carbon::parse($this->endDate)->translatedFormat('d F Y');
                    $periodeText .= "{$start} - {$end}";
                } else {
                    $periodeText .= 'Semua Data';
                }

                // Set dan style periode
                $sheet->setCellValue('A2', $periodeText);
                $sheet->mergeCells("A2:{$highestColumn}2");
                $sheet->getStyle("A2")->applyFromArray([
                    'font' => ['italic' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFF287'],
                    ],
                ]);

                // Set border
                $highestRow = $sheet->getHighestRow();
                $cellRange = 'A2:' . $highestColumn . $highestRow;

                $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );

                $rupiahFormat = '"Rp." #,##0.00;"Rp. -" #,##0.00';

                $sheet->getStyle('F4:F' . $highestRow)
                    ->getNumberFormat()
                    ->setFormatCode($rupiahFormat);

                // Auto size tiap kolom
                foreach (range('A', $highestColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
