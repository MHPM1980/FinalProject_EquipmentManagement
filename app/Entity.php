<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;

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
