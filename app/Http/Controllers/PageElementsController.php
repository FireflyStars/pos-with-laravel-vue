<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\page_builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Resources\reportsResource;

class PageElementsController extends Controller
{

    public function store(Request $request) 
    {

        $pages = json_decode($request->pages);

        $pdf = App::make('dompdf.wrapper');

        $pdf->setOptions([
            'enable_php'           => true,
            'isRemoteEnabled'      => true, 
            'isHtml5ParserEnabled' => true, 
        ]);

        $pdf->loadView(
            'page-multiple', [
                'pages'     => $pages,
                'templates' => page_builder::templates(),
                'svgs'      => page_builder::get_svgs(),
                'builder'   => (new page_builder),
            ]
        );

        return $pdf->download('page.pdf');
        
    }

    public function get_page_order(Order $order) 
    {
        DB::enableQueryLog();
        return response()->json(
            new reportsResource($order)
        );
    }

    public function get_page_templates() 
    {
        return response()->json(page_builder::templates());   
    }


}
