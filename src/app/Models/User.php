<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'photo', 'designation', 
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

    // public function stats()
    // {
    //     return $this->hasOne('App\Stats');
    // }

    public function adcode()
    {
        return $this->hasOne('App\Adcode', 'user_id');
    }

    public function websites()
    {
        return $this->hasMany('App\Domains', 'user_id', 'id')->where('status', 1)->with('codes');
    }

}
