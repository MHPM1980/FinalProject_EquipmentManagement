<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    protected $fillable = [
        'name',
        'address',
        'phone_number',
    ];
}
