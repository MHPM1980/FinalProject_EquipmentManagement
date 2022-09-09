<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use SoftDeletes;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'designation','description',
    ];
}
