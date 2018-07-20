<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Models\User;

use Illuminate\Support\Facades\Validator;


class DefaultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showChangepasswordForm()
    {
      return view('admin.default.changepassword');
    }
    public function changepassword(Request $request)
    {
      
      
      $user_id=$request->input('user_id');
      $password=$request->input('password');
  
      $rules= [
            'password' => 'required|min:6|max:9|confirmed',
            'password_confirmation' => 'required',
        ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
             return redirect('admin/changepassword')
                         ->withErrors($validator)
                         ->withInput();
      }
  
      $model=User::where('id',$user_id)->where('is_deleted','N')
      ->where('isAdmin','1')
      ->first();
      if(!$model)
      {
        $message=config('params.msg_error').'Invalid User !'.config('params.msg_end');
        Session::flash('message',$message);
        return redirect('/admin/dashboard');
      }
      $model->password=md5($password);
  
      if($model->save())
      {
        $message=config('params.msg_success').'Password has been Changed !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/admin/dashboard');
      }
      else {
        $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/admin/dashboard');
      }
  
  
    }
    public function showEditprofileForm()
    {
        $id=Auth::user()->id;
        $user=User::find($id);
        if(!$user)
        {
          $message=config('params.msg_error').'user not found !'.config('params.msg_end');

          Session::flash('message',$message);
          return redirect('admin/user');
        }
      return view('admin.default.editprofile',['user'=>$user]);
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
             return redirect('admin/editprofile')
                         ->withErrors($validator)
                         ->withInput();
      }
      $user=User::find($user_id);

      if(!$user)
      {
        $message=config('params.msg_error').'User not found !'.config('params.msg_end');

        Session::flash('message',$message);
        return redirect('/admin/dashboard');
      }
      $user->name=$request->input('name');
      $user->email=$request->input('email');
      if($password!='')
      $user->password=md5($password);
       if ($request->hasFile('image'))
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
        return redirect('/admin/dashboard');
      }
      else {
        $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
        $request->session()->flash('message',$message);
        return redirect('/admin/dashboard');
      }
    }
}
