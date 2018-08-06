<?php
namespace App\Helpers;
use App;
use Response;
use App\Models\User;
use App\Models\Userdevices;
use App\Extensions\SecurityTrait;
use App\Helpers\ApiResponseTrait;
use Auth;
use Illuminate\Http\Request;

Class ApiFunction {

	use SecurityTrait,ApiResponseTrait;
	
	
    //********************************************************************************
    //Title : get User Detail On Password
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 25-07-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
    public static function getUserDetailOnPassword($email,$password,$user_type)
    {
		$result_obj =[];//blank array for the result object
		//query one for user
		try {
			$result_obj = User::select('*')->where(['is_deleted'=>'N','password'=>md5($password),'email'=>$email,'isAdmin'=>$user_type])->first();
		}
		catch(Exception $e) {
			//hope you dont need to uncomment below
			//print $e
		}
        return $result_obj;
    }
	//********************************************************************************
    //Title : Manage Token
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function manageToken($user_id=null,$device_id=null,$device_type=null,$token=null)
	{
		if(/*isset($user_id) && $user_id!=null &&  isset($device_id) && $device_id!=null && */
		   /*isset($device_type) && $device_type!=null && */
		   isset($token) && $token!=null
		   )
		{
			
			$result["token"] = [];
			
			$userlogindata = Userdevices::where('access_token',$token)->first();
			

			if(!is_object($userlogindata)){
				$userlogindata = new Userdevices();
			}
			
			if (isset($user_id) && $user_id!=null )
			$userlogindata->user_id = $user_id;


			if (isset($device_id) ){
				$userlogindata->device_id = $device_id;
			}
			if (isset($device_type))
				$userlogindata->device_type = $device_type;

			$userlogindata->save();
			
		}
	}
	/*=====================================COMMON FUNCTION FOR LOGIN AND ITS RESPONSE ============================================================
     CREATED : RAJESH YADAV
     WHY ? : USED IN LOGIN AND SOCIAL LOGIN AND IN SOCIAL LOGIN USED TWICE OR THRISE SO INSTEAD OF WRITING TWICE I WROTE COMMONLY
     TESTED : NOT YET
     CREATION DATE  : 30/06/2017
     CHANGED BY:
     UPDATION DATE:
     RETURN TYPE : STATUS CODE , USING THIS CODE WE WILL MANAGE DIFFERANT TYPE OF LOGIN ERROS LIKE ACCOUNT DEACTIVATE,NOT VERIFIED, ACCOUNT DELETED ECT..
     PARAMS : DATA(RESULT OF FIND ONE QUERY)
	      DEVICE ID,
	      DEVICE TYPE,
	      LOGIN TYPE(SOCIAL OR NORMAL)WHY ? MAY SOME PROJECT HAVE THE SPECIAL RETRUN TYPE FOR IT

    200=success
    800=error
    801=otp not veified
    802=email not verified
    803=account deactivated
    =====================================******************************************============================================================*/

    public static function apiLogin($data,$device_id=null,$device_type=null,$login_type=null,$is_merge="",$updatetoken=true)
    {
		//echo $is_merge;die;
		$result['message'] = config('params.response_text')['400'];
		
		//$result['success'] = false;
		

		try {

			//if you want to change the response please change centrally or create new relative method
			if($login_type==null)
				$result = apifunction::userResponse($data->id);
			else
				$result = apifunction::userResponse($data->id,$login_type);
				
			//dd($result);
			//$result['is_social_login'] = $login_type=='S' ? 'Y' : 'N';
			//$result["token"] = $this->
			$result['message'] = config('params.successfully_logged_in');
			if($login_type =='r')
			{
				$result['message'] = config('params.successfully_registered');
			}
			//$result['success'] = true;
		}
		catch(Exception $e) {
		}

		$result["token"] = apifunction::Userlogintocken($data->id, $device_id, $device_type, $updatetoken);
		if(isset($is_merge) && $is_merge!=null){
			$result["is_merge"] = \strtolower($is_merge);
		}else{
			$result["is_merge"] = \strtolower("Y");
		}
		if (isset($login_type) && $login_type != null) {
			$result['message'] = config('params.successfully_logged_in');
			$result["type"] = $login_type;
			//$result["code"] = 200;
		}
		$result["is_deleted"] = $data->is_deleted;
		//$result["success"] = true;
		return $result;



    }
	/*
     USER RESPONSE (MOST COMMONLY USED FUNCTION ), WE CAN SAY USER DETAIL
     POURPOSE : TO RETURN USERS DETAILS
     DESCRIPTION : for getting users resoponse based on the id or data of array(this query should return on result)

    */

    public static function userResponse($data,$is_internal_call='n')
    {

		$result['user'] = array();//this is for the api so i used  user array
		try
		{
			if(isset($data->id) && $data->id != null)
			{
			//nothing to do
			}else{
				$data = User::where(['is_deleted'=>'N','id'=>$data])->first();


			//common for above both of one
			$result['user']['user_id'] = isset($data->id) ? $data->id: "";
			$result['user']['name'] = isset($data->name) ? $data->name : "";
			$result['user']['country_code'] = isset($data->dial_code) ? $data->dial_code : "";
			$result['user']['contact_number'] = isset($data->contact_number) ? $data->contact_number : "";
			$result['user']['email'] = isset($data->email) ? $data->email : "";
			$result['user']['profile_image'] = isset($data->image) ? $data->image: "";
			$result['user']['email_verified'] = ($data->email_verified=='Y')?true:false;
			$result['user']['contact_verified'] = ($data->mobile_verified=='Y')?true:false;
			$result['user']['login_type'] = $is_internal_call;
			
			//$result['user']['is_first_time'] = $data->is_firsttime;
			//$data->is_firsttime="n";
			$data->save();
			/*for user settion array*/
			}
		}
		catch(Exception $e) {
			 //hope you dont need to uncomment below
			 //print $e
		}
		return $result;
	}
	//********************************************************************************
    //Title : User login tocken
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function Userlogintocken($user_id,$device_id,$device_type,$updatetoken)
	{
		//var_dump($updatetoken);die;

		$result["token"] = [];
		if(isset($device_id) && $device_id!=null && isset($device_type) && $device_type!=null)
			$userlogindata = Userdevices::where(['user_id' => $user_id, 'device_id' => $device_id, 'device_type' => $device_type])->orderby('last_login_datetime','DESC')->first();
		else if(Auth::user()->access_token!=null || Auth::user()->access_token!='')
		{
			$userlogindata = Userdevices::where(['access_token' => Auth::user()->access_token])->orderby('last_login_datetime','DESC')->first();
		}



		if(!is_object($userlogindata)){
			$userlogindata = new Userdevices();
		}
		$userlogindata->user_id = $user_id;


		if (isset($device_id) && $device_id !=null && $updatetoken){
			//$userlogindata->access_token = \Yii::$app->security->generateRandomString();
			$userlogindata->device_id = $device_id;
		}
		if (isset($device_type) && $device_type!=null)
			$userlogindata->device_type = $device_type;


		//if($updatetoken || $userlogindata->isNewRecord){
		if($updatetoken ){
			$userlogindata->last_login_datetime = date("Y-m-d H:i:s");
			$userlogindata->access_token = $this->generateRandomString();
			$userlogindata->save();
		}
		//echo "<pre>";
		//print_r($userlogindata);die;


		$result['token']['token'] = $userlogindata->access_token;
		$result['token']['type'] = 'Bearer';

		return $result["token"];
	}
	//********************************************************************************
    //Title : Check Auth Token
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function CheckAuthToken($request=null)
	{		
		
		if(isset($request) && $request!=null)
		{
			//dd($request->headers->get('Authorization'));
			//$authHeader = $request->getHeaders()->get('Authorization');
			$authHeader = $request->headers->get('Authorization');
			
			if ($authHeader !== null && preg_match("/^Bearer\\s+(.*?)$/", $authHeader, $matches)) {
				$tocken = explode(" ",$authHeader);
				$access_token = trim($tocken[1]);
				$userlogindata = Userdevices::where(["access_token"=>$access_token])->get();
				if($userlogindata!=array()){
					return true;
				}else{
					return false;
				}
	
			}else{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	//********************************************************************************
    //Title : check Is Post
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function checkIsPost($required,$post)
    {
        $error = true;
        foreach($required as $field)
        {
            if (!isset($post[$field]) || $post[$field] == null)
            {
                $error = false;
            }
        }
        return $error;
    }
	//********************************************************************************
    //Title : update Access Tocken to Null
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function updateAccessTockentoNull($token)
	{
		//return Userdevices::updateAll(["access_token"=>""], "user_id=$user_id");
		return Userdevices::where('access_token',$token)->delete();
	}
	//********************************************************************************
    //Title : check Logged user
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function checkLoggeduser($token=null)
	{
		$result=true;
		if(isset($token) && $token!=null)
		{
			//echo $updatetoken;die;
			$userlogindata = Userdevices::select('user_id')->where(['access_token' => $token])->first();
			if(isset($userlogindata) && $userlogindata!=null)
			{

				if(isset($userlogindata->user_id) && $userlogindata->user_id!=null)
				{
					 //This Token is assigned to logged user
					$result=true;
				}
				else
				{
					
					//$result=Yii::$app->apifunction->setResponse('error_user_have_not_access',true,200,200);
					//$result=ApiFunction::ErrorResponse('',200,[],200,'error_user_have_not_access');
					//dump($result);
					//return $result;
					//ApiFunction::setHeader(200);
					//return $result;
					$result=false;

				}
			}
			else
			{
				//$result=Yii::$app->apifunction->setResponse('error_user_have_not_access',true,200,200);
				//$result=$this->ErrorResponse('',200,[],200,'error_user_have_not_access');
				//Yii::$app->mycomponent->setHeader(200);
				//echo json_encode($result,true);die;
				$result=false;
			}
		}
		else
		{
			//$result=Yii::$app->apifunction->setResponse('error_user_have_not_access',true,200,200);
			//$result=$this->ErrorResponse('',200,[],200,'error_user_have_not_access');
			//Yii::$app->mycomponent->setHeader(200);
			//echo json_encode($result,true);die;
			$result=false;
		}
		return $result;
	}
	//********************************************************************************
    //Title : Set Header
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
	public static function setHeader($status){
       $status_header = 'HTTP/1.1 ' . $status . ' ' . config('params.response_text')[$status];
       $content_type="application/json; charset=utf-8";
       header($status_header);
       header('Content-type: ' . $content_type);
       header('X-Powered-By: ' . config('params.appTitle'));
   }
   //********************************************************************************
    //Title : Success Response
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
   public static function SuccessResponse($data, $status = 200, $headers = array(), $options = 0, $message='')
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
	//********************************************************************************
    //Title : Error Response
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 02-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
   public static function ErrorResponse($data, $status = 200, $headers = array(), $options = 0, $message='',$message_code=null)
   {

        
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
	/*
     function for getting the user detail on the username and passwrd and usertype
     update date : 21/06/2017
    */
    public static function getUserDetailOnEmail($email,$user_type)
    {
		$result_obj =[];//blank array for the result object
		//query one for user
		try {
			$result_obj = User::where(['is_deleted'=>'N','email'=>$email,'isAdmin'=>$user_type])->first();
		}
		catch(Exception $e) {
			 //hope you dont need to uncomment below
			 //print $e
		}
		return $result_obj;
    }
	/*
     function for getting the user detail on the username and passwrd and usertype
     update date : 21/06/2017
    */
    public static function getUserDetailOnMobile($dial_code,$contact_number,$user_type)
    {
		$result_obj =[];//blank array for the result object
		//query one for user
		try {
			$result_obj = User::where(['is_deleted'=>'N','dial_code'=>$dial_code,'contact_number'=>$contact_number,'user_type'=>$user_type])->first();
		}
		catch(Exception $e) {
			 //hope you dont need to uncomment below
			 //print $e
		}
        return $result_obj;
    }
} 