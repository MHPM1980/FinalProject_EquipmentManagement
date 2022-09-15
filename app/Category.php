<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Category extends Model
{
    use HasApiTokens, SoftDeletes;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function booted()
    {
        static::deleting(function ($category) {
            if ($category->products()->exists()) {
                throw new \Exception('Related products found');
            }
        });
    }
}
