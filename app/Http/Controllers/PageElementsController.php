<?php

namespace App\Http\Controllers;

use App\Http\Resources\reportsResource;
use PDF;
use App\Models\Order;
use App\Models\page_builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PageElementsController extends Controller
{
    
    public function store(Request $request) 
    {
        $pages = json_decode($request->pages);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        ->loadView(
            'page-multiple', [
                'pages'  => $pages,
                'templates' => page_builder::templates(),
                'svgs'      => page_builder::get_svgs(),
                'builder'   => (new page_builder)
            ]
        );

        return $pdf->download('page.pdf');
    }

    public function get_page_order(Order $order) 
    {
        // \DB::enableQueryLog(); 
        // $order_data = $order->load([
            // 'customer',
            // 'customer.addresses',
            // 'orderZones',
            // 'orderZones.orderOuvrage',
            // 'orderZones.orderOuvrage.orderCategory',
            // 'orderZones.moyenacces',
            // 'orderZones.orderZoneComments',
            // 'orderZones.gedDetails',
            // 'orderZones.gedDetails.gedCategory',
        // ]);

        // dd(\DB::getQueryLog());

        // return $order_data;
        
        return response()->json(
            new reportsResource($order)
        );
    }


}
