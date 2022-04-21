<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevisController extends Controller
{
    //

    public function loadList(Request $request){

        $column_filters=$request->post('column_filters');
        $skip=$request->post('skip');
        $take=$request->post('take');
  

        $orderList=DB::table('orders')
        ->select(['orders.*',
        'events.id as evnt',
        'users.name as responsable', 
        DB::raw("CONCAT(customers.company,' ',customers.firstname,' ',customers.name) as customer"),
        DB::raw("CONCAT(contacts.firstname,' ',contacts.name,'<br/>',contacts.mobile) as contact"),
        DB::raw("CONCAT(addresses.address1, IF(addresses.address2<>'', '<br/>',''),addresses.address2,'<br/>',addresses.postcode,' ',addresses.city) as address")])
          ->join('customers',function($join){
            $join->on('customers.id','=','orders.customer_id');
        })->join('events',function($join){
            $join->on('events.order_id','=','orders.id');
        })->join('contacts',function($join){
            $join->on('contacts.id','=','events.contact_id');
        })->leftJoin('addresses',function($join){
            $join->on('addresses.id','=','events.address_id')
            ->where('addresses.address_type_id','=',2);
        })->leftJoin('users',function($join){
            $join->on('users.id','=','orders.responsable_id');
        });

        //column filters
        if($column_filters!=null)
        foreach($column_filters as $column_filter){
            if(isset($column_filter['having'])&&$column_filter['having']==true){
                $orderList=$orderList->having($column_filter['id'],'LIKE','%'.$column_filter['word'].'%');
            }else{
                $orderList=$orderList->where((isset($column_filter['table'])?$column_filter['table'].'.':'').$column_filter['id'],'LIKE','%'.$column_filter['word'].'%');
            }
        }

        $orderList=$orderList->groupBy('orders.id')->skip($skip)->take($take)->get();
        return response()->json($orderList);
    }

    /**
     * Get Ged categories
     * 
     */

    public function getGedCategories(){
        $categories = DB::table('ged_categories')->select('id', 'name', )->get();
        foreach ($categories as $key => $item) {
            $item->items = [];
        }
        return response()->json($categories->groupBy('id'));
    }
}
