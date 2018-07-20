<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    public function loginold(Request $request)
    {

        // dd($request);
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

          $this->sendLoginResponse($request);
       return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
    public function login(Request $request)
    {
      $rules= [
            'email' => 'required|email',
            'password' => 'required',
        ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
             return redirect('/login')
                         ->withErrors($validator)
                         ->withInput();
      }

      $user=User::where('email',$request->input('email'))->where('isAdmin','0')->where('is_deleted','N')->first();
        
      if($user) // user exist
      {
        if($user->is_active=='N') // check user is blocked or not
        {
          $message=config('params.msg_error').'You have been blocked by admin  !'.config('params.msg_end');
          Session::flash('message',$message);
          return redirect('/login');
        }
        if($user->password!=md5($request->input('password')))
        {
          $message=config('params.msg_error').'Email id or password does not match  !'.config('params.msg_end');
          Session::flash('message',$message);
          return redirect('/login');
        }
            //dd(Auth::guard('web')->login($user));
        //Auth::guard()->login();
        Auth::guard()->login($user);

        return redirect('/home');

      }
      else { // user not found
        $message=config('params.msg_error').'Email Id not found !'.config('params.msg_end');
        Session::flash('message',$message);

        return redirect('/login');
      }
    }

    protected function validateLogin(Request $request)
    {
   
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    protected function attemptLogin(Request $request)
    {
       
     
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        // $request->session()->invalidate();

        return redirect('/');
    }
}
