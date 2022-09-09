<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    protected $fillable = [
        'image',
        'name',
        'description',
        'serial_number',
        'category_id',
        'warehouse_id',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
