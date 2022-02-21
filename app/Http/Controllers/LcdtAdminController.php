<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LcdtAdminController extends Controller{
    public function getTextPos(Request $request){
        $id = $request->post('id');

        $cc = DB::table('campagne_category')->where('id',$id)->first();

        return response()->json([
            'cc'=>$cc,
            'post'=>$request->all(),
        ]);

    }


    public function updateTextPos(Request $request){
        $id = $request->post('id_cc');

        $POST = $request->all();
        $arr = [];

        for($i=1;$i<=3;$i++){
            $arr['xfield'.$i] = (isset($POST['textpos_'.$i.'_x'])?$POST['textpos_'.$i.'_x']:0);
            $arr['yfield'.$i] = (isset($POST['textpos_'.$i.'_y'])?$POST['textpos_'.$i.'_y']:0);
        }

        $updated = DB::table('campagne_category')->where('id',$id)->update($arr);


        return response()->json([
            //'post'=>$request->all(),
            'arr'=>$arr,
            'updated'=>$updated,
        ]);
    }

}
