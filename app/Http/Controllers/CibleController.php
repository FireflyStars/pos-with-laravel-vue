<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use App\Models\CampagneCible;
use App\Models\Customer;
use App\Models\CustomerNaf;
use App\Models\CustomerStatut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CibleController extends Controller
{
    public function initialload(Request $request,$campagne_category_id){
        $user=Auth::user();
        $customer_naf=DB::table('customer_naf')->select(['id','selection','name','code'])->groupBy('selection')->orderBy('id')->get();
        $lastcampagnes=Campagne::where('affiliate_id','=',$user->affiliate_id)->orderBy('id', 'desc')->take(5)->get(['id','name','created_at'])->sortKeysDesc();
        foreach($lastcampagnes as &$campagne){
            $date=Carbon::createFromTimeString($campagne->created_at);
            $campagne->formated_date=$date->format('d/m/Y');
            $campagne->contacts=CampagneCible::where('campagne_id','=',$campagne->id)
            ->get(['id as campagne_cible_id','contact_id','email','customer_id','company as Company','name','firstname','phone','address1','address2','postcode','city','created_at']);
            unset($campagne->created_at);
        }
    
        $lastCmp=array();
        foreach($lastcampagnes as $last){
            $lastCmp[]=$last;
        }
        return response()->json(
            array(
                'customer_statut'=>CustomerStatut::all()->makeHidden(['created_at','updated_at','deleted_at']),
                'naf'=>$customer_naf,
                'campagne_list'=>$lastCmp,
            )
        );

    }

    public function loadcible(Request $request,$naf_selection,$customer_statut_id){

        $user=Auth::user();
    
        $nafcodes=CustomerNaf::where('selection','=',$naf_selection)->get(['code'])->pluck('code')->toArray();
      
        $customer_statut=CustomerStatut::find($customer_statut_id);
        $contacts=DB::table('contacts')
        ->select(['contacts.id','contacts.email','contacts.gender','customers.id as customer_id','customers.Company','contacts.name','contacts.firstname','contacts.mobile','contacts.telephone','customers.siteweb','addresses.address1','addresses.address2','addresses.postcode','addresses.city'])
        ->join('customers',function ($join) use ($user,$nafcodes){
            $join->on('contacts.customer_id', '=', 'customers.id')
            ->where('customers.affiliate_id','=',$user->affiliate_id)
            ->whereIn('customers.naf',$nafcodes)
            ->whereNull('customers.deleted_at')
            ->where('customers.active','=',1);
        })
        ->leftJoin('addresses','contacts.address_id','=','addresses.id')
        ->where('contacts.type','=',$customer_statut->name)
        ->get();

        return response()->json($contacts);

    }
}
