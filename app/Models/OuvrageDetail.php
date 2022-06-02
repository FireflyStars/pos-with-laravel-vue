<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvrageDetail extends Model
{
    protected $table = 'ouvrage_detail';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}