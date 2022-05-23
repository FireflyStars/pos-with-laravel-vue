<?php

namespace App\Models;

use App\Models\Campagne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampagneCible extends Model
{
    use HasFactory;
    protected $table="campagne_cible";

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function contact(){
        return $this->belongsTo(Contact::class);
    }

    public function campagne() 
    {
        return $this->belongsTo(Campagne::class);
    }

}
