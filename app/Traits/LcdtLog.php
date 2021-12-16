<?php

namespace App\Traits;

use App\Models\LcdtLog as ModelsLcdtLog;
use Illuminate\Support\Facades\Auth;

trait LcdtLog
{
    public function l($type,$message,$user_id=null){
       
            $user=Auth::user();
            $lcdtlog=new ModelsLcdtLog();
            $lcdtlog->type=$type;
            $lcdtlog->user_id=$user!=null?$user->id:$user_id;
            $lcdtlog->message=$message;
            $lcdtlog->save();
    }
}
