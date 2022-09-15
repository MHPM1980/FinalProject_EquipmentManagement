<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Entity extends Model
{
    use HasApiTokens, SoftDeletes;

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    protected $fillable = [
        'name',
        'address',
        'phone_number',
    ];

    protected static function booted()
    {
        static::deleting(function ($entity) {
            if ($entity->warehouses()->exists()) {
                throw new \Exception('Related entities found');
            }
        });
    }
}
