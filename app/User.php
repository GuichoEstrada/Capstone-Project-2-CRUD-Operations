<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    function books() {
        return $this->belongsToMany('App\Book')
        ->withPivot(['quantity', 'status', 'id']);
    }
}
