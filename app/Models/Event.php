<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function orders(){
        return $this->belongsToMany(Order::class);
    }
}
