<?php

namespace App\Models;

use App\Models\Campagne;
use App\Models\campagne_card_detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampagneCategory extends Model
{
    use HasFactory;

    protected $table="campagne_category";

    protected $appends = ['imageTemplateUrl'];

    public function cardDetail() 
    {
        return $this->hasOne(campagne_card_detail::class);
    }

    public function campagne() 
    {
        return $this->hasMany(Campagne::class);
    }

    public function getImageTemplateUrlAttribute() 
    {
        return rtrim(config('app.url'), '/') . Storage::url($this->imagetemplate);
    }

}
