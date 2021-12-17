<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable =[
        'Name'
    ];

    public function customers(){
        return $this->hasMany(Customer::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function events(){
        return $this->hasMany(Event::class);
    }
}
