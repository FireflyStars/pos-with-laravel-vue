<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public function contacts(){
        return $this->hasMany(Contact::class);
    }

}
