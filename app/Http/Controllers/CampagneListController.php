<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\TableFiltersController;

class CampagneListController extends Controller
{
    
    public function index(Request $request) 
    {
        
        $campagne = Campagne::query()->where('campagnes.affiliate_id', $request->user()->affiliate->id);

        $data = $this->get_data($campagne, $request);
        
        $data = $data->skip($request->skip ?? 0)
        ->take($request->take ?? 15)
        ->get();

        return response()->json($data);

    }


    public function user_campagnes(Request $request) 
    {

        $campagne = Campagne::query()->where('campagnes.user_id', $request->user()->id);

        $data = $this->get_data($campagne, $request);
        
        $data = $data->skip($request->skip ?? 0)
        ->take($request->take ?? 15)
        ->get();

        return response()->json($data);

    }

    private function get_data($campagne, Request $request) 
    {

        $data = $campagne->join('users', 'users.id', '=', 'campagnes.user_id')
        ->select(
            'campagnes.id', 
            'campagnes.name',
            'users.name as username',
            'type',
            'status',
            'nb',
            'montant', 
            DB::raw('DATE_FORMAT(datelancement, "%Y-%m-%d") as datelancement'), 
            DB::raw('DATE_FORMAT(campagnes.created_at, "%Y-%m-%d") as created_at'),
        );

        $data = (new TableFiltersController)->sorts($request, $data, 'campagnes.id');
        $data = (new TableFiltersController)->filters($request, $data);

        return $data;

    }

}
