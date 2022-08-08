<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $fillable = [
        'category_id',
        'warehouse_id',
        'name',
        'description',
        'serial_number',
        'image',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
