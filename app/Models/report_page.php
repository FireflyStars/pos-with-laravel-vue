<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class report_page extends Model
{

    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'pages'      => 'array',
        'page_files' => 'array'
    ];

    public function order() 
    {
        return $this->belongsTo(Order::class);
    }

}
