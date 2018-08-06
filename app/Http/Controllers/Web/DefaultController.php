<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class DefaultController extends Controller
{
 
    public function __construct()
    {
        
        $this->middleware('auth:web');
    }
    
    public function showEditprofileForm()
    {
        $id=Auth::user()->id;
        $user=User::find($id);
        if(!$user)
        {
          $message=config('params.msg_error').'user not found !'.config('params.msg_end');

          Session::flash('message',$message);
          return redirect('/home');
        }
      return view('web.default.editprofile',['user'=>$user]);
    }
    public function editprofile(Request $request)
    {
        
        //dd($_FILES);
        $user_id=$request->input('user_id');
        $password=$request->input('password');
        $rules= [
            'name' => 'required|max:255|min:3',
            'email' => 'required|email|max:255|min:3|unique:users,email,'.$user_id,
            'password' => 'confirmed',
            'password_confirmation' => '',
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
             return redirect('/profile')
                         ->withErrors($validator)
                         ->withInput();
      }
      $user=User::find($user_id);

      if(!$user)
      {
        $message=config('params.msg_error').'User not found !'.config('params.msg_end');

        Session::flash('message',$message);
        return redirect('/home');
      }
      $user->name=$request->input('name');
      $user->email=$request->input('email');
      if($password!='')
      $user->password=md5($password);
       if($request->hasFile('image'))
       {
        
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img/uploads');
            $image->move($destinationPath, $name);
            $user->avatar='/img/uploads/'.$name;
            
       }

      if($user->save())
      {
        $message=config('params.msg_success').'User successfully updated !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/home');
      }
      else {
        $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/home');
      }
    }
   
}
