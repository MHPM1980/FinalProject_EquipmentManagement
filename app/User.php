<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function cost()
    {
        return $this->belongsTo(Cost::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id','cost_id','name','phone_number', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected static function booted()
    {
        static::deleting(function ($user) {
            if ($user->reservations()->exists()) {
                throw new \Exception('Related reservations found');
            }
        });
    }
}
