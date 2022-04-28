<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //
    public function geListInfoForCustomer(){
        $status = DB::table('customer_statut')->select('id as value', 'name as display')->orderBy('name')->get();
        $types  = DB::table('customer_categories')->select('id as value', 'name as display')->orderBy('name')->get();
        $nafs   = DB::table('customer_naf')->select('code as value', 'name as display')->orderBy('name')->get();
        $taxs   = DB::table('taxes')->select('taux as value', 'name as display')->orderBy('name')->get();
        $addressTypes   = DB::table('address_type')->select('id as value', 'name as display')->orderBy('name')->get();
        return response()->json([
            'status'    => $status,
            'types'      => $types,
            'nafs'      => $nafs,
            'taxs'      => $taxs,
            'addressTypes'      => $addressTypes,
        ]);
    }
}
