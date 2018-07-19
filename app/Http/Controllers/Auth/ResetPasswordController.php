<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Session;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function resetold(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }
    public function reset(Request $request)
    {
      if(!$request->has('token'))
      {
        $message=config('params.msg_error').'Invalid Request !'.config('params.msg_end');
        Session::flash('message',$message);
        return redirect('/login');
      }
      $token=$request->input('token');
      $password=$request->input('password');
  
      $rules= [
            'password' => 'required|min:6|max:9|confirmed',
            'password_confirmation' => 'required',
        ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
             return redirect('/password/reset/'.$token)
                         ->withErrors($validator)
                         ->withInput();
      }
  
      $model=User::where('remember_token',$token)->where('is_deleted','N')->first();
      if(!$model)
      {
        $message=config('params.msg_error').'Invalid Token !'.config('params.msg_end');
        Session::flash('message',$message);
        return redirect('/login');
      }
      $model->remember_token=null;
      $model->password=md5($password);
  
      if($model->save())
      {
        $message=config('params.msg_success').'Password Reseted !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/login');
      }
      else {
        $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/login');
      }
  
  
    }
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => md5($password),
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);
    }
}
