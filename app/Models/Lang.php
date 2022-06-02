<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lang extends Model
{
    protected $table = 'lang';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}