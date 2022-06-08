<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\TemplateFormattedFiles;
use App\Http\Resources\ReportsCollectionResource;

class ReportsController extends Controller
{
    use TemplateFormattedFiles;
    
    public function index(Request $request) 
    {

        $affiliate_id = $request->user()->affiliate->id;

        $orders = Order::query()->where('affiliate_id', $affiliate_id);

        if($request->has('sortby') && count($request->sortby)) 
        {
            $sortby = $request->sortby[0];
            $orders = $orders->orderBy($sortby['id'], $sortby['orderby']);
        }
        
        $orders = $orders
                ->skip($request->skip ?? 0)
                ->take($request->take ?? 15);

        try {
            return ReportsCollectionResource::collection(
                $orders->get()
            );
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function show(Order $order) 
    {
        return response()->json(
            new ReportsCollectionResource($order)
        );
    }
    
    public function store(Request $request) 
    {
        $page_files = $this->get_page_files($request);
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;

        $order = Order::find($request->order_id);

        $report = $order->report()->create([
            'template_id'  => $request->template_id, 
            'affiliate_id' => optional(Auth::user())->id,
            'pages'        => $pages,
            'page_files'   => $page_files,
        ]);  
        
        return response()->json($report, 201);    

    }

    public function update(Order $order, Request $request) 
    {
        
        $pages = gettype($request->pages) == 'string' ? json_decode($request->pages, true) : $request->pages;
        $page_files = $this->get_page_files($request);

        $order->report()->update([
            'pages'      => $pages,
            'page_files' => $page_files 
        ]);

        return response()->json($order->report, 201); 

    }
}
