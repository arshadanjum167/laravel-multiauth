<?php
namespace App\Http\Traits;
use App;
use Response;

class SuccessResponseTrait {

    public static function make($object, $message, $status = 200, $headers = array(), $options = 0 ) {

        $response['error'] = []; 
        $response['data'] = $object; 
        $response['success'] = true; 

        return Response::json($response, $status, $headers, $options);
    }
} 