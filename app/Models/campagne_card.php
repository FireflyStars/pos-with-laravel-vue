<?php

namespace App\Models;

use App\Models\User;
use App\Models\Campagne;
use App\Models\Affiliate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class campagne_card extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = 'campagne_card';
    protected $guarded = ['id'];


    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function affiliate() 
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function campagne() 
    {
        return $this->hasOne(Campagne::class, 'campagne_card_id');
    }


}
