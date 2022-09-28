<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Reservation extends Model
{
    use HasApiTokens, SoftDeletes;

    protected $fillable = [
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
        return $this->hasOne(Product::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
