<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerCategory extends Model
{
    protected $table = 'customer_categories';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
