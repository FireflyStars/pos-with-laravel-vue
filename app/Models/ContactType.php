<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactType extends Model
{
    protected $table = 'contact_type';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}