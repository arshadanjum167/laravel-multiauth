<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Session;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
  public function __construct()
  {
      $this->middleware('admin_guest');
  }
  public function showResetForm($token)
  {
    
    $model=User::where('remember_token',$token)->where('is_deleted','N')->first();
    if(!$model)
    {
      $message=config('params.msg_error').'Invalid Token !'.config('params.msg_end');
      Session::flash('message',$message);
      return redirect('admin/login');
    }
    return view('admin.auth.passwords.reset')->with('token',$token);
  }

  public function reset(Request $request)
  {
    if(!$request->has('token'))
    {
      $message=config('params.msg_error').'Invalid Request !'.config('params.msg_end');
      Session::flash('message',$message);
      return redirect('admin/login');
    }
    $token=$request->input('token');
    $password=$request->input('password');

    $rules= [
          'password' => 'required|min:6|max:9|confirmed',
          'password_confirmation' => 'required',
      ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
           return redirect('admin/password/reset/'.$token)
                       ->withErrors($validator)
                       ->withInput();
    }

    $model=User::where('remember_token',$token)->where('is_deleted','N')->first();
    if(!$model)
    {
      $message=config('params.msg_error').'Invalid Token !'.config('params.msg_end');
      Session::flash('message',$message);
      return redirect('admin/login');
    }
    $model->remember_token=null;
    $model->password=md5($password);

    if($model->save())
    {
      $message=config('params.msg_success').'Password Reseted !'.config('params.msg_end');
      $request->session()->flash('message',$message);
      return redirect('admin/login');
    }
    else {
      $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
      $request->session()->flash('message',$message);
      return redirect('admin/login');
    }


  }
}
