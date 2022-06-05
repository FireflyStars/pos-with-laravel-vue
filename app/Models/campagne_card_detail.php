<?php

namespace App\Models;

use App\Models\Tax;
use App\Models\Campagne;
use App\Models\CampagneCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class campagne_card_detail extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'campagne_card_detail';
    protected $guarded = ['id'];

    public function campagneCategory() 
    {
        return $this->belongsTo(CampagneCategory::class, 'campagne_category_id');
    }

    public function tax() 
    {
        return $this->belongsTo(Tax::class, 'taxe_id');
    }

}
