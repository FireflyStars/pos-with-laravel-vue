<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use Illuminate\Http\Request;

class CampagneListController extends Controller
{
    
    public function index(Request $request) 
    {
        $data = $request->user()->campagnes->load('affiliate')->skip(0)->take(10);
        return response()->json($data);
    }


}
