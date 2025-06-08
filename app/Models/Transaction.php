<?php

namespace App\Models;

use App\Models\BookingGroup;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'booking_group_id',
        'payment_status',
        'midtrans_order_id',
        'payment_type',
        'amount',
        'paid_at',
        'is_latest',
        'snap_token',
    ];

    public function bookingGroup()
    {
        return $this->belongsTo(BookingGroup::class);
    }
}
