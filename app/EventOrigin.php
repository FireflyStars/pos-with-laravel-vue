<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventOrigin extends Model
{
    protected $table = 'event_origins';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}
