<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    protected $fillable = [
        'entity_id',
        'name',
        'description',
        'address',
        'phone_number',
    ];
}
