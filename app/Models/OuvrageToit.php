<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OuvrageToit extends Model
{
    protected $table = 'ouvrage_toit';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}