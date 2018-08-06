<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

//use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Models\User;

use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    //protected function validator(array $data)
    //{
    //    
    //    return Validator::make($data, [
    //        'name' => 'required|string|max:255',
    //        'email' => 'required|string|email|max:255|unique:users',
    //        'password' => 'required|string|min:6|confirmed',
    //    ]);
    //}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => md5($data['password']),
        ]);
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
         
    
        //$this->validator($request->all())->validate();
        $rules= [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            
               return redirect('/register')
                           ->withErrors($validator)
                           ->withInput();
        }
        else
        {
            //dd('aaaa');
        }
        //dd(Auth::guard());

        //event(new Registered($user = $this->create($request->all())));
        $user=new User;
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password=md5($request->input('password'));
        
         //dd($user);
        if($user->save())
        {            
          $message=config('params.msg_success').'User successfully created !'.config('params.msg_end');
          $request->session()->flash('message',$message);
          return redirect('/home');
        }
        else {
          $message=config('params.msg_error').'Error in save !'.config('params.msg_end');
          $request->session()->flash('message',$message);
          return redirect('/register');
        }

        
        //return redirect('/home');
        //return $this->registered($request, $user)
        //                ?: redirect($this->redirectPath());
    }
}
