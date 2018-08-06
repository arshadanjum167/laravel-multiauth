<?php
namespace App\Helpers;
use App\Models\User;
use App;
use Response;

trait ApiResponseTrait {

    public function SuccessResponse($data, $status = 200, $headers = array(), $options = 0, $message='')
    {
        
        $response['error'] = array(); 
        $response['data'] = $data;
        if(!empty($message))
        {
            
            if(!empty(config('params.'.$message)) && config('params.'.$message)!=null)
            $response['data']['message'] = config('params.'.$message);
            else
            $response['data']['message'] = $message;
            
        }
        $response['success'] = 1; 
        return Response::json($response, $status, $headers, $options);
    }
    public function ErrorResponse($data, $status = 200, $headers = array(), $options = 0, $message='',$message_code=null) {

        
         $response['error'] = array();
         $response['data'] = (object)[];
         if(!empty($message))
         {
           
           if($message_code!=null && !empty(config('params.'.$message)[$message_code]) && config('params.'.$message)[$message_code]!=null)
           {
            $response['error'][] = config('params.'.$message)[$message_code];
           }
           elseif(!empty(config('params.'.$message)) && config('params.'.$message)!=null)
           {
            
            $response['error'][] = config('params.'.$message);
           }
            else
            $response['error'][] = $message;
         }
         if(!empty($data))
        $response['data'] = $data;  
        $response['success'] = 0;
        
        return Response::json($response, $status, $headers, $options);
    }
} 