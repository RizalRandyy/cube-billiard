<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoolTableModel extends Model
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
}
