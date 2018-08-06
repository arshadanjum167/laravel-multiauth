<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\Userdevices;
use App\Http\Resources\TokenResource;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponseTrait;
use App\Extensions\SecurityTrait;


use Illuminate\Support\Facades\Validator;


class DefaultController extends Controller
{
	use SecurityTrait,ApiResponseTrait;
	
	//********************************************************************************
    //Title : get Token
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 25-07-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
    public function gettoken(Request $request)
    {
       extract($_POST);
        
        if(isset($device_id) && $device_id!=null && isset($device_type) && $device_type!=null)
        {
            //check device id and device type already there
            $userlogindata = Userdevices::find()->where(['device_id' => $device_id, 'device_type' => $device_type])->one();
            
            if(isset($userlogindata) && $userlogindata!=array())
            {
                //merge the data
            }
            else
            {
                $userlogindata = new Userdevices();
            }
        }
        else
        {
            $userlogindata = new Userdevices();
        }
        
        if (isset($device_id) && $device_id!=null)
			$userlogindata->device_id = $device_id;
		
		if (isset($device_type) && $device_type!=null)
			$userlogindata->device_type = $device_type;
            
        
        $userlogindata->user_id = null;
        $userlogindata->access_token = $this->generateRandomString();
        $userlogindata->last_login_datetime = date("Y-m-d H:i:s");
        //echo "<pre>";
        //    print_r($userlogindata);die;
		if($userlogindata->save())
        {
            
        }
        else{
            //echo "<pre>";
            //print_r($userlogindata->getErrors());die;
        }
        $result['token']['token']=$userlogindata->access_token;
		$result['token']['type']='Bearer';
        return $this->SuccessResponse($result);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
