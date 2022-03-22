<?php

namespace App\Models;

use App\Models\OrderCat;
use App\Models\GedDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderOuvrage extends Model
{
    use HasFactory;

    public function orderCategory()
    {
        return $this->belongsTo(OrderCat::class, 'order_cat_id');
    }

    public function gedDetail() 
    {
        return $this->hasMany(GedDetail::class);
    }
}
