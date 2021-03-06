<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
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

    public function user() 
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function template() 
    {
        return $this->belongsTo(Template::class, 'template_id');
    }

}
