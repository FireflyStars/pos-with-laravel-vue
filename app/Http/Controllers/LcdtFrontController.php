<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LcdtFrontController extends Controller{

    public function getAffiliateDetail(Request $request){
        $user = Auth::user();

        return response()->json([
            'user'=>$user,
            'affiliate'=>$user->affiliate,
        ]);
    }

    public function getCampagneCategory(Request $request){
        $id = $request->post('id');

        $campagne = DB::table('campagne_category')->where('id',$id)->first();

        return response()->json([
            'campagne'=>$campagne,
        ]);
    }
}
