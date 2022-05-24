<?php

namespace App\Http\Controllers;

use App\Traits\Tools;
use App\Models\OrderState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Ged;
use App\Models\Order;
use App\Models\OrderZone;
use App\Models\GedCategory;
use App\Models\GedDetail;

class DevisController extends Controller
{
    use Tools;

    public function loadList(Request $request){

        $column_filters=$request->post('column_filters');
        $column_sortby=$request->post('sortby');
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
       
            if($column_filter['type']=='date'){
                if(isset($column_filter['having'])&&$column_filter['having']==true){
                    if($column_filter['word']['from']!=''){
                        $orderList=$orderList->having($column_filter['id'],'>=',$column_filter['word']['from']);
                    }
                    if($column_filter['word']['to']!=''){
                        $orderList=$orderList->having($column_filter['id'],'<',$column_filter['word']['to']);
                    }
                }else{
                   if($column_filter['word']['from']!=''){
                        $orderList=$orderList->whereDate((isset($column_filter['table'])?$column_filter['table'].'.':'').$column_filter['id'],'>=',$column_filter['word']['from']);
                    }
                    if($column_filter['word']['to']!=''){
                        $orderList=$orderList->whereDate((isset($column_filter['table'])?$column_filter['table'].'.':'').$column_filter['id'],'<',$column_filter['word']['to']);
                    }
                }
            }else{
                if(isset($column_filter['having'])&&$column_filter['having']==true){
                    $orderList=$orderList->having($column_filter['id'],'LIKE','%'.$column_filter['word'].'%');
                }else{
                    $orderList=$orderList->where((isset($column_filter['table'])?$column_filter['table'].'.':'').$column_filter['id'],'LIKE','%'.$column_filter['word'].'%');
                }
            }
        }

        //sortby
        if($column_sortby!=null)
        foreach($column_sortby as $sortby){
            $orderList=$orderList->orderBy($sortby['id'],$sortby['orderby']);
        }
        

