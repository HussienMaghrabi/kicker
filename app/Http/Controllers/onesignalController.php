<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\onesignal;
class onesignalController extends Controller
{
    public function index(){
        // dd(config('onesignal.rest_api_key'));
        $onesignal = onesignal::first();
        return $onesignal;
    }
    public function store(Request $request){
        // dd($request->all());
        $update = onesignal::first();
        $update->api_key = $request->api_key;
        $update->rest_key = $request->rest_key;
        $update->update();
        if($update){
            $values = [
                'onsignal_app_id' => $update->api_key,
                'onsignal_rest_api_key' => $update->rest_key,
            ];
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
            if (count($values) > 0) {
                foreach ($values as $envKey => $envValue) {
        
                    $str .= "\n"; // In case the searched variable is in the last line without \n
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    // If key does not exist, add it
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
                }
            }
        
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)) return 'some error';
            return 'save in env file';
                    // rewrite file content with changed data
            return response()->json([
                'data' => 'up to date'
            ],200);
        }
    }
}
