<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PDO;

class Ged extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function gedDetails(){
        return $this->hasMany(GedDetail::class);
    }
    
}
