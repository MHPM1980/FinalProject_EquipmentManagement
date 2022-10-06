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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
