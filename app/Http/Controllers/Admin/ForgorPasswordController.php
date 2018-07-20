<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

use Session;
use App\Http\Requests;
use App\Models\User;
use App\Mail\ForgotPasswordAdmin;

class ForgorPasswordController extends Controller
{
    public function __construct()
    {
        //$this->middleware('admin_guest');
        //$this->middleware('admin_guest')->only();
        $this->middleware('guest')->only('forgot_password');
    }
    public function showLinkRequestForm()
    {
      return view('admin.auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request)
    {
      $rules= [
            'email' => 'required|email',
        ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
             return redirect('admin/password/reset')
                         ->withErrors($validator)
                         ->withInput();
      }
      $user=User::where('email',$request->input('email'))->where('isAdmin','1')->where('is_deleted','N')->first();
      if($user) // user exist
      {
        $token=hash_hmac('sha256', Str::random(40),$user->email_id);
        $name=$user->user_name;
        $link = url('/admin/password/reset').'/'.$token;

        $user->remember_token=$token;
        $user->save();

        Mail::to($user->email)->send(new ForgotPasswordAdmin($link,$name));
        // Mail::send('admin.mail.forgotpassword', ['link' => $link,'name'=>$name], function ($message)
        //       {
        //           $message->to('yasin@peerbits.com')
        //           ->subject('Forgot Password');
        //       });

        if( count(Mail::failures()) > 0 ) {
          $message=config('params.msg_error').'Error in sending mail !'.config('params.msg_end');
          $request->session()->flash('message',$message);
          return redirect('admin/login');
        }

        $message=config('params.msg_success').'Link Sent !'.config('params.msg_end');
        Session::flash('message',$message);
        return redirect('admin/login');

      }
      else { // user not found
        $message=config('params.msg_error').'Email Id not found !'.config('params.msg_end');
        Session::flash('message',$message);

        return redirect('admin/password/reset');
      }

    }
}
