<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Reservation extends Model
{
    use HasApiTokens, SoftDeletes;

    protected $fillable = [
        'product_id',
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
