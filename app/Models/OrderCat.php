<?php

namespace App\Models;

use App\Models\OrderZone;
use App\Models\OrderOuvrage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderCat extends Model
{
    use HasFactory;

    protected $table="order_cat";

    public function orderOuvrage() 
    {
        return $this->hasMany(OrderOuvrage::class);
    }

    public function orderZones() 
    {
        return $this->belongsTo(OrderZone::class);
    }

}
