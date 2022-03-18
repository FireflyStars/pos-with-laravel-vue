<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
