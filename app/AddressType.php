<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressType extends Model
{
    protected $table = 'address_type';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
