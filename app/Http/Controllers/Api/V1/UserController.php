<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponseTrait;
use apifunction; // Important
use Auth;
class UserController extends Controller
{
    
    use ApiResponseTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:token');
    }
    
    
    //********************************************************************************
    //Title : Login
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Laravel Multiauth
    //Created By : Arshad Shaikh
    //Created Date : 25-07-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
    public function Login(Request $request){
        
       $validation = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'device_id'=>'required',
            'device_type'=>'required',
            ]);
       
        extract($_POST);
        $data = apifunction::getUserDetailOnPassword($email,$password,"0");
        $login_type='n';
        if(isset($data) && $data != array())
        {
            switch ($data) {
                case $data->is_active=='N':
                $result_code = 803;
                break;
                default:
                $result_code = 200;
            }
            
            /*if from admin panel the user is not activated then  we will show this below message*/
            if($result_code==803 || $result_code==802 || $result_code==801)
            {
                //$result['message'] = Yii::t('app',Yii::$app->params['account_deactivate']);
                //return Yii::$app->apifunction->setResponse('account_deactivate',false,200,400);
                
                //Yii::$app->getResponse()->setStatusCode(400);
                return apifunction::ErrorResponse('',200,[],200,'account_deactivate');
                
            }
            
            
            //if($data->mobile_verified=="N")
            //{
            //    return Yii::$app->apifunction->setResponse('phone_verification_pending',false,200,400);
            //}
            //if(isset($data->email) && $data->email!=null)
            //{
            //    if($data->email_verified=="N")
            //    {
            //        return Yii::$app->apifunction->setResponse('email_verification_pending',false,200,400);
            //    }
            //}
            
            //set device and device type to access token
            $token_result = apifunction::manageToken($data->id, $device_id, $device_type,Auth::user()->access_token);
            /*common code for login device updation is also there*/
            //$result = Yii::$app->apifunction->apiLogin($data, $device_id, $device_type, $login_type,'',false);
            $result = apifunction::apiLogin($data, $device_id, $device_type, $login_type,'',false);
            //return Yii::$app->apifunction->setResponse('welcome_login',true,200,200,$result);
            return apifunction::SuccessResponse($result,200,[],0,'welcome_login');
           
        }
        else
        {
            return apifunction::ErrorResponse('',200,[],200,'invalid_login_1');
            //return Yii::$app->apifunction->setResponse('invalid_login_1',false,200,400);
        }
    }
    /***********************************************************************************************************************************
        API FOR Logout
        CREATED BY :Arshad Shaikh
        DATE : 02/08/2018
        MODIFIED DATE :
        TESTED : NOT YET
    ***********************************************************************************************************************************/

    public function Logout(Request $request)
    {
        
        /*insert all required veriables*/
        $required_objs = [];
        if (apifunction::CheckAuthToken($request)) {
            if (apifunction::checkIsPost($required_objs, $_POST)) {
                extract($_POST);
                $userid = Auth::user()->user_id;
                if(!apifunction::checkLoggeduser(Auth::user()->access_token))
                    return apifunction::ErrorResponse('',200,[],200,'error_user_have_not_access');
                
                $data = User::where(['id'=>$userid,'is_deleted'=>'N'])->first();
                if(isset($data) && $data != array())
                {
                    apifunction::updateAccessTockentoNull(Auth::user()->access_token);
                    //$result = Yii::$app->apifunction->setResponse('success', true, 200);
                    //$result["message"] = Yii::t('app', Yii::$app->params["success_logout"]);
                    //return Yii::$app->apifunction::setResponse('success_logout',true,200,400);
                    return apifunction::SuccessResponse(array(),200,[],0,'success_logout');
                }
                else{
                    //return Yii::$app->apifunction->setResponse('error_user_not_found',false,200,400);
                    return apifunction::ErrorResponse('',200,[],200,'error_user_not_found');

                }
            } else {
                //return Yii::$app->apifunction->setResponse('response_text',false,200,400);
                return apifunction::ErrorResponse('',200,[],200,'response_text',400);
            }
        }else{
            //return Yii::$app->apifunction->setResponse('response_text',false,200,400);
            return apifunction::ErrorResponse('',200,[],200,'response_text',400);
        }


    }
    
    //********************************************************************************
    //Title : Register
    //Developer: Arshad Shaikh
    //Email:arshad@peerbits.com
    //Company:Peerbits Solution
    //Project:Multi-Auth
    //Created By : Arshad Shaikh
    //Created Date : 06-08-2018
    //Updated Date : 
    //Updated By : 
    //********************************************************************************
    public function Register(Request $request)
    {
        
        /**insert all required veriables*/
        
        $validation = $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            ]);
        $required_objs = [];
        if(apifunction::checkIsPost($required_objs,$_POST))
        {
            extract($_POST);
            $data = apifunction::getUserDetailOnEmail($email,'0');//0=user
            
            if(!isset($device_id)){$device_id=null;}
            if(!isset($device_type)){$device_type=null;}
            
            if($data == null)
            {
            
                if(isset($_POST['country_code']) && $_POST['country_code']!=null && isset($_POST['contact_number']) && $_POST['contact_number']!=null  )
                {
                    
                    
                    $contact_data = apifunction::getUserDetailOnMobile($_POST['country_code'],$_POST['contact_number'],'0');
                    if(isset($contact_data) && $contact_data != array())
                        return apifunction::ErrorResponse('',200,[],200,'phone_exist_already');
                        //return Yii::$app->apifunction->setResponse('phone_exist_already',false, 200, 400);
                }
                
                $user = new User;
                $user->name = $_POST['name'];
                
                //$user->email_verified = 'Y';//if email is optional
                if(isset($_POST['email']) && $_POST['email']!=null) 
                {
                    $user->email = $_POST['email'];
                    //$user->email_verified = 'N';
                }
                //$user->mobile_verified = 'Y'; //if mobile is optional
                if(isset($_POST['country_code']) && $_POST['country_code']!=null && isset($_POST['contact_number']) && $_POST['contact_number']!=null  )
                {
                    $user->dial_code = $_POST['country_code'];
                    $user->contact_number = $_POST['contact_number'];
                    $user->mobile_verified = 'N';
                }
                $user->password = md5($_POST['password']);

                /*REMOVE IF YOU ARE SAVING globally SAVE METHOD*/
                $user->isAdmin = 0;
                
                //$user->i_date = date('Y-m-d H:i:s');
                //$user->u_date = date('Y-m-d H:i:s');
                $user->save();
                //$user->i_by = $user->id;
                //$user->u_by = $user->id;
                //$user->email_verification_token = Yii::$app->apifunction->randomstring($user->id);
                //$otp=Yii::$app->common->generate_otp_code();
                //$user->otp=$otp;
                
                
                //if(isset($_POST['country_code']) && $_POST['country_code']!=null && isset($_POST['contact_number']) && $_POST['contact_number']!=null  )
                //{
                //    $content='Welcome to '.Yii::$app->params['appName'].', One Time Password(OTP) to verify your phone number is :'.$otp;
                //    Yii::$app->common->sendsms($user->dial_code.$user->contact_number,$content);
                //    if(isset($user->email) && $user->email!=null)
                //        Yii::$app->common->otpemail($user->email,$user->user_name,$content,'otp_mail');
                //
                //    $user->mobile_verified = 'N';
                //}

                if($user->save())
                {
                    ///*send mail via common code you can send via your default code too*/
                    //Yii::$app->apifunction->sendMail('Email Verification', $user->email_id, array('username' => $user->user_name, 'link' => $link), 'verifyemail');
                    //if(isset($_POST['email']) && $_POST['email']!=null)
                    //{
                    //    $link=Url::to("@web/site/useremailverification?args=".$user->email_verification_token."&type=N",true);
                    //    apifunction::sendemail($user->email,$user->user_name,$link,'emailverify');
                    //}
                    //set device and device type to access token
                    $token_result = apifunction::manageToken($user->id, $device_id, $device_type,Auth::user()->access_token);
                    ///*set the response code*/
                    $result = apifunction::apiLogin($user, $device_id, $device_type, '','',false);
                    return apifunction::SuccessResponse(array(),200,[],0,'successfully_registered');
                    //return Yii::$app->apifunction->setResponse('verification_email_sent', true, 200,200,$result);

                }

            }
            else
            {
                //return Yii::$app->apifunction->setResponse('email_exist_already',false, 200, 400);
                return apifunction::ErrorResponse('',200,[],200,'email_exist_already');
            }
        }
        else
        {
            //return Yii::$app->apifunction->setResponse('response_text',false,200,400);
            return apifunction::ErrorResponse('',200,[],200,'response_text',400);
        }
        return $result;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function userlist()
    //{
    //    //  return ProductCollection::collection(Product::paginate());
    //    $data = User::collection(Product::paginate());
    //    if($data){
    //        return  apifunction::SuccessResponse($data,$status = 200, $headers = array(), $options = 0 );
    //    }else{
    //        return  apifunction::ErrorResponse($data,$status = 401, $headers = array(), $options = 0 );
    //    }
    //
    //}
}
