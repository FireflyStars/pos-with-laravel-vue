<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Template extends Model
{

    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pages'      => 'array',
        'page_files' => 'array'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

}
