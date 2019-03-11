<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
	use SoftDeletes;

    protected $dates = [
        'deleted_at'
    ];

    function category() {
    return $this->belongsTo('App\Category');
	}

	function users() {
		return $this->belongsToMany('App\User')
		->withPivot(['quantity','status', 'id', 'created_at']);
	}
}
