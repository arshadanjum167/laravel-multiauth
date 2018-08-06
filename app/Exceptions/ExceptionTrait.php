<?php 
namespace App\Exceptions;
use App\Helpers\ApiResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Debug\Exception\FatalThrowableError;


use App\Extensions\ResponseStatus;
trait ExceptionTrait {
	
    use ApiResponseTrait;

	public function returnExeption($req,$exep){
		
		if($exep instanceof ModelNotFoundException){
            return $this->isModel($req,$exep);
        }
        if ($exep instanceof NotFoundHttpException) {
        	return $this->isHttp($req,$exep);
        }if($exep instanceof MethodNotAllowedHttpException){
            return $this->isMethod($req,$exep);
        }
        if($exep instanceof ValidationException){
            return $this->isValidation($req,$exep);
        }
        if($exep instanceof QueryException){
            return $this->isQuery($req,$exep);
        }
		if($exep instanceof FatalThrowableError){
           return $this->isFatal($req,$exep);
       }
        
        return parent::render($req,$exep);

	}

	protected function isModel($req,$exep){
        $model = last(explode('\\',$exep->getModel()));
        return $this->ErrorResponse([], 404, $headers = array(), $options = 0, $message="$model not found" );
        
	}

	protected function isHttp($req,$exep){
        return $this->ErrorResponse([], 404, $headers = array(), $options = 0, $message="API endpoint is not found" );
    }
    
    protected function isMethod($req,$exep){
        return $this->ErrorResponse([], 404, $headers = array(), $options = 0, $message="This method is not allowed" );
    }

    protected function isValidation($req,$exep){
        return $this->ErrorResponse([], 404, $headers = array(), $options = 0, $message="Bad Request" );
    }
	
	protected function isFatal($req,$exep){
           $message = $exep->getMessage().' on line number '.$exep->getLine();
       return $this->ErrorResponse([], $status = 404, $headers = array(), $options = 0, $message=$message );
   }
    protected function isQuery($req,$exep){
        if(config('app.debug')){
            return $this->ErrorResponse([], $status = 404, $headers = array(), $options = 0, $message=$exep->getMessage());
        }else
        return $this->ErrorResponse([], $status = 404, $headers = array(), $options = 0, $message="Something went wrong!");
    }
    
    protected function unauthenticated($request, AuthenticationException $exception){
		
		  //return $this->ErrorResponse([], 401, $headers = array(), $options = 0, $message="Unauthenticated" );
        if($request->expectsJson())
		{
            return $this->ErrorResponse([], 401, $headers = array(), $options = 0, $message="Unauthenticated" );
		}
		else
		{
			//dd($request);
			////$message=config('params.msg_error').'Something went wrong!'.config('params.msg_end');
			////Session::flash('message',$message);
			//redirect()->guest(route('login'));
			redirect('/login')->send();
			$this->ErrorResponse([], 401, $headers = array(), $options = 0, $message="Unauthenticated" );
		}
                    //: $this->ErrorResponse([], 401, $headers = array(), $options = 0, $message="Unauthenticated" );
    }
    
}


?>