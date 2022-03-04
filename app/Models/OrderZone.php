<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderZone extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function gedDetails()
    {
       return $this->hasMany(GedDetail::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function orderCategories(){
        return $this->hasMany(OrderCat::class);
    }
    public function orderZoneComments(){
        return $this->hasMany(OrderZoneComment::class);
   }
}
