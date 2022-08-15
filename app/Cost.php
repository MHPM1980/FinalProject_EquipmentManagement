<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'designation','description',
    ];
}
