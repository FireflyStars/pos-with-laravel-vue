<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moyenacce extends Model
{
    protected $table = 'moyenacces';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
