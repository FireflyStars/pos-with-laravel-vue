<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campagne extends Model
{
    //
    use SoftDeletes;
    
    public function affiliate(){
        return $this->belongsTo(Affiliate::class);
    }

    public function campagneCategory(){
        return $this->belongsTo(CampagneCategory::class);
    }
}