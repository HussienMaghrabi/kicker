<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    # --------------------successResponse------------------
    public function successResponse($data, $message = NULL)
    {
        $response = array(
            'status'  => TRUE,
            'message' => $message,
            'data'    => $data
        );
        return response()->json($response, 200);
    }

    # --------------------errorResponse------------------
    public function errorResponse($errors , $data = NULL)
    {
        $response = array(
            'status'  => FALSE,
            'message' => $errors,
            'data'    => $data
        );
        return response()->json($response);
    }


    # --------------------__construct------------------
    public function __construct(){
        if(Session::get("Newlang") == null){
            Session::put("Newlang","en");}
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $imageValidTypes = ["image/jpeg","image/jpg","image/png","image/gif","image/gif","image/bmp","image/svg"];    

    public function saveSingleImage($object,$photo,$path,$attributeName=null)
    {
        
        if(!$photo)
        {
          //  dd($attributeName);
            $this->addNoImage($object,$attributeName);
        }
        else if(is_array($photo))
        {
            //return "koko wawa";
          return  $this->saveMultiplePhotos($object,$photo,$path,$attributeName);
        }
        else{
        $exploded = explode(',',$photo);
        $image = base64_decode($exploded[1]);
        $file = finfo_open();
        $mime_type = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);
        
        
        if(!in_array($mime_type,$this->imageValidTypes))
        {
            $this->addNoImage($object,$attributeName);
            return response()->json(['error' => "Image corrupted"], $this->failedStatus);
        }
       
       
        $type =explode("image/",  $mime_type);
       
        $filename = $path . time() .'.'.$type[1];
        file_put_contents($filename, $image);
        
        $object->$attributeName = $filename;
        $object->save();
        }
    }

    public function saveMultiplePhotos($item,$photos,$path,$attributeName)
    {
        $photosArray = [];
        foreach($photos as $key=> $photo)
        {
            if(!isset($photo['dataURL'])){
                
                if(!isset($photo['name'])){
                    // in this case sended file is not valid 
                    continue;
                }
                
                array_push($photosArray,$photo['name']);
                continue;
            } 
            $exploded = explode(',',$photo['dataURL']);
            $image = base64_decode($exploded[1]);

            $file = finfo_open();
            $mime_type = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);

            if(in_array($mime_type,$this->imageValidTypes))
            {
               

                $type =explode("image/",  $mime_type);
                $filename = $path . time().$key .'.'.$type[1];
                file_put_contents($filename, $image);
                array_push($photosArray,$filename);
            }

        }
       
        if(!empty($photosArray)){
            $item->$attributeName  = $photosArray;
            $item->save();
        }
    }
}
