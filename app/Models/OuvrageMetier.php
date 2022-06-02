<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvrageMetier extends Model
{
    protected $table = 'ouvrage_metier';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}