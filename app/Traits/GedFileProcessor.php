<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait GedFileProcessor


{

    public function storeFile($base64_string,$filename){
        $uuid = DB::select('select UUID() AS uuid')[0]->uuid;//unique name for file

        //check file extension
        $file_extension='';
        $pathinfo=pathinfo($filename);
        if(isset($pathinfo['extension'])){
          $file_extension=$pathinfo['extension'];
        }
        if($file_extension==''){
                //if no extension then try to check data for image
                //check for PNG,JPEG,TIFF and GIF
                $data=explode(';',$base64_string);
                $data=$data[0];
                $data=explode('/',$data);
                if(isset($data[1])){

                    if(in_array(strtolower($data[1]),['png','jpeg','jpg','tiff','gif'])){
                            $file_extension=$data[1];
                            if($data[1]=='jpeg'){
                                $file_extension='jpg';
                            }
                    }

                }
            }
        dd($file_extension);

        return $uuid;
    }

  

    public function generateImageMinature($base64,$folder){
      
         


            
    }
}
 