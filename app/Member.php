<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends \Illuminate\Foundation\Auth\User
{
    //
    protected $fillable = [
        'username', 'tel', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
