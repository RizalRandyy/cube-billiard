<?php

namespace App\Models;

use App\Models\PoolTable;
use App\Models\BookingGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
