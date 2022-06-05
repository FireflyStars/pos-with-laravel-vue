<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ouvrage extends Model
{
    protected $table = 'ouvrages';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
