<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Order;
use App\Models\page_builder;
use Illuminate\Http\Request;

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
        return response()->json(
            $order->load([
                'customer',
                'customer.addresses',
                'orderZones',
                'orderZones.gedDetails',
                'orderZones.gedDetails.gedCategory',
                'orderZones.gedDetails.orderOuvrage',
                'orderZones.orderZoneComments',
                'events',
            ])
        );
    }


}
