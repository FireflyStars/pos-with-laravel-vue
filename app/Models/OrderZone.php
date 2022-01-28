<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderZone extends Model
{
    use HasFactory;

    public function gedDetails()
    {
       return $this->hasMany(GedDetail::class);
    }

}
