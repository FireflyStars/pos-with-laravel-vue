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
}
