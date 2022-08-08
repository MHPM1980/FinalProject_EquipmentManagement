<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'warehouse_id',
        'registry_date',
        'start_date',
        'end_date',
        'delivered',
        'returned',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
