<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvragePrestation extends Model
{
    protected $table = 'ouvrage_prestation';
	//
	
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
