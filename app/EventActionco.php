<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventActionco extends Model
{
    protected $table = 'event_actioncos';
	//
	use SoftDeletes;
	protected $dates = ['deleted_at'];
}