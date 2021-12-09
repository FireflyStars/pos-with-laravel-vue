<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    public function test(Request $request){
      
       /*$customer=new Customer();
        $customer->firstname='reyewat';
        $customer->name='reyewat bissessur';
        $customer->id_invoice=0;
        $customer->id_master=0;
        $customer->id_group=1;
        $customer->id_lang=1;
        $customer->id_affilie=1;
        $customer->customeruuid=10;
        $customer->signupdate=date('Y-m-d');
        $customer->save();
        
        $order=new Order();
        $order->reference='WSSAHSKS';
        $order->orderuuid='WSSAHSKS';
        $order->id_affilie=1;
        $order->id_lang=1;
        $order->id_order_state=1;
        //$order->changeStatus('NEW_ORDER');

        $customer->orders()->save($order);
*/
        $user=User::findOrFail(1);
        $aff= Affiliate::find(1);

        $user->affiliate()->associate($aff);
        $user->save();
    $affiliate=  $user->affiliate;

    dd($affiliate);

    }

}
