<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerNaf extends Model
{
    protected $table = 'customer_naf';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
