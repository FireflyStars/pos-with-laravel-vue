<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerStatut extends Model
{
    protected $table = 'customer_statut';
	//
	
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
