<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use Illuminate\Http\Request;
use App\Http\Resources\CampagnesListResource;

class CampagneListController extends Controller
{
    
    public function index(Request $request) 
    {
        
        $campagne = Campagne::query();

        $data = $campagne->where('user_id', $request->user()->id);
        
        if($request->has('sortby') && count($request->sortby)) 
        {
            $soryby = $request->sortby[0];
            $data = $data->orderBy($soryby['id'], $soryby['orderby']);
        }

        if($request->has('column_filters') && count($request->column_filters)) 
        {
            // foreach($request->column_filters as $filter) 
            // {
            //     $data->where($filter['id'], )
            // }
        }

        $data = $data->skip($request->skip ?? 0)
        ->take($request->take ?? 15)
        ->get();

        return response()->json(
            campagnesListResource::collection($data)
        );

    }


}
