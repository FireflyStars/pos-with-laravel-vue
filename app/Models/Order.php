<?php

namespace App\Models;

use App\Traits\LcdtLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Tools;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    use Tools;
    use LcdtLog;


    public function events(){
        return $this->belongsToMany(Event::class);
    }

    public function orderZones(){
        return $this->hasMany(OrderZone::class);
    }

    public function state(){
        return $this->belongsTo(OrderState::class);
    }

    public function updateState($order_state_id,$user_id=null){
    
        if($user_id==null)
        $user_id=Auth::user()->id;
        $previous_order_state_id=$this->order_state_id;
        if($this->order_state_id!=$order_state_id){
            $this->order_state_id=$order_state_id;
            $orderHistory=new OrderHistory();
            $orderHistory->order_state_id=$order_state_id;
            $orderHistory->user_id=$user_id;
            $orderHistory->order_id=$this->id;
            $this->save();
            $orderHistory->save();
       
            $this->l('ORDER STATE UPDATED','Order #'.$this->id.': status changed '.($previous_order_state_id==null?'':'from '.$previous_order_state_id).' to '.$order_state_id,$user_id);
        }
    }

    public function generateReference(){
        $this->reference= strtoupper($this->passwdGen(10,'NO_NUMERIC'));
    }
}
