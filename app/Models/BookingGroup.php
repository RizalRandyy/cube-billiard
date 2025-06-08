<?php

namespace App\Models;

use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;

class BookingGroup extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
