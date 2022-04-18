<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\page_builder;
use Illuminate\Http\Request;
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

        session()->put('pages', $pages);
        session()->put('order_id', $request->order_id);

        $pdf->loadView(
            'page-multiple', [
                'pages'     => $pages,
                'templates' => page_builder::templates(),
                'svgs'      => page_builder::get_svgs(),
                'builder'   => (new page_builder),
                'affiliate' => $this->get_order_affiliate($request)
            ]
        );

        return $pdf->download('page.pdf');
        
    }

    public function store_get(Request $request) 
    {

        $pages = json_decode($request->pages);

        $pdf = App::make('dompdf.wrapper');

        $pdf->setOptions([
            'dpi'                  => 150,
            'defaultFont'          => 'sans-serif',  
            'enable_php'           => true,
            'isRemoteEnabled'      => true, 
            'isHtml5ParserEnabled' => true, 
        ]);

        $affiliate =  optional(Order::find(session('order_id')))->affiliate;

        return view(
            'page-multiple', [
                'pages'     => session('pages'),//$pages,
                'templates' => page_builder::templates(),
                'svgs'      => page_builder::get_svgs(),
                'builder'   => (new page_builder),
                'affiliate' => $affiliate,//$this->get_order_affiliate($request)
            ]
        );

        $pdf->loadView(
            'page-multiple', [
                'pages'     => $pages,
                'templates' => page_builder::templates(),
                'svgs'      => page_builder::get_svgs(),
                'builder'   => (new page_builder),
                'affiliate' => $this->get_order_affiliate($request)
            ]
        );

        return $pdf->download('page.pdf');
        
    }

    public function get_order_affiliate(Request $request) 
    {
        return $request->has('order_id') && !is_null($request->order_id) 
        ? optional(Order::find($request->order_id))->affiliate 
        : null;
    }

    public function get_page_order(Order $order) 
    {
        return response()->json(
            new reportsResource($order)
        );
    }

    public function get_page_templates() 
    {
        return response()->json(page_builder::templates());   
    }


}
