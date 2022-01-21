<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GedDetail extends Model
{
    use HasFactory;

    public function gedCategory(){
        return $this->belongsTo(GedCategory::class);
    }

    public function ged(){
        return $this->belongsTo(Ged::class);
    }
    
    public function orderZone(){
        return $this->belongsTo(OrderZone::class);
    }
    public function orderOuvrage(){
        return $this->belongsTo(OrderOuvrage::class);
    }

    public function save(array $options = []){

        if($this->id==''){
            $user=Auth::user();
            $uuid = DB::select('select UUID() AS uuid')[0]->uuid;//unique name for file
            $this->file=$uuid; 
            if($this->user_id=='')
            $this->user_id=$user->id;
        }

        return parent::save($options);
    }
}
