<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

use App\Models\Affiliate;
use App\Models\CampagneCategory;
use App\Models\CampagneCible;
use App\Models\CampagneCibleStatuts;
use App\Models\CustomerStatut;
use App\Models\CustomerNaf;
use App\Models\Campagnes;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\User;
// use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\PDF;
use Mail;
use App\Mail\MyDemoMail;

class CompagneController extends Controller
{
     private  $pdf;
    /**
     * Get campagnes for a specefic compagne
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampagnes()
    {

        $campagnes = Campagnes::get();

        if($campagnes) {
            return response()->json([
                'campagnes' => $campagnes,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get compagnes'
            ], 400);
        }

    }

    /**
     * Get compagne cible
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampagneCible()
    {

        $compagnesCible = CompagneCible::get(['id','industrie', 'statut']);
        dd($compagnesCible);
        if($compagnesCible) {
            return response()->json([
                'industrie' => $compagnesCible->industrie,
                'statut'    => $compagnesCible->statut,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get compagnes cibles'
            ], 400);
        }

    }

    /**
     * Get customer Statut / code Naf
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomerStatut()
    {

        $statuts = DB::table('customer_statut')->get();
        $codeNaf = DB::table('customer_naf')->get();
        $contacts = DB::table('contacts')->join('customers','customers.id','=','contacts.customer_id')->get(['email','naf','type']);
        $count = count($contacts);
        foreach ($statuts as $key => $statut) {
            $array_status[]=$statut-> name;
        }

        foreach ($codeNaf as $key => $code) {
            $array_codeNaf[]=$code-> selection;
        }

        if($contacts) {
            return response()->json([
                'customerStatut' => $array_status,
                'codeNaf'        => $array_codeNaf,
                'contacts'  => $contacts,
                'count' => $count,
            ]);
         }else {
            return response()->json([
                'error' => 'error 400 : can\'t get informations from DB'
            ], 400);
        }

    }
    /**
     * Get compagne categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampagneCategory()
    {
        $campagnesCategory = DB::table('campagne_category')->get();
        $data_id = DB::table('campagne_category')->select()->get();

        foreach ($data_id as $key => $data) {
            $array_ids[]=$data->categorie_parent_id;
        }

        foreach ($campagnesCategory as $key => $data) {
            $type[]=$data->type;
        }

        if($campagnesCategory) {
            return response()->json([
                'campagnes' => $campagnesCategory->where('categorie_parent_id','0'),
                'my_ids' => $array_ids,
                'type' => $type,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get compagnes category'
            ], 400);
        }

    }
    /**
     * Get templates
     *
     * @return \Illuminate\Http\JsonResponse
     */
     public function getTemplates($id)
    {
        $mydata = DB::table('campagne_category')->select()->where('categorie_parent_id',"!=", '0')->get(); //get all sous-category
        $campagnesCategory = DB::table('campagne_category')->where('id',"=", $id)->get(); //get data by id
        $template = DB::table('campagne_category')->select()->where('categorie_parent_id',"=", $id)->get(); // get sous-category1

        // return $campagnesCategory;
        $data_id = DB::table('campagne_category')->select()->get();
        foreach ($data_id as $key => $data) {
            $array_ids[]=$data->categorie_parent_id;
        }
        foreach ($template as $key => $data) {
            $template_id[]=$data->id;
        }
        foreach ($campagnesCategory as $key => $data) {
            $type[]=$data->type;
        }

        if($template) {
            return response()->json([
                'campagnesCategory' =>$campagnesCategory,
                'id'=> $id,
                'template' => $template,
                'data_id' => $array_ids,
                'myvar' =>true,
                'type' =>$type,


                // 'template_id' => $template_id
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get templates'
            ], 400);
        }

    }
    /**
     * Get getContentImage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContentImage($id)
    {
        $data = DB::table('campagne_category')->where('id',"=", $id)->get();
        foreach ($data as $key => $dataname) {
            $ss = $dataname->imagetemplate;
        }
        return $ss;
    }
     /**
     * Get SubCategory
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function SubCategory($id)
    {
        $mydata = DB::table('campagne_category')->select()->where('categorie_parent_id',"!=", '0')->get(); //get all sous-category
        $campagnesCategory = DB::table('campagne_category')->where('id',"=", $id)->get(); //get data by id
        $template = DB::table('campagne_category')->select()->where('categorie_parent_id',"=", $id)->get(); // get sous-category1
        foreach ($mydata as $key => $data) {
            $array_ids[]=$data->id;
        }

        foreach ($campagnesCategory as $key => $data) {
            $type[]=$data->type;
        }

        if ( (in_array($id, $array_ids)) && $template) {
            return response()->json([
                'campagnesCategory'=>$campagnesCategory,
                'data' =>$template,
                'mylist'=> $array_ids,
                'id' => $id,
                'myvar' =>true,
                'type' =>$type
            ]);
        }
        else {
            return response()->json([
                'error' => 'error 400 : Sub-Category does not exist'
            ], 400);
        }

    }

     /**
     * Get categories compagne
     *  @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function campagne_id($id)
    {
        $campagnesCategory = DB::table('campagne_category')->where('id',"=", $id)->get();
        if($campagnesCategory) {
            return response()->json([
                'campagnesCategory' =>$campagnesCategory,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get templates'
            ], 400);
        }
    }

     /**
     * Get ciblesum (somme des contacts de chaque selection & type)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ciblesum(Request $request)
    {
        $t= intval($request->data)+1;
       $string= $request->data2.'_'.$t;
        $data2 = $request->data2;
        switch ($request->data) {
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

        $contacts = DB::table('contacts')->select('contacts.*')
        ->join('customers','customers.id','=','contacts.customer_id')
                                        ->join('customer_naf','customer_naf.code','=','customers.naf')
                                        ->where('contacts.type' ,"=", $data_test)
                                        ->where('customer_naf.selection' ,"=", $data2)->get();

        if($contacts){
            $count = $contacts->count();
            return response()->json([
                'contacts'=>$contacts,
                'count' => $count,
                'index' => $string,
            ]);

        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get count'
            ], 400);
        }

    }

    /**
     * Get categories compagne
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datarequest()
    {
        $codes = DB::table('customer_naf')->select('selection')->get();
        $types = DB::table('customer_statut')->get();
        $contacts = DB::table('contacts')->join('customers','customers.id','=','contacts.customer_id')->get(['email','naf','type']);
        foreach ($codes as $key => $code) {
            $array_codes[]=$code->selection;
        }
        foreach ($types as $key => $type) {
            $array_types[]=$type->name;
        }
        foreach ($contacts as $key => $contact) {
            $array_contacts_type[]=$contact->type;
            $array_contacts_code[]=$contact->naf;

        }
        return $contacts;
                 return response()->json([
                'array_codes' => $array_codes,
                'array_types' => $array_types,
                'contcts' => $contacts,
                'type' => $array_contacts_type,
                'code' => $array_contacts_code
            ]);

    }

     /**
     * Get categories compagne
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailReminder(Request $request)
    {
        $user = 'farah-balti@live.com' ;

        Mail::send('welcome', ['user' => $user], function ($m) use ($user) {
            $m->from('farah.balti@esprit.tn', 'Your Application');

            $m->to($user)->subject('Your Reminder!');
        });
    }

     /**
     * Get categories compagne
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function getStatusName() {
        $statuts = DB::table('customer_statut')->get();

        foreach ($statuts as $key => $statut) {
            $array_status[]=$statut-> name;
        }
        return response()->json([
            'array_status' => $array_status,

        ]);
    }

     /**
     * Get cibles compagne
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampagny_Cible()
    {
        $cibles = DB::table('campagne_cible')->get();
        foreach ($cibles as $key => $cible) {
            $array_cibles_indus[]=$cible->industrie;
        }
        foreach ($cibles as $key => $cible) {
            $array_cibles_status[]=$cible->statut;
        }
        $codes = DB::table('customer_naf')->get();
        $types = DB::table('customer_statut')->get();

        foreach ($codes as $key => $code) {
            $array_codes[]=$code->selection;
        }
        foreach ($types as $key => $type) {
            $array_types[]=$type->name;
        }


        for ($i = 0; $i < count($cibles); $i++) {
            if( (in_array($array_types[$i], $array_cibles_status)) && (in_array($array_codes[$i], $array_cibles_indus)) ) {
                return 'exist';
            }else{
                return 'no';
            }
        }

        if($cibles) {
            return response()->json([
                'cibles' =>$cibles,
                'array_cibles_indus' =>$array_cibles_indus,
                'array_cibles_status' =>$array_cibles_status,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get data'
            ], 400);
        }

    }

     /**
     * Get cibles of a specific compagne
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCibleByCampagne($id)
    {
        $cibles = DB::table('campagne_cible')->join('customers','customers.id','=','campagne_cible.customer_id')
                                            ->join('contacts','contacts.customer_id','=','customers.id')
                                            ->where('campagne_cible.campagne_id',"=", $id)->get
                                            ([
                                                'campagne_cible.id',
                                                'campagne_cible.email',
                                                'campagne_cible.phone',
                                                'campagne_cible.postcode',
                                                'campagne_cible.address1',
                                                'campagne_cible.address2',
                                                'campagne_cible.name',
                                                'campagne_cible.firstname',
                                                'campagne_cible.company',
                                                'customers.gender',
                                                'contacts.type',
                                            ]);

        if($cibles) {
            $cmp = DB::table('campagnes')->where('id', $id)
            ->update([
                'nb' =>   $cibles->count()
            ]);
            return response()->json([
                'cibles' => $cibles,
                'count' => $cibles->count(),
                '$cmp' => $cmp
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get data'
            ], 400);
        }
    }

     /**
     * create a new compagne the compagne cible
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function creatCompagne(Request $request)
    {
        $user = Auth::user();
      
        $name = $request->name;
        $campagne_category_id = $request->for_template;


        $campagne_category = CampagneCategory::find($campagne_category_id);
                                            
        if($campagne_category==null)
        return response('Campagne category id '.$campagne_category_id.' not found',509);
       
        $addCompagne =  DB::table('campagnes')->insertGetId
        ([
            'datefinvalidatiom' => date("Y-m-d"),
            'datelancement' => date("Y-m-d"),
            'user_id' => $user->id,
            'affiliate_id' => $user->affiliate->id,
            'email_template_id' => intval($campagne_category->idapi),
            'address' => null,
            'expediteur' => null,
            'phone' => null,
            'lettreaccompagnement' => null,
            'type' => 'EMAIL',
            'run' =>  date("Y-m-d"),
            'montant' => 0,
            'nb' => $request->count,
            'name' => $name,
            'created_at' =>date("Y-m-d"),
            'updated_at' =>date("Y-m-d"),
        ]);

        $GLOBALS = $addCompagne;

        for ($i=0; $i <count($request->data) ; $i++) {

            $type = $request->data[$i]['type'];
            $status = $request->data[$i]['status'];
            switch ($type) {
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
            $contacts = DB::table('contacts')->join('customers','customers.id','=','contacts.customer_id')
                                            ->join('customer_naf','customer_naf.code','=','customers.naf')
                                            ->where('contacts.type' ,"=", $data_test)
                                            ->where('customer_naf.selection' ,"=", $status)->get(
                                                ['contacts.id',
                                                'contacts.customer_id',
                                                'customer_naf.selection',
                                                'contacts.type',
                                                'contacts.mobile',
                                                'contacts.email',

                                            ]);


            if($contacts->count() != 0){

                $contacts->each(function ($item ) {

                    DB::table('campagne_cible')->insert
                    ([
                        'affiliate_id' => 1,
                        'cible_statut_id' => 1,
                        'address_id' => 1,
                        'customer_id' => $item->customer_id,
                        'contact_id' => $item->id,
                        'campagne_old_id' => 0,
                        'campagne_id' => $GLOBALS,
                        'industrie' =>  $item->selection,
                        'statut' => $item->type,
                        'phone' => $item->mobile,
                        'email' => $item->email,
                        'created_at' => date("Y-m-d"),
                        'updated_at' => date("Y-m-d"),
                    ]);

                });

            }else continue;
        }

        $data_old = $request->data_old;
        $test_exist =[];
        for ($i=0; $i < count($data_old); $i++) {
            $contacts_old = DB::table('campagne_cible')->where('campagne_cible.campagne_old_id' ,"=", $data_old[$i])
                                ->get();

            $contacts_old->each(function ($item ) {
                $user_exist = DB::table('campagne_cible')->where('campagne_cible.campagne_id','=',$GLOBALS)
                                                         ->where('campagne_cible.email','=',$item->email)->get();
                    $test_exist[] =$user_exist ;
                    if (!$user_exist) {

                        DB::table('campagne_cible')->insert
                        ([
                            'affiliate_id' => 1,
                            'cible_statut_id' => 1,
                            'address_id' => 1,
                            'customer_id' => $item->customer_id,
                            'contact_id' => $item->contact_id,
                            'campagne_old_id' => 0,
                            'campagne_id' => $GLOBALS,
                            'industrie' =>  $item->industrie,
                            'statut' => $item->statut,
                            'phone' => $item->phone,
                            'email' => $item->email,
                            'created_at' => date("Y-m-d"),
                            'updated_at' => date("Y-m-d"),
                        ]);
                    }

                });
        }
        return response()->json([
                'GLOBALS' => $GLOBALS,
                'test_exist' => $test_exist,
                'categ_id'=> $campagne_category_id,
            ]);

    }

    /**
     * Get compagne cible when returns from segmentations component
     *  @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompgneCibleSelected($id)
    {
        $cibles = DB::table('campagne_cible')->where('campagne_id' ,"=", $id)
                                            ->where('delete_at','=',NULL)
                                            ->groupBy('industrie')
                                            ->groupBy('statut')
                                            ->get(
                                                [
                                                'industrie',
                                                'statut',
                                            ]);

        if($cibles) {
            $array_cible = [];
            $string = '';
            foreach ($cibles as $key => $cible) {
                switch (strtolower($cible->statut)) {
                    case 'cible':
                    $data_test = 1 ;
                    break;
                    case 'contact':
                    $data_test = 2 ;
                    break;
                    case 'suspect':
                    $data_test = 3 ;
                    break;
                    case 'prospect':
                    $data_test = 4 ;
                    break;
                    case 'client':
                    $data_test = 5 ;
                    break;
                    case 'fiche obsolete':
                    $data_test = 6 ;
                    break;
                    case 'fiche doublons':
                    $data_test = 7 ;
                    break;
                }
                $string = [
                    'secteur'=>$cible->industrie,
                    'type'=> $data_test
                ];
                $array_cible[] = $string;
            };
            // get count after updating list from segmentation view
            $count_retourn = DB::table('campagnes')->where('id' ,"=", $id)->get('nb');

            return response()->json([
                'cibles' => $array_cible,
                'count' => $count_retourn,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get templates'
            ], 400);
        }
    }

    /**
     * Get compagne cible when returns from segmentations component
     *  @param  string  $id
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contentform(Request $request, $id)
    {
        // $cmp = DB::table('campagnes')->where('id', $id)->update([
        //         'expediteur' =>  $request->expediteur
        // ]);

        return response()->json([
                'cibles' => $request,

            ]);

    }

    /**
     * Get compagne cible when returns from segmentations component
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCompagneCible(Request $request)
    {
        $cmp = DB::table('campagne_cible')->where('id', $request->id)
        ->where('campagne_id', intval($request->campagne_id))
        ->update([
                'delete_at' =>  date("Y-m-d"),
        ]);

        $cible = DB::table('campagne_cible')->where('campagne_id',"=", $request->campagne_id)
                                                ->where('delete_at',"=", NULL)->get();
        $cmp = DB::table('campagnes')->where('id', intval($request->campagne_id))
        ->update([
            'nb' =>   $cible->count()
        ]);

        return response()->json([
            'cibles' => $cible->count(),
        ]);

    }

    /**
     * Get compagne cible when returns from segmentations component
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertCompagneCible(Request $request)
    {
        $cmp = DB::table('campagne_cible')->where('id',  $request->id)
        ->where('campagne_id', intval($request->campagne_id))
        ->update([
                'delete_at' =>  NULL,
        ]);
        $cible = DB::table('campagne_cible')->where('campagne_id',"=", $request->campagne_id)
                                                ->where('delete_at',"=", NULL)->get();
        $cmp = DB::table('campagnes')->where('id', intval($request->campagne_id))
        ->update([
            'nb' =>   $cible->count()
        ]);

        return response()->json([
            'cibles' => $cible->count(),
        ]);


    }

    /**
     * getCourrier
     * @param  String  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourrier()
    {
        $Courrier = DB::table('campagnes')->where('type', "=",'COURRIER')->where('name', "=",'Flyer')->get();
        $Courrier_lettre = DB::table('campagnes')->where('type', "=",'COURRIER')->where('name', "=",'lettre accompagnement')->get();
        $Courrier_autre = DB::table('campagnes')->where('type', "=",'COURRIER')->where('name', "!=",'Flyer')->where('name', "!=",'lettre accompagnement')->get();

        return response()->json([
            'data' => $Courrier,
            'data1' => $Courrier_lettre,
            'data2' => $Courrier_autre,
        ]);

    }

    /**
     * getOldCompagne
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOldCompagne()
    {

        $data = DB::table('campagnes')->join('campagne_cible','campagnes.id','=','campagne_cible.campagne_id')
                    ->where('campagne_old_id','!=','0')
                    ->distinct()
                    ->get(['campagne_old_id','campagnes.name','campagnes.created_at','nb','campagne_cible.campagne_id']);
        $cmp_id = [];


        if( $data ) {
            $cibles = [];
            $grouped_cibles = [];
            $mapped_old_id = [];

            foreach($data as $k=>$v){
                if(!in_array($v->campagne_id,$cmp_id)){
                    array_push($cmp_id,$v->campagne_id);
                }
                $mapped_old_id[$v->campagne_old_id] = $v->campagne_id;
            }


            $cibles = DB::table('campagne_cible')->whereIn('campagne_id',$cmp_id)->get()->toArray();


            foreach($cibles as $k=>$v){
                $grouped_cibles[$v->campagne_id][] = $v->email;
            }

            return response()->json([
                'oldCompagne' => $data ,
                'map_old_id'=>$mapped_old_id,
                'old_cibles'=>$grouped_cibles,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get data'
            ], 400);
        }
    }

    /**
     * getOldCompagne
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteOldCompagne(Request $request)
    {
        $data = DB::table('campagne_cible')->where('campagne_id', $request->id)
        ->update([
            'campagne_old_id' => 0
        ]);
        $oldCompagne = DB::table('campagnes')->join('campagne_cible','campagnes.id','=','campagne_cible.campagne_id')
                    ->where('campagne_old_id','!=','0')
                    ->distinct()
                    ->get(['campagnes.id','campagnes.name','campagnes.created_at','campagnes.nb']);
        if( $request->id ) {

            return response()->json([
                'data' => $request->id ,
                'oldCompagne' => $oldCompagne ,
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get data'
            ], 400);
        }
    }

    /**
     * Ganarate csv file for compagne cibles
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function exportCsv($id)
    {

        $data_id = DB::table('campagne_cible')->select()->where('campagne_id',$id)->get();
        $filename="LCDT";
        $current_date_time = Carbon::now()->timestamp;
        $csv_filename = $filename."_".date("Y-m-d",time())."_".$current_date_time.".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csv_filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
            "file"                => $csv_filename,
        );

        $columns = array('Email', 'Company', 'Firstname', 'Name', 'Address2' , 'Address1', 'Postcode', 'City', 'Industrie', 'Phone' );
        $callback = function() use($data_id, $columns, $csv_filename ) {
        $file = fopen('../public/uploads/'.$csv_filename, 'w');

            fputcsv($file, $columns);

            foreach ($data_id as $data) {

                $row['Email']  = $data->email;
                $row['Company']    = $data->company;
                $row['Firstname']    = $data->firstname;
                $row['Name']  = $data->name;
                $row['Address2']  = $data->address2 ;

                $row['Address1']  = $data->address1;
                $row['Postcode']    = $data->postcode;
                $row['City']    = $data->city;
                $row['Industrie']  = $data->industrie;
                $row['Phone']  = $data->phone   ;

                $data_file = array($row['Email'], $row['Company'], $row['Firstname'], $row['Name'], $row['Address2'] , $row['Address1'], $row['Postcode'], $row['City'], $row['Industrie'], $row['Phone']) ;


                fputcsv($file, $data_file);

            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ganarate pdf file for lettre d'accopagnement
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function downloadPdf(Request $request)
    {

        $pdf_filename = $request->fileName;

        $this->fpdf = new \Mpdf\Mpdf([
             'default_font_size' => 10,
             'default_font' => 'Arial'

        ]);
        $this->fpdf->AddPage();
        $this->fpdf->showImageErrors = true;
        $this->fpdf->img_dpi = 96;

        $this->fpdf->Image('../public/images/logolcdt.png' , 15, 15, 100, 20);
        $this->fpdf->Ln(15);


        $htmlFooter = '<div style= "width: 100%;
        display: flex;
        justify-content: flex-end;
        background-color: orangered;
        margin-top: auto;
        height: 10px;
        padding: 0 40px 0 0;
        margin-bottom: 20px;">

        <div style = "
        padding: 0 3px;
        font-size: xx-small;
        font-weight: bold;
        margin-left: 400px;
        width: 350px;
        background-color: white;
        margin-top: -1px;">
         <span>LE RESEAU EXPERT </span>
         <span style="color:orangered;">DES TOITS PROFESSIONNELS</span>
        </div>
        </div>';
        $this->fpdf->SetHTMLFooter($htmlFooter);


        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(100,5, $request->expediteur );
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(200,5,"SARL");
        $this->fpdf->Ln(8);

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(100,5,$request->expediteur2);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(300,5,"Civilité Prénom Nomn");
        $this->fpdf->Ln(8);


        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(100,5,$request->address);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(300,5,"310 Route de l'Odyssée");
        $this->fpdf->Ln(8);

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(100,5,$request->address2);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(300,5,"45700 CONFLANS SUR LOING");
        $this->fpdf->Ln(8);

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(100,5,$request->coord);
        $this->fpdf->Ln(8);

        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(100,5, $request->email);
        $this->fpdf->SetFont('Arial','',10);

        $this->fpdf->Ln(10);


        $this->fpdf->Cell(120,5,);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(200,5,"Chilly Mazarin, le XX juin 2021");


        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(40,5,'Madame X, Monsieur Y, Madame, Monsieur,');
        if (!$request->html) {
            $request->html = '<div></div>';
        }
        $this->fpdf->Ln(15);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->WriteHTML( $request->html);

        $this->fpdf->Ln(10);
        $this->fpdf->Cell(120,5,);
        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->Cell(200,5,"L'equipe commerciale");

        $this->fpdf->Ln(8);
        $this->fpdf->Cell(120,5,);
        $this->fpdf->SetFont('Arial','',10);
        $this->fpdf->Cell(200,5,"Agence X");



        $this->fpdf->Output('../public/uploads/'.$pdf_filename, 'F');

        return response()->json([
            'message' => 'yess is done !!',
            'fileName' => $pdf_filename

        ]);

    }

    /**
     * Get all compagnes Sarbacane
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertdestinataire(Request $request , $id){
        $user = auth()->user();
        $number = date("Y-m-d H:i:s");
        $name =  'Campagne_Test'. '_' .$number;
        $listname =  'list_test'. '_' .$number;
        $formatedDate = date("Y-m-d H:i:s"); //'2022-01-28T05:07:43.280Z'
        // return $request->data;
        //creation d'une compagne
        //return $data;
        $cible = $request->data;


            $array_cible  =[
                "email" => $request->email,
                "Nom agence" => $request->input_agence,
                "Tel agence" => $request->input_phone,
                "E-mail agence" => $request->input_email
                ] ;

        $data = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists', [

            "name"=>$listname
        ]);
        $id_list = $data['id'];
        $data_champ_name = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'Nom agence',

        ]);
        $data_champ_tel = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'Tel agence'

        ]);
        $data_champ_email = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'E-mail agence'

        ]);
        $send = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/campaigns/email', [

                "name"=> $name,
                "emailFrom"=>$request->emailFrom,
                "aliasFrom"=> $request->emailFrom,
                "emailReplyTo"=>$request->emailReplyTo,
                "aliasReplyTo"=> $request->emailReplyTo,
                "subject"=> $request->subject,
                "preheader"=> "Preheader",

        ]);


        $data_added = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/contacts',
                $array_cible
        );

        $template = DB::table('campagne_category')->where('id',"=", $id)->get();
        foreach ($template as $key => $code) {
            $array_temp =$code->idapi;
        };
            //    return $data_added;
        if($send){
            //ajout du model
            $id= $send['id'] ;
            $template = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
            ->post('https://sarbacaneapis.com/v1/campaigns/'.$id.'/content', [

                    "templateId"=> $array_temp

            ]);
            $contact_list = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
            ->post('https://sarbacaneapis.com/v1/campaigns/'.$id.'/list', [

                    "listId"=> $id_list

            ]);
        }

        //envoi des compagnes

        $daysent = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
            ])->post('https://sarbacaneapis.com/v1/campaigns/'.$id.'/send', [
                    [
                        "requestedSendDate"=> $formatedDate
                ]
            ]);

        return $array_cible;

    }

    /**
     * Get all compagnes Sarbacane
     * @param $data sata
     * @param $data_csv data_csv
     * @return \Illuminate\Http\JsonResponse
     */
    public function envoi_lettre($data, $data_csv){
        $user = auth()->user();
        Mail::to($user->email)->send(new MyDemoMail($data, $data_csv));
        return "email sent";
    }

