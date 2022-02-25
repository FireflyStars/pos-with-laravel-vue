<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

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

    public function getCibleEmails(Request $request){
        $cibles = @json_decode($request->post('cibles'));
        $old_campagne_ids = @json_decode($request->post('old_campagne_ids'));

        $all_emails = [];
        $all_emails_old = [];
        $all_emails_new = [];
        $arr = [];
        $grouped_by_selection = [];
        $count_by_selection = [];
        $all_contacts = [];

        if(!empty($cibles)){
            foreach($cibles as $k=>$v){
                $parts = explode("_",$v);

                $data = $parts[1]-1;
                $data2 = $parts[0];

                switch ($data) {
                    case 0:
                        $data_test = 'Cible' ;
                        break;
                     case 1:
                        $data_test = 'Contact' ;
                        break;
                         case 2:
                        $data_test = 'Suspect' ;
                        break;
                         case 3:
                        $data_test = 'Prospect' ;
                        break;
                         case 4:
                        $data_test = 'Client' ;
                        break;
                         case 5:
                        $data_test = 'Fiche obsolete' ;
                        break;
                         case 6:
                        $data_test = 'Fiche doublons' ;
                        break;
                    default:
                        $data_test ='';
                        break;
                }


                $contacts = LcdtFrontController::getContactsByNafSelection($data_test,$data2);

                $emails = [];
                if(!empty($contacts)){

                    foreach($contacts as $k=>$v){
                        $emails[] = $v->email;
                        $all_contacts[] = $v;
                    }

                    $all_emails_new = array_merge($all_emails_new,$emails);
                }
            }


            if(!empty($all_contacts)){
                foreach($all_contacts as $k=>$v){
                    $grouped_by_selection[$v->selection][] = $v;
                }

                foreach($grouped_by_selection as $k=>$v){
                    $count_by_selection[$k] = count($v);
                }
            }
        };


        if(!empty($old_campagne_ids)){
            $cibles = DB::table('campagne_cible')->whereIn('campagne_id',$old_campagne_ids)->get()->toArray();

            foreach($cibles as $k=>$v){
                if(!in_array($v->email,$all_emails_old)){
                    array_push($all_emails_old,$v->email);
                }
            }
        }

        $all_emails = array_merge($all_emails_new,$all_emails_old);

        $filtered_all_mails = [];

        foreach($all_emails as $k=>$v){
            if(!in_array($v,$filtered_all_mails)){
                array_push($filtered_all_mails,$v);
            }
        }


        return response()->json([
            'new_emails'=>$all_emails_new,
            'old_emails'=>$all_emails_old,
            'count'=>count($filtered_all_mails),
            'grouped_by_selection'=>$count_by_selection,
        ]);
    }


    public static function getContactsByNafSelection($type,$selection){
        return DB::table('contacts')
            ->select('contacts.*','customer_naf.selection')
            ->join('customers','customers.id','=','contacts.customer_id')
            ->join('customer_naf','customer_naf.code','=','customers.naf')
            ->where('contacts.type' ,"=", $type)
            ->where('customer_naf.selection' ,"=", $selection)
            ->get()->toArray();

    }
}
