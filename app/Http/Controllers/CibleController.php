<?php

namespace App\Http\Controllers;

use App\Models\Campagne;
use App\Models\CampagneCategory;
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
            ->get(['id as campagne_cible_id','address_id','contact_id as id','email','customer_id','company','name','firstname','phone as mobile','address1','address2','postcode','city','industrie','statut','created_at']);
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
                'campagne_category'=>CampagneCategory::find($campagne_category_id)
            )
        );

    }

    public function loadcible(Request $request,$naf_selection,$customer_statut_id){

        $user=Auth::user();
    
        $nafcodes=CustomerNaf::where('selection','=',$naf_selection)->get(['code'])->pluck('code')->toArray();
      
        $customer_statut=CustomerStatut::find($customer_statut_id);
        $contacts=DB::table('contacts')
        ->select(['contacts.id','contacts.email','contacts.gender','customers.id as customer_id','contacts.address_id','customers.company','contacts.name','contacts.firstname','contacts.mobile','contacts.telephone','customers.siteweb','addresses.address1','addresses.address2','addresses.postcode','addresses.city'])
        ->join('customers',function ($join) use ($user,$nafcodes){
            $join->on('contacts.customer_id', '=', 'customers.id')
            ->where('customers.affiliate_id','=',$user->affiliate_id)
            ->whereIn('customers.naf',$nafcodes)
            ->whereNull('customers.deleted_at')
            ->where('customers.active','=',1);
        })
        ->leftJoin('addresses','contacts.address_id','=','addresses.id')
        ->where('contacts.type','=',$customer_statut->name)
        ->whereNull('contacts.deleted_at')
        ->get();
        foreach($contacts as &$contact){
            $contact->industrie=$naf_selection;
            $contact->statut=$customer_statut->name;
        }
        return response()->json($contacts);

    }

    public function createcampagne(Request $request)
    {
        $user = Auth::user();
      

        $campagne_category_id = $request->post('campagne_category_id');
        $contacts=$request->post('contacts');
        $campagne_category = CampagneCategory::find($campagne_category_id);
     


       
        $name=$campagne_category->name.'-';
                                            
        if($campagne_category==null)
        return response('Campagne category id '.$campagne_category_id.' not found',509);
       
        $campagne_id =  DB::table('campagnes')->insertGetId
        ([
            'datefinvalidatiom' => date("Y-m-d"),
            'datelancement' => date("Y-m-d"),
            'user_id' => $user->id,
            'affiliate_id' => $user->affiliate->id,
            'email_template_id' => intval($campagne_category->idapi),
            'campagne_category_id'=>$campagne_category->id,
            'address' => $user->affiliate->reponseaddress,
            'expediteur' =>  $user->affiliate->name,
            'phone' =>  $user->affiliate->telephone,
            'lettreaccompagnement' => null,
            'type' => $campagne_category->type,
            'run' =>  date("Y-m-d"),
            'montant' => count($contacts)*$campagne_category->price,
            'nb' => count($contacts),
            'name' => $name,
            'created_at' =>date("Y-m-d"),
            'updated_at' =>date("Y-m-d"),
        ]);
        DB::table('campagnes')->where('id','=',$campagne_id)->update([
            'name'=>$name.$campagne_id.'_'.date('Ymd')
        ]);
   
       


              foreach($contacts as $contact)

                    DB::table('campagne_cible')->insert
                    ([
                        'affiliate_id' => $user->affiliate->id,
                        'cible_statut_id' => 1,
                        'address_id' => 1,
                        'customer_id' => $contact['customer_id'],
                        'contact_id' =>$contact['id'],
                        'campagne_old_id' => 0,
                        'campagne_id' => $campagne_id,
                        'industrie' =>  $contact['industrie'],
                        'statut' => $contact['statut'],
                        'phone' => $contact['mobile'],
                        'email' => $contact['email'],
                        'created_at' => date("Y-m-d"),
                        'updated_at' => date("Y-m-d"),
                    ]);


        return response()->json([
                'campagne_id' => $campagne_id
            ]);

    }
}
