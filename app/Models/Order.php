<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    public function events(){
        return $this->belongsToMany(Event::class);
    }

    public function zones(){
        return $this->hasMany(OrderZone::class);
    }

    public function state(){
        return $this->belongsTo(OrderState::class);
    }

    public function updateState($order_state_id,$user_id){
        
    }
}
