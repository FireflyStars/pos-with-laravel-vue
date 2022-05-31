<?php

namespace App\Models;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Affiliate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
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

    public function moyenacces(){
        return $this->hasMany(Moyenacces::class);
    }

    public function tax() 
    {
        return $this->belongsTo(Tax::class, 'taxe_id');
    }

}
