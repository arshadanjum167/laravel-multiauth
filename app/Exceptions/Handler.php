<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    use ExceptionTrait;
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        //dd($exception);
        if($request->wantsJson()){
        //dd('2');    
            return $this->findException($request,$exception);
        }
        //dd('3');
        return parent::render($request, $exception);
    }
    protected function findException($req ,$exep){
        //dd('a');
        return $this->returnExeption($req ,$exep);
    }
    //protected function unauthenticated($request, AuthenticationException $exception)
    //{
    //    if ($request->expectsJson()) {
    //        return response()->json(['error' => 'Unauthenticated.'], 401);
    //    }
    //    $guard = array_get($exception->guards(), 0);
    //    switch ($guard) {
    //   case 'admin':
    //        $login = 'admin.login';
    //        break;
    //    // case 'doctor':
    //    //     $login = 'doctor.login';
    //    //     break;
    //    default:
    //        $login = 'login';
    //        break;
    //    }
    //    return redirect()->guest(route($login));
    //}
}
