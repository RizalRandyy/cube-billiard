<?php

namespace App\Models;

use App\Models\PoolTable;
use App\Models\BookingGroup;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'pool_table_id',
        'booking_group_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
    ];

    public function bookingGroup()
    {
        return $this->belongsTo(BookingGroup::class);
    }

    public function poolTable()
    {
        return $this->belongsTo(PoolTable::class);
    }
}