        $orderList=$orderList->groupBy('orders.id')->skip($skip)->take($take)->get();
        return response()->json($orderList);
    }

    public function getOrderStates(Request $request){
        return response()->json(OrderState::all());
    }

    /**
     * Get Ged categories
     * 
     */

    public function getGedCategories(){
        $categories = DB::table('ged_categories')->select('id', 'name')->get();
        foreach ($categories as $item) {
            $item->items = [];
        }
        return response()->json([
            'gedCats'   => $categories->groupBy('id'),
            'taxes'     => DB::table('taxes')->select('id as value', DB::raw('CEIL(taux * 100) as display'))->get(),
            'roofAccesses'     => DB::table('moyenacces')->select('id as value', 'name as display')->get(),
        ]);
    }

    /**
     * Get all toits
     * 
     */

    public function getAllToits(){
        return response()->json(DB::table('ouvrage_toit')->select('id', 'name', 'image')->get());
    }

    /**
     * Get all prestation ouvrages
     * 
     */

    public function getPrestationOuvrages(Request $request){
        $query = DB::table('ouvrages')
                ->join('ouvrage_toit', 'ouvrage_toit.id', '=', 'ouvrages.ouvrage_toit_id')
                ->join('ouvrage_metier', 'ouvrage_metier.id', '=', 'ouvrages.ouvrage_metier_id')
                ->join('units', 'units.id', '=', 'ouvrages.unit_id')
                ->where('type', 'PRESTATION')
                ->where('ouvrage_toit_id', $request->toit == 0 ? '!=' : '=',$request->toit);
        
        return response()->json(
            $query->select(
                'ouvrages.id', 'ouvrages.name',
                'ouvrages.textchargeaffaire', 'ouvrage_metier.name as metier',
                'ouvrage_toit.name as toit', 'ouvrages.type', 'units.code as unit'
            )->get()
        );
    }

    public function getOuvrage(Request $request){
        $ouvrage = DB::table('ouvrages')
                    ->select(
                        'unit_id as unit', 'textcustomer as customerText', 'name', 'id',
                        'textchargeaffaire', 'textoperator', 'ouvrage_metier_id', 'ouvrage_prestation_id', 'ouvrage_toit_id'
                        )
                    ->where('id', $request->id)->first();
        $ouvrage->qty = 0;
        $ouvrage->totalHour = 0;
        $ouvrage->avg = 0;
        $ouvrage->qtyOuvrage = $request->qtyOuvrage;
        $ouvrage->total = 0;
        $ouvrage->totalWithoutMarge = 0;
        $tasks = DB::table('ouvrage_task')
                ->where('ouvrage_id', $request->id)
                ->select('id', 'name', 'textcustomer as customerText', 'textchargeaffaire', 'textoperator', 'unit_id', 'qty')
                ->get();
        $ouvrage->tasks = $tasks;
        foreach ($tasks as $task) {
            $details = DB::table('ouvrage_detail')
                            ->join('products', 'products.id', '=', 'ouvrage_detail.product_id')
                            ->join('units', 'units.id', '=', 'products.unit_id')
                            ->where('ouvrage_task_id', $task->id)
                            ->select(
                                'ouvrage_detail.id', 'ouvrage_detail.numberh as numberH', 'ouvrage_detail.qty', 'units.id as unit_id',
                                'products.type', 'units.code as unit', 'products.id as productId', 'products.name', 'products.taxe_id as tax', 'products.price as productPrice'
                            )->get();
            foreach ($details as $detail) {
                $detail->unitPrice = 0;
                $detail->marge = 0;
                $detail->totalPrice = 0;
                $detail->qtyOuvrage = (int)$request->qtyOuvrage*((int)$detail->qty);
                $detail->totalPriceWithoutMarge = 0;
            }
            $task->details = $details;
        }
        return response()->json($ouvrage);
    }

    /**
     * Search Ouvrages
     */
    public function searchOuvrage(Request $request){
        $query = DB::table('ouvrages')
                    ->join('ouvrage_toit', 'ouvrage_toit.id', '=', 'ouvrages.ouvrage_toit_id')
                    ->join('ouvrage_metier', 'ouvrage_metier.id', '=', 'ouvrages.ouvrage_metier_id')
                    ->join('units', 'units.id', '=', 'ouvrages.unit_id');
        if($request->search != ''){
            $query =    $query->where('ouvrages.name', 'like', '%'.$request->search.'%')
                        ->orWhere('ouvrages.codelcdt', 'like', '%'.$request->search.'%')
                        ->orWhere('ouvrages.textchargeaffaire', 'like', '%'.$request->search.'%');
        }
        if($request->type != '')
            $query =    $query->where('type', $request->type);
        return response()->json(
            $query->select(
                'ouvrages.id', 'ouvrages.name',
                'ouvrages.textchargeaffaire', 'ouvrage_metier.name as metier', 
                'ouvrage_toit.name as toit', 'ouvrages.type', 'units.code as unit'
            )->get()
        );
    }

    /**
     * Search Products
     */
    public function searchProduct(Request $request){
        $query = DB::table('products')
                ->join('taxes', 'taxes.id', '=', 'products.taxe_id')
                ->join('units', 'units.id', '=', 'products.unit_id');
        if($request->search != ''){
            $query =    $query->where('products.name', 'like', '%'.$request->search.'%')
                        ->orWhere('products.reference', 'like', '%'.$request->search.'%')
                        ->orWhere('products.description', 'like', '%'.$request->search.'%');
        }
        if($request->type != '')
            $query =    $query->where('products.type', $request->type);
        return response()->json(
            $query->select(
                'products.id', 'products.name',
                'products.description', 'products.type', 'products.unit_id', DB::raw('CEIL(taxes.taux * 100) as tax'),
                'products.reference', 'products.wholesale_price', 'products.type', 'units.code as unit'
            )->get()
        );
    }
    
    /**
     * Get Taxes
     */
    public function getSuppliers(){
        return response()->json(
            DB::table('suppliers')->select('id as value', 'name as display')->get()
        );
    }

    /**
     * Get info to add empty ouvrage
     */
    public function getInfoForEmtpyOuvrage(){
        return response()->json([
            'units'         =>  DB::table('units')->select('code as display', 'id as value')->get(),
            'toits'         =>  DB::table('ouvrage_toit')->select('name as display', 'id as value')->get(),
            'metiers'       =>  DB::table('ouvrage_metier')->select('name as display', 'id as value')->get(),
            'prestations'   =>  DB::table('ouvrage_prestation')->select('name as display', 'id as value')->get(),
        ]);
    }

    /**
     * Get units
     */
    public function getUnits(){
        return response()->json([
            DB::table('units')->select('code as display', 'id as value')->get()
        ]);
    }
    /**
     * Save a new devis
     */
    public function storeDevis(Request $request){
        $orderData = [
            'lang_id'           => 1,
            'affiliate_id'      => Auth::user()->affiliate->id,
            'reponsable_id'     => Auth::id(),
            'order_state_id '   => 2,
            'total '            => ($request->totalPriceForInstall + $request->totalPriceForSecurity + $request->totalPriceForSecurity),
            'address_id'        => $request->address['id'],
            'customer_id'       => $request->customer['id'],
            'datecommande'      => Carbon::now(),
            'signed_by_customer'=> 0,
            'reference'         => $this->passwdGen(10,'NO_NUMERIC'),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];

        $orderId = DB::table('orders')->insertGetId($orderData);
        if(
            ! Ged::where('user_id','=',Auth::id())
                ->where('customer_id', $request->customer['id'])
                ->where('order_id', $orderId)->exists()
        ){
            $zedData = [
                'customer_id'   =>  $request->customer['id'],
                'user_id'       =>  Auth::id(),
                'order_id'      =>  $orderId,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
            ];        
            $gedId = DB::table('geds')->insertGetId($zedData);
        }
        foreach ($request->zones as $zone) {
            $zoneData = [
                'order_id'      =>  $orderId,
                'latitude'      =>  '',
                'longitude'     =>  '',
                'description'   =>  '',
                'hauteur'       =>  $zone['height'],
                'moyenacces_id' =>  $zone['roofAccess'],
                'name'          =>  $zone['name'],
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
            ];
            $zoneId = DB::table('order_zones')->insertGetId($zoneData);
            // save ged details
            foreach ($zone['gedCats'] as $gedCatId=> $gedCat) {
                foreach ($gedCat[0]['items'] as $file) {
                    $gedDetail = new GedDetail();
                    $gedDetail->ged_id = $gedId;
                    $gedDetail->order_zone_id = $zoneId;
                    $gedDetail->ged_category_id = $gedCatId;
                    $gedDetail->user_id = Auth::id();
                    $gedDetail->save();
                    $gedDetail = $gedDetail->fresh();//retreve fresh object with all fields

                    $file['base64data'];
                    if( $gedDetail->file == null){//files can only be stored once to avoid duplicates;
                        if(isset($file['base64data']) && !$this->isBlank($file['base64data'])){
                            $storedFile = $this->storeFile($file['base64data'], $file['fileName'], $gedDetail->id);
                            $gedDetail->file = $storedFile->file;
                            $gedDetail->type = $storedFile->type;
                            $gedDetail->storage_path = $storedFile->storage_path;
                            $gedDetail->human_readable_filename = $storedFile->human_readable_filename;
                        }
                    }
                    $gedDetail->save();
                }
            }            
            if( count($zone['installOuvrage']['ouvrages']) ){
                $installationCat = [
                    'order_zone_id' =>  $zoneId,
                    'type'          =>  '',
                    'name'          =>  $zone['installOuvrage']['name'],
                    'textcustomer'  =>  '',
                    'textoperator'  =>  '',
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ];
                $orderCatId = DB::table('order_cat')->insertGetId($installationCat);
                foreach ($zone['installOuvrage']['ouvrages'] as $ouvrage) {
                    $ouvrageData = [
                        'order_id'          => $orderId,
                        'order_zone_id'     => $zoneId,
                        'unit_id'           => $ouvrage['unit'],
                        'qty'               => $ouvrage['qty'],
                        'order_cat_id'      => $orderCatId,
                        'ouvrage_prestation_id'=> $ouvrage['ouvrage_prestation_id'],
                        'ouvrage_toit_id'   => $ouvrage['ouvrage_toit_id'],
                        'ouvrage_metier_id' => $ouvrage['ouvrage_metier_id'],
                        'textcustomer'      => $ouvrage['customerText'],
                        'textchargeaffaire' => $ouvrage['textchargeaffaire'],
                        'textoperator'      => $ouvrage['textoperator'],
                        'type'              => 'INSTALLATION',
                        'name'              => $ouvrage['name'],
                        'created_at'        => Carbon::now(),
                        'updated_at'        => Carbon::now(),
                    ];
                    $orderOuvrageId = DB::table('order_ouvrages')->insertGetId($ouvrageData);
                    foreach ($ouvrage['tasks'] as $taskIndex => $task) {
                        $orderOuvrageTask = [
                            'order_ouvrage_id'      => $orderOuvrageId,
                            'name'                  => $task['name'],
                            'textcustomer'          => $task['customerText'],
                            'textchargeaffaire'     => $task['textchargeaffaire'],
                            'textoperator'          => $task['textoperator'],
                            'qty'                   => $task['qty'],
                            'unit_id'               => $task['unit_id'],
                            'created_at'            => Carbon::now(),
                            'updated_at'            => Carbon::now()
                        ];
                        $orderOuvrageTaskId = DB::table('order_ouvrage_task')->insertGetId($orderOuvrageTask);
                        foreach ($task['details'] as $detailIndex => $detail) {
                            $detailData = [
                                'ouvrage_task_id'   => $orderOuvrageTaskId,
                                'product_id'        => $detail['productId'],
                                'type'              => $detail['type'],
                                'name'              => $detail['name'],
                                'textcustomer'      => '',
                                'textchargeaffaire' => '',
                                'textoperator'      => '',
                                'qty'               => $detail['qty'],
                                'numberh'           => $detail['numberH'],
                                'unitprice'         => $detail['unitPrice'],
                                'qtyouvrage'        => $detail['qtyOuvrage'],
                                'qtyunitouvrage'    => 1,
                                'houvrage'          => 0,
                                'marge'             => $detail['marge'],
                                'totalprice'        => $detail['totalPrice'],
                                'taxe_id'           => $detail['tax'],
                                'unit_id'           => $detail['unit_id'],
                                'priceachat'        => $detail['productPrice'],
                            ];
                            if($detail['type'] == 'COMMANDE FOURNISSEUR'){
                                if(preg_match('/^data:application\/pdf;base64,/', $detail['base64'], $type)){
                                    $data = substr($detail['base64'], strpos($detail['base64'], ',') + 1);
                                    $type = 'pdf';
                                    if(!File::isDirectory(public_path('SupplierOrder/'))){
                                        File::makeDirectory(public_path('SupplierOrder/'), 0755, true, true);
                                    }
                                    $data = str_replace( ' ', '+', $data );
                                    $data = base64_decode($data);                    
                                    $uuid_filename = DB::select('select UUID() AS uuid')[0]->uuid;
                                    $orderFilePath = "/SupplierOrder/{$uuid_filename}.{$type}";
                                    file_put_contents(public_path($orderFilePath), $data);                                
                                    $detailData['orderfile'] = $orderFilePath;
                                }
                            }
                            DB::table('order_ouvrage_detail')->insert($detailData);
                        }
                    }
                }
            }
        }
        return response()->json();
    }
}
