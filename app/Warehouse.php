<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone_number',
    ];
}
