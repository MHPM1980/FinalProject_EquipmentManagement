<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

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
