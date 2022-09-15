<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Role extends Model
{
    use HasApiTokens, SoftDeletes;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'name',
    ];

    protected static function booted()
    {
        static::deleting(function ($role) {
            if ($role->users()->exists()) {
                throw new \Exception('Related products found');
            }
        });
    }
}
