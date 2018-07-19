<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Session;
class AdminLoginController extends Controller
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
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd('admin');
        $this->middleware('guest:admin')->except('logout');
    }


     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.adminlogin');
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

            // dd('in admin login controller',$this->sendLoginResponse($request));
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
             return redirect('/admin/login')
                         ->withErrors($validator)
                         ->withInput();
      }

      $user=User::where('email',$request->input('email'))->where('isAdmin','1')->where('is_deleted','N')->first();
        
      if($user) // user exist
      {
        if($user->is_active=='N') // check user is blocked or not
        {
          $message=config('params.msg_error').'You have been blocked by admin  !'.config('params.msg_end');
          Session::flash('message',$message);
          return redirect('/admin/login');
        }
        if($user->password!=md5($request->input('password')))
        {
          $message=config('params.msg_error').'Email id or password does not match  !'.config('params.msg_end');
          Session::flash('message',$message);
          return redirect('/admin/login');
        }
            //dd(Auth::guard('web')->login($user));
        //Auth::guard()->login();
        Auth::guard('admin')->login($user);

        return redirect('/admin/dashboard');

      }
      else { // user not found
        $message=config('params.msg_error').'Email Id not found !'.config('params.msg_end');
        Session::flash('message',$message);

        return redirect('/admin/login');
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
       
        // dd( $this->guard()->attempt(
        //     $this->credentials($request), $request->filled('remember')
        // ));
        
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
        
        $this->guard('admin')->logout();

        // $request->session()->invalidate();

        return redirect('admin/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : 'admin/dashboard';
    }
}
