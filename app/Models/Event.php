<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use function PHPUnit\Framework\throwException;

class Event extends Model
{
    use HasFactory;


    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function address(){
        return $this->belongsTo(Address::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function save(array $options = []){
        
        $user=Auth::user();
        if($user)
        $this->affiliate_id=$user->affiliate->id;

        return  parent::save($options);
      }

     public function updateStatus($status_id){
         $eventHistory= new EventHistory();
         $user=Auth::user();
         if($user==null)
         throw new Exception('Cannot update status without user authentication.');
         //$eventHistory->
     } 
}
