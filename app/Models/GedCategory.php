<?php

namespace App\Models;

use App\Models\GedDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GedCategory extends Model
{
    use HasFactory;

    public function getDetail() 
    {
        return $this->hasMany(GedDetail::class);
    }

}
