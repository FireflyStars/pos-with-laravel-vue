<?php

namespace App\Traits;

use App\Models\GedDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\json_decode;
/**
 * 
 */
trait GedFileProcessor


{
    private $allowedImageFileExts=['png','jpeg','jpg','tiff','gif'];

    //creates and return the directory path for file to be stored ;
    private function getDirectoryNameByGedDetailId($id){

        $gedDetail= GedDetail::findOrFail($id);

        $ged=$gedDetail->ged()->first();
        $orderzone=$gedDetail->orderZone()->first();
        $getcategory=$gedDetail->gedCategory()->first();
        $orderouvrage=$gedDetail->orderOuvrage()->first();
        $Path = 'GED'. ( $ged != null ? ( '/GED_'.$ged->id ) : '' ) .( $orderzone != null ? ( '/Z_'. preg_replace( '/[\W]/', '',$orderzone->name)) : '' ).( $getcategory != null ? ( '/CAT_'.preg_replace( '/[\W]/', '' , $getcategory->name )) : '' )
        . ( $orderouvrage != null ? ('/OUV_'.preg_replace( '/[\W]/', '',$orderouvrage->name)) : '');
        Storage::disk('local')->makeDirectory('public/'.$Path);
        return $Path;
    }

    public function storeFile($datauri_string,$filename,$gedDetail_id){

       
        //check file extension
        $file_extension='';
        $pathinfo=pathinfo($filename);
        if(isset($pathinfo['extension'])){
          $file_extension=$pathinfo['extension'];
        }
        if($file_extension==''){
                //if no extension then try to check data for image
                //check for PNG,JPEG,TIFF and GIF
                $data=explode(';',$datauri_string);
         
                $data=$data[0];
                $data=explode('/',$data);
                if(isset($data[1])){

                    if(in_array(strtolower($data[1]),$this->allowedImageFileExts)){
                            $file_extension=$data[1];
                            if($data[1]=='jpeg'){
                                $file_extension='jpg';
                            }
                    }

                }
            }
        
        
            
        $path=$this->getDirectoryNameByGedDetailId($gedDetail_id);
        $data=explode(';',$datauri_string);    
        $base64_string=explode(',',$data[1]);
        $base64_string=$base64_string[1];
        $uuid_filename='';
        if(in_array($file_extension,$this->allowedImageFileExts)){
            $uuid_filename= $this->generateImageMinatures($base64_string,$path,$file_extension);
        }else{
            $uuid_filename = DB::select('select UUID() AS uuid')[0]->uuid;
            $output_file=$path.'/'.$uuid_filename.'.'.$file_extension;
    
            Storage::disk('local')->put('public/'.$output_file, base64_decode( $base64_string ));
        }

        return json_decode('{"storage_path":"'.$path.'","file":"'.$uuid_filename.'","type":"'.$file_extension.'","human_readable_filename":"'.$filename.'"}');
    }

    
    //generates thumbnails and return filename
    private function generateImageMinatures($base64_string,$path,$file_extension){
      
        $uuid_filename = DB::select('select UUID() AS uuid')[0]->uuid;
        $output_file=$path.'/'.$uuid_filename.'.'.$file_extension;

        Storage::disk('local')->put('public/'.$output_file, base64_decode( $base64_string ));

        //medium image
        $imagick = new \Imagick(storage_path('app/public/'.$output_file));
        $imagick->setImageBackgroundColor(new \ImagickPixel('rgb(82, 82, 82)'));
        $dimension=json_decode(setting('lcdt.image_medium'));
        $imagick->thumbnailImage($dimension->width, $dimension->height, true, true);
        $medium_file=$path.'/'.$uuid_filename.'_medium.'.$file_extension;
        Storage::disk('local')->put('public/'.$medium_file,$imagick->getImageBlob());
        $imagick->destroy();
        //small image
        $imagick = new \Imagick(storage_path('app/public/'.$output_file));
        $imagick->setImageBackgroundColor(new \ImagickPixel('rgb(82, 82, 82)'));
        $dimension=json_decode(setting('lcdt.image_small'));
        $imagick->thumbnailImage($dimension->width, $dimension->height, true, true);
        $small_file=$path.'/'.$uuid_filename.'_small.'.$file_extension;
        Storage::disk('local')->put('public/'.$small_file,$imagick->getImageBlob());
        $imagick->destroy();

        return $uuid_filename;
            
    }
    
    //TODO: get urls for files given ged_detail
    public function getFileUrls($gedDetail){
        if(in_array($gedDetail->type,$this->allowedImageFileExts)){
            return array(
                'original'=>getenv('APP_URL').Storage::url( $gedDetail->storage_path.'/'.$gedDetail->file.($gedDetail->type!=''?'.'.$gedDetail->type:'')),
                'medium'=>getenv('APP_URL').Storage::url( $gedDetail->storage_path.'/'.$gedDetail->file.'_medium'.($gedDetail->type!=''?'.'.$gedDetail->type:'')),
                'small'=>getenv('APP_URL').Storage::url( $gedDetail->storage_path.'/'.$gedDetail->file.'_small'.($gedDetail->type!=''?'.'.$gedDetail->type:'')),
            );
        }else{
            return array('original'=>getenv('APP_URL').Storage::url( $gedDetail->storage_path.'/'.$gedDetail->file.($gedDetail->type!=''?'.'.$gedDetail->type:'')));
        }
    }
}
 