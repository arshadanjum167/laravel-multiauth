{{--@extends('admin.layouts.login')--}}
{{--@extends('layouts.app')--}}
@extends('layouts.admin.before_login')
{{--@section('main_contant')--}}
@section('content')
<!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Please enter your registered email address</p>
                
        @if (Session::has('message'))
          {!! Session::get('message') !!}
        @endif
        

        {!! Form::open(['url' => 'admin/password/email','method'=>'POST','class'=>'login-form']) !!}
          {{ csrf_field() }}

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback input-icon" >
                  <!--<label for="email" class="col-md-4 control-label">E-Mail Address</label>-->

                  <!--<div class="col-md-6">-->
                      <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                      @if ($errors->has('email'))
                          <span class="help-block">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                      @endif
                  <!--</div>-->
              </div>
          
              <button type="submit" name="login-button" class="btn btn-primary btn-block btn-flat">Submit</button>
            
          
        {!! Form::close() !!}
      <div class="social-auth-links text-center">
          <a href="{{ URL::to('admin/login') }}" class="text-center">I remember my password.</a>
      </div>      
  </div>
        
@endsection
