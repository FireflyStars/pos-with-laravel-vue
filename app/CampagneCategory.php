<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampagneCategory extends Model
{

    use SoftDeletes;
	protected $dates = ['deleted_at'];


    protected $table = 'campagne_category';
	protected $guarded = ['id'];
}
