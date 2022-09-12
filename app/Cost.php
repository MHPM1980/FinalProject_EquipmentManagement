<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Cost extends Model
{
    use HasApiTokens, SoftDeletes;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'designation','description',
    ];
}
