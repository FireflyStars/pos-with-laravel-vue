<?php

namespace App\Models;

use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class campagne_card extends Model
{
    use HasFactory;
    protected $table = 'campagne_card';


    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function affiliate() 
    {
        return $this->belongsTo(Affiliate::class);
    }


}