    /**
     * Get all compagnes Sarbacane
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Http::withHeaders([
            'accountId'   => '61a62892e924e35ea3f5469e',
            'apiKey'    => 'gCdU9nAUQj6THBlujWyMvA',
        ])->get('https://sarbacaneapis.com/v1/campaigns');

        return $response;
    }

    /**
     * send compagne immediat
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    // public function envoi($id)
    // {
    //     $user = auth()->user();
    //     //get cible
    //     $cible = DB::table('campagne_cible')->where('campagne_id',"=", $id)
    //                                         ->where('delete_at',"=", NULL)
    //                                         ->get();
    //     // return $cible;
    //     foreach ($cible as $key => $code) {
    //         $array_cible[] =['email' => $code->email];
    //     } ;

    //     $template = DB::table('campagne_category')->where('id',"=", $id)->get();
    //     foreach ($template as $key => $code) {
    //         $array_temp =$code->idapi;
    //     };

    //     foreach ($template as $key => $code) {
    //         $array_name =$code->name.'-immédiat-'.$number;
    //     } ;

    //     // $data_template = DB::table('email_template')->where('id',"=", $array_temp)->get();
    //     // foreach ($data_template as $key => $code) {
    //     //     $temp =$code->idapi;
    //     // } ;

    //     $formatedDate = date("Y-m-d H:i:s");
    //     //creation d'une compagne
    //     $send = Http::withHeaders([
    //         'accountId'=> '61a62892e924e35ea3f5469e',
    //         'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
    //     ])->post('https://sarbacaneapis.com/v1/campaigns/email', [

    //             "name"=> $array_name,
    //             "emailFrom"=>$request->emailFrom,
    //             "aliasFrom"=> $request->emailFrom,
    //             "emailReplyTo"=>$request->emailFrom,
    //             "aliasReplyTo"=> $request->emailFrom,
    //             "subject"=> $request->subject,
    //             "preheader"=> "Preheader",
    //     ]);

    //     if($send){
    //         //ajout du model
    //         $camp_id= $send['id'] ;
    //         $template_data = Http::withHeaders([
    //             'accountId'=> '61a62892e924e35ea3f5469e',
    //             'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
    //         ->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/content', [

    //                 "templateId"=> $array_temp

    //         ]);
    //     }
    //         //ajout destinataires
    //     $camp_id= $send['id'] ;
    //     $response = Http::withHeaders([
    //         'accountId'=> '61a62892e924e35ea3f5469e',
    //         'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
    //     ])->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/recipients',
    //         $array_cible
    //     );

    //     if ($response) {
    //     $camp_id= $send['id'] ;
    //     $daysent = Http::withHeaders([
    //         'accountId'=> '61a62892e924e35ea3f5469e',
    //         'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
    //         ])->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/send', [
    //                 [
    //                     "requestedSendDate"=> $formatedDate
    //             ]
    //         ]);
    //     }

    //     return 'data added imme';
    // }
    /**
     * send compagne deffirer
     * @param string $id
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function envoiprogramme(Request $request , $id)
    {
        $user = auth()->user();
        $number = mt_rand(1000, 9999999);
        $name =  'list_differed'. '_' .$number;
        $data = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists', [

            "name"=>$name
        ]);
        $id_list = $data['id'];
        $cible = DB::table('campagne_cible')->where('campagne_cible.campagne_id',"=", $id)->where('campagne_cible.delete_at',"=", NULL)->get();

        foreach ($cible as $key => $code) {
            $array_cible[] =[
                "email" => $code->email,
                "Nom agence" => $request->input_agence,
                "Tel agence" => $request->input_phone,
                "E-mail agence" => $request->input_email
                ] ;
        }

        $data_champ_name = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'Nom agence',

        ]);
        $data_champ_tel = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'Tel agence'

        ]);
        $data_champ_email = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'E-mail agence'

        ]);
        for($i=0; $i<count($array_cible); $i++) {
        $data_added = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/contacts',
                $array_cible[$i]
        );
        }

        $template = DB::table('campagne_category')->where('id',"=", $request->id_category)->get();
        foreach ($template as $key => $code) {
            $array_temp =$code->idapi;
        };
        foreach ($template as $key => $code) {
            $array_name =$code->name.'-programmé-'.$number;
        };
        // $data_template = DB::table('email_template')->where('id',"=", $array_temp)->get();
        // foreach ($data_template as $key => $code) {
        //     $temp =$code->idapi;
        // };
        $send = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/campaigns/email', [

                "name"=> $array_name,
                "emailFrom"=>$request->emailFrom,
                "aliasFrom"=> $request->emailFrom,
                "emailReplyTo"=>$request->emailFrom,
                "aliasReplyTo"=> $request->emailFrom,
                "subject"=> $request->subject,
                "preheader"=> "Preheader",
        ]);

        if($send){
            //ajout du model
            $camp_id= $send['id'] ;
            $template_data = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
            ->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/content', [

                    "templateId"=> $array_temp

            ]);
            $contact_list = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
            ->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/list', [

                    "listId"=> $id_list

            ]);
        }
        if ($contact_list) {
            $camp_id= $send['id'] ;
            $daysent = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
            ])->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/send', [
                    [
                        "requestedSendDate"=> $request->formatedDate
                ]
            ]);
        }
        return  $request->formatedDate;

    }



    /**
     * Get cibles of a specific compagne
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCount_cible($id)
    {
        $count_cible = DB::table('campagne_cible')->where('campagne_cible.campagne_id',"=", $id)
                                                ->where('campagne_cible.delete_at',"=", NULL)->get();

        if($count_cible) {

            return response()->json([
                'count_cible' =>$count_cible->count(),
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get data'
            ], 400);
        }
    }
    /**
    * createdata
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createdata(Request $request, $id){
        $user = auth()->user();
        $number = mt_rand(1000, 9999999);
        $name =  'list'. '_' .$number;
        $data = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists', [

            "name"=>$name
        ]);
        $id_list = $data['id'];
        $cible = DB::table('campagne_cible')->where('campagne_cible.campagne_id',"=", $id)->where('campagne_cible.delete_at',"=", NULL)->get();

        foreach ($cible as $key => $code) {
            $array_cible[] =[
                "email" => $code->email,
                "Nom agence" => $request->input_agence,
                "Tel agence" => $request->input_phone,
                "E-mail agence" => $request->input_email
                ] ;
        }

        $data_champ_name = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'Nom agence',

        ]);
        $data_champ_tel = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'Tel agence'

        ]);
        $data_champ_email = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/fields', [

                "kind" => 'STRING',
                "caption" => 'E-mail agence'

        ]);

        for( $i=0; $i<count($array_cible); $i++ ) {
            $data_added = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
            ])->post('https://sarbacaneapis.com/v1/lists/'.$id_list.'/contacts',
                    $array_cible[$i]
            );
        }

        $template = DB::table('campagne_category')->where('id',"=", $request->id_category)->get();
        foreach ($template as $key => $code) {
            $array_temp =$code->idapi;
        };
        foreach ($template as $key => $code) {
            $array_name =$code->name.'-immédiat-'.$number;
        };
        // $data_template = DB::table('email_template')->where('id',"=", $array_temp)->get();
        // foreach ($data_template as $key => $code) {
        //     $temp =$code->idapi;
        // };
        $send = Http::withHeaders([
            'accountId'=> '61a62892e924e35ea3f5469e',
            'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
        ])->post('https://sarbacaneapis.com/v1/campaigns/email', [

                "name"=> $array_name,
                "emailFrom"=>$request->emailFrom,
                "aliasFrom"=> $request->emailFrom,
                "emailReplyTo"=>$request->emailFrom,
                "aliasReplyTo"=> $request->emailFrom,
                "subject"=> $request->subject,
                "preheader"=> "Preheader",
        ]);

        if($send){
            //ajout du model
            $camp_id= $send['id'] ;
            $template_data = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
            ->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/content', [

                    "templateId"=> $array_temp

            ]);
            $contact_list = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'])
            ->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/list', [

                    "listId"=> $id_list

            ]);
        }
        if ($contact_list) {
            $camp_id= $send['id'] ;
            $daysent = Http::withHeaders([
                'accountId'=> '61a62892e924e35ea3f5469e',
                'apiKey'=> 'gCdU9nAUQj6THBlujWyMvA'
            ])->post('https://sarbacaneapis.com/v1/campaigns/'.$camp_id.'/send', [
                    [
                        "requestedSendDate"=> $request->formatedDate
                ]
            ]);
        }
        return 'data';
    }
    public function getTempname($id){
        $campagnesCategory = DB::table('campagne_category')->where('id',"=",$id)->first();
        if($campagnesCategory!=null)
        return $campagnesCategory->name;

        return null;
    }

    /**
     * Get imagefield
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function imagefield($id){
        $data = DB::table('campagne_category')->select()->where('id',"=", $id)->get();
        foreach ($data as $key => $code) {
            $array_data1 =[
                "xfield1" => $code->xfield1,
                "yfield1" => $code->yfield1,
                "color1" => $code->color1,
                ] ;
            $array_data2 =[
                "xfield2" => $code->xfield2,
                "yfield2" => $code->yfield2,
                "color2" => $code->color2,
                ] ;
            $array_data3 =[
                "xfield3" => $code->xfield3,
                "yfield3" => $code->yfield3,
                "color3" => $code->color3,
                ] ;
        }
        return response()->json([
                    'data1' => $array_data1,
                    'data2' => $array_data2,
                    'data3' => $array_data3
                ]);
    }
     /**
     * Get lettredata
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function lettredata($id){

        $lettre = DB::table('campagne_category')->select(['lettreaccompagnement'])->where('id',"=", $id)->get();
        return response()->json([
                'content' =>$lettre[0]->lettreaccompagnement,
            ]);

    }

}
