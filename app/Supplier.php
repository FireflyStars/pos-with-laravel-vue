<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    protected $table = 'suppliers';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
