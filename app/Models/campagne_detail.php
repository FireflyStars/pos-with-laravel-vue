<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class campagne_detail extends Model
{
    use HasFactory;
    protected $table = 'campagne_detail';
    protected $guarded = ['id'];
}
