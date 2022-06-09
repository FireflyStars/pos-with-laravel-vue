<?php

namespace App\Models;

use App\Models\Tax;
use App\Models\Campagne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class campagne_detail extends Model
{
    use HasFactory;
    protected $table = 'campagne_detail';
    protected $guarded = ['id'];

    public function campagne() 
    {
        return $this->belongsTo(Campagne::class);
    }

    public function tax() 
    {
        return $this->belongsTo(Tax::class, 'taxe_id');
    }

    
}
