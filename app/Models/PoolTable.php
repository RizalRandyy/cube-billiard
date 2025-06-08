<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

class PoolTable extends Model
{
    protected $table = 'pool_tables';
    protected $fillable = [
        'name',
        'price_per_hour',
        'status',
        'x',
        'y',
        'orientation'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
