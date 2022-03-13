<?php

namespace App\Models;

use App\Models\Moyenacces;
use App\Models\OrderOuvrage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderZone extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function gedDetails()
    {
       return $this->hasMany(GedDetail::class);
    }

    public function moyenacces() 
    {
        return $this->belongsTo(Moyenacces::class);
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
    public function orderOuvrage() 
    {
        return $this->hasMany(OrderOuvrage::class);
    }
}
