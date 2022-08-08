<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost_Center extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected $fillable = [
        'designation','description',
    ];
}
