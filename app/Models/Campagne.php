<?php

namespace App\Models;

use App\Models\campagne_card;
use App\Models\CampagneCible;
use App\Models\campagne_detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campagne extends Model
{
    protected $guarded = ['id'];

    use SoftDeletes;
    
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function campagneCategory()
    {
        return $this->belongsTo(CampagneCategory::class);
    }

    public function campagneCible() 
    {
        return $this->hasMany(CampagneCible::class);
    }

    public function card() 
    {
        return $this->belongsTo(campagne_card::class);
    }

    public function details() 
    {
        return $this->hasMany(campagne_detail::class);
    }

}