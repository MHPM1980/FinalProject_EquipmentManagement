<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Product extends Model
{
    use HasApiTokens, SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    protected $fillable = [
        'image',
        'name',
        'description',
        'serial_number',
        'category_id',
        'warehouse_id',
        'status',
    ];


    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->reservations()->exists()) {
                throw new \Exception('Related reservations found');
            }
        });
    }
}
