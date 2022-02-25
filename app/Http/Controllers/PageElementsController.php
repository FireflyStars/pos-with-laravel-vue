<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;

class PageElementsController extends Controller
{
    
    public function store(Request $request) 
    {
        $elements = json_decode($request->elements);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        ->loadView('page', ['elements' => $elements]);
        return $pdf->download('page.pdf');
    }

}
