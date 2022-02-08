<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GedDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

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
      
            if($this->user_id=='')
            $this->user_id=$user->id;
        }

        return parent::save($options);
    }
}
